<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Foto semanal de las visitas de cada artículo (copiado de psyrisksite).
 * La llena el comando blog:snapshot-visitas (cron semanal). Una fila por artículo y fecha.
 * Idempotente.
 */
class CreateBlogVisitasSnapshotsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'                 => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'blog_post_id'       => ['type' => 'INT', 'unsigned' => true],
            'titulo'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'               => ['type' => 'VARCHAR', 'constraint' => 255],
            'snapshot_date'      => ['type' => 'DATE'],
            'visitas_acumuladas' => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'captured_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['snapshot_date', 'blog_post_id'], 'uniq_snapshot_post');
        $this->forge->addKey('snapshot_date', false, false, 'idx_snapshot_date');
        $this->forge->addKey(['blog_post_id', 'snapshot_date'], false, false, 'idx_post_date');
        $this->forge->createTable('blog_visitas_snapshots', true, ['ENGINE' => 'InnoDB', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down(): void
    {
        $this->forge->dropTable('blog_visitas_snapshots', true);
    }
}
