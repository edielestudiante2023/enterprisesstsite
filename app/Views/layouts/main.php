<?php
/**
 * Plantilla principal de EnterpriseSST.
 *
 * Cada controlador entrega title y description. Las vistas NO pasan otra description a
 * sus parciales de JSON-LD: en psyrisksite eso reemplazó la del controlador en el <head>
 * (lección del 23 de octubre de 2026).
 */
$sitio           = config('Sitio');
$pageTitle       = $title ?? 'EnterpriseSST · Software SG-SST para consultores y empresas';
$pageDescription = $description ?? 'Gestiona el SG-SST de todos tus clientes en una sola plataforma: documentos con IA, estándares mínimos, inspecciones desde el celular y firma electrónica.';
$canonical       = $canonical ?? base_url(uri_string());
$ogImage         = $ogImage ?? base_url('assets/img/marca/og-enterprisesst.png');
$ogImageAlt      = $ogImageAlt ?? 'EnterpriseSST · Sistemas que evolucionan · Una marca de Cycloid Talent';
$ogType          = $ogType ?? 'website';
$robots          = seo_is_utility_page(uri_string()) ? 'noindex, nofollow' : ($robots ?? 'index, follow, max-image-preview:large');
$activeNav       = $activeNav ?? '';

// Medidas reales de la imagen para Open Graph (las de los artículos varían).
$ogImageMeta = str_starts_with($ogImage, base_url())
    ? @getimagesize(FCPATH . substr($ogImage, strlen(base_url())))
    : false;
$assetVer = (string) (@filemtime(FCPATH . 'assets/css/enterprisesst.css') ?: '1');
$gaId     = (string) (env('GA_MEASUREMENT_ID') ?: '');

