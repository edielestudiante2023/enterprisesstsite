<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Datos de marca y contacto de EnterpriseSST.
 *
 * Fuente: docs/VENTA_ARRIENDO_ENTERPRISESST.md (sección 7A). Los datos de contacto
 * son los de Diana Cuestas en cycloidtalent.com; si cambian allá, se cambian aquí.
 */
class Sitio extends BaseConfig
{
    public string $marca = 'EnterpriseSST';
    public string $lema = 'Sistemas que evolucionan';
    public string $empresa = 'Cycloid Talent';
    public string $empresaUrl = 'https://cycloidtalent.com/';

    /** Aplicativo donde ingresan las firmas que ya arriendan. */
    public string $aplicativoUrl = 'https://dashboard.cycloidtalent.com/';

    /** Formulario central de solicitudes (decisión del 21 de noviembre de 2026). */
    public string $contactoUrl = 'https://cycloidtalent.com/contacto';
    public string $contactoServicio = 'Plataforma EnterpriseSST';

    public string $contactoNombre = 'Diana Cuestas';
    public string $contactoCargo = 'Directora Comercial';
    public string $contactoCorreo = 'diana.cuestas@cycloidtalent.com';
    public string $contactoTelefono = '+57 311 7919191';
    public string $contactoWhatsapp = '573117919191';
    public string $contactoLinkedin = 'https://www.linkedin.com/in/diana-patricia-cuestas-183024399/';

    /**
     * Redes sociales oficiales de EnterpriseSST (24 de noviembre de 2026).
     *
     * @var array<string, string>
     */
    public array $redes = [
        'Facebook'  => 'https://www.facebook.com/profile.php?id=61596825214488',
        'Instagram' => 'https://www.instagram.com/enterprisesst.oficial/',
        'LinkedIn'  => 'https://www.linkedin.com/company/enterprisesst/',
        'YouTube'   => 'https://www.youtube.com/@enterprisesst.oficial',
        'TikTok'    => 'https://www.tiktok.com/@enterprisesst_oficial',
    ];

    /** Dirección de Cycloid Talent (la misma que publica psyrisksite). */
    public string $direccion = 'Tv. 24B #17-209, Soacha, Cundinamarca, Colombia';

    /**
     * Tarifas mensuales por empresa cliente activa (tbl_suscripcion_tarifa del aplicativo,
     * revisada el 21 de noviembre de 2026). Confirmar contra producción antes de publicar cambios.
     *
     * @var list<array{estandares: int, trabajadores: string, valor: int}>
     */
    public array $tarifas = [
        ['estandares' => 7,  'trabajadores' => '1 a 10',    'valor' => 100000],
        ['estandares' => 21, 'trabajadores' => '1 a 50',    'valor' => 200000],
        ['estandares' => 60, 'trabajadores' => '1 a 10',    'valor' => 120000],
        ['estandares' => 60, 'trabajadores' => '11 a 30',   'valor' => 200000],
        ['estandares' => 60, 'trabajadores' => '31 a 50',   'valor' => 250000],
        ['estandares' => 60, 'trabajadores' => '51 o más',  'valor' => 400000],
    ];
}
