<?php

use App\Libraries\Contenido;
use App\Models\BlogPostModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * SEO y comportamiento básico del sitio (mismos controles que psyrisksite/tests/feature/SeoTest.php).
 */
final class SitioTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        \Config\Services::resetSingle('renderer');
        $_COOKIE = [];
        $_GET    = [];
        helper(['url', 'seo', 'marketing']);

        // El blog no depende de la base en estas pruebas.
        $model = $this->getMockBuilder(BlogPostModel::class)->disableOriginalConstructor()->onlyMethods(['getPublicados'])->getMock();
        $model->method('getPublicados')->willReturn([
            ['slug' => 'publico', 'titulo' => 'Público', 'extracto' => '', 'imagen' => null, 'imagen_alt' => null, 'categoria' => null, 'noindex' => 0, 'created_at' => '2026-11-01 10:00:00', 'updated_at' => '2026-11-02 10:00:00'],
            ['slug' => 'oculto', 'titulo' => 'Oculto', 'extracto' => '', 'imagen' => null, 'imagen_alt' => null, 'categoria' => null, 'noindex' => 1, 'created_at' => '2026-11-01 10:00:00', 'updated_at' => null],
        ]);
        Factories::injectMock('models', BlogPostModel::class, $model);
    }

    public static function paginasQueVenden(): array
    {
        return [
            ['/'], ['funciones'], ['precios'], ['como-funciona'], ['para-firmas-consultoras'],
            ['para-consultores-independientes'], ['para-empresas'], ['preguntas-frecuentes'],
            ['privacidad'], ['terminos'], ['blog'],
        ];
    }

    #[DataProvider('paginasQueVenden')]
    public function testPaginaIndexableConMetadatosCompletos(string $ruta): void
    {
        $resultado = $this->get($ruta);
        $resultado->assertStatus(200);
        $html = $resultado->response()->getBody();

        $this->assertSame(1, substr_count($html, '<h1'), 'Debe haber un solo H1');
        $this->assertStringContainsString('rel="canonical" href="' . base_url($ruta === '/' ? '/' : $ruta) . '"', $html);
        $this->assertStringContainsString('name="robots" content="index, follow', $html);

        preg_match('#<title>(.*?)</title>#s', $html, $titulo);
        preg_match('#<meta name="description" content="([^"]*)"#', $html, $descripcion);
        $this->assertNotEmpty($titulo[1] ?? '');
        $this->assertLessThanOrEqual(70, mb_strlen(html_entity_decode($titulo[1], ENT_QUOTES)), 'Título demasiado largo');
        $this->assertNotEmpty($descripcion[1] ?? '');
        $this->assertLessThanOrEqual(160, mb_strlen(html_entity_decode($descripcion[1], ENT_QUOTES)), 'Description demasiado larga');
    }

    public function testElHeroDiceQueEsUnaMarcaDeCycloidTalent(): void
    {
        $html = $this->get('/')->response()->getBody();
        $hero = substr($html, strpos($html, '<section class="hero">'), 3000);

        $this->assertStringContainsString('EnterpriseSST es una marca de <strong>Cycloid Talent</strong>', $hero);
    }

    public function testLosBotonesDeDemoVanAlFormularioDeCycloidConAtribucion(): void
    {
        $url = demo_url('prueba');
        parse_str((string) parse_url($url, PHP_URL_QUERY), $params);

        $this->assertStringStartsWith('https://cycloidtalent.com/contacto?', $url);
        $this->assertSame('Plataforma EnterpriseSST', $params['servicio']);
        $this->assertSame('enterprisesst', $params['utm_source']);
        $this->assertSame('prueba', $params['utm_campaign']);
    }

    public function testLasPreguntasVisiblesYLasDeGoogleSonLasMismas(): void
    {
        $html = $this->get('preguntas-frecuentes')->response()->getBody();
        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $bloques);

        $faq = null;
        foreach ($bloques[1] as $json) {
            $schema = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
            if (($schema['@type'] ?? '') === 'FAQPage') {
                $faq = $schema;
            }
        }
        $this->assertNotNull($faq);
        $this->assertCount(count(Contenido::preguntas()), $faq['mainEntity']);
        foreach ($faq['mainEntity'] as $pregunta) {
            $this->assertStringContainsString('<summary>' . esc($pregunta['name']) . '</summary>', $html);
            $this->assertStringContainsString('<p>' . esc($pregunta['acceptedAnswer']['text']) . '</p>', $html);
        }
    }

    public function testLosPreciosPublicadosSonLosDeLaConfiguracion(): void
    {
        $html = $this->get('precios')->response()->getBody();
        foreach (config('Sitio')->tarifas as $tarifa) {
            $this->assertStringContainsString(precio_cop($tarifa['valor']), $html);
        }
    }

    public static function paginasOperativas(): array
    {
        return [['iniciar-sesion'], ['recuperar-password']];
    }

    #[DataProvider('paginasOperativas')]
    public function testPaginasOperativasNoSeIndexan(string $ruta): void
    {
        $resultado = $this->get($ruta);
        $resultado->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->assertStringContainsString('name="robots" content="noindex, nofollow"', $resultado->response()->getBody());
    }

    public function testElPanelExigeIniciarSesion(): void
    {
        $this->get('admin/blog')->assertRedirect();
    }

    public function testPaginaInexistenteDevuelve404Real(): void
    {
        $resultado = $this->get('no-existe-esta-pagina');
        $resultado->assertStatus(404);
        $resultado->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function testHeadResponde(): void
    {
        $this->call('HEAD', 'precios')->assertStatus(200);
    }

    public function testSitemapIncluyePaginasYOmiteArticulosNoindex(): void
    {
        $body = $this->get('sitemap.xml')->response()->getBody();
        $this->assertNotFalse(simplexml_load_string($body));
        $this->assertStringContainsString(base_url('precios'), $body);
        $this->assertStringContainsString(base_url('blog/publico'), $body);
        $this->assertStringNotContainsString('blog/oculto', $body);
    }

    public function testEncabezadosDeSeguridad(): void
    {
        $resultado = $this->get('/');
        $resultado->assertHeader('X-Content-Type-Options', 'nosniff');
        $resultado->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        // No "same-origin": el formulario de Cycloid necesita saber de qué sitio viene la solicitud.
        $resultado->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function testRendimientoFuentesPropiasYPrioridadDeLaImagenPrincipal(): void
    {
        $html = $this->get('/')->response()->getBody();
        $this->assertStringNotContainsString('fonts.googleapis.com', $html);
        $this->assertStringContainsString('rel="preload" href="' . base_url('assets/fonts/montserrat-latin-var.woff2') . '"', $html);
        $this->assertMatchesRegularExpression('#<img class="hero-simbolo"[^>]+fetchpriority="high"#', $html);
        $this->assertDoesNotMatchRegularExpression('#<img class="hero-simbolo"[^>]+loading="lazy"#', $html);
    }

    public function testPrecargaDePaginasEnElSitioPeroNoEnElPanel(): void
    {
        $html = $this->get('precios')->response()->getBody();
        $this->assertStringContainsString('<script type="speculationrules"', $html);
        $this->assertStringContainsString('"eagerness": "moderate"', $html);

        $login = $this->get('iniciar-sesion')->response()->getBody();
        $this->assertStringContainsString('"href_matches": "/*sesion*"', $login, 'El ingreso nunca se precarga desde otras páginas');
    }

    public function testElArticuloNoCuentaVisitasDePrecarga(): void
    {
        $articulo = ['id' => 7, 'titulo' => 'Uno', 'slug' => 'uno', 'extracto' => 'Resumen', 'contenido' => '<p>Texto</p>', 'meta_titulo' => null, 'meta_descripcion' => null, 'categoria' => null, 'etiquetas' => null, 'imagen' => null, 'imagen_alt' => null, 'noindex' => 0, 'visitas' => 3, 'created_at' => '2026-11-01 10:00:00', 'updated_at' => null];
        $model = $this->getMockBuilder(BlogPostModel::class)->disableOriginalConstructor()->onlyMethods(['getBySlug', 'contarVisita'])->getMock();
        $model->method('getBySlug')->willReturn($articulo);
        $model->expects($this->never())->method('contarVisita');
        Factories::injectMock('models', BlogPostModel::class, $model);

        $this->withHeaders(['Sec-Purpose' => 'prefetch', 'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0)'])
            ->get('blog/uno')
            ->assertStatus(200);
    }

    public function testPostSinTokenCsrfSeRechaza(): void
    {
        $this->expectException(\CodeIgniter\Security\Exceptions\SecurityException::class);
        $this->post('iniciar-sesion', ['email' => 'a@b.co', 'password' => 'x']);
    }
}
