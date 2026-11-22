<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogPostModel;
use App\Models\BlogVisitasSnapshotModel;
use DateTimeImmutable;
use DateTimeZone;

class Blog extends BaseController
{
    private const REGLAS = [
        'titulo'           => 'required|max_length[255]',
        'contenido'        => 'required',
        'meta_titulo'      => 'permit_empty|max_length[70]',
        'meta_descripcion' => 'permit_empty|max_length[160]',
    ];

    private const MENSAJES = [
        'meta_titulo'      => ['max_length' => 'El título SEO supera los 70 caracteres. Acórtalo para que Google no lo corte.'],
        'meta_descripcion' => ['max_length' => 'La meta descripción supera los 160 caracteres. Acórtala para que Google no la corte.'],
    ];

    protected BlogPostModel $blogModel;

    public function __construct()
    {
        $this->blogModel = new BlogPostModel();
    }

    public function index()
    {
        return view('pages/admin/blog/index', [
            'title'       => 'Blog · Admin · EnterpriseSST',
            'description' => 'Gestion de articulos del blog.',
            'activeNav'   => '',
            'posts'       => $this->blogModel->getWithAutor(),
        ]);
    }

    public function estadisticas()
    {
        $weeks = (int) ($this->request->getGet('weeks') ?: 12);
        if (! in_array($weeks, [8, 12, 26, 52], true)) {
            $weeks = 12;
        }

        $snapshotModel = new BlogVisitasSnapshotModel();

        return view('pages/admin/blog/estadisticas', [
            'title'       => 'Evolucion de visitas del blog · Admin · EnterpriseSST',
            'description' => 'Evolucion semanal de visualizaciones de los articulos.',
            'activeNav'   => '',
            'weeksFilter' => $weeks,
            'evolution'   => $snapshotModel->getEvolution($weeks),
        ]);
    }

    public function snapshot()
    {
        try {
            $snapshotModel = new BlogVisitasSnapshotModel();
            $result = $snapshotModel->capture(
                new DateTimeImmutable('now', new DateTimeZone('America/Bogota'))
            );
        } catch (\Throwable $e) {
            log_message('error', '[Blog.snapshot] ' . $e->getMessage());

            return redirect()->to(base_url('admin/blog/estadisticas'))
                ->with('error', 'No se pudo tomar el snapshot. Revisa el log de la aplicación.');
        }

        $action = $result['inserted'] > 0 ? 'creado' : 'actualizado';
        $message = sprintf(
            'Snapshot %s %s: %d artículos y %s visitas acumuladas.',
            date('d/m/Y', strtotime($result['date'])),
            $action,
            $result['posts'],
            number_format($result['total'], 0, ',', '.')
        );

        return redirect()->to(base_url('admin/blog/estadisticas'))
            ->with('success', $message);
    }

    public function create()
    {
        return view('pages/admin/blog/form', [
            'title'       => 'Crear articulo · Admin · EnterpriseSST',
            'description' => 'Crear un articulo del blog.',
            'activeNav'   => '',
            'post'        => null,
        ]);
    }

