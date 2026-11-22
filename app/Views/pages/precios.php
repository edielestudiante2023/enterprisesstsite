<?= $this->extend('layouts/main') ?>

<?= $this->section('jsonld') ?>
<?= view('partials/jsonld-breadcrumb', ['items' => [
    ['name' => 'Inicio', 'url' => base_url('/')],
    ['name' => 'Precios', 'url' => base_url('precios')],
]]) ?>
<script type="application/ld+json"><?= json_encode(\App\Libraries\Contenido::softwareLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<?= view('partials/jsonld-faq', ['faqs' => $faqs]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$tamano = static function (array $t): string {
    return 'Empresa de ' . $t['trabajadores'] . ' trabajadores';
};
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Migas de pan"><a href="<?= base_url('/') ?>">Inicio</a><span class="sep">/</span><span aria-current="page">Precios</span></nav>
        <span class="eyebrow">Precios</span>
        <h1>Pagas solo por las empresas que gestionas</h1>
        <p class="lead">Una mensualidad por cada empresa cliente activa, según los estándares mínimos que le aplican y su número de trabajadores. Todas las funciones incluidas, sin cobro por consultor ni por usuario.</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="tabla-precios-wrap">
            <table class="tabla-precios">
                <thead>
                    <tr><th>Tamaño de la empresa cliente</th><th>Estándares mínimos (Res. 0312)</th><th>Mensualidad por empresa</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($tarifas as $t): ?>
                        <tr>
                            <td><?= esc($tamano($t)) ?></td>
                            <td><?= (int) $t['estandares'] ?> estándares</td>
                            <td class="valor"><?= precio_cop((int) $t['valor']) ?> <small>/ mes</small></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <p class="ejemplo-precio">Sin cláusulas de permanencia ni paquetes rígidos: activas o desactivas empresas según el movimiento real de tu cartera. Si una empresa crece y cambia de tramo, se cobra según su tamaño real.</p>
        <p style="font-size:.88rem; color:var(--color-muted);">Valores en pesos colombianos. Las empresas de riesgo IV o V aplican los 60 estándares sin importar su tamaño.</p>

        <div class="dividida" style="margin-top:48px; align-items:start;">
            <div class="tarjeta">
                <h2 style="font-size:1.35rem;">Qué incluye</h2>
                <ul class="lista-check incluido">
                    <li>Documentos SG-SST con IA</li>
                    <li>Estándares mínimos y plan de trabajo</li>
                    <li>Matrices IPEVR, legal y de EPP</li>
                    <li>Inspecciones desde el celular</li>
                    <li>Comités y votación electrónica</li>
                    <li>Firma electrónica verificable</li>
                    <li>17 indicadores e informe de avances</li>
                    <li>Portal del cliente y asistente Otto</li>
                    <li>Consultores y usuarios sin costo</li>
                    <li>La marca de tu firma</li>
                </ul>
            </div>
            <div class="tarjeta">
                <h2 style="font-size:1.35rem;">Cómo se cobra</h2>
                <ul class="lista-check">
                    <li>Se cobra cada empresa cliente que estuvo activa al menos un día del mes. Las que inactives dejan de cobrarse.</li>
                    <li>El día 1 recibes la orden de servicio del mes anterior y pagas hasta el día 10.</li>
                    <li>Pago por transferencia a la llave Bre-B de Cycloid Talent; subes el comprobante en la plataforma.</li>
                    <li>Tus clientes nunca ven avisos de cobro.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="seccion-crema">
    <div class="container">
        <div class="encabezado-seccion">
            <span class="eyebrow">Preguntas sobre el precio</span>
            <h2>Antes de pedir tu propuesta</h2>
        </div>
        <?= view('partials/faq', ['faqs' => $faqs]) ?>
    </div>
</section>

<?= view('partials/cta_final', ['campana' => 'precios-final', 'titulo' => 'Recibe tu propuesta según tus clientes', 'texto' => 'En la demo guiada revisamos cuántas empresas gestionas y de qué tamaño, y te enviamos el valor exacto de tu mensualidad.']) ?>
<?= $this->endSection() ?>
