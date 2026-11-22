<?php

/**
 * Genera las versiones livianas del logo de EnterpriseSST a partir del original
 * (public/assets/img/marca/logo-enterprisesst-lema-original.png, 5100 × 3300, fondo blanco).
 *
 * Uso: php tools/generar_marca.php
 *
 * Salida en public/assets/img/marca/ y public/:
 *  - simbolo-dorado.png / .webp      Ícono dorado con fondo transparente (encabezado, pie)
 *  - logo-enterprisesst.png / .webp  Logo completo con lema, 900 px de ancho (fondo transparente)
 *  - logo-enterprisesst-blanco.png / .webp  El mismo, con letras blancas para fondo oscuro
 *  - icono-32.png, icono-180.png, icono-512.png  Favicon y aplicación instalable
 *  - og-enterprisesst.png            Imagen para redes (1200 × 630)
 */

if (PHP_SAPI !== 'cli') {
    exit(1);
}

$dir      = dirname(__DIR__) . '/public/assets/img/marca/';
$original = $dir . 'logo-enterprisesst-lema-original.png';
$fuente   = 'C:/Windows/Fonts/arialbd.ttf';
$fuenteN  = 'C:/Windows/Fonts/arial.ttf';
if (! is_file($original)) {
    fwrite(STDERR, "Falta el original: {$original}\n");
    exit(1);
}

$src = imagecreatefrompng($original);
[$w, $h] = [imagesx($src), imagesy($src)];

// 1) Símbolo: recorte cuadrado alrededor del ícono (medido sobre el original), conservando
//    la transparencia del PNG original.
[$cx, $cy, $lado] = [1780, 480, 1540];
$simbolo = imagecreatetruecolor($lado, $lado);
imagealphablending($simbolo, false);
imagesavealpha($simbolo, true);
imagecopy($simbolo, $src, 0, 0, $cx, $cy, $lado, $lado);

$redimensionar = static function ($img, int $ancho, int $alto) {
    $out = imagecreatetruecolor($ancho, $alto);
    imagealphablending($out, false);
    imagesavealpha($out, true);
    imagefill($out, 0, 0, imagecolorallocatealpha($out, 0, 0, 0, 127));
    imagecopyresampled($out, $img, 0, 0, 0, 0, $ancho, $alto, imagesx($img), imagesy($img));

    return $out;
};

$s256 = $redimensionar($simbolo, 256, 256);
imagepng($s256, $dir . 'simbolo-dorado.png', 9);
imagewebp($s256, $dir . 'simbolo-dorado.webp', 90);

// 2) Íconos sobre fondo azul noche (favicon y aplicación).
foreach ([32, 180, 512] as $tam) {
    $ico = imagecreatetruecolor($tam, $tam);
    imagefill($ico, 0, 0, imagecolorallocate($ico, 28, 36, 55));
    imagealphablending($ico, true);
    $margen = (int) round($tam * 0.12);
    $sim    = $redimensionar($simbolo, $tam - 2 * $margen, $tam - 2 * $margen);
    imagecopy($ico, $sim, $margen, $margen, 0, 0, imagesx($sim), imagesy($sim));
    imagepng($ico, $dir . "icono-{$tam}.png", 9);
}

// 3) Logo completo liviano (recorta márgenes y deja 900 px de ancho), con transparencia.
//    Versión clara (letras azul noche) y versión para fondo oscuro (letras blancas).
[$lx, $ly, $lw, $lh] = [480, 450, 4140, 2400];
$alto = (int) round(900 * $lh / $lw);
$logo = imagecreatetruecolor(900, $alto);
imagealphablending($logo, false);
imagesavealpha($logo, true);
imagefill($logo, 0, 0, imagecolorallocatealpha($logo, 255, 255, 255, 127));
imagecopyresampled($logo, $src, 0, 0, $lx, $ly, 900, $alto, $lw, $lh);
imagepng($logo, $dir . 'logo-enterprisesst.png', 9);
imagewebp($logo, $dir . 'logo-enterprisesst.webp', 88);

$oscuro = imagecreatetruecolor(900, $alto);
imagealphablending($oscuro, false);
imagesavealpha($oscuro, true);
for ($y = 0; $y < $alto; $y++) {
    for ($x = 0; $x < 900; $x++) {
        $c = imagecolorat($logo, $x, $y);
        $a = ($c >> 24) & 127;
        $r = ($c >> 16) & 255;
        // El azul noche (rojo 28) pasa a blanco; el dorado (rojo 189) se conserva.
        $color = $r < 120 ? imagecolorallocatealpha($oscuro, 255, 255, 255, $a) : $c;
        imagesetpixel($oscuro, $x, $y, $color);
    }
}
imagepng($oscuro, $dir . 'logo-enterprisesst-blanco.png', 9);
imagewebp($oscuro, $dir . 'logo-enterprisesst-blanco.webp', 88);

// 4) Imagen para redes (Open Graph) 1200 × 630.
$og = imagecreatetruecolor(1200, 630);
imagefill($og, 0, 0, imagecolorallocate($og, 28, 36, 55));
imagealphablending($og, true);
$simOg = $redimensionar($simbolo, 300, 300);
imagecopy($og, $simOg, 90, 165, 0, 0, 300, 300);
$blanco = imagecolorallocate($og, 255, 255, 255);
$oro    = imagecolorallocate($og, 189, 151, 81);
$gris   = imagecolorallocate($og, 200, 205, 215);
imagettftext($og, 40, 0, 440, 280, $blanco, $fuente, 'E N T E R P R I S E S S T');
imagettftext($og, 30, 0, 444, 345, $oro, $fuenteN, 'Sistemas que evolucionan');
imagettftext($og, 22, 0, 444, 420, $gris, $fuenteN, 'El SG-SST de todos tus clientes en una sola plataforma');
imagettftext($og, 20, 0, 444, 470, $gris, $fuenteN, 'Una marca de Cycloid Talent');
imagepng($og, $dir . 'og-enterprisesst.png', 9);

// 5) Tamaños justos para cada uso (Lighthouse: no servir imágenes más grandes de lo que se muestran).
//    Encabezado 44 px -> 96 px (pantallas 2x); hero hasta 360 px -> 360 y 720 px; pie 190 px -> 380 px.
foreach ([96, 360, 720] as $tam) {
    $img = $redimensionar($simbolo, $tam, $tam);
    imagewebp($img, $dir . "simbolo-dorado-{$tam}.webp", 90);
}
$pie = imagecreatefrompng($dir . 'logo-enterprisesst-blanco.png');
imagealphablending($pie, false);
imagesavealpha($pie, true);
$pie380 = $redimensionar($pie, 380, (int) round(380 * imagesy($pie) / imagesx($pie)));
imagewebp($pie380, $dir . 'logo-enterprisesst-blanco-380.webp', 88);

// Favicon clásico en la raíz pública.
copy($dir . 'icono-32.png', dirname(__DIR__) . '/public/favicon.png');

echo "Listo: versiones del logo generadas en public/assets/img/marca/\n";
