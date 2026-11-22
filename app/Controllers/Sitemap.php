<?php

namespace App\Controllers;

use App\Models\BlogPostModel;

/**
 * Genera /sitemap.xml de forma dinámica.
 *
 * Reemplaza al antiguo public/sitemap.xml estático: la lista de páginas
 * vive aquí y la fecha <lastmod> de cada una se calcula sola a partir de
 * la fecha de modificación del archivo de vista.
 *
 * Para agregar una página nueva al sitemap, añade una línea a $pages.
 * Los artículos del blog (tabla blog_posts) se inyectan automáticamente
 * al final, filtrando por publicado = 1.
 */
class Sitemap extends BaseController
{
    /**
     * Páginas públicas indexables.
     *  - uri:        ruta relativa (se combina con base_url()).
     *  - view:       archivo de vista, relativo a app/Views/ (para el <lastmod>).
     *  - changefreq: frecuencia estimada de cambio.
     *  - priority:   prioridad relativa dentro del sitio (0.0 - 1.0).
     */
    private array $pages = [
        ['uri' => '/', 'view' => 'pages/inicio.php', 'changefreq' => 'weekly', 'priority' => '1.0'],
        ['uri' => 'funciones', 'view' => 'pages/funciones.php', 'changefreq' => 'monthly', 'priority' => '0.9'],
        ['uri' => 'precios', 'view' => 'pages/precios.php', 'changefreq' => 'monthly', 'priority' => '0.9'],
        ['uri' => 'como-funciona', 'view' => 'pages/como_funciona.php', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['uri' => 'para-firmas-consultoras', 'view' => 'pages/para_firmas.php', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['uri' => 'para-consultores-independientes', 'view' => 'pages/para_independientes.php', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['uri' => 'para-empresas', 'view' => 'pages/para_empresas.php', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['uri' => 'preguntas-frecuentes', 'view' => 'pages/preguntas.php', 'changefreq' => 'monthly', 'priority' => '0.7'],
        ['uri' => 'blog', 'view' => 'pages/blog/index.php', 'changefreq' => 'weekly', 'priority' => '0.7'],
        ['uri' => 'privacidad', 'view' => 'pages/legal/privacidad.php', 'changefreq' => 'yearly', 'priority' => '0.2'],
        ['uri' => 'terminos', 'view' => 'pages/legal/terminos.php', 'changefreq' => 'yearly', 'priority' => '0.2'],
    ];

    public function index()
    {
        $urls  = [];

        foreach ($this->pages as $page) {
            $viewPath = APPPATH . 'Views/' . $page['view'];
            $lastmod  = is_file($viewPath) ? date('Y-m-d', filemtime($viewPath)) : null;

            $urls[] = [
                'loc'        => base_url($page['uri']),
                'lastmod'    => $lastmod,
                'changefreq' => $page['changefreq'],
                'priority'   => $page['priority'],
            ];
        }

        // Artículos del blog publicados (dinámico).
        // try/catch para que el sitemap no rompa si la tabla aún no existe.
        try {
            $posts = model(BlogPostModel::class)->getPublicados();
            foreach ($posts as $post) {
                if (! empty($post['noindex'])) {
                    continue;
                }
                $stamp   = $post['updated_at'] ?? $post['created_at'] ?? null;
                $timestamp = $stamp ? strtotime($stamp) : false;
                $lastmod = $timestamp !== false ? date('Y-m-d', $timestamp) : null;
                $urls[]  = [
                    'loc'        => base_url('blog/' . $post['slug']),
                    'lastmod'    => $lastmod,
                    'changefreq' => 'monthly',
                    'priority'   => '0.7',
                ];
            }
        } catch (\Throwable $e) {
            // Si la tabla blog_posts no existe en este entorno, ignoramos.
        }

        /*
         * 'debug' => false: evita que CI4 inserte comentarios HTML
         * (DEBUG-VIEW START / END) antes de la declaración XML, lo que
         * invalidaría el documento — la declaración XML debe ser el
         * primer carácter del archivo.
         */
        $xml = view('sitemap', ['urls' => $urls], ['debug' => false]);

        return $this->response
            ->setHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->setBody($xml);
    }
}
