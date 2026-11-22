<?php

namespace App\Controllers;

use App\Libraries\Contenido;

/**
 * Páginas comerciales y legales. Títulos de hasta ~65 caracteres y descriptions de
 * hasta 160, para que Google no los corte.
 */
class Paginas extends BaseController
{
    public function funciones(): string
    {
        return view('pages/funciones', [
            'title'       => 'Funciones del software SG-SST | EnterpriseSST',
            'description' => 'Documentos SG-SST con IA, estándares 0312, matriz IPEVR, inspecciones desde el celular, comités con votación electrónica, indicadores y firma electrónica.',
            'activeNav'   => 'funciones',
            'grupos'      => Contenido::gruposFunciones(),
        ]);
    }

    public function precios(): string
    {
        $faqs = array_values(array_filter(Contenido::preguntas(), static fn ($f) => in_array($f['q'], [
            '¿Cuánto cuesta arrendar EnterpriseSST?', '¿Cómo se paga?', '¿Qué pasa con mis clientes si me atraso en un pago?', '¿Hay prueba gratis?',
        ], true)));

        return view('pages/precios', [
            'title'       => 'Precios del software SG-SST | EnterpriseSST',
            'description' => 'Una mensualidad por empresa cliente activa, según su tamaño. Sin cobro por consultor ni por usuario, sin permanencia y con todas las funciones incluidas.',
            'activeNav'   => 'precios',
            'tarifas'     => config('Sitio')->tarifas,
            'faqs'        => $faqs,
        ]);
    }

    public function comoFunciona(): string
    {
        return view('pages/como_funciona', [
            'title'       => 'Cómo funciona el arriendo de EnterpriseSST',
            'description' => 'Tu firma recibe un espacio propio y aislado, con tu marca, tus consultores y tus clientes. Demo guiada, alta con correo de bienvenida y puesta en marcha.',
            'activeNav'   => 'como-funciona',
        ]);
    }

    public function firmas(): string
    {
        return view('pages/para_firmas', [
            'title'       => 'Software SG-SST para firmas consultoras | EnterpriseSST',
            'description' => 'Gestiona todos tus consultores y clientes en un solo lugar, con la marca de tu firma, espacio aislado y el avance de cada cliente a la vista.',
            'activeNav'   => '',
        ]);
    }

    public function independientes(): string
    {
        return view('pages/para_independientes', [
            'title'       => 'Software SG-SST para consultores independientes',
            'description' => 'Atiende más empresas con el mismo tiempo: documentos con IA, inspecciones desde el celular y firma electrónica. Pagas solo por las empresas que gestionas.',
            'activeNav'   => '',
        ]);
    }

    public function empresas(): string
    {
        return view('pages/para_empresas', [
            'title'       => 'Software SG-SST para empresas con área SST | EnterpriseSST',
            'description' => 'Organiza el SG-SST de tu empresa y sus sedes: documentos, evidencias por estándar, inspecciones, comités e indicadores, listos para auditorías.',
            'activeNav'   => '',
        ]);
    }

    public function preguntas(): string
    {
        return view('pages/preguntas', [
            'title'       => 'Preguntas frecuentes sobre EnterpriseSST',
            'description' => 'Precio, prueba, marca de tu firma, aislamiento de datos, IA, licencia SST, importación desde Excel, pagos y uso en el celular: respuestas claras.',
            'activeNav'   => 'preguntas',
            'faqs'        => Contenido::preguntas(),
        ]);
    }

    public function privacidad(): string
    {
        return view('pages/legal/privacidad', [
            'title'       => 'Política de privacidad | EnterpriseSST',
            'description' => 'Cómo trata Cycloid Talent los datos personales de quienes visitan el sitio de EnterpriseSST y solicitan una demo.',
        ]);
    }

    public function terminos(): string
    {
        return view('pages/legal/terminos', [
            'title'       => 'Términos de uso del sitio | EnterpriseSST',
            'description' => 'Condiciones de uso del sitio web de EnterpriseSST, marca de Cycloid Talent SAS.',
        ]);
    }
}
