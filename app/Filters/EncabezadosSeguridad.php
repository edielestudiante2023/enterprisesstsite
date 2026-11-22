<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Encabezados de seguridad del sitio. La política de contenido (CSP) la arma CodeIgniter
 * desde app/Config/ContentSecurityPolicy.php; aquí van los demás.
 *
 * Referrer-Policy es strict-origin-when-cross-origin (no same-origin): el formulario de
 * contacto de Cycloid Talent registra el sitio de origen de cada solicitud de demo y
 * necesita recibir al menos el dominio.
 */
class EncabezadosSeguridad implements FilterInterface
{
    private const ENCABEZADOS = [
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options'        => 'SAMEORIGIN',
        'Referrer-Policy'        => 'strict-origin-when-cross-origin',
        'Permissions-Policy'     => 'camera=(), microphone=(), geolocation=(), payment=(), usb=()',
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        foreach (self::ENCABEZADOS as $nombre => $valor) {
            $response->setHeader($nombre, $valor);
        }
        if (ENVIRONMENT === 'production') {
            $response->setHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
    }
}
