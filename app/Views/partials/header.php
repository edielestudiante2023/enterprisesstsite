<?php
$activeNav = $activeNav ?? '';
$enlaces = [
    'funciones'     => ['Funciones', base_url('funciones')],
    'precios'       => ['Precios', base_url('precios')],
    'como-funciona' => ['Cómo funciona', base_url('como-funciona')],
    'blog'          => ['Blog', base_url('blog')],
    'preguntas'     => ['Preguntas', base_url('preguntas-frecuentes')],
];
?>
<header class="sitio-header">
    <div class="container">
        <a href="<?= base_url('/') ?>" class="marca">
            <img src="<?= base_url('assets/img/marca/simbolo-dorado-96.webp') ?>" alt="" width="44" height="44">
            <span class="marca-texto">
                <span class="marca-nombre">ENTERPRISESST</span>
                <span class="marca-lema">Sistemas que evolucionan</span>
            </span>
        </a>

        <button class="menu-boton" type="button" aria-controls="nav-principal" aria-expanded="false" aria-label="Abrir menú">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>

        <nav class="nav-principal" id="nav-principal" aria-label="Principal">
            <?php foreach ($enlaces as $clave => [$texto, $url]): ?>
                <a href="<?= $url ?>"<?= $activeNav === $clave ? ' aria-current="page"' : '' ?>><?= esc($texto) ?></a>
            <?php endforeach; ?>
            <a href="<?= esc(config('Sitio')->aplicativoUrl) ?>" class="nav-ingresar" rel="nofollow">Ingresar</a>
            <a href="<?= esc(demo_url('menu')) ?>" class="btn btn-primary" target="_blank" rel="noopener">Pedir demo</a>
        </nav>
    </div>
</header>
