<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Rol administrador del panel. Idempotente: no lo duplica si ya existe.
 * Uso: php spark db:seed RolesSeeder
 */
class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = $this->db->table('roles');
        if ($roles->where('name', 'admin')->countAllResults() === 0) {
            $this->db->table('roles')->insert([
                'name'        => 'admin',
                'description' => 'Acceso total al panel de administración',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
