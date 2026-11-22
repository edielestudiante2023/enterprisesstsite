<?php

/**
 * Corrige el incidente del 22 de noviembre de 2026: "php spark migrate -g production" corrió
 * contra la base LOCAL porque Config\Database no tenía el grupo production, y dejó en la
 * tabla migrations local registros falsos con group = 'production'. Las tablas locales no
 * cambiaron (ya existían). Este script borra SOLO esos registros. Nunca usar rollback: borraría
 * las tablas locales.
 *
 * Uso: php tools/limpiar_migraciones_falsas_local.php --confirmar
 */

if (PHP_SAPI !== 'cli' || ! in_array('--confirmar', $argv, true)) {
    fwrite(STDERR, "Uso: php tools/limpiar_migraciones_falsas_local.php --confirmar\n");
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
$stmt = $db->prepare('DELETE FROM migrations WHERE `group` = ?');
$grupo = 'production';
$stmt->bind_param('s', $grupo);
$stmt->execute();
echo "Base local: {$stmt->affected_rows} registros falsos de migración eliminados (group = production).\n";
