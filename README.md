# enterprisesstsite

Sitio comercial de **EnterpriseSST**, marca de Cycloid Talent: https://enterprisesst.cycloidtalent.com

- CodeIgniter 4.7, PHP 8.2+, MySQL.
- Brújula del proyecto (qué se vende, a quién, decisiones y estado): `docs/VENTA_ARRIENDO_ENTERPRISESST.md`.
- El aplicativo que se arrienda vive en otro repositorio (`enterprisesst`) y en `dashboard.cycloidtalent.com`.

## Puesta en marcha local

```bash
composer install
cp env .env              # completar base de datos y baseURL
php spark db:create enterprisesstsite
php spark migrate
php spark db:seed RolesSeeder
php spark admin:crear correo@dominio.com "Nombre"
```

## Pruebas

```bash
php -d extension=sqlite3 vendor/bin/phpunit -c phpunit.dist.xml --no-coverage
```

## Despliegue

Rama de trabajo `cycloid`; el servidor sirve `main`. Mezclar `cycloid` en `main`, `git push origin main` y `git pull origin main` en `/www/wwwroot/enterprisesstsite`. La raíz web del servidor es la carpeta `public/`.
