<?php

namespace App\Commands;

use App\Models\RoleModel;
use App\Models\UserModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Crea o reactiva un administrador del panel.
 *
 * Uso: php spark admin:crear correo@dominio.com "Nombre Apellido"
 * La contraseña se pide por consola (no queda en el historial). Idempotente: si el
 * correo ya existe, solo actualiza la contraseña y lo activa.
 */
class CrearAdmin extends BaseCommand
{
    protected $group       = 'Panel';
    protected $name        = 'admin:crear';
    protected $description = 'Crea o reactiva un administrador del panel del sitio.';
    protected $usage       = 'admin:crear <correo> <nombre>';

    public function run(array $params)
    {
        $email = strtolower(trim((string) ($params[0] ?? '')));
        $name  = trim((string) ($params[1] ?? ''));
        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || $name === '') {
            CLI::error('Uso: php spark admin:crear correo@dominio.com "Nombre Apellido"');

            return EXIT_ERROR;
        }

        $role = (new RoleModel())->where('name', 'admin')->first();
        if (! $role) {
            CLI::error('Falta el rol admin. Corre primero: php spark db:seed RolesSeeder');

            return EXIT_ERROR;
        }

        $password = (string) (getenv('ADMIN_PASSWORD') ?: CLI::prompt('Contraseña (mínimo 8 caracteres)'));
        if (strlen($password) < 8) {
            CLI::error('La contraseña debe tener al menos 8 caracteres.');

            return EXIT_ERROR;
        }

        $users = new UserModel();
        $data  = [
            'email'         => $email,
            'name'          => $name,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role_id'       => (int) $role['id'],
            'status'        => 'active',
        ];

        $existing = $users->findByEmail($email);
        if ($existing) {
            $users->update((int) $existing['id'], $data);
            CLI::write("Administrador actualizado: {$email}", 'green');
        } else {
            $users->insert($data);
            CLI::write("Administrador creado: {$email}", 'green');
        }

        return EXIT_SUCCESS;
    }
}