    public function store()
    {
        if (! $this->validate(self::REGLAS, self::MENSAJES)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $contenido = blog_limpiar_encabezados((string) $this->request->getPost('contenido'));

        if ($aviso = $this->avisoSimilares($contenido)) {
            return $aviso;
        }

        $titulo = (string) $this->request->getPost('titulo');

        // Transliterar tildes/enies a ASCII antes de slugificar - CI4 rechaza
        // URIs con caracteres acentuados (permittedURIChars) y rompen SEO/cache.
        $tituloAscii = strtr($titulo, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n',
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ü' => 'U', 'Ñ' => 'N',
        ]);
        $slug = url_title($tituloAscii, '-', true);

        if ($this->blogModel->where('slug', $slug)->first()) {
            $slug .= '-' . time();
        }

        $data = [
            'titulo'           => $titulo,
            'slug'             => $slug,
            'extracto'         => $this->request->getPost('extracto'),
            'meta_titulo'      => $this->request->getPost('meta_titulo') ?: null,
            'meta_descripcion' => $this->request->getPost('meta_descripcion') ?: null,
            'categoria'        => $this->request->getPost('categoria') ?: null,
            'etiquetas'        => $this->request->getPost('etiquetas') ?: null,
            'imagen_alt'       => $this->request->getPost('imagen_alt') ?: null,
            'contenido'        => $contenido,
            'autor_id'         => session()->get('user_id'),
            'publicado'        => $this->request->getPost('publicado') ? 1 : 0,
            'noindex'          => $this->request->getPost('noindex') ? 1 : 0,
        ];

        $img = $this->request->getFile('imagen');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'assets/img/blog', $newName);
            $data['imagen'] = $newName;
        }

        $this->blogModel->insert($data);

        return redirect()->to(base_url('admin/blog'))->with('success', 'Articulo creado.');
    }

    public function edit($id)
    {
        $post = $this->blogModel->find((int) $id);

        if (! $post) {
            return redirect()->to(base_url('admin/blog'))->with('error', 'Articulo no encontrado.');
        }

        return view('pages/admin/blog/form', [
            'title'       => 'Editar articulo · Admin · EnterpriseSST',
            'description' => 'Editar un articulo del blog.',
            'activeNav'   => '',
            'post'        => $post,
        ]);
    }

    public function update($id)
    {
        $id   = (int) $id;
        $post = $this->blogModel->find($id);

        if (! $post) {
            return redirect()->to(base_url('admin/blog'))->with('error', 'Articulo no encontrado.');
        }

        if (! $this->validate(self::REGLAS, self::MENSAJES)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $contenido = blog_limpiar_encabezados((string) $this->request->getPost('contenido'));

        if ($aviso = $this->avisoSimilares($contenido, $id)) {
            return $aviso;
        }

        $data = [
            'titulo'           => $this->request->getPost('titulo'),
            'extracto'         => $this->request->getPost('extracto'),
            'meta_titulo'      => $this->request->getPost('meta_titulo') ?: null,
            'meta_descripcion' => $this->request->getPost('meta_descripcion') ?: null,
            'categoria'        => $this->request->getPost('categoria') ?: null,
            'etiquetas'        => $this->request->getPost('etiquetas') ?: null,
            'imagen_alt'       => $this->request->getPost('imagen_alt') ?: null,
            'contenido'        => $contenido,
            'publicado'        => $this->request->getPost('publicado') ? 1 : 0,
            'noindex'          => $this->request->getPost('noindex') ? 1 : 0,
        ];

        $img = $this->request->getFile('imagen');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            if (! empty($post['imagen'])) {
                $oldPath = FCPATH . 'assets/img/blog/' . $post['imagen'];
                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'assets/img/blog', $newName);
            $data['imagen'] = $newName;
        }

        $this->blogModel->update($id, $data);

        return redirect()->to(base_url('admin/blog'))->with('success', 'Articulo actualizado.');
    }

    /**
     * Al publicar, avisa si el contenido se parece a otro articulo. No bloquea:
     * quien edita decide y confirma con la casilla del formulario.
     */
    private function avisoSimilares(string $contenido, ?int $id = null)
    {
        if (! $this->request->getPost('publicado') || $this->request->getPost('confirmar_similar')) {
            return null;
        }

        $similares = $this->blogModel->getSimilares($contenido, $id);

        return $similares === [] ? null : redirect()->back()->withInput()->with('similares', $similares);
    }

    public function destroy($id)
    {
        $id   = (int) $id;
        $post = $this->blogModel->find($id);

        if ($post && ! empty($post['imagen'])) {
            $path = FCPATH . 'assets/img/blog/' . $post['imagen'];
            if (is_file($path)) {
                @unlink($path);
            }
        }

        $this->blogModel->delete($id);

        return redirect()->to(base_url('admin/blog'))->with('success', 'Articulo eliminado.');
    }

    public function togglePublished($id)
    {
        $id   = (int) $id;
        $post = $this->blogModel->find($id);

        if ($post) {
            $this->blogModel->update($id, ['publicado' => $post['publicado'] ? 0 : 1]);
        }

        return redirect()->to(base_url('admin/blog'));
    }
}
