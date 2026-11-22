<?php

namespace App\Controllers;

use App\Models\BlogPostModel;

class Blog extends BaseController
{
    public function index()
    {
        $blogModel = model(BlogPostModel::class);

        return view('pages/blog/index', [
            'title'       => 'Blog para consultores SST | EnterpriseSST',
            'description' => 'Guías para consultores y responsables SST: cómo organizar el SG-SST de varios clientes, estándares mínimos, evidencias, inspecciones y comités.',
            'activeNav'   => 'blog',
            'posts'       => $blogModel->getPublicados(),
        ]);
    }

    public function articulo(string $slug)
    {
        $blogModel = model(BlogPostModel::class);
        $post      = $blogModel->getBySlug($slug);

        if (! $post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $ogImage = ! empty($post['imagen'])
            ? base_url('assets/img/blog/' . $post['imagen'])
            : base_url('assets/img/marca/og-enterprisesst.png');

        // Metadata SEO con fallbacks: si el campo manual esta vacio, se usa el
        // valor por defecto (titulo / extracto) para no romper articulos previos.
        $metaTitulo      = ! empty($post['meta_titulo']) ? $post['meta_titulo'] : $post['titulo'];
        $metaDescripcion = ! empty($post['meta_descripcion'])
            ? $post['meta_descripcion']
            : blog_resumir($post['extracto'] ?: $post['contenido']);
        $imagenAlt = ! empty($post['imagen_alt']) ? $post['imagen_alt'] : $post['titulo'];

        // Contador de visitas: cuenta solo personas (no bots ni peticiones
        // HEAD de crawlers) y una sola vez por sesion por articulo — recargar
        // la pagina muestra el mismo numero. array_key_exists protege el
        // despliegue si el codigo llega antes que la migracion 003 (visitas).
        $numeroVisitante = null;
        if (array_key_exists('visitas', $post)) {
            $sessionKey      = 'blog_visita_' . $post['id'];
            $numeroVisitante = session()->get($sessionKey);

            // La precarga de páginas (speculation rules) pide el artículo antes de que la
            // persona lo abra; esas solicitudes llegan con "Sec-Purpose: prefetch" y no cuentan.
            $esPrecarga = str_contains(strtolower($this->request->getHeaderLine('Sec-Purpose')), 'prefetch');
            $esPersona  = strtoupper($this->request->getMethod()) === 'GET'
                && ! $esPrecarga
                && ! $this->request->getUserAgent()->isRobot();

            if ($numeroVisitante === null && $esPersona) {
                $numeroVisitante = $blogModel->contarVisita((int) $post['id']);
                session()->set($sessionKey, $numeroVisitante);
            }
        }

        return view('pages/blog/articulo', [
            'title'       => $metaTitulo,
            'description' => $metaDescripcion,
            'ogTitle'     => $metaTitulo,
            'ogDescription' => $metaDescripcion,
            'ogImage'     => $ogImage,
            'ogImageAlt'  => $imagenAlt,
            'ogType'      => 'article',
            'keywords'    => ! empty($post['etiquetas']) ? $post['etiquetas'] : null,
            'robots'      => ! empty($post['noindex'])
                ? 'noindex, nofollow'
                : 'index, follow, max-image-preview:large',
            'activeNav'   => 'blog',
            'post'        => $post,
            'numeroVisitante' => $numeroVisitante,
        ]);
    }
}
