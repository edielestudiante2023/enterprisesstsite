<?= $this->extend('layouts/main') ?>

<?= $this->section('jsonld') ?>
<?= view('partials/jsonld-breadcrumb', ['items' => [
    ['name' => 'Inicio', 'url' => base_url('/')],
    ['name' => 'Preguntas frecuentes', 'url' => base_url('preguntas-frecuentes')],
]]) ?>
<?= view('partials/jsonld-faq', ['faqs' => $faqs]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Migas de pan"><a href="<?= base_url('/') ?>">Inicio</a><span class="sep">/</span><span aria-current="page">Preguntas frecuentes</span></nav>
        <span class="eyebrow">Preguntas frecuentes</span>
        <h1>Todo lo que necesitas saber antes de arrendar EnterpriseSST</h1>
        <p class="lead">Si tu pregunta no está aquí, escríbele a Diana por WhatsApp o pide una demo guiada.</p>
    </div>
</section>

<section>
    <div class="container">
        <?= view('partials/faq', ['faqs' => $faqs]) ?>
    </div>
</section>

<?= view('partials/cta_final', ['campana' => 'preguntas-final']) ?>
<?= $this->endSection() ?>
