<?= $this->extend('layouts/main') ?>

<?= $this->section('jsonld') ?>
<?= view('partials/jsonld-breadcrumb', ['items' => [
    ['name' => 'Inicio', 'url' => base_url('/')],
    ['name' => 'Para consultores independientes', 'url' => base_url('para-consultores-independientes')],
]]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Migas de pan"><a href="<?= base_url('/') ?>">Inicio</a><span class="sep">/</span><span aria-current="page">Para consultores independientes</span></nav>
        <span class="eyebrow">Para consultores SST independientes</span>
        <h1>Atiende más empresas con el mismo tiempo</h1>
        <p class="lead">Deja de copiar y adaptar documentos en Word, de pasar inspecciones del papel al computador y de perseguir firmas. Entrega un SG-SST ordenado y con tu marca.</p>
        <div class="hero-ctas">
            <a href="<?= esc(demo_url('independientes-hero')) ?>" class="btn btn-primary btn-lg" target="_blank" rel="noopener">Pedir demo guiada</a>
            <a href="<?= base_url('precios') ?>" class="btn btn-outline btn-lg">Ver precios</a>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="encabezado-seccion">
            <span class="eyebrow">Tu semana con EnterpriseSST</span>
            <h2>Menos digitación, más trabajo profesional</h2>
        </div>
        <div class="rejilla rejilla-2">
            <div class="tarjeta">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'documento']) ?></span>
                <h3>El borrador ya está hecho</h3>
                <p>La IA redacta políticas, programas, procedimientos y actas con el contexto de cada cliente. Tú pones el criterio: revisas, ajustas y apruebas.</p>
            </div>
            <div class="tarjeta">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'celular']) ?></span>
                <h3>La visita se registra en sitio</h3>
                <p>Inspecciones con fotos y actas de visita desde el celular. Al salir de la empresa, la evidencia ya está guardada.</p>
            </div>
            <div class="tarjeta">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'firma']) ?></span>
                <h3>Las firmas llegan por correo</h3>
                <p>Cada firmante recibe su enlace. El documento queda con huella digital y verificación pública.</p>
            </div>
            <div class="tarjeta">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'check']) ?></span>
                <h3>Listo para la auditoría</h3>
                <p>Estándares mínimos con historial y evidencias organizadas por estándar. Tu cliente consulta su avance en su portal.</p>
            </div>
        </div>
    </div>
</section>

<section class="seccion-crema">
    <div class="container dividida">
        <div>
            <span class="eyebrow">Empieza con lo que tienes</span>
            <h2>Trae a tus clientes actuales</h2>
            <p>Importa desde Excel procesos, cargos, sedes, matriz legal y otros registros. Te acompañamos en la puesta en marcha para que no empieces de cero.</p>
        </div>
        <div class="tarjeta">
            <h3>Pagas por empresa activa</h3>
            <p>Una mensualidad por cada empresa activa, según su tamaño, sin permanencia. Si un cliente se va, lo inactivas y deja de cobrarse.</p>
            <a href="<?= base_url('precios') ?>" class="btn btn-primary">Ver tarifas</a>
        </div>
    </div>
</section>

<?= view('partials/cta_final', ['campana' => 'independientes-final']) ?>
<?= $this->endSection() ?>