$organizacionLd = [
    '@context' => 'https://schema.org',
    '@type'    => 'Organization',
    '@id'      => base_url('/') . '#organizacion',
    'name'     => 'Cycloid Talent',
    'legalName' => 'Cycloid Talent SAS',
    'url'      => $sitio->empresaUrl,
    'brand'    => [
        '@type' => 'Brand',
        'name'  => $sitio->marca,
        'slogan' => $sitio->lema,
        'logo'  => base_url('assets/img/marca/logo-enterprisesst.png'),
        'url'   => base_url('/'),
        'sameAs' => array_values($sitio->redes),
    ],
    'address' => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => 'Tv. 24B #17-209',
        'addressLocality' => 'Soacha',
        'addressRegion'   => 'Cundinamarca',
        'addressCountry'  => 'CO',
    ],
    'contactPoint' => [
        '@type'             => 'ContactPoint',
        'telephone'         => '+57-311-791-9191',
        'email'             => $sitio->contactoCorreo,
        'contactType'       => 'sales',
        'areaServed'        => 'CO',
        'availableLanguage' => ['Spanish'],
    ],
];
$sitioLd = [
    '@context'   => 'https://schema.org',
    '@type'      => 'WebSite',
    '@id'        => base_url('/') . '#sitio',
    'name'       => $sitio->marca,
    'url'        => base_url('/'),
    'inLanguage' => 'es-CO',
    'publisher'  => ['@id' => base_url('/') . '#organizacion'],
];
?>
<!DOCTYPE html>
<html lang="es-CO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle) ?></title>
    <meta name="description" content="<?= esc($pageDescription) ?>">
    <meta name="robots" content="<?= esc($robots) ?>">
    <link rel="canonical" href="<?= esc($canonical) ?>">
    <meta name="theme-color" content="#1c2437">

    <meta property="og:type" content="<?= esc($ogType) ?>">
    <meta property="og:site_name" content="EnterpriseSST">
    <meta property="og:locale" content="es_CO">
    <meta property="og:title" content="<?= esc($ogTitle ?? $pageTitle) ?>">
    <meta property="og:description" content="<?= esc($ogDescription ?? $pageDescription) ?>">
    <meta property="og:url" content="<?= esc($canonical) ?>">
    <meta property="og:image" content="<?= esc($ogImage) ?>">
    <meta property="og:image:alt" content="<?= esc($ogImageAlt) ?>">
    <?php if ($ogImageMeta): ?>
    <meta property="og:image:width" content="<?= (int) $ogImageMeta[0] ?>">
    <meta property="og:image:height" content="<?= (int) $ogImageMeta[1] ?>">
    <meta property="og:image:type" content="<?= esc($ogImageMeta['mime']) ?>">
    <?php endif; ?>
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/img/marca/icono-32.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('assets/img/marca/icono-180.png') ?>">

    <?php /* Fuentes propias precargadas: el navegador las pide antes de leer el CSS. */ ?>
    <link rel="preload" href="<?= base_url('assets/fonts/montserrat-latin-var.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= base_url('assets/fonts/inter-latin-var.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= base_url('assets/css/enterprisesst.css') ?>?v=<?= esc($assetVer) ?>">
    <script src="<?= base_url('assets/js/enterprisesst.js') ?>?v=<?= esc($assetVer) ?>" defer></script>
    <?php if (! str_starts_with(uri_string(), 'admin')): ?>
    <?php /* Precarga de la página siguiente al pasar el cursor o empezar a tocar un enlace interno.
             Excluye el panel, enlaces externos o sin seguimiento y los que abren en otra pestaña. */ ?>
    <script type="speculationrules" <?= csp_script_nonce() ?>>
    {"prefetch": [{"where": {"and": [
        {"href_matches": "/*"},
        {"not": {"href_matches": "/*admin*"}},
        {"not": {"href_matches": "/*sesion*"}},
        {"not": {"href_matches": "/*password*"}},
        {"not": {"selector_matches": "[rel~=nofollow]"}},
        {"not": {"selector_matches": "[target=_blank]"}}
    ]}, "eagerness": "moderate"}]}
    </script>
    <?php endif; ?>

    <script type="application/ld+json"><?= json_encode($organizacionLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
    <script type="application/ld+json"><?= json_encode($sitioLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
    <?= $this->renderSection('jsonld') ?>
    <?= $this->renderSection('head') ?>

    <?php if ($gaId !== '' && ENVIRONMENT === 'production'): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= esc($gaId) ?>"></script>
    <script <?= csp_script_nonce() ?>>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= esc($gaId) ?>');</script>
    <?php endif; ?>
</head>
<body>
    <a href="#contenido" class="sr-saltar">Saltar al contenido</a>
    <?= view('partials/header', ['activeNav' => $activeNav]) ?>

    <main id="contenido">
        <?= $this->renderSection('content') ?>
    </main>

    <?= view('partials/footer') ?>

    <a href="<?= esc(whatsapp_url()) ?>" class="whatsapp-flotante" target="_blank" rel="noopener" aria-label="Escribir a Diana por WhatsApp">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.5 14.4c-.3-.1-1.7-.8-2-.9-.3-.1-.5-.1-.7.1-.2.3-.8.9-.9 1.1-.2.2-.3.2-.6.1-.3-.1-1.2-.5-2.3-1.4-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6l.4-.5c.2-.2.2-.3.3-.5.1-.2 0-.4 0-.5l-.9-2.2c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.4s1 2.8 1.2 3c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.7-.7 1.9-1.4.2-.7.2-1.2.2-1.4-.1-.1-.3-.2-.6-.3zM12 21.8c-1.8 0-3.5-.5-5-1.4l-.4-.2-3.7 1 1-3.6-.2-.4C2.7 15.6 2.2 13.8 2.2 12 2.2 6.6 6.6 2.2 12 2.2c2.6 0 5.1 1 6.9 2.9 1.8 1.8 2.9 4.3 2.9 6.9 0 5.4-4.4 9.8-9.8 9.8zm8.4-18.2C18.1 1.3 15.2.1 12 .1 5.5.1.2 5.4.2 11.9c0 2.1.5 4.1 1.6 5.9L.1 24l6.3-1.7c1.7.9 3.7 1.4 5.6 1.4 6.5 0 11.8-5.3 11.8-11.8 0-3.2-1.2-6.1-3.4-8.3z"/></svg>
    </a>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
