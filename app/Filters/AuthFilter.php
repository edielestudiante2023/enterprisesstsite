<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AuthFilter — protege rutas de administración.
 *
 * Si no hay sesión activa con user_id, redirige al login con returnTo.
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (! $session->get('user_id')) {
            $returnTo = $request->getUri()->getPath();
            $session->setFlashdata('error', 'Debes iniciar sesión para acceder.');
            return redirect()->to(base_url('iniciar-sesion?returnTo=' . urlencode($returnTo)));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // sin acción
    }
}
