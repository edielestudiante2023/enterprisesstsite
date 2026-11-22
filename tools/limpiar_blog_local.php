<?php

/**
 * Vacía el blog de la base LOCAL (artículos y snapshots), por ejemplo después de pruebas.
 * Se niega a correr si la base no es la local de XAMPP.
 *
 * Uso: php tools/limpiar_blog_local.php --confirmar
 */

if (PHP_SAPI !== 'cli' || ! in_array('--confirmar', $argv, true)) {
    fwrite(STDERR, "Uso: php tools/limpiar_blog_local.php --confirmar\n");
    exit(1);
}

$env = [];
foreach (file(dirname(__DIR__) . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
    if (str_contains($line, '=') && ! str_starts_with(trim($line), '#')) {
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        $env[$k] = trim($v, " \"'");
    }
}

$host = $env['database.default.hostname'] ?? '';
$base = $env['database.default.database'] ?? '';
if (! in_array($host, ['localhost', '127.0.0.1'], true) || $base !== 'enterprisesstsite') {
    fwrite(STDERR, "Solo se permite sobre la base local enterprisesstsite (host {$host}, base {$base}).\n");
    exit(1);
}

$db = new mysqli($host, $env['database.default.username'] ?? 'root', $env['database.default.password'] ?? '', $base, (int) ($env['database.default.port'] ?? 3306));
$db->set_charset('utf8mb4');
$snap  = $db->query('DELETE FROM blog_visitas_snapshots') ? $db->affected_rows : 0;
$posts = $db->query('DELETE FROM blog_posts') ? $db->affected_rows : 0;
echo "Base local limpia: {$posts} artículos y {$snap} snapshots eliminados.\n";
