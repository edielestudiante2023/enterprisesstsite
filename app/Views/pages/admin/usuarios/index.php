<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-hero">
    <div class="container">
        <div class="admin-bar">
            <div>
                <span class="eyebrow" style="display:inline-block; text-transform:uppercase; letter-spacing:.12em; font-size:.8rem; font-weight:600; color:var(--color-secondary); margin-bottom:8px;">Panel de administración</span>
                <h1 style="margin-bottom:6px;">Usuarios</h1>
                <p style="color:var(--color-muted); margin:0;">Sesión: <strong><?= esc(session()->get('user_name')) ?></strong> · <?= esc(session()->get('user_email')) ?></p>
            </div>
            <div style="display:flex; gap:8px;">
                <a href="<?= base_url('admin/blog') ?>" class="btn btn-ghost">Blog</a>
                <form method="post" action="<?= base_url('cerrar-sesion') ?>" style="margin:0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline">Cerrar sesión</button>
                </form>
            </div>
        </div>

        <?php $error = session()->getFlashdata('error'); if (is_string($error) && $error !== ''): ?>
            <div class="auth-alert auth-alert-error"><?= esc($error) ?></div>
        <?php endif; ?>
        <?php $success = session()->getFlashdata('success'); if (is_string($success) && $success !== ''): ?>
            <div class="auth-alert auth-alert-success"><?= esc($success) ?></div>
        <?php endif; ?>

        <div class="admin-card" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h2 style="font-size:1.15rem; margin:0 0 4px;">Usuarios registrados (<?= count($usuarios) ?>)</h2>
                <p style="margin:0; color:var(--color-muted); font-size:.9rem;">Cualquiera de ellos puede entrar al panel y gestionar clientes.</p>
            </div>
            <a href="<?= base_url('admin/usuarios/nuevo') ?>" class="btn btn-primary">Nuevo usuario</a>
        </div>

        <div class="admin-card">
            <?php if (empty($usuarios)): ?>
                <p style="color:var(--color-muted); margin:0;">No hay usuarios.</p>
            <?php else: ?>
                <div class="ficha-table-wrap">
                    <table class="ficha-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Último login</th>
                                <th style="width:120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $u): ?>
                                <tr>
                                    <td><?= esc($u['name']) ?></td>
                                    <td><?= esc($u['email']) ?></td>
                                    <td><?= esc($u['role_name'] ?? '-') ?></td>
                                    <td><?= $u['status'] === 'active' ? '<span style="color:var(--color-success); font-weight:600;">Activo</span>' : '<span style="color:var(--color-muted);">Inactivo</span>' ?></td>
                                    <td><?= $u['last_login_at'] ? esc($u['last_login_at']) : '<span style="color:var(--color-muted);">Nunca</span>' ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/usuarios/editar/' . $u['id']) ?>" class="btn btn-ghost" style="padding:6px 10px; font-size:.85rem;">Editar</a>
                                        <?php if ((int) $u['id'] !== (int) session()->get('user_id')): ?>
                                            <form method="post" action="<?= base_url('admin/usuarios/eliminar/' . $u['id']) ?>" style="display:inline; margin:0;" data-confirmar="¿Eliminar este usuario?">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-ghost" style="color:var(--color-danger); padding:6px 10px; font-size:.85rem;">Eliminar</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
