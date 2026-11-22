<?php
/** @var string $campana */
$titulo = $titulo ?? 'Mira EnterpriseSST funcionando con un cliente real';
$texto  = $texto ?? 'Agenda una demo guiada con Diana Cuestas, Directora Comercial de Cycloid Talent. Te mostramos la plataforma y te enviamos una propuesta según el número de empresas que gestionas.';
?>
<section class="cta-final">
    <div class="container">
        <span class="eyebrow">Demo guiada</span>
        <h2><?= esc($titulo) ?></h2>
        <p><?= esc($texto) ?></p>
        <div class="hero-ctas">
            <a href="<?= esc(demo_url($campana ?? 'cta-final')) ?>" class="btn btn-primary btn-lg" target="_blank" rel="noopener">Pedir demo</a>
            <a href="<?= esc(whatsapp_url()) ?>" class="btn btn-outline btn-lg" target="_blank" rel="noopener">Escribir por WhatsApp</a>
        </div>
    </div>
</section>
