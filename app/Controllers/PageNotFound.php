<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Method;

/**
 * Override del 404.
 *
 * CodeIgniter enruta por verbo HTTP: una URL declarada solo con
 * $routes->post(...) responde 404 cuando el navegador la pide con GET. Eso
 * ocurre sin que nadie haga nada raro — al mandar un formulario, la URL de
 * destino queda en el historial, y desde ahí el botón atrás, un marcador o el
 * autocompletado de la barra de direcciones la vuelven a pedir con GET.
 *
 * Es el mismo tipo de problema que ya resolvimos agregando 'head' a las rutas
 * públicas (ver la nota de Config/Routes.php): un verbo no contemplado termina
 * en 404. Aquí lo cubrimos de forma general — si la URL existe como POST,
 * devolvemos al usuario a la pantalla más cercana que sí responde a GET. Las
 * URLs que no existen bajo ningún verbo siguen viendo el 404 de siempre.
 */
class PageNotFound extends BaseController
{
    public function index(string $message = '')
    {
        $path = trim(uri_string(), '/');

        if ($path !== '' && $this->isPostOnlyRoute($path)) {
            return redirect()->to(base_url($this->nearestGetRoute($path)))
                ->with('error', 'Esa dirección solo responde a acciones hechas desde los botones de la página. Te devolvimos a la pantalla correspondiente.');
        }

        return $this->response->setStatusCode(404)
            ->setBody(view('errors/html/error_404', ['message' => $message]));
    }

    /**
     * ¿La URL existe como ruta POST?
     *
     * Las rutas de administración solo se reconocen con sesión activa, para no
     * revelarle a un visitante anónimo qué direcciones internas existen.
     */
    private function isPostOnlyRoute(string $path): bool
    {
        if (str_starts_with($path, 'admin/') && ! session()->get('user_id')) {
            return false;
        }

        return $this->matchesRoute($path, Method::POST);
    }

    /**
     * Sube por los segmentos de la URL hasta encontrar el prefijo más largo que
     * sí tiene ruta GET. Por ejemplo admin/contactos/eliminar/5 termina en
     * admin/contactos. Si no encuentra ninguno, manda al inicio.
     */
    private function nearestGetRoute(string $path): string
    {
        $segments = explode('/', $path);

        while (count($segments) > 1) {
            array_pop($segments);
            $candidate = implode('/', $segments);

            if ($this->matchesRoute($candidate, Method::GET)) {
                return $candidate;
            }
        }

        return '/';
    }

    /**
     * Compara la ruta contra las claves de la colección, que ya vienen con los
     * placeholders convertidos a regex. Usamos el mismo patrón que el Router.
     */
    private function matchesRoute(string $path, string $verb): bool
    {
        foreach (array_keys(service('routes')->getRoutes($verb)) as $routeKey) {
            if ($routeKey === '/') {
                continue;
            }

            if (preg_match('#^' . $routeKey . '$#u', $path) === 1) {
                return true;
            }
        }

        return false;
    }
}
