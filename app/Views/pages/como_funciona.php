<?= $this->extend('layouts/main') ?>

<?= $this->section('jsonld') ?>
<?= view('partials/jsonld-breadcrumb', ['items' => [
    ['name' => 'Inicio', 'url' => base_url('/')],
    ['name' => 'Cómo funciona', 'url' => base_url('como-funciona')],
]]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Migas de pan"><a href="<?= base_url('/') ?>">Inicio</a><span class="sep">/</span><span aria-current="page">Cómo funciona</span></nav>
        <span class="eyebrow">Cómo funciona el arriendo</span>
        <h1>Tu propio espacio en EnterpriseSST, con tu marca</h1>
        <p class="lead">Arrendar EnterpriseSST es tener la misma plataforma que usa Cycloid Talent, en un espacio exclusivo para tu firma: tus consultores, tus clientes y tu información, separados de los de cualquier otra firma.</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="encabezado-seccion">
            <span class="eyebrow">Paso a paso</span>
            <h2>Así empiezas</h2>
        </div>
        <div class="pasos">
            <div class="paso"><h3>Demo guiada</h3><p>Diana te muestra la plataforma con un caso real y resuelve tus dudas. No hay prueba sin acompañamiento: poner en marcha un SG-SST exige cargar bien la información.</p></div>
            <div class="paso"><h3>Propuesta</h3><p>Con el número y tamaño de tus clientes calculamos tu mensualidad.</p></div>
            <div class="paso"><h3>Alta de tu espacio</h3><p>Creamos tu firma con su primer administrador. Recibes un correo de bienvenida con tus credenciales y una guía de primeros pasos.</p></div>
            <div class="paso"><h3>Puesta en marcha</h3><p>Creas tus consultores y tus clientes, y traes desde Excel lo que ya tienes. Te acompañamos en el arranque.</p></div>
        </div>
    </div>
</section>

<section class="seccion-crema">
    <div class="container">
        <div class="rejilla rejilla-3">
            <div class="tarjeta">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'escudo']) ?></span>
                <h3>Espacio aislado</h3>
                <p>Tus consultores solo ven tus clientes, y ninguna otra firma ve tu información. Cycloid Talent solo entra para darte soporte, con un modo que registra cada acceso.</p>
            </div>
            <div class="tarjeta">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'marca']) ?></span>
                <h3>Con tu marca</h3>
                <p>Tus consultores y tus clientes ven el logo, el nombre y el color de tu firma. Los documentos salen con el logo de cada cliente.</p>
            </div>
            <div class="tarjeta">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'personas']) ?></span>
                <h3>Tu equipo completo</h3>
                <p>Tu administrador crea los consultores que necesites y asigna sus clientes. No se cobra por consultor ni por usuario.</p>
            </div>
            <div class="tarjeta">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'portal']) ?></span>
                <h3>Tus clientes, conectados</h3>
                <p>Cada cliente tiene su portal de consulta, y sus comités e inspectores participan desde el celular.</p>
            </div>
            <div class="tarjeta">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'moneda']) ?></span>
                <h3>Cobro mensual simple</h3>
                <p>Orden de servicio el día 1, pago hasta el día 10 por llave Bre-B y comprobante en la plataforma. Tus clientes nunca ven avisos de cobro.</p>
            </div>
            <div class="tarjeta">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'check']) ?></span>
                <h3>Una plataforma que evoluciona</h3>
                <p>Cycloid Talent la usa a diario con sus propios clientes y la mejora de forma continua. Las mejoras llegan a tu espacio sin costo adicional.</p>
            </div>
        </div>
    </div>
</section>

<?= view('partials/cta_final', ['campana' => 'como-funciona-final']) ?>
<?= $this->endSection() ?>
