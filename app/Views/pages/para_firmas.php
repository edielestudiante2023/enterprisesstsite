<?= $this->extend('layouts/main') ?>

<?= $this->section('jsonld') ?>
<?= view('partials/jsonld-breadcrumb', ['items' => [
    ['name' => 'Inicio', 'url' => base_url('/')],
    ['name' => 'Para firmas consultoras', 'url' => base_url('para-firmas-consultoras')],
]]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Migas de pan"><a href="<?= base_url('/') ?>">Inicio</a><span class="sep">/</span><span aria-current="page">Para firmas consultoras</span></nav>
        <span class="eyebrow">Para firmas consultoras SST</span>
        <h1>Todos tus consultores y todos tus clientes en una sola plataforma</h1>
        <p class="lead">Controla el avance de cada cliente y el trabajo de cada consultor, entrega documentos y evidencias con la marca de tu firma y deja de depender de carpetas compartidas.</p>
        <div class="hero-ctas">
            <a href="<?= esc(demo_url('firmas-hero')) ?>" class="btn btn-primary btn-lg" target="_blank" rel="noopener">Pedir demo para mi firma</a>
            <a href="<?= base_url('precios') ?>" class="btn btn-outline btn-lg">Ver precios</a>
        </div>
    </div>
</section>

<section>
    <div class="container rejilla rejilla-3">
        <div class="tarjeta">
            <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'personas']) ?></span>
            <h3>Tu equipo, organizado</h3>
            <p>Tu administrador crea los consultores y les asigna clientes. Cada consultor ve solo lo suyo y tú ves todo. Sin cobro por consultor.</p>
        </div>
        <div class="tarjeta">
            <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'marca']) ?></span>
            <h3>Con la marca de tu firma</h3>
            <p>Tus clientes ven el logo, el nombre y el color de tu firma. Los documentos de cada cliente salen con su propio logo, código y versión.</p>
        </div>
        <div class="tarjeta">
            <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'escudo']) ?></span>
            <h3>Información aislada</h3>
            <p>Tu espacio es exclusivo: ninguna otra firma ve tus clientes. Cycloid Talent solo entra para darte soporte y cada acceso queda registrado.</p>
        </div>
        <div class="tarjeta">
            <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'documento']) ?></span>
            <h3>Documentos en minutos</h3>
            <p>75 tipos de documento redactados con IA a partir del contexto de cada cliente. Tu consultor revisa y aprueba.</p>
        </div>
        <div class="tarjeta">
            <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'grafica']) ?></span>
            <h3>Avance a la vista</h3>
            <p>Estándares mínimos con historial, plan de trabajo por PHVA, 17 indicadores e informe de avances por cliente.</p>
        </div>
        <div class="tarjeta">
            <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'portal']) ?></span>
            <h3>Clientes que no piden informes</h3>
            <p>Cada cliente consulta su avance en su portal y le pregunta a Otto, el asistente con IA, por su información.</p>
        </div>
    </div>
</section>

<section class="seccion-azul">
    <div class="container dividida">
        <div>
            <span class="eyebrow">Cuánto cuesta</span>
            <h2>Una mensualidad por cliente activo, según su tamaño</h2>
            <p>Una mensualidad por cada empresa activa, según su tamaño, sin permanencia. Los clientes que inactives dejan de cobrarse, y tus clientes nunca ven avisos de cobro.</p>
            <a href="<?= base_url('precios') ?>" class="btn btn-claro">Ver todas las tarifas</a>
        </div>
        <div>
            <ul class="lista-check">
                <li>Todas las funciones incluidas</li>
                <li>Consultores y usuarios sin costo adicional</li>
                <li>Importación desde Excel para traer a tus clientes actuales</li>
                <li>Demo guiada y acompañamiento en la puesta en marcha</li>
            </ul>
        </div>
    </div>
</section>

<?= view('partials/cta_final', ['campana' => 'firmas-final', 'titulo' => 'Lleva tu firma a una sola plataforma']) ?>
<?= $this->endSection() ?>
