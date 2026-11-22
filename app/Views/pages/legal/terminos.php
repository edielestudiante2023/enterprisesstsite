<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $sitio = config('Sitio'); ?>
<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Legal</span>
        <h1>Términos de uso del sitio</h1>
        <p class="lead">Condiciones para usar el sitio web de EnterpriseSST.</p>
    </div>
</section>

<section>
    <div class="container texto-legal">
        <p>Este sitio es de Cycloid Talent SAS, titular de la marca EnterpriseSST. Al usarlo aceptas estas condiciones.</p>

        <h2>Uso del sitio</h2>
        <p>El sitio es informativo: presenta la plataforma EnterpriseSST, sus funciones y sus precios. Su contenido no constituye asesoría en seguridad y salud en el trabajo.</p>

        <h2>Precios y contratación</h2>
        <p>Los precios publicados están en pesos colombianos y pueden cambiar. El arriendo de la plataforma se rige por la propuesta y las condiciones que Cycloid Talent acuerda con cada cliente; en caso de diferencia, prevalece lo acordado.</p>

        <h2>Propiedad intelectual</h2>
        <p>La marca EnterpriseSST, su logo, los textos y las imágenes de este sitio son de Cycloid Talent SAS. No se pueden reproducir sin autorización.</p>

        <h2>Enlaces</h2>
        <p>El sitio enlaza al formulario de contacto y a otros servicios de Cycloid Talent, que tienen sus propias condiciones.</p>

        <h2>Contacto</h2>
        <p>Escríbenos a <a href="mailto:<?= esc($sitio->contactoCorreo) ?>"><?= esc($sitio->contactoCorreo) ?></a>.</p>
        <p style="color:var(--color-muted); font-size:.9rem;">Última actualización: 21 de noviembre de 2026.</p>
    </div>
</section>
<?= $this->endSection() ?>
