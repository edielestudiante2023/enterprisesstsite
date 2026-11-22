<?php

namespace App\Libraries;

/**
 * Envío de correos por SendGrid (versión reducida de la de psyrisksite).
 *
 * Por ahora solo se usa para recuperar la contraseña del panel. Variables en .env:
 *   email.fromEmail, email.fromName, email.SMTPPass (API key de SendGrid, empieza por "SG.").
 */
class EmailService
{
    protected string $fromEmail;
    protected string $fromName;
    protected string $apiKey;

    public function __construct()
    {
        $this->fromEmail = (string) (env('email.fromEmail') ?: 'no-reply@cycloidtalent.com');
        $this->fromName  = (string) (env('email.fromName') ?: 'EnterpriseSST');
        $this->apiKey    = (string) env('email.SMTPPass');
    }

    public function isConfigured(): bool
    {
        return $this->apiKey !== '' && str_starts_with($this->apiKey, 'SG.');
    }

    public function sendPasswordReset(string $toEmail, string $toName, string $resetLink, int $ttlMinutes = 60): bool
    {
        $html = view('emails/password_reset', [
            'toName'     => $toName !== '' ? $toName : 'Hola',
            'resetLink'  => $resetLink,
            'ttlMinutes' => $ttlMinutes,
        ]);

        return $this->send($toEmail, 'Restablece tu contraseña — EnterpriseSST', $html);
    }

    protected function send(string $toEmail, string $subject, string $htmlContent): bool
    {
        if (! $this->isConfigured()) {
            log_message('warning', "EmailService: API key no configurada. No se envió a {$toEmail}");

            return false;
        }

        try {
            $email = new \SendGrid\Mail\Mail();
            $email->setFrom($this->fromEmail, $this->fromName);
            $email->setSubject($subject);
            $email->addTo($toEmail);
            $email->addContent('text/html', $htmlContent);

            // Sin seguimiento de clics: conserva los enlaces originales.
            $tracking = new \SendGrid\Mail\TrackingSettings();
            $click    = new \SendGrid\Mail\ClickTracking();
            $click->setEnable(false);
            $click->setEnableText(false);
            $tracking->setClickTracking($click);
            $email->setTrackingSettings($tracking);

            $response = (new \SendGrid($this->apiKey))->send($email);
            $status   = $response->statusCode();
            if ($status >= 200 && $status < 300) {
                return true;
            }

            log_message('error', "Correo a {$toEmail} falló (HTTP {$status}): " . $response->body());

            return false;
        } catch (\Throwable $e) {
            log_message('error', "Excepción enviando correo a {$toEmail}: " . $e->getMessage());

            return false;
        }
    }
}
