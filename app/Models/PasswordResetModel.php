<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetModel extends Model
{
    protected $table         = 'password_resets';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = ['user_id', 'token', 'expires_at', 'used_at'];

    /**
     * Crea un nuevo token de recuperación, invalidando los previos del usuario.
     * Retorna el token en claro (para incluir en el link del email).
     */
    public function createToken(int $userId, int $ttlSeconds = 3600): string
    {
        // Invalidar tokens previos no usados del mismo usuario
        $this->where('user_id', $userId)
             ->where('used_at IS NULL', null, false)
             ->set(['used_at' => date('Y-m-d H:i:s')])
             ->update();

        $token = bin2hex(random_bytes(32)); // 64 chars hex
        $this->insert([
            'user_id'    => $userId,
            'token'      => $token,
            'expires_at' => date('Y-m-d H:i:s', time() + $ttlSeconds),
        ]);

        return $token;
    }

    /**
     * Busca un token válido (existe + no expirado + no usado).
     */
    public function findValidByToken(string $token): ?array
    {
        $row = $this->where('token', $token)
                    ->where('used_at IS NULL', null, false)
                    ->where('expires_at >', date('Y-m-d H:i:s'))
                    ->first();
        return $row ?: null;
    }

    public function markUsed(int $id): void
    {
        $this->update($id, ['used_at' => date('Y-m-d H:i:s')]);
    }
}
