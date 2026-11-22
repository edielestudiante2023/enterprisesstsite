<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-hero">
    <div class="container" style="max-width:480px;">
        <h1 style="text-align:center;">Iniciar sesión</h1>
        <p class="lead" style="text-align:center;">Acceso al panel de administración del sitio.</p>

        <?php $error = session()->getFlashdata('error'); if (is_string($error) && $error !== ''): ?>
            <div class="auth-alert auth-alert-error"><?= esc($error) ?></div>
        <?php endif; ?>
        <?php $success = session()->getFlashdata('success'); if (is_string($success) && $success !== ''): ?>
            <div class="auth-alert auth-alert-success"><?= esc($success) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('iniciar-sesion') ?>" class="auth-form" autocomplete="on">
            <?= csrf_field() ?>
            <input type="hidden" name="returnTo" value="<?= esc($returnTo ?? '') ?>">

            <label>
                <span>Email</span>
                <input type="email" name="email" required autofocus autocomplete="username"
                    value="<?= esc(old('email')) ?>">
            </label>

            <label>
                <span>Contraseña</span>
                <?= view('partials/password-field', ['name' => 'password', 'autocomplete' => 'current-password']) ?>
            </label>

            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">Entrar</button>

            <p style="text-align:center; margin-top:14px; font-size:.9rem;">
                <a href="<?= base_url('recuperar-password') ?>">¿Olvidaste tu contraseña?</a>
            </p>
        </form>
    </div>
</section>

<?= $this->endSection() ?>
