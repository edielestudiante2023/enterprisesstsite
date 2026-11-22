<?= $this->extend('layouts/main') ?>

<?= $this->section('jsonld') ?>
<script type="application/ld+json"><?= json_encode(\App\Libraries\Contenido::softwareLd(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<?= view('partials/jsonld-faq', ['faqs' => $faqs]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php $sitio = config('Sitio'); ?>

<!-- =================== HERO =================== -->
<section class="hero">
    <div class="container hero-grid">
        <div>
            <p class="hero-marca">
                <span class="punto"><img src="<?= base_url('assets/img/marca/simbolo-dorado-96.webp') ?>" alt="" width="18" height="18"></span>
                <span>EnterpriseSST es una marca de <strong>Cycloid Talent</strong></span>
            </p>
            <h1>Gestiona el SG-SST de todos tus clientes en <span class="resalte">una sola plataforma</span></h1>
            <p class="lead">Documentos redactados con IA y el logo de cada cliente, estándares mínimos de la Resolución 0312, inspecciones desde el celular y firma electrónica. Todo con la marca de tu firma.</p>
            <div class="hero-ctas">
                <a href="<?= esc(demo_url('inicio-hero')) ?>" class="btn btn-primary btn-lg" target="_blank" rel="noopener">Pedir demo guiada</a>
                <a href="<?= base_url('precios') ?>" class="btn btn-claro btn-lg">Ver precios</a>
            </div>
            <ul class="hero-puntos">
                <li>Pagas solo por las empresas que gestionas</li>
                <li>Sin cobro por consultor ni por usuario</li>
                <li>Te acompañamos en la puesta en marcha</li>
            </ul>
        </div>
        <img class="hero-simbolo" src="<?= base_url('assets/img/marca/simbolo-dorado-360.webp') ?>" srcset="<?= base_url('assets/img/marca/simbolo-dorado-360.webp') ?> 360w, <?= base_url('assets/img/marca/simbolo-dorado-720.webp') ?> 720w" sizes="(max-width: 860px) 180px, 360px" alt="Símbolo de EnterpriseSST" width="360" height="360" fetchpriority="high">
    </div>
</section>

<!-- =================== PARA QUIÉN =================== -->
<section>
    <div class="container">
        <div class="encabezado-seccion">
            <span class="eyebrow">Para quién es</span>
            <h2>Hecho para quien lleva el SG-SST todos los días</h2>
            <p class="lead">Un mismo software, pensado para tres formas de trabajar.</p>
        </div>
        <div class="rejilla rejilla-3">
            <a class="tarjeta tarjeta-enlace" href="<?= base_url('para-firmas-consultoras') ?>">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'maletin']) ?></span>
                <h3>Firmas consultoras</h3>
                <p>Todo tu equipo y todos tus clientes en un solo lugar, con el avance de cada consultor a la vista y la marca de tu firma.</p>
                <span class="mas">Ver cómo te ayuda →</span>
            </a>
            <a class="tarjeta tarjeta-enlace" href="<?= base_url('para-consultores-independientes') ?>">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'persona']) ?></span>
                <h3>Consultores independientes</h3>
                <p>Deja de rehacer documentos en Word y Excel. Atiende más empresas con el mismo tiempo y entrega un trabajo más profesional.</p>
                <span class="mas">Ver cómo te ayuda →</span>
            </a>
            <a class="tarjeta tarjeta-enlace" href="<?= base_url('para-empresas') ?>">
                <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'edificio']) ?></span>
                <h3>Empresas con área SST</h3>
                <p>Tu responsable SST organiza documentos, evidencias, inspecciones y comités de tu empresa y sus sedes, listo para auditorías.</p>
                <span class="mas">Ver cómo te ayuda →</span>
            </a>
        </div>
    </div>
</section>

