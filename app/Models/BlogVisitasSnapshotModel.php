<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTimeImmutable;

class BlogVisitasSnapshotModel extends Model
{
    protected $table         = 'blog_visitas_snapshots';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'blog_post_id',
        'titulo',
        'slug',
        'snapshot_date',
        'visitas_acumuladas',
        'captured_at',
    ];

    /**
     * Guarda el total actual de cada articulo. Repetir el corte en la misma
     * fecha actualiza sus valores y no genera duplicados.
     *
     * @return array{date:string, posts:int, inserted:int, updated:int, total:int}
     */
    public function capture(DateTimeImmutable $capturedAt): array
    {
        $date  = $capturedAt->format('Y-m-d');
        $stamp = $capturedAt->format('Y-m-d H:i:s');
        $posts = $this->db->table('blog_posts')
            ->select('id, titulo, slug, visitas')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        $inserted = 0;
        $updated  = 0;
        $total    = 0;

        $this->db->transStart();
        foreach ($posts as $post) {
            $postId = (int) $post['id'];
            $visitas = (int) ($post['visitas'] ?? 0);
            $total += $visitas;

            $exists = $this->builder()
                ->select('id')
                ->where('snapshot_date', $date)
                ->where('blog_post_id', $postId)
                ->get()
                ->getRowArray();

            $data = [
                'blog_post_id'       => $postId,
                'titulo'             => (string) $post['titulo'],
                'slug'               => (string) $post['slug'],
                'snapshot_date'      => $date,
                'visitas_acumuladas' => $visitas,
                'captured_at'        => $stamp,
            ];

            if ($exists) {
                $this->builder()->where('id', (int) $exists['id'])->update($data);
                $updated++;
            } else {
                $this->builder()->insert($data);
                $inserted++;
            }
        }
        $this->db->transComplete();

        if (! $this->db->transStatus()) {
            throw new \RuntimeException('No se pudo guardar el snapshot de visitas.');
        }

        return [
            'date'     => $date,
            'posts'    => count($posts),
            'inserted' => $inserted,
            'updated'  => $updated,
            'total'    => $total,
        ];
    }

    /**
     * Prepara hasta $limit cortes para el grafico y los indicadores.
     * El primer corte es baseline; solo los siguientes tienen incremento.
     *
     * @return array<string, mixed>
     */
    public function getEvolution(int $limit = 12): array
    {
        $limit = max(2, min(52, $limit));
        $dateRows = $this->builder()
            ->select('snapshot_date')
            ->groupBy('snapshot_date')
            ->orderBy('snapshot_date', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();

        $dates = array_column($dateRows, 'snapshot_date');
        $dates = array_reverse($dates);
        if ($dates === []) {
            return self::emptyEvolution();
        }

        $rows = $this->builder()
            ->whereIn('snapshot_date', $dates)
            ->orderBy('snapshot_date', 'ASC')
            ->orderBy('blog_post_id', 'ASC')
            ->get()
            ->getResultArray();

        return self::buildEvolutionData($dates, $rows);
    }

    /**
     * Transforma snapshots ordenados en series semanales. Se mantiene puro
     * para poder verificar el calculo sin depender de un motor de base de datos.
     *
     * @param list<string> $dates
     * @param list<array<string, mixed>> $rows
     * @return array<string, mixed>
     */
    public static function buildEvolutionData(array $dates, array $rows): array
    {
        if ($dates === []) {
            return self::emptyEvolution();
        }

        $byDate = [];
        $articles = [];
        foreach ($rows as $row) {
            $date   = (string) $row['snapshot_date'];
            $postId = (int) $row['blog_post_id'];
            $byDate[$date][$postId] = (int) $row['visitas_acumuladas'];
            $articles[$postId] = [
                'id'     => $postId,
                'titulo' => (string) $row['titulo'],
                'slug'   => (string) $row['slug'],
            ];
        }

        $weeks       = [];
        $previous    = null;
        $previousSum = null;
        $maxIncrement = 0;
        foreach ($dates as $date) {
            $current = $byDate[$date] ?? [];
            $sum     = array_sum($current);
            $parts   = [];

            foreach ($current as $postId => $total) {
                if ($previous === null) {
                    $increment = null;
                } elseif (array_key_exists($postId, $previous)) {
                    $increment = max(0, $total - $previous[$postId]);
                } else {
                    // Articulo creado despues del corte anterior: todas sus
                    // visitas hasta este corte pertenecen al nuevo periodo.
                    $increment = $total;
                }
                $parts[$postId] = $increment;
            }

            $increment = $previousSum === null
                ? null
                : array_sum(array_map(static fn ($value) => $value ?? 0, $parts));
            if ($increment !== null) {
                $maxIncrement = max($maxIncrement, array_sum(array_map(
                    static fn ($value) => $value ?? 0,
                    $parts
                )));
            }

            $weeks[] = [
                'date'       => $date,
                'total'      => $sum,
                'increment'  => $increment,
                'byArticle'  => $parts,
            ];
            $previous    = $current;
            $previousSum = $sum;
        }

        $lastTotals  = $byDate[$dates[count($dates) - 1]] ?? [];
        $lastWeek    = $weeks[count($weeks) - 1];
        $articleRows = [];
        foreach ($articles as $postId => $article) {
            $currentTotal = (int) ($lastTotals[$postId] ?? 0);
            $periodGain = 0;
            foreach ($weeks as $week) {
                $periodGain += (int) ($week['byArticle'][$postId] ?? 0);
            }
            $articleRows[] = $article + [
                'total'      => $currentTotal,
                'lastWeek'   => $lastWeek['byArticle'][$postId] ?? null,
                'periodGain' => $periodGain,
            ];
        }
        usort($articleRows, static fn ($a, $b) => $b['total'] <=> $a['total']);

        return [
            'dates'        => $dates,
            'weeks'        => $weeks,
            'articles'     => $articleRows,
            'maxIncrement' => $maxIncrement,
            'summary'      => [
                'snapshotCount' => count($dates),
                'firstDate'     => $dates[0],
                'lastDate'      => $dates[count($dates) - 1],
                'currentTotal'  => array_sum($lastTotals),
                'lastWeek'      => $lastWeek['increment'],
                'periodGain'    => array_sum(array_column($articleRows, 'periodGain')),
            ],
        ];
    }

    /** @return array<string, mixed> */
    private static function emptyEvolution(): array
    {
        return [
            'dates'        => [],
            'weeks'        => [],
            'articles'     => [],
            'maxIncrement' => 0,
            'summary'      => [
                'snapshotCount' => 0,
                'firstDate'     => null,
                'lastDate'      => null,
                'currentTotal'  => 0,
                'lastWeek'      => null,
                'periodGain'    => 0,
            ],
        ];
    }
}
