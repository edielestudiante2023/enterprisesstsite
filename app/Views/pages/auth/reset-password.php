<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-hero">
    <div class="container" style="max-width:480px;">
        <h1 style="text-align:center;">Nueva contraseña</h1>
        <p class="lead" style="text-align:center;">Define una nueva contraseña para tu cuenta.</p>

        <?php $error = session()->getFlashdata('error'); if (is_string($error) && $error !== ''): ?>
            <div class="auth-alert auth-alert-error"><?= esc($error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('restablecer-password') ?>" class="auth-form">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= esc($token) ?>">

            <label>
                <span>Nueva contraseña (mínimo 8 caracteres)</span>
                <?= view('partials/password-field', ['name' => 'password', 'autocomplete' => 'new-password', 'autofocus' => true]) ?>
            </label>

            <label>
                <span>Confirma la nueva contraseña</span>
                <?= view('partials/password-field', ['name' => 'password_confirm', 'autocomplete' => 'new-password']) ?>
            </label>

            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">Actualizar contraseña</button>
        </form>
    </div>
</section>

<?= $this->endSection() ?>
