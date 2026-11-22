<?php

use CodeIgniter\Router\RouteCollection;

/**
 * Rutas de enterprisesst.cycloidtalent.com.
 *
 * Las páginas públicas aceptan GET y HEAD: los rastreadores y los monitores usan HEAD
 * y una ruta solo GET les respondería 404 (lección de psyrisksite).
 *
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);
$routes->set404Override('App\Controllers\PageNotFound::index');

// Páginas que venden
$routes->match(['get', 'head'], '/', 'Home::index');
$routes->match(['get', 'head'], 'funciones', 'Paginas::funciones');
$routes->match(['get', 'head'], 'precios', 'Paginas::precios');
$routes->match(['get', 'head'], 'como-funciona', 'Paginas::comoFunciona');
$routes->match(['get', 'head'], 'para-firmas-consultoras', 'Paginas::firmas');
$routes->match(['get', 'head'], 'para-consultores-independientes', 'Paginas::independientes');
$routes->match(['get', 'head'], 'para-empresas', 'Paginas::empresas');
$routes->match(['get', 'head'], 'preguntas-frecuentes', 'Paginas::preguntas');

// Legal
$routes->match(['get', 'head'], 'privacidad', 'Paginas::privacidad');
$routes->match(['get', 'head'], 'terminos', 'Paginas::terminos');

// Blog
$routes->match(['get', 'head'], 'blog', 'Blog::index');
$routes->match(['get', 'head'], 'blog/(:segment)', 'Blog::articulo/$1');

// Sitemap dinámico
$routes->match(['get', 'head'], 'sitemap.xml', 'Sitemap::index');

// Acceso al panel
$routes->match(['get', 'head'], 'iniciar-sesion', 'Auth::login');
$routes->post('iniciar-sesion', 'Auth::authenticate');
$routes->post('cerrar-sesion', 'Auth::logout');
$routes->match(['get', 'head'], 'recuperar-password', 'Auth::forgotPassword');
$routes->post('recuperar-password', 'Auth::sendResetEmail');
$routes->match(['get', 'head'], 'restablecer-password/(:segment)', 'Auth::showResetForm/$1');
$routes->post('restablecer-password', 'Auth::resetPassword');

// Panel de administración (filtro auth en Config/Filters.php)
$routes->group('admin', static function ($routes) {
    $routes->match(['get', 'head'], '/', static fn () => redirect()->to(base_url('admin/blog')));

    $routes->match(['get', 'head'], 'usuarios', 'Admin\Usuarios::index');
    $routes->match(['get', 'head'], 'usuarios/nuevo', 'Admin\Usuarios::create');
    $routes->post('usuarios/guardar', 'Admin\Usuarios::store');
    $routes->match(['get', 'head'], 'usuarios/editar/(:num)', 'Admin\Usuarios::edit/$1');
    $routes->post('usuarios/actualizar/(:num)', 'Admin\Usuarios::update/$1');
    $routes->post('usuarios/eliminar/(:num)', 'Admin\Usuarios::destroy/$1');

    $routes->match(['get', 'head'], 'blog', 'Admin\Blog::index');
    $routes->match(['get', 'head'], 'blog/estadisticas', 'Admin\Blog::estadisticas');
    $routes->post('blog/snapshot', 'Admin\Blog::snapshot');
    $routes->match(['get', 'head'], 'blog/crear', 'Admin\Blog::create');
    $routes->post('blog/guardar', 'Admin\Blog::store');
    $routes->match(['get', 'head'], 'blog/editar/(:num)', 'Admin\Blog::edit/$1');
    $routes->post('blog/actualizar/(:num)', 'Admin\Blog::update/$1');
    $routes->post('blog/eliminar/(:num)', 'Admin\Blog::destroy/$1');
    $routes->post('blog/toggle/(:num)', 'Admin\Blog::togglePublished/$1');
});
