<?php $sitio = config('Sitio'); ?>
<footer class="sitio-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <img src="<?= base_url('assets/img/marca/logo-enterprisesst-blanco-380.webp') ?>" alt="EnterpriseSST · Sistemas que evolucionan" class="footer-logo" width="190" height="110" loading="lazy">
                <p>El software SG-SST para firmas consultoras, consultores independientes y empresas con área SST propia.</p>
                <p><strong style="color:#fff;">EnterpriseSST es una marca de <a href="<?= esc($sitio->empresaUrl) ?>" target="_blank" rel="noopener">Cycloid Talent</a>.</strong></p>
            </div>
            <div>
                <h2 class="footer-titulo">Plataforma</h2>
                <ul>
                    <li><a href="<?= base_url('funciones') ?>">Funciones</a></li>
                    <li><a href="<?= base_url('precios') ?>">Precios</a></li>
                    <li><a href="<?= base_url('como-funciona') ?>">Cómo funciona el arriendo</a></li>
                    <li><a href="<?= base_url('preguntas-frecuentes') ?>">Preguntas frecuentes</a></li>
                    <li><a href="<?= base_url('blog') ?>">Blog</a></li>
                </ul>
            </div>
            <div>
                <h2 class="footer-titulo">Para quién</h2>
                <ul>
                    <li><a href="<?= base_url('para-firmas-consultoras') ?>">Firmas consultoras</a></li>
                    <li><a href="<?= base_url('para-consultores-independientes') ?>">Consultores independientes</a></li>
                    <li><a href="<?= base_url('para-empresas') ?>">Empresas con área SST</a></li>
                    <li><a href="<?= esc($sitio->aplicativoUrl) ?>" rel="nofollow">Ingresar a la plataforma</a></li>
                </ul>
            </div>
            <div>
                <h2 class="footer-titulo">Habla con nosotros</h2>
                <ul>
                    <li><?= esc($sitio->contactoNombre) ?>, <?= esc($sitio->contactoCargo) ?></li>
                    <li><a href="mailto:<?= esc($sitio->contactoCorreo) ?>"><?= esc($sitio->contactoCorreo) ?></a></li>
                    <li><a href="<?= esc(whatsapp_url()) ?>" target="_blank" rel="noopener">WhatsApp <?= esc($sitio->contactoTelefono) ?></a></li>
                    <li><a href="<?= esc(demo_url('pie')) ?>" target="_blank" rel="noopener">Pedir una demo</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-legal">
            <span>© <?= date('Y') ?> Cycloid Talent SAS · <?= esc($sitio->direccion) ?></span>
            <span><a href="<?= base_url('privacidad') ?>">Política de privacidad</a> · <a href="<?= base_url('terminos') ?>">Términos de uso</a></span>
        </div>
    </div>
</footer>
