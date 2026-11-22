<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$isEdit = isset($usuario) && $usuario;
$action = $isEdit
    ? base_url('admin/usuarios/actualizar/' . $usuario['id'])
    : base_url('admin/usuarios/guardar');
$pageTitleH1 = $isEdit ? 'Editar usuario' : 'Nuevo usuario';
?>

<section class="page-hero">
    <div class="container">
        <div class="admin-bar">
            <div>
                <span class="eyebrow" style="display:inline-block; text-transform:uppercase; letter-spacing:.12em; font-size:.8rem; font-weight:600; color:var(--color-secondary); margin-bottom:8px;">Panel de administración</span>
                <h1 style="margin-bottom:6px;"><?= esc($pageTitleH1) ?></h1>
                <p style="color:var(--color-muted); margin:0;">Sesión: <strong><?= esc(session()->get('user_name')) ?></strong> · <?= esc(session()->get('user_email')) ?></p>
            </div>
            <div style="display:flex; gap:8px;">
                <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-ghost">← Volver</a>
                <form method="post" action="<?= base_url('cerrar-sesion') ?>" style="margin:0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline">Cerrar sesión</button>
                </form>
            </div>
        </div>

        <?php $error = session()->getFlashdata('error'); if (is_string($error) && $error !== ''): ?>
            <div class="auth-alert auth-alert-error"><?= esc($error) ?></div>
        <?php endif; ?>

        <div class="admin-card">
            <h2 style="font-size:1.15rem; margin-bottom:18px;">Datos del usuario</h2>

            <form method="post" action="<?= esc($action) ?>" class="admin-form">
                <?= csrf_field() ?>

                <div class="form-row-2">
                    <label>
                        <span>Nombre</span>
                        <input type="text" name="name" required maxlength="120"
                            value="<?= esc(old('name', $usuario['name'] ?? '')) ?>">
                    </label>

                    <label>
                        <span>Email</span>
                        <input type="email" name="email" required maxlength="190"
                            value="<?= esc(old('email', $usuario['email'] ?? '')) ?>">
                    </label>
                </div>

                <div class="form-row-2">
                    <label>
                        <span>Rol</span>
                        <select name="role_id" required>
                            <option value="">Selecciona un rol</option>
                            <?php $currentRoleId = (int) old('role_id', $usuario['role_id'] ?? 0); foreach ($roles as $r): ?>
                                <option value="<?= (int) $r['id'] ?>" <?= $currentRoleId === (int) $r['id'] ? 'selected' : '' ?>>
                                    <?= esc($r['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span>Estado</span>
                        <select name="status">
                            <?php $currentStatus = old('status', $usuario['status'] ?? 'active'); ?>
                            <option value="active"   <?= $currentStatus === 'active'   ? 'selected' : '' ?>>Activo</option>
                            <option value="inactive" <?= $currentStatus === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </label>
                </div>

                <label>
                    <span><?= $isEdit ? 'Nueva contraseña (déjala vacía para no cambiarla)' : 'Contraseña (mínimo 8 caracteres)' ?></span>
                    <?= view('partials/password-field', ['name' => 'password', 'autocomplete' => 'new-password', 'required' => ! $isEdit]) ?>
                </label>

                <div style="display:flex; gap:10px; margin-top:8px;">
                    <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Actualizar usuario' : 'Crear usuario' ?></button>
                    <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
