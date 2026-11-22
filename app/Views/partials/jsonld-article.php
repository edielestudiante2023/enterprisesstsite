<?php
/**
 * @var string $headline
 * @var string $description
 * @var string $url
 * @var string $datePublished  (opcional, formato Y-m-d)
 * @var string $dateModified   (opcional, formato Y-m-d; si falta usa datePublished)
 * @var string $articleSection (opcional, categoria del articulo)
 * @var string $keywords       (opcional, palabras clave separadas por coma)
 */
$schema = [
    '@context'         => 'https://schema.org',
    '@type'            => 'Article',
    'headline'         => $headline,
    'description'      => $description,
    'url'              => $url,
    'inLanguage'       => 'es-CO',
    'author'           => [
        '@type' => 'Organization',
        'name'  => 'Cycloid Talent',
        'url'   => 'https://cycloidtalent.com/',
    ],
    'publisher'        => [
        '@type' => 'Organization',
        'name'  => 'Cycloid Talent',
        'url'   => 'https://cycloidtalent.com/',
        'logo'  => [
            '@type' => 'ImageObject',
            'url'   => base_url('assets/img/marca/logo-enterprisesst.png'),
        ],
    ],
    'about'            => [
        ['@type' => 'Thing', 'name' => 'SG-SST'],
        ['@type' => 'Thing', 'name' => 'Seguridad y salud en el trabajo'],
        ['@type' => 'Thing', 'name' => 'Software SG-SST'],
    ],
    'isAccessibleForFree' => true,
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id'   => $url,
    ],
];

if (! empty($datePublished)) {
    $schema['datePublished'] = $datePublished;
}
if (! empty($dateModified)) {
    $schema['dateModified'] = $dateModified;
}
if (! empty($image)) {
    $schema['image'] = $image;
}

if (! empty($articleSection)) {
    $schema['articleSection'] = $articleSection;
}
if (! empty($keywords)) {
    $schema['keywords'] = $keywords;
}
?>
<script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
