<?php

use CodeIgniter\Test\CIUnitTestCase;

final class BlogSeoHelperTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        helper('seo');
    }

    public function testRemovesEmptyHeadingsOnly(): void
    {
        $html = '<h2><br></h2><h2>Real</h2><h3 class="ql-align-justify"><strong><br></strong></h3><h3>&nbsp;</h3><p><br></p>';

        $this->assertSame('<h2>Real</h2><p><br></p>', blog_limpiar_encabezados($html));
    }

    public function testSummaryKeepsWholeWords(): void
    {
        $summary = blog_resumir('<p>' . str_repeat('productividad empresarial ', 20) . '</p>');

        $this->assertLessThanOrEqual(160, mb_strlen($summary));
        $this->assertMatchesRegularExpression('/(productividad|empresarial)\.$/u', $summary);
        $this->assertSame('Texto corto', blog_resumir('<p>Texto corto</p>'));
    }

    public function testSimilarArticlesAreFlaggedAndSorted(): void
    {
        $base = 'la evaluacion permite detectar factores de riesgo y disenar planes de intervencion para cada area de la empresa';

        $similares = blog_articulos_similares($base, [
            ['titulo' => 'Distinto', 'contenido' => 'recetas de cocina tradicional para compartir en familia durante todo el fin de semana'],
            ['titulo' => 'Parecido', 'contenido' => $base . ' con seguimiento'],
            ['titulo' => 'Igual', 'contenido' => $base],
        ]);

        $this->assertSame(['Igual', 'Parecido'], array_column($similares, 'titulo'));
        $this->assertSame(100, $similares[0]['porcentaje']);
    }
}
