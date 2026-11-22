<?php

namespace App\Controllers;

use App\Libraries\EmailService;
use App\Models\PasswordResetModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to(base_url('admin'));
        }

        return view('pages/auth/login', [
            'title'       => 'Iniciar sesión · EnterpriseSST',
            'description' => 'Acceso al panel de administración.',
            'returnTo'    => $this->request->getGet('returnTo'),
            'activeNav'   => '',
        ]);
    }

    public function authenticate()
    {
        $email    = strtolower(trim((string) $this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');
        $returnTo = (string) $this->request->getPost('returnTo');

        if ($email === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Ingresa email y contraseña.');
        }

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if (! $user || $user['status'] !== 'active' || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Credenciales inválidas.');
        }

        $userModel->touchLastLogin((int) $user['id']);

        $session = session();
        $session->regenerate();
        $session->set([
            'user_id'    => (int) $user['id'],
            'user_email' => $user['email'],
            'user_name'  => $user['name'],
            'role_id'    => (int) $user['role_id'],
        ]);

        $target = $returnTo !== '' ? base_url(ltrim($returnTo, '/')) : base_url('admin');
        return redirect()->to($target);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('iniciar-sesion'))->with('success', 'Sesión cerrada.');
    }

    /** GET /recuperar-password — formulario para pedir email */
    public function forgotPassword()
    {
        return view('pages/auth/forgot-password', [
            'title'       => 'Recuperar contraseña · EnterpriseSST',
            'description' => 'Solicita un enlace para restablecer tu contraseña.',
            'activeNav'   => '',
        ]);
    }

    /** POST /recuperar-password — envía email con token */
    public function sendResetEmail()
    {
        $email = strtolower(trim((string) $this->request->getPost('email')));

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->with('error', 'Ingresa un email válido.');
        }

        // Respuesta genérica siempre (evita enumeración de usuarios)
        $genericMsg = 'Si el email está registrado, en breve recibirás un enlace para restablecer tu contraseña.';

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if ($user && $user['status'] === 'active') {
            $resetModel = new PasswordResetModel();
            $token = $resetModel->createToken((int) $user['id'], 3600);
            $link  = base_url('restablecer-password/' . $token);

            $email_service = new EmailService();
            if ($email_service->isConfigured()) {
                $email_service->sendPasswordReset($user['email'], $user['name'], $link, 60);
            } else {
                // En entornos sin SendGrid (ej. local sin API key), loguea el link
                // así el equipo puede recuperarlo desde los logs.
                log_message('warning', '[Auth] SendGrid no configurado. Link de reset para ' . $user['email'] . ': ' . $link);
            }
        }

        return redirect()->to(base_url('iniciar-sesion'))->with('success', $genericMsg);
    }

    /** GET /restablecer-password/{token} — formulario nueva contraseña */
    public function showResetForm($token = null)
    {
        $token = (string) $token;
        $reset = (new PasswordResetModel())->findValidByToken($token);

        if (! $reset) {
            return redirect()->to(base_url('recuperar-password'))
                ->with('error', 'El enlace es inválido o ha expirado. Solicita uno nuevo.');
        }

        return view('pages/auth/reset-password', [
            'title'       => 'Restablecer contraseña · EnterpriseSST',
            'description' => 'Define tu nueva contraseña.',
            'token'       => $token,
            'activeNav'   => '',
        ]);
    }

    /** POST /restablecer-password — actualiza la contraseña */
    public function resetPassword()
    {
        $token   = (string) $this->request->getPost('token');
        $pass    = (string) $this->request->getPost('password');
        $confirm = (string) $this->request->getPost('password_confirm');

        if (strlen($pass) < 8) {
            return redirect()->back()->with('error', 'La contraseña debe tener al menos 8 caracteres.');
        }
        if ($pass !== $confirm) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
        }

        $resetModel = new PasswordResetModel();
        $reset = $resetModel->findValidByToken($token);

        if (! $reset) {
            return redirect()->to(base_url('recuperar-password'))
                ->with('error', 'El enlace es inválido o ha expirado. Solicita uno nuevo.');
        }

        $userModel = new UserModel();
        $userModel->update((int) $reset['user_id'], [
            'password_hash' => password_hash($pass, PASSWORD_DEFAULT),
        ]);
        $resetModel->markUsed((int) $reset['id']);

        return redirect()->to(base_url('iniciar-sesion'))
            ->with('success', 'Contraseña actualizada. Ya puedes iniciar sesión.');
    }
}
