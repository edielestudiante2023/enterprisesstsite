<?php

/**
 * Enlaces comerciales de EnterpriseSST.
 *
 * Todas las solicitudes van al formulario central de Cycloid Talent con el servicio
 * "Plataforma EnterpriseSST" y la atribución del sitio (utm_source=enterprisesst).
 * Si el visitante llegó con UTM (por ejemplo desde una red social), se respetan los
 * de su primera visita (cookie del filtro UtmFirstTouch).
 */

if (! function_exists('demo_url')) {
    /** Enlace a "Pedir demo"; $campana identifica el botón que se pulsó. */
    function demo_url(string $campana = 'enterprisesst-demo'): string
    {
        $sitio  = config('Sitio');
        $params = marketing_utm_params();
        $params['servicio'] = $sitio->contactoServicio;

        if (empty($params['utm_campaign'])) {
            $params['utm_campaign'] = $campana;
        }

        return $sitio->contactoUrl . '?' . http_build_query($params);
    }
}

if (! function_exists('whatsapp_url')) {
    function whatsapp_url(string $mensaje = 'Hola Diana, quiero conocer EnterpriseSST.'): string
    {
        return 'https://wa.me/' . config('Sitio')->contactoWhatsapp . '?text=' . rawurlencode($mensaje);
    }
}

if (! function_exists('precio_cop')) {
    function precio_cop(int $valor): string
    {
        return '$' . number_format($valor, 0, ',', '.');
    }
}

if (! function_exists('marketing_utm_params')) {
    /** @return array<string, string> */
    function marketing_utm_params(): array
    {
        $keys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
        $out  = [];

        foreach ($keys as $k) {
            if (! empty($_GET[$k]) && is_string($_GET[$k])) {
                $out[$k] = marketing_utm_sanitize($_GET[$k]);
            }
        }

        if ($out === [] && ! empty($_COOKIE['enterprisesst_first_touch_utm'])) {
            $decoded = json_decode((string) $_COOKIE['enterprisesst_first_touch_utm'], true);
            if (is_array($decoded)) {
                foreach ($keys as $k) {
                    if (! empty($decoded[$k]) && is_string($decoded[$k])) {
                        $out[$k] = marketing_utm_sanitize($decoded[$k]);
                    }
                }
            }
        }

        $out['utm_source'] ??= 'enterprisesst';
        $out['utm_medium'] ??= 'referral';

        return array_filter($out, static fn ($v) => $v !== '');
    }
}

if (! function_exists('marketing_utm_sanitize')) {
    function marketing_utm_sanitize(string $v): string
    {
        $v = preg_replace('/[^A-Za-z0-9._\-\s]/', '', trim($v)) ?? '';

        return mb_substr($v, 0, 64);
    }
}
