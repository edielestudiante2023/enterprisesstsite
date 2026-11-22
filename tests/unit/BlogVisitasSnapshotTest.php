<?php

use App\Models\BlogVisitasSnapshotModel;
use CodeIgniter\Test\CIUnitTestCase;

/** @internal */
final class BlogVisitasSnapshotTest extends CIUnitTestCase
{
    public function testCalculaIncrementosEntreDosSnapshots(): void
    {
        $rows = [
            ['blog_post_id' => 1, 'titulo' => 'Articulo A', 'slug' => 'articulo-a', 'snapshot_date' => '2026-07-24', 'visitas_acumuladas' => 10, 'captured_at' => '2026-07-24 08:00:00'],
            ['blog_post_id' => 2, 'titulo' => 'Articulo B', 'slug' => 'articulo-b', 'snapshot_date' => '2026-07-24', 'visitas_acumuladas' => 4,  'captured_at' => '2026-07-24 08:00:00'],
            ['blog_post_id' => 1, 'titulo' => 'Articulo A', 'slug' => 'articulo-a', 'snapshot_date' => '2026-07-31', 'visitas_acumuladas' => 13, 'captured_at' => '2026-07-31 08:00:00'],
            ['blog_post_id' => 2, 'titulo' => 'Articulo B', 'slug' => 'articulo-b', 'snapshot_date' => '2026-07-31', 'visitas_acumuladas' => 6,  'captured_at' => '2026-07-31 08:00:00'],
        ];

        $evolution = BlogVisitasSnapshotModel::buildEvolutionData(
            ['2026-07-24', '2026-07-31'],
            $rows
        );

        $this->assertSame(2, $evolution['summary']['snapshotCount']);
        $this->assertSame(19, $evolution['summary']['currentTotal']);
        $this->assertSame(5, $evolution['summary']['lastWeek']);
        $this->assertSame(5, $evolution['summary']['periodGain']);
        $this->assertNull($evolution['weeks'][0]['increment']);
        $this->assertSame(5, $evolution['weeks'][1]['increment']);
        $this->assertSame(3, $evolution['weeks'][1]['byArticle'][1]);
        $this->assertSame(2, $evolution['weeks'][1]['byArticle'][2]);
    }

    public function testRenderizaLaVistaConLineaBase(): void
    {
        helper(['mode', 'marketing']);

        $evolution = [
            'dates' => ['2026-07-31'],
            'weeks' => [[
                'date' => '2026-07-31',
                'total' => 35,
                'increment' => null,
                'byArticle' => [1 => null],
            ]],
            'articles' => [[
                'id' => 1,
                'titulo' => 'Articulo de prueba',
                'slug' => 'articulo-prueba',
                'total' => 35,
                'lastWeek' => null,
                'periodGain' => 0,
            ]],
            'maxIncrement' => 0,
            'summary' => [
                'snapshotCount' => 1,
                'firstDate' => '2026-07-31',
                'lastDate' => '2026-07-31',
                'currentTotal' => 35,
                'lastWeek' => null,
                'periodGain' => 0,
            ],
        ];

        $html = view('pages/admin/blog/estadisticas', [
            'title' => 'Prueba',
            'description' => 'Prueba',
            'activeNav' => '',
            'weeksFilter' => 12,
            'evolution' => $evolution,
        ]);

        $this->assertStringContainsString('Evolución de visitas del blog', $html);
        $this->assertStringContainsString('Tomar snapshot ahora', $html);
        $this->assertStringContainsString('admin/blog/snapshot', $html);
        $this->assertStringContainsString('Línea base guardada', $html);
        $this->assertStringContainsString('Articulo de prueba', $html);
    }
}
