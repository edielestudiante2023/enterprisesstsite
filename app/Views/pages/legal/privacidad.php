<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $sitio = config('Sitio'); ?>
<section class="page-hero">
    <div class="container">
        <span class="eyebrow">Legal</span>
        <h1>Política de privacidad</h1>
        <p class="lead">Cómo trata Cycloid Talent SAS los datos de quienes visitan este sitio.</p>
    </div>
</section>

<section>
    <div class="container texto-legal">
        <p>EnterpriseSST es una marca de Cycloid Talent SAS, responsable del tratamiento de los datos personales que se recogen en este sitio, conforme a la Ley 1581 de 2012 y sus normas reglamentarias.</p>

        <h2>Qué datos recogemos en este sitio</h2>
        <p>Este sitio no tiene formularios propios. Cuando pides una demo, te llevamos al formulario de contacto de Cycloid Talent en cycloidtalent.com, donde tus datos se tratan según la <a href="https://cycloidtalent.com/politica-de-privacidad" target="_blank" rel="noopener">política de privacidad de Cycloid Talent</a>.</p>
        <p>Para saber desde qué canal llegaste (por ejemplo, una red social o una campaña), el sitio guarda en tu navegador, durante 90 días, los parámetros de la campaña de tu primera visita. Esa información se envía al formulario de contacto solo si decides pedir una demo.</p>
        <p>El panel de administración usa una cookie de sesión técnica, necesaria para que el equipo de Cycloid Talent publique contenido.</p>

        <h2>Para qué usamos los datos</h2>
        <p>Para responder tu solicitud de demo, enviarte una propuesta y medir qué canales y páginas nos traen solicitudes.</p>

        <h2>Tus derechos</h2>
        <p>Puedes conocer, actualizar, rectificar y pedir la supresión de tus datos, o revocar la autorización, escribiendo a <a href="mailto:<?= esc($sitio->contactoCorreo) ?>"><?= esc($sitio->contactoCorreo) ?></a>.</p>

        <h2>Responsable</h2>
        <p>Cycloid Talent SAS · <?= esc($sitio->direccion) ?> · Teléfono <?= esc($sitio->contactoTelefono) ?>.</p>
        <p style="color:var(--color-muted); font-size:.9rem;">Última actualización: 21 de noviembre de 2026.</p>
    </div>
</section>
<?= $this->endSection() ?>
