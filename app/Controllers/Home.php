<?php

namespace App\Controllers;

use App\Libraries\Contenido;

class Home extends BaseController
{
    public function index(): string
    {
        return view('pages/inicio', [
            'title'       => 'EnterpriseSST · Software SG-SST para consultores y empresas',
            'description' => 'Gestiona el SG-SST de todos tus clientes en una sola plataforma: documentos con IA, estándares 0312, inspecciones desde el celular y firma electrónica.',
            'canonical'   => base_url('/'),
            'activeNav'   => 'inicio',
            'funciones'   => Contenido::funcionesPrincipales(),
            'faqs'        => Contenido::preguntasInicio(),
        ]);
    }
}
