<?= $this->extend('layouts/main') ?>

<?= $this->section('jsonld') ?>
<?= view('partials/jsonld-breadcrumb', ['items' => [
    ['name' => 'Inicio', 'url' => base_url('/')],
    ['name' => 'Blog',   'url' => base_url('blog')],
    ['name' => $post['titulo'], 'url' => base_url('blog/' . $post['slug'])],
]]) ?>
<?= view('partials/jsonld-article', [
    'headline'       => $post['titulo'],
    'image'          => $ogImage,
    'description'    => $description,
    'url'            => base_url('blog/' . $post['slug']),
    'datePublished'  => date('Y-m-d', strtotime($post['created_at'])),
    'dateModified'   => ! empty($post['updated_at']) ? date('Y-m-d', strtotime($post['updated_at'])) : null,
    'articleSection' => $post['categoria'] ?? null,
    'keywords'       => $post['etiquetas'] ?? null,
]) ?>
<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
    .blog-article-body { font-size: 1.05rem; line-height: 1.75; color: var(--color-text-soft); }
    .blog-article-body h2 { font-size: 1.6rem; margin: 1.8em 0 .6em; color: var(--color-text); }
    .blog-article-body h3 { font-size: 1.25rem; margin: 1.5em 0 .5em; color: var(--color-text); }
    .blog-article-body p  { margin: 0 0 1.1em; }
    .blog-article-body ul, .blog-article-body ol { margin: 0 0 1.1em 1.25em; padding: 0; }
    .blog-article-body li { margin-bottom: .35em; }
    .blog-article-body a  { color: var(--color-primary); text-decoration: underline; }
    .blog-article-body a:hover { color: var(--color-primary-dark); }
    .blog-article-body blockquote {
        margin: 1.4em 0; padding: .8em 1.2em;
        border-left: 4px solid var(--color-primary);
        background: var(--color-bg-alt); border-radius: 4px;
        color: var(--color-text); font-style: italic;
    }
    .blog-article-body img { max-width: 100%; height: auto; border-radius: var(--radius-md); margin: 1.2em 0; }
    .blog-article-body pre, .blog-article-body code {
        font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
        background: var(--color-bg-alt); padding: .15em .35em; border-radius: 4px;
        font-size: .92em;
    }
    .blog-article-body pre { padding: 1em; overflow-x: auto; }
    .blog-cover-img { width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: var(--radius-md); margin-bottom: 1.5em; background: var(--color-bg-alt); }

    .visitor-counter {
        display: inline-flex; align-items: center; gap: 8px;
        margin-top: 14px; padding: 6px 14px;
        font-size: .85rem; color: var(--color-text-soft);
        background: var(--color-bg-alt); border-radius: 999px;
    }
    .visitor-counter strong { color: var(--color-primary); }

    /* Soporte de clases que genera Quill 2.0.3 (toolbar admin) */
    .blog-article-body .ql-align-center  { text-align: center; }
    .blog-article-body .ql-align-right   { text-align: right; }
    .blog-article-body .ql-align-justify { text-align: justify; }
    .blog-article-body .ql-indent-1 { padding-left: 3em;  }
    .blog-article-body .ql-indent-2 { padding-left: 6em;  }
    .blog-article-body .ql-indent-3 { padding-left: 9em;  }
    .blog-article-body .ql-indent-4 { padding-left: 12em; }
    .blog-article-body .ql-indent-5 { padding-left: 15em; }
    .blog-article-body .ql-indent-6 { padding-left: 18em; }
    .blog-article-body .ql-indent-7 { padding-left: 21em; }
    .blog-article-body .ql-indent-8 { padding-left: 24em; }
    .blog-article-body .ql-size-small { font-size: .85em; }
    .blog-article-body .ql-size-large { font-size: 1.5em; line-height: 1.4; }
    .blog-article-body .ql-size-huge  { font-size: 2.2em; line-height: 1.3; }
    /* Quill marca el direction RTL con esta clase si se llegara a usar */
    .blog-article-body .ql-direction-rtl { direction: rtl; text-align: inherit; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Migas de pan">
            <a href="<?= base_url('/') ?>">Inicio</a>
            <span class="sep">/</span>
            <a href="<?= base_url('blog') ?>">Blog</a>
            <span class="sep">/</span>
            <span aria-current="page"><?= esc($post['titulo']) ?></span>
        </nav>

        <span class="eyebrow">Blog · Cycloid Talent · <?= date('d/m/Y', strtotime($post['created_at'])) ?></span>
        <h1 style="margin-bottom:.5em;"><?= esc($post['titulo']) ?></h1>
        <?php if (! empty($post['extracto'])): ?>
            <p class="lead"><?= esc($post['extracto']) ?></p>
        <?php endif; ?>

        <?php if (! empty($numeroVisitante)): ?>
            <p class="visitor-counter">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Usted es el visitante número <strong><?= number_format((int) $numeroVisitante, 0, ',', '.') ?></strong> de este artículo
            </p>
        <?php endif; ?>
    </div>
</section>

<section>
    <div class="container" style="max-width:880px;">
        <?php if (! empty($post['imagen'])): ?>
            <img src="<?= base_url('assets/img/blog/' . $post['imagen']) ?>"
                 alt="<?= esc(! empty($post['imagen_alt']) ? $post['imagen_alt'] : $post['titulo']) ?>"
                 class="blog-cover-img">
        <?php endif; ?>

        <article class="blog-article-body">
            <?= $post['contenido'] ?>
        </article>

        <div style="margin-top:48px; padding-top:24px; border-top:1px solid var(--color-bg-alt);">
            <a href="<?= base_url('blog') ?>" class="btn btn-ghost">← Volver al blog</a>
        </div>
    </div>
</section>

<?= view('partials/cta_final', ['campana' => 'blog-articulo']) ?>

<?= $this->endSection() ?>
