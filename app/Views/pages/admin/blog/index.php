<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-hero">
    <div class="container">
        <div class="admin-bar">
            <div>
                <span class="eyebrow" style="display:inline-block; text-transform:uppercase; letter-spacing:.12em; font-size:.8rem; font-weight:600; color:var(--color-secondary); margin-bottom:8px;">Panel de administración</span>
                <h1 style="margin-bottom:6px;">Blog</h1>
                <p style="color:var(--color-muted); margin:0;">Sesión: <strong><?= esc(session()->get('user_name')) ?></strong> · <?= esc(session()->get('user_email')) ?></p>
            </div>
            <div style="display:flex; gap:8px;">
                <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-ghost">Usuarios</a>
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
        <?php $errors = session()->getFlashdata('errors'); if (is_array($errors) && ! empty($errors)): ?>
            <div class="auth-alert auth-alert-error">
                <ul style="margin:0; padding-left:1.2em;">
                    <?php foreach ($errors as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php
        // Consolidado de visitas: el listado viene ordenado por visitas DESC,
        // asi que el primer post con visitas > 0 es el mas visitado.
        $totalVisitas = array_sum(array_map(static fn ($p) => (int) ($p['visitas'] ?? 0), $posts));
        $masVisitado  = (! empty($posts) && (int) ($posts[0]['visitas'] ?? 0) > 0) ? $posts[0] : null;
        ?>
        <div class="admin-card" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
            <div>
                <h2 style="font-size:1.15rem; margin:0 0 4px;">Artículos (<?= count($posts) ?>) · Visitas totales: <span style="color:var(--color-primary);"><?= number_format($totalVisitas, 0, ',', '.') ?></span></h2>
                <p style="margin:0; color:var(--color-muted); font-size:.9rem;">
                    Ordenados del más al menos visitado. Sólo los publicados aparecen en /blog y /sitemap.xml.
                    <?php if ($masVisitado !== null): ?>
                        <br>Más visitado: <strong><?= esc($masVisitado['titulo']) ?></strong> (<?= number_format((int) $masVisitado['visitas'], 0, ',', '.') ?> visitas)
                    <?php endif; ?>
                </p>
            </div>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <a href="<?= base_url('admin/blog/estadisticas') ?>" class="btn btn-outline">Ver evolución semanal</a>
                <a href="<?= base_url('admin/blog/crear') ?>" class="btn btn-primary">+ Nuevo artículo</a>
            </div>
        </div>

        <div class="admin-card">
            <?php if (empty($posts)): ?>
                <p style="color:var(--color-muted); margin:0;">No hay artículos aún.</p>
            <?php else: ?>
                <div class="ficha-table-wrap">
                    <table class="ficha-table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Visitas</th>
                                <th>Autor</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th style="width:260px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $p): ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($p['titulo']) ?></strong>
                                        <?php if (! empty($p['imagen'])): ?>
                                            <span style="display:inline-block; margin-left:6px; padding:1px 6px; background:var(--color-primary-light); color:var(--color-primary-dark); font-size:.7rem; border-radius:4px;">img</span>
                                        <?php endif; ?>
                                        <div style="font-size:.78rem; color:var(--color-muted); margin-top:2px;">/blog/<?= esc($p['slug']) ?></div>
                                    </td>
                                    <td><strong style="color:var(--color-primary);"><?= number_format((int) ($p['visitas'] ?? 0), 0, ',', '.') ?></strong></td>
                                    <td><?= esc($p['autor_nombre'] ?? 'Sin autor') ?></td>
                                    <td>
                                        <?php if ((int) $p['publicado'] === 1): ?>
                                            <span style="color:var(--color-success); font-weight:600;">Publicado</span>
                                        <?php else: ?>
                                            <span style="color:var(--color-muted);">Borrador</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc(date('d/m/Y', strtotime($p['created_at']))) ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/blog/editar/' . $p['id']) ?>" class="btn btn-ghost" style="padding:6px 10px; font-size:.85rem;">Editar</a>
                                        <form method="post" action="<?= base_url('admin/blog/toggle/' . $p['id']) ?>" style="display:inline; margin:0;">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-ghost" style="padding:6px 10px; font-size:.85rem; color:var(--color-secondary);">
                                                <?= (int) $p['publicado'] === 1 ? 'Despublicar' : 'Publicar' ?>
                                            </button>
                                        </form>
                                        <form method="post" action="<?= base_url('admin/blog/eliminar/' . $p['id']) ?>" style="display:inline; margin:0;" data-confirmar="¿Eliminar este artículo? La imagen asociada también se borrará.">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-ghost" style="color:var(--color-danger); padding:6px 10px; font-size:.85rem;">Eliminar</button>
                                        </form>
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
