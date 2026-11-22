<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogPostModel extends Model
{
    protected $table         = 'blog_posts';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['titulo', 'slug', 'extracto', 'meta_titulo', 'meta_descripcion', 'categoria', 'etiquetas', 'contenido', 'imagen', 'imagen_alt', 'autor_id', 'publicado', 'noindex'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPublicados()
    {
        return $this->where('publicado', 1)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Ultimo articulo publicado e indexable, para el aviso del blog en el home.
     */
    public function getUltimoPublicado(): ?array
    {
        return $this->select('id, titulo, slug, imagen, imagen_alt, created_at')
                    ->where('publicado', 1)
                    ->where('noindex', 0)
                    ->orderBy('created_at', 'DESC')
                    ->first();
    }

    /**
     * Articulos parecidos al contenido, sin contar el que se esta editando.
     */
    public function getSimilares(string $contenido, ?int $exceptoId = null): array
    {
        $builder = $this->select('id, titulo, contenido');
        if ($exceptoId !== null) {
            $builder->where('id !=', $exceptoId);
        }

        return blog_articulos_similares($contenido, $builder->findAll());
    }

    public function getBySlug(string $slug)
    {
        return $this->where('slug', $slug)
                    ->where('publicado', 1)
                    ->first();
    }

    /**
     * Suma una visita al articulo y devuelve el total actualizado.
     * Usa el query builder directo (sin pasar por save/update del Model)
     * para no tocar updated_at: el sitemap lo usa como <lastmod> y no
     * debe moverse por trafico.
     */
    public function contarVisita(int $id): int
    {
        $this->builder()
             ->where('id', $id)
             ->set('visitas', 'visitas + 1', false)
             ->update();

        $row = $this->builder()
                    ->select('visitas')
                    ->where('id', $id)
                    ->get()
                    ->getRowArray();

        return (int) ($row['visitas'] ?? 0);
    }

    public function getWithAutor(?int $id = null)
    {
        $builder = $this->select('blog_posts.*, usuarios.name as autor_nombre')
                        ->join('usuarios', 'usuarios.id = blog_posts.autor_id', 'left');

        if ($id !== null) {
            return $builder->find($id);
        }

        // Listado del admin: primero los mas visitados; a igual visitas,
        // el mas reciente arriba.
        return $builder->orderBy('blog_posts.visitas', 'DESC')
                       ->orderBy('blog_posts.created_at', 'DESC')
                       ->findAll();
    }
}
