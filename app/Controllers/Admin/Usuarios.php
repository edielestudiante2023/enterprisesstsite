<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\UserModel;

class Usuarios extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $usuarios = $userModel
            ->select('usuarios.*, roles.name AS role_name')
            ->join('roles', 'roles.id = usuarios.role_id', 'left')
            ->orderBy('usuarios.created_at', 'DESC')
            ->findAll();

        return view('pages/admin/usuarios/index', [
            'title'       => 'Usuarios · Admin · EnterpriseSST',
            'description' => 'Gestión de usuarios con acceso al panel.',
            'usuarios'    => $usuarios,
            'activeNav'   => '',
        ]);
    }

    public function create()
    {
        return view('pages/admin/usuarios/form', [
            'title'       => 'Nuevo usuario · Admin · EnterpriseSST',
            'description' => 'Crear un nuevo usuario del panel.',
            'usuario'     => null,
            'roles'       => (new RoleModel())->orderBy('name')->findAll(),
            'activeNav'   => '',
        ]);
    }

    public function store()
    {
        $email    = strtolower(trim((string) $this->request->getPost('email')));
        $name     = trim((string) $this->request->getPost('name'));
        $password = (string) $this->request->getPost('password');
        $roleId   = (int) $this->request->getPost('role_id');
        $status   = $this->request->getPost('status') === 'inactive' ? 'inactive' : 'active';

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->with('error', 'Email inválido.');
        }
        if ($name === '') {
            return redirect()->back()->withInput()->with('error', 'El nombre es obligatorio.');
        }
        if (strlen($password) < 8) {
            return redirect()->back()->withInput()->with('error', 'La contraseña debe tener al menos 8 caracteres.');
        }
        if ($roleId === 0) {
            return redirect()->back()->withInput()->with('error', 'Selecciona un rol.');
        }

        $userModel = new UserModel();
        if ($userModel->findByEmail($email)) {
            return redirect()->back()->withInput()->with('error', 'Ya existe un usuario con ese email.');
        }

        $userModel->insert([
            'email'         => $email,
            'name'          => $name,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role_id'       => $roleId,
            'status'        => $status,
        ]);

        return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario creado.');
    }

    public function edit($id)
    {
        $usuario = (new UserModel())->find((int) $id);
        if (! $usuario) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'Usuario no encontrado.');
        }

        return view('pages/admin/usuarios/form', [
            'title'       => 'Editar usuario · Admin · EnterpriseSST',
            'description' => 'Editar usuario del panel.',
            'usuario'     => $usuario,
            'roles'       => (new RoleModel())->orderBy('name')->findAll(),
            'activeNav'   => '',
        ]);
    }

    public function update($id)
    {
        $id = (int) $id;
        $userModel = new UserModel();
        $usuario = $userModel->find($id);
        if (! $usuario) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'Usuario no encontrado.');
        }

        $name     = trim((string) $this->request->getPost('name'));
        $email    = strtolower(trim((string) $this->request->getPost('email')));
        $roleId   = (int) $this->request->getPost('role_id');
        $status   = $this->request->getPost('status') === 'inactive' ? 'inactive' : 'active';
        $password = (string) $this->request->getPost('password');

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->with('error', 'Email inválido.');
        }
        if ($name === '') {
            return redirect()->back()->withInput()->with('error', 'El nombre es obligatorio.');
        }
        if ($roleId === 0) {
            return redirect()->back()->withInput()->with('error', 'Selecciona un rol.');
        }

        // Validar email único entre otros usuarios
        $existing = $userModel->where('email', $email)->where('id !=', $id)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Ya existe otro usuario con ese email.');
        }

        $update = [
            'name'    => $name,
            'email'   => $email,
            'role_id' => $roleId,
            'status'  => $status,
        ];

        if ($password !== '') {
            if (strlen($password) < 8) {
                return redirect()->back()->withInput()->with('error', 'Si cambias la contraseña, debe tener mínimo 8 caracteres.');
            }
            $update['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $update);

        return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario actualizado.');
    }

    public function destroy($id)
    {
        $id = (int) $id;
        $sessionUserId = (int) session()->get('user_id');

        if ($id === $sessionUserId) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $userModel = new UserModel();
        $usuario = $userModel->find($id);
        if (! $usuario) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'Usuario no encontrado.');
        }

        $userModel->delete($id);
        return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario eliminado.');
    }
}
