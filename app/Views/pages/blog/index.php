<?= $this->extend('layouts/main') ?>

<?= $this->section('jsonld') ?>
<?= view('partials/jsonld-breadcrumb', ['items' => [
    ['name' => 'Inicio', 'url' => base_url('/')],
    ['name' => 'Blog',   'url' => base_url('blog')],
]]) ?>
<script type="application/ld+json"><?= json_encode([
    '@context'  => 'https://schema.org',
    '@type'     => 'Blog',
    'name'      => 'Blog de EnterpriseSST',
    'url'       => base_url('blog'),
    'publisher' => ['@id' => config('Sitio')->empresaUrl . '#organizacion'],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Migas de pan">
            <a href="<?= base_url('/') ?>">Inicio</a><span class="sep">/</span><span aria-current="page">Blog</span>
        </nav>
        <span class="eyebrow">Blog</span>
        <h1>Guías para gestionar el SG-SST con menos esfuerzo</h1>
        <p class="lead">Ideas prácticas para consultores y responsables SST: estándares mínimos, evidencias, inspecciones, comités y cómo organizar el trabajo de varios clientes.</p>
    </div>
</section>

<section>
    <div class="container">
        <?php if (empty($posts)): ?>
            <div class="admin-card" style="text-align:center; padding:48px 24px;">
                <p style="color:var(--color-muted); margin:0;">Muy pronto publicaremos los primeros artículos.</p>
            </div>
        <?php else: ?>
            <div class="res-grid">
                <?php foreach ($posts as $p): ?>
                    <a href="<?= base_url('blog/' . $p['slug']) ?>" class="res-card blog-card">
                        <?php if (! empty($p['imagen'])): ?>
                            <div style="margin:-24px -24px 16px; aspect-ratio:16/9; overflow:hidden; background:var(--color-bg-alt);">
                                <img src="<?= base_url('assets/img/blog/' . $p['imagen']) ?>" alt="<?= esc(! empty($p['imagen_alt']) ? $p['imagen_alt'] : $p['titulo']) ?>" loading="lazy" style="width:100%; height:100%; object-fit:cover; display:block;">
                            </div>
                        <?php endif; ?>
                        <span class="pill-cat"><?= esc(! empty($p['categoria']) ? $p['categoria'] : 'SG-SST') ?></span>
                        <h2 class="res-card-titulo"><?= esc($p['titulo']) ?></h2>
                        <?php if (! empty($p['extracto'])): ?><p><?= esc($p['extracto']) ?></p><?php endif; ?>
                        <span class="read-more"><?= date('d/m/Y', strtotime($p['created_at'])) ?> · Leer artículo →</span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= view('partials/cta_final', ['campana' => 'blog-listado']) ?>
<?= $this->endSection() ?>