<!-- =================== ANTES Y DESPUÉS =================== -->
<section class="seccion-crema">
    <div class="container">
        <div class="encabezado-seccion">
            <span class="eyebrow">El cambio</span>
            <h2>Del Excel y las carpetas a un sistema que evoluciona</h2>
        </div>
        <div class="antes-despues">
            <div class="antes">
                <h3>Sin EnterpriseSST</h3>
                <ul>
                    <li>Copiar y adaptar el mismo documento para cada cliente</li>
                    <li>Evidencias repartidas entre correos, carpetas y celulares</li>
                    <li>Firmas impresas, escaneadas y perdidas</li>
                    <li>Inspecciones en papel que se pasan después al computador</li>
                    <li>Clientes que piden informes de avance por correo</li>
                </ul>
            </div>
            <div class="despues">
                <h3>Con EnterpriseSST</h3>
                <ul>
                    <li>La IA redacta el borrador con el contexto del cliente; tú lo apruebas</li>
                    <li>Cada evidencia queda organizada por cliente y por estándar</li>
                    <li>Firma electrónica por correo, con verificación pública</li>
                    <li>Inspecciones con fotos desde el celular</li>
                    <li>El cliente consulta su avance en su propio portal</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- =================== FUNCIONES =================== -->
<section>
    <div class="container">
        <div class="encabezado-seccion">
            <span class="eyebrow">Qué hace</span>
            <h2>Todo el SG-SST, del diagnóstico a la auditoría</h2>
            <p class="lead">Funciones que ya usan a diario Cycloid Talent y los profesionales que arriendan la plataforma.</p>
        </div>
        <div class="rejilla rejilla-4">
            <?php foreach ($funciones as $f): ?>
                <div class="tarjeta">
                    <span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => $f['icono']]) ?></span>
                    <h3><?= esc($f['titulo']) ?></h3>
                    <p><?= esc($f['texto']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <p style="text-align:center; margin-top:32px;">
            <a href="<?= base_url('funciones') ?>" class="btn btn-outline">Ver todas las funciones</a>
        </p>
    </div>
</section>

<!-- =================== MARCA PROPIA Y AISLAMIENTO =================== -->
<section class="seccion-azul">
    <div class="container dividida">
        <div>
            <span class="eyebrow">Tu marca, tus datos</span>
            <h2>Tus clientes ven tu firma, no la nuestra</h2>
            <p>Tus consultores y tus clientes trabajan con el logo, el nombre y el color de tu firma. Los documentos de cada cliente salen con el logo de ese cliente.</p>
            <ul class="lista-check">
                <li>Espacio propio y aislado: nadie más ve a tus clientes</li>
                <li>Tu propio administrador, tus consultores y tus clientes</li>
                <li>Cycloid Talent solo entra para darte soporte, y cada acceso queda registrado</li>
                <li>Tus clientes nunca ven avisos de cobro</li>
            </ul>
            <a href="<?= base_url('como-funciona') ?>" class="btn btn-claro">Cómo funciona el arriendo</a>
        </div>
        <div class="rejilla rejilla-2">
            <div class="tarjeta"><span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'marca']) ?></span><h3>Con tu marca</h3><p>Logo, nombre y color de tu firma en la plataforma.</p></div>
            <div class="tarjeta"><span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'escudo']) ?></span><h3>Aislado</h3><p>Ninguna otra firma ve tu información.</p></div>
            <div class="tarjeta"><span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'portal']) ?></span><h3>Portal del cliente</h3><p>Consulta en solo lectura de su avance.</p></div>
            <div class="tarjeta"><span class="tarjeta-icono"><?= view('partials/icono', ['nombre' => 'celular']) ?></span><h3>En el celular</h3><p>Inspecciones, comités e IPEVR desde el teléfono.</p></div>
        </div>
    </div>
</section>

