<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Artículos del blog. Misma estructura que psyrisksite (metadatos con límites 70/160,
 * noindex, contador de visitas). Los artículos los firma Cycloid Talent; autor_id
 * guarda quién lo creó en el panel. Idempotente.
 */
class CreateBlogPostsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'titulo'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'extracto'         => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'meta_titulo'      => ['type' => 'VARCHAR', 'constraint' => 70, 'null' => true],
            'meta_descripcion' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'categoria'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'etiquetas'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'contenido'        => ['type' => 'TEXT'],
            'imagen'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'imagen_alt'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'autor_id'         => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'publicado'        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'noindex'          => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'visitas'          => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug', 'uniq_slug');
        $this->forge->addKey(['publicado', 'created_at'], false, false, 'idx_publicado_created');
        $this->forge->addKey('autor_id', false, false, 'idx_autor');
        $this->forge->addForeignKey('autor_id', 'usuarios', 'id', 'CASCADE', 'SET NULL', 'fk_blog_autor');
        $this->forge->createTable('blog_posts', true, ['ENGINE' => 'InnoDB', 'COLLATE' => 'utf8mb4_unicode_ci']);
    }

    public function down(): void
    {
        $this->forge->dropTable('blog_posts', true);
    }
}
