<?php

namespace App\Commands;

use App\Models\BlogVisitasSnapshotModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;
use DateTimeImmutable;
use DateTimeZone;

/**
 * Captura el total acumulado de visitas de cada articulo.
 *
 * Cron de produccion (viernes 8:00 a. m. en Bogota):
 *   CRON_TZ=America/Bogota
 *   0 8 * * 5 cd /www/wwwroot/enterprisesstsite && php spark blog:snapshot-visitas
 */
class SnapshotBlogVisitas extends BaseCommand
{
    protected $group       = 'Blog';
    protected $name        = 'blog:snapshot-visitas';
    protected $description = 'Guarda el snapshot semanal de visitas acumuladas del blog.';
    protected $usage       = 'blog:snapshot-visitas [default|local|production]';
    protected $arguments   = [
        'entorno' => 'Opcional: default, local o production.',
    ];

    public function run(array $params)
    {
        $environment = $params[0] ?? 'default';
        if (! in_array($environment, ['default', 'local', 'production'], true)) {
            CLI::error('Entorno invalido. Usa default, local o production.');
            return EXIT_ERROR;
        }

        $group = $environment === 'production' ? 'production' : 'default';
        $now   = new DateTimeImmutable('now', new DateTimeZone('America/Bogota'));

        try {
            $db = Database::connect($group);
            if (! $db->tableExists('blog_visitas_snapshots')) {
                CLI::error("Falta blog_visitas_snapshots en {$environment}. Ejecuta la migracion primero.");
                return EXIT_ERROR;
            }

            $model  = new BlogVisitasSnapshotModel($db);
            $result = $model->capture($now);
            $history = $model->getEvolution(52);
        } catch (\Throwable $e) {
            CLI::error('No se pudo crear el snapshot: ' . $e->getMessage());
            return EXIT_ERROR;
        }

        CLI::write("Snapshot {$result['date']} (America/Bogota)", 'cyan');
        CLI::write("Articulos: {$result['posts']} | Visitas acumuladas: {$result['total']}");
        CLI::write("Nuevos: {$result['inserted']} | Actualizados: {$result['updated']}");
        CLI::write("Cortes historicos disponibles: {$history['summary']['snapshotCount']}");
        CLI::write('Snapshot completado OK.', 'green');

        return EXIT_SUCCESS;
    }
}