<!-- =================== PRECIO =================== -->
<section>
    <div class="container dividida">
        <div>
            <span class="eyebrow">Precio claro</span>
            <h2>Pagas solo por las empresas que gestionas</h2>
            <p>Una mensualidad por cada empresa cliente activa, según su tamaño. Sin cobro por consultor, por usuario ni por documentos.</p>
            <p class="ejemplo-precio">Sin cláusulas de permanencia ni paquetes rígidos: activas o desactivas empresas según el movimiento real de tu cartera.</p>
            <a href="<?= base_url('precios') ?>" class="btn btn-primary">Ver todas las tarifas</a>
        </div>
        <div class="tarjeta">
            <h3>Una mensualidad por empresa, según su tamaño</h3>
            <ul class="lista-check">
                <li>Todas las funciones incluidas</li>
                <li>Consultores y usuarios sin costo adicional</li>
                <li>Solo pagas los clientes activos del mes</li>
                <li>Demo guiada y acompañamiento en la puesta en marcha</li>
            </ul>
        </div>
    </div>
</section>

<!-- =================== CÓMO EMPEZAR =================== -->
<section class="seccion-crema">
    <div class="container">
        <div class="encabezado-seccion">
            <span class="eyebrow">Cómo empezar</span>
            <h2>De la demo a tu primer cliente en la plataforma</h2>
        </div>
        <div class="pasos">
            <div class="paso"><h3>Demo guiada</h3><p>Te mostramos la plataforma con un caso real y resolvemos tus dudas.</p></div>
            <div class="paso"><h3>Propuesta</h3><p>Calculamos tu mensualidad según el número y tamaño de tus clientes.</p></div>
            <div class="paso"><h3>Tu espacio</h3><p>Creamos tu espacio y recibes un correo de bienvenida con tus credenciales.</p></div>
            <div class="paso"><h3>Puesta en marcha</h3><p>Te acompañamos a cargar tus clientes, también desde Excel.</p></div>
        </div>
    </div>
</section>

<!-- =================== CONFIANZA Y CONTACTO =================== -->
<section class="seccion-azul">
    <div class="container dividida">
        <div>
            <span class="eyebrow">Respaldo</span>
            <h2>La plataforma que Cycloid Talent usa con sus propios clientes</h2>
            <p>EnterpriseSST nació para gestionar el SG-SST de los clientes de Cycloid Talent. Hoy profesionales SST ya la arriendan para gestionar los suyos.</p>
        </div>
        <div>
            <div class="contacto-persona">
                <img src="<?= base_url('assets/img/equipo/diana-cuestas-360.webp') ?>" alt="Diana Cuestas, Directora Comercial de Cycloid Talent" width="84" height="84" loading="lazy">
                <div>
                    <strong><?= esc($sitio->contactoNombre) ?></strong>
                    <span><?= esc($sitio->contactoCargo) ?> de Cycloid Talent</span><br>
                    <span><a href="mailto:<?= esc($sitio->contactoCorreo) ?>" style="color:#fff;"><?= esc($sitio->contactoCorreo) ?></a> · <?= esc($sitio->contactoTelefono) ?></span>
                </div>
            </div>
            <div class="hero-ctas">
                <a href="<?= esc(demo_url('inicio-diana')) ?>" class="btn btn-primary" target="_blank" rel="noopener">Agendar demo con Diana</a>
                <a href="<?= esc(whatsapp_url()) ?>" class="btn btn-claro" target="_blank" rel="noopener">WhatsApp</a>
            </div>
        </div>
    </div>
</section>

<!-- =================== PREGUNTAS =================== -->
<section>
    <div class="container">
        <div class="encabezado-seccion">
            <span class="eyebrow">Preguntas frecuentes</span>
            <h2>Lo que nos preguntan antes de arrendar</h2>
        </div>
        <?= view('partials/faq', ['faqs' => $faqs]) ?>
        <p style="text-align:center; margin-top:24px;"><a href="<?= base_url('preguntas-frecuentes') ?>">Ver todas las preguntas →</a></p>
    </div>
</section>

<?= view('partials/cta_final', ['campana' => 'inicio-final']) ?>

<?= $this->endSection() ?>
