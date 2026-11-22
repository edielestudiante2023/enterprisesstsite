<?= $this->extend('layouts/main') ?>

<?= $this->section('jsonld') ?>
<?= view('partials/jsonld-breadcrumb', ['items' => [
    ['name' => 'Inicio', 'url' => base_url('/')],
    ['name' => 'Para empresas con área SST', 'url' => base_url('para-empresas')],
]]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Migas de pan"><a href="<?= base_url('/') ?>">Inicio</a><span class="sep">/</span><span aria-current="page">Para empresas con área SST</span></nav>
        <span class="eyebrow">Para empresas con área SST propia</span>
        <h1>El SG-SST de tu empresa, ordenado y listo para cualquier auditoría</h1>
        <p class="lead">Tu responsable SST organiza documentos, evidencias, inspecciones, comités e indicadores de tu empresa y sus sedes en una sola plataforma, sin depender de carpetas ni de Excel.</p>
        <div class="hero-ctas">
            <a href="<?= esc(demo_url('empresas-hero')) ?>" class="btn btn-primary btn-lg" target="_blank" rel="noopener">Pedir demo para mi empresa</a>
            <a href="<?= base_url('precios') ?>" class="btn btn-outline btn-lg">Ver precios</a>
        </div>
    </div>
</section>

<section>
    <div class="container rejilla rejilla-3">
        <div class="tarjeta">
            <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'check']) ?></span>
            <h3>Estándares mínimos al día</h3>
            <p>Evaluación de la Resolución 0312 con historial de puntajes y plan de trabajo anual por ciclo PHVA.</p>
        </div>
        <div class="tarjeta">
            <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'documento']) ?></span>
            <h3>Documentos de tu empresa</h3>
            <p>Políticas, programas y procedimientos redactados con IA a partir del contexto de tu empresa, con tu logo, código y versión.</p>
        </div>
        <div class="tarjeta">
            <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'celular']) ?></span>
            <h3>Inspecciones en tus sedes</h3>
            <p>Locativa, extintores, botiquín, señalización, EPP y simulacros, con fotos, desde el celular.</p>
        </div>
        <div class="tarjeta">
            <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'personas']) ?></span>
            <h3>Comités sin papel</h3>
            <p>Elecciones de COPASST y comité de convivencia con votación electrónica, actas con firma e informes.</p>
        </div>
        <div class="tarjeta">
            <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'matriz']) ?></span>
            <h3>Matrices conectadas</h3>
            <p>IPEVR (GTC 45), matriz legal, matriz de EPP, profesiograma y perfiles de cargo.</p>
        </div>
        <div class="tarjeta">
            <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'grafica']) ?></span>
            <h3>Indicadores para la gerencia</h3>
            <p>17 indicadores SST e informe de avances para mostrar el estado del sistema.</p>
        </div>
    </div>
</section>

<section class="seccion-azul">
    <div class="container dividida">
        <div>
            <span class="eyebrow">Cuánto cuesta</span>
            <h2>Una mensualidad según el tamaño de tu empresa</h2>
            <p>Tu empresa tiene su propio espacio y paga la tarifa que corresponde a sus estándares mínimos y su número de trabajadores.</p>
            <a href="<?= base_url('precios') ?>" class="btn btn-claro">Ver tarifas</a>
        </div>
        <div>
            <h3>¿Necesitas que alguien ejecute tu SG-SST?</h3>
            <p>EnterpriseSST es para la empresa que ya tiene quién gestione su sistema. Si necesitas un equipo que lo diseñe y lo ejecute contigo, Cycloid Talent ofrece consultoría SST.</p>
            <a href="https://cycloidtalent.com/servicios/consultoria-sst" class="btn btn-claro" target="_blank" rel="noopener">Conocer la consultoría SST</a>
        </div>
    </div>
</section>

<?= view('partials/cta_final', ['campana' => 'empresas-final', 'titulo' => 'Mira EnterpriseSST con el caso de tu empresa']) ?>
<?= $this->endSection() ?>
