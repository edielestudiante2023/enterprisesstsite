<?= $this->extend('layouts/main') ?>

<?= $this->section('jsonld') ?>
<?= view('partials/jsonld-breadcrumb', ['items' => [
    ['name' => 'Inicio', 'url' => base_url('/')],
    ['name' => 'Funciones', 'url' => base_url('funciones')],
]]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Migas de pan"><a href="<?= base_url('/') ?>">Inicio</a><span class="sep">/</span><span aria-current="page">Funciones</span></nav>
        <span class="eyebrow">Funciones</span>
        <h1>Todo lo que necesitas para gestionar el SG-SST de tus clientes</h1>
        <p class="lead">Del diagnóstico inicial a la auditoría: documentos con IA, matrices, inspecciones, comités, indicadores y firmas, en una sola plataforma con la marca de tu firma.</p>
        <div class="hero-ctas">
            <a href="<?= esc(demo_url('funciones-hero')) ?>" class="btn btn-primary btn-lg" target="_blank" rel="noopener">Pedir demo guiada</a>
            <a href="<?= base_url('precios') ?>" class="btn btn-outline btn-lg">Ver precios</a>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <nav aria-label="Grupos de funciones" style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:40px;">
            <?php foreach ($grupos as $g): ?>
                <a href="#<?= esc($g['id']) ?>" class="pill-cat" style="text-decoration:none;"><?= esc($g['titulo']) ?></a>
            <?php endforeach; ?>
        </nav>

        <div class="rejilla rejilla-2">
            <?php foreach ($grupos as $g): ?>
                <article class="tarjeta" id="<?= esc($g['id']) ?>">
                    <h2 style="font-size:1.35rem;"><?= esc($g['titulo']) ?></h2>
                    <p><?= esc($g['intro']) ?></p>
                    <ul class="lista-check">
                        <?php foreach ($g['items'] as $item): ?>
                            <li><?= esc($item) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="seccion-azul">
    <div class="container dividida">
        <div>
            <span class="eyebrow">Con la marca de tu firma</span>
            <h2>Tus clientes ven tu firma en cada pantalla</h2>
            <p>Logo, nombre y color de tu firma para tus consultores y tus clientes. Los documentos de cada cliente salen con el logo de ese cliente.</p>
        </div>
        <div>
            <ul class="lista-check">
                <li>Espacio propio y aislado para tu firma</li>
                <li>Consultores y usuarios sin costo adicional</li>
                <li>Aplicaciones para el celular: inspecciones, comités, IPEVR e ingreso</li>
                <li>Correos de firma y notificaciones con el nombre de tu firma</li>
            </ul>
        </div>
    </div>
</section>

<?= view('partials/cta_final', ['campana' => 'funciones-final']) ?>
<?= $this->endSection() ?>
