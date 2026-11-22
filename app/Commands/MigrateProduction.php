<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;
use Config\Migrations as MigrationsConfig;

/**
 * Ejecuta las migraciones nuevas contra la BD `production` correctamente.
 *
 * Workaround a un bug de `php spark migrate -g production` (CI4 4.7.2 y 4.7.6; copiado de psyrisksite):
 * el flag -g cambia el filtro de history pero NO la conexión, por lo que
 * el CREATE TABLE se ejecuta en `default` (localhost) en lugar de en
 * producción. Esta clase fuerza la conexión correcta.
 *
 * Uso:
 *   php spark db:migrate-production
 */
class MigrateProduction extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:migrate-production';
    protected $description = 'Aplica migraciones pendientes en la BD production usando la conexión production.';
    protected $usage       = 'db:migrate-production';

    public function run(array $params)
    {
        $config = config(MigrationsConfig::class);
        // 'production' como string instruye al MigrationRunner a conectar a production.
        $runner = (new \CodeIgniter\Database\MigrationRunner($config, 'production'))
            ->setGroup('production')
            ->setNamespace('App');

        CLI::write('Conexión: production · Aplicando migraciones pendientes...', 'yellow');

        try {
            $ok = $runner->latest('production');
        } catch (\Throwable $e) {
            CLI::error('Falló: ' . $e->getMessage());
            return;
        }

        $messages = $runner->getCliMessages();
        foreach ($messages as $m) {
            CLI::write($m);
        }

        if ($ok) {
            CLI::write('Migraciones aplicadas en production.', 'green');
        } else {
            CLI::error('No se pudo completar la migración.');
        }
    }
}
