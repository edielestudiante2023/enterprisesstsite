<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablece tu contraseña — EnterpriseSST</title>
</head>
<body style="margin:0; padding:0; background:#f4f2ee; font-family:Arial,Helvetica,sans-serif; color:#1c2437;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f2ee; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; background:#ffffff; border-radius:14px; overflow:hidden;">
                    <tr>
                        <td style="background:#1c2437; padding:28px 32px; color:#ffffff; text-align:center;">
                            <div style="font-size:.8rem; letter-spacing:.3em; color:#bd9751; margin-bottom:6px;">ENTERPRISESST</div>
                            <h1 style="margin:0; font-size:1.4rem;">Restablece tu contraseña</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px; line-height:1.55;">
                            <p style="margin:0 0 16px;"><?= esc($toName ?? 'Hola') ?>,</p>
                            <p style="margin:0 0 16px;">Recibimos una solicitud para restablecer la contraseña de tu cuenta en el panel del sitio de EnterpriseSST. Si fuiste tú, haz clic en el botón:</p>
                            <p style="margin:24px 0; text-align:center;">
                                <a href="<?= esc($resetLink) ?>" style="display:inline-block; background:#bd9751; color:#1c2437; text-decoration:none; padding:14px 32px; border-radius:10px; font-weight:bold;">Restablecer contraseña</a>
                            </p>
                            <p style="margin:0 0 16px; color:#5b6272; font-size:.88rem;">El enlace sirve durante <strong><?= (int) ($ttlMinutes ?? 60) ?> minutos</strong>. Si vence, pide uno nuevo desde la pantalla de ingreso.</p>
                            <p style="margin:24px 0 0; color:#5b6272; font-size:.85rem;">Si no pediste este cambio, ignora este correo: tu contraseña actual sigue funcionando.</p>
                            <p style="margin:24px 0 0; color:#8a90a0; font-size:.75rem; word-break:break-all;">¿El botón no funciona? Copia esta dirección en tu navegador:<br><?= esc($resetLink) ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f4f2ee; padding:16px 32px; font-size:.78rem; color:#5b6272; text-align:center;">
                            EnterpriseSST es una marca de Cycloid Talent SAS
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
