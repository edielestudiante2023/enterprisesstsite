<?php

/** Las páginas operativas se pueden rastrear para que el buscador lea noindex. */
function seo_is_utility_page(string $path): bool
{
    $path = trim($path, '/');

    return in_array($path, [
        'iniciar-sesion', 'cerrar-sesion', 'recuperar-password', 'restablecer-password',
    ], true) || preg_match('#^(admin|restablecer-password)(/|$)#', $path) === 1;
}

/** El editor deja encabezados sin texto al pulsar Enter dentro de un título. */
function blog_limpiar_encabezados(string $html): string
{
    return preg_replace_callback('#<h[1-6]\b[^>]*>(.*?)</h[1-6]>#isu', static function (array $match): string {
        return blog_texto_plano($match[1]) === '' && stripos($match[1], '<img') === false ? '' : $match[0];
    }, $html);
}

/** Texto sin etiquetas ni espacios repetidos; separa bloques contiguos. */
function blog_texto_plano(string $html): string
{
    $text = html_entity_decode(strip_tags(str_replace('<', ' <', $html)), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    return trim(preg_replace('/[\s\x{00A0}]+/u', ' ', $text));
}

/** Resume un texto sin cortar palabras, para usarlo como meta descripción. */
function blog_resumir(string $html, int $max = 160): string
{
    $text = blog_texto_plano($html);
    if (mb_strlen($text) <= $max) {
        return $text;
    }

    $cut  = mb_substr($text, 0, $max);
    $last = mb_strrpos($cut, ' ');
    if ($last !== false) {
        $cut = mb_substr($cut, 0, $last);
    }

    return rtrim($cut, " ,;:.-") . '.';
}

/** Proporción de frases de tres palabras compartidas entre dos textos (0 a 1). */
function blog_similitud(string $htmlA, string $htmlB): float
{
    $shingles = static function (string $html): array {
        $words = preg_split('/[^\p{L}\p{N}]+/u', mb_strtolower(blog_texto_plano($html)), -1, PREG_SPLIT_NO_EMPTY);
        $set   = [];
        for ($i = 0, $total = count($words) - 2; $i < $total; $i++) {
            $set[$words[$i] . ' ' . $words[$i + 1] . ' ' . $words[$i + 2]] = true;
        }

        return $set;
    };

    $a = $shingles($htmlA);
    $b = $shingles($htmlB);
    if ($a === [] || $b === []) {
        return 0.0;
    }

    $shared = count(array_intersect_key($a, $b));

    return $shared / (count($a) + count($b) - $shared);
}

/**
 * Artículos parecidos al contenido dado, del más al menos similar. El umbral
 * 0,12 se calibró con los 25 artículos publicados: el único par casi duplicado
 * marcó 0,14 y el siguiente 0,098.
 *
 * @param list<array<string, mixed>> $posts
 *
 * @return list<array{titulo: string, porcentaje: int}>
 */
function blog_articulos_similares(string $contenido, array $posts, float $umbral = 0.12): array
{
    $similares = [];
    foreach ($posts as $post) {
        $similitud = blog_similitud($contenido, (string) $post['contenido']);
        if ($similitud >= $umbral) {
            $similares[] = ['titulo' => (string) $post['titulo'], 'porcentaje' => (int) round($similitud * 100)];
        }
    }
    usort($similares, static fn (array $a, array $b): int => $b['porcentaje'] <=> $a['porcentaje']);

    return $similares;
}
