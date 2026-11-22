<?php
// Version de los assets de DataTables para invalidar cache del navegador.
$dtVer = (string) (@filemtime(FCPATH . 'assets/vendor/datatables/datatables.min.js') ?: '1');
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/vendor/datatables/datatables.min.css') ?>?v=<?= $dtVer ?>">
<style>
    .bv-kpis { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; }
    .bv-kpi { padding:16px; border:1px solid var(--color-border); border-radius:12px; background:#fff; }
    .bv-kpi-label { color:var(--color-muted); font-size:.78rem; letter-spacing:.07em; text-transform:uppercase; }
    .bv-kpi-value { display:block; margin-top:4px; color:var(--color-primary); font-size:1.55rem; font-variant-numeric:tabular-nums; }
    @media (max-width:700px) { .bv-kpis { grid-template-columns:1fr; } }

    /* Selector de articulo */
    .bv-chart-toolbar { display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:12px; margin:14px 0 4px; }
    .bv-chart-hint { margin:0; color:var(--color-muted); font-size:.85rem; max-width:520px; }
    .bv-select-field { display:flex; flex-direction:column; gap:4px; min-width:280px; }
    .bv-select-field span { font-size:.78rem; text-transform:uppercase; letter-spacing:.07em; color:var(--color-muted); }
    .bv-select-field select { padding:8px 12px; border:1px solid var(--color-border); border-radius:var(--radius-sm,6px); background:#fff; color:var(--color-text); font-size:.9rem; }

    /* Grafica de linea (una serie a la vez) */
    .bv-linechart-wrap { position:relative; overflow-x:auto; padding:8px 0 4px; }
    .bv-linechart-inner { position:relative; min-width:600px; }
    .bv-linechart { display:block; width:100%; height:auto; }
    .bv-grid-line { stroke:var(--color-border); stroke-width:1; }
    .bv-axis-label { fill:var(--color-muted); font-size:11px; font-family:inherit; }
    .bv-baseline { stroke:#c3c2b7; stroke-width:1; }
    .bv-series-line { fill:none; stroke-width:2; stroke-linejoin:round; stroke-linecap:round; }
    .bv-series-area { stroke:none; }
    .bv-series-dot { stroke:#fff; stroke-width:2; }
    .bv-crosshair { stroke:#c3c2b7; stroke-width:1; opacity:0; pointer-events:none; }
    .bv-hit { fill:transparent; cursor:crosshair; }
    .bv-hit:focus-visible { outline:2px solid var(--color-primary); outline-offset:-2px; }
    .bv-tooltip { position:absolute; top:6px; pointer-events:none; background:#fff; border:1px solid var(--color-border); border-radius:8px; box-shadow:var(--shadow-sm); padding:8px 12px; font-size:.8rem; min-width:120px; z-index:5; }
    .bv-tooltip[hidden] { display:none; }
    .bv-tooltip-date { font-weight:700; color:var(--color-text); margin-bottom:2px; }
    .bv-tooltip-value { color:var(--color-primary); font-variant-numeric:tabular-nums; }

    /* DataTables: mismo lenguaje visual usado en admin/contactos */
    .dt-wrap { background:transparent; border:0; box-shadow:none; overflow:visible; }
    .dt-wrap .dt-scrollx { overflow-x:auto; background:#fff; border:1px solid var(--color-border); border-radius:var(--radius-md); box-shadow:var(--shadow-sm); }
    .dt-wrap .dt-container { color:var(--color-text-soft); }
    .dt-wrap .dt-layout-row { margin-bottom:12px; }
    .dt-wrap .dt-layout-row:last-child { margin-bottom:0; margin-top:14px; }
    .dt-wrap .dt-search input,
    .dt-wrap .dt-length select { padding:7px 11px; border:1px solid var(--color-border); border-radius:var(--radius-sm,6px); font-size:.9rem; color:var(--color-text); }
    .dt-wrap .dt-search label,
    .dt-wrap .dt-length label { font-size:.86rem; color:var(--color-muted); }
    .dt-wrap .dt-info { font-size:.86rem; color:var(--color-muted); }
    .dt-wrap .dt-buttons { display:flex; flex-wrap:wrap; gap:8px; }
    .dt-wrap button.dt-button { margin:0; padding:9px 16px; border-radius:var(--radius-sm,6px); border:1px solid var(--color-primary); background:var(--color-primary); color:#fff; font-size:.86rem; font-weight:600; cursor:pointer; transition:background .18s ease, color .18s ease; }
    .dt-wrap button.dt-button:hover,
    .dt-wrap button.dt-button:focus-visible { background:var(--color-primary-dark); border-color:var(--color-primary-dark); color:#fff; }
    .dt-wrap button.dt-button.dt-btn-soft { background:transparent; color:var(--color-primary); }
    .dt-wrap button.dt-button.dt-btn-soft:hover,
    .dt-wrap button.dt-button.dt-btn-soft:focus-visible { background:var(--color-primary); color:#fff; }
    .dt-wrap .dt-paging .dt-paging-button { padding:6px 12px; border-radius:var(--radius-sm,6px); color:var(--color-text-soft); }
    .dt-wrap .dt-paging .dt-paging-button.current { background:var(--color-primary-light); border-color:var(--color-border); color:var(--color-primary-dark); font-weight:700; }
    #tabla-blog-estadisticas tbody tr { cursor:pointer; }
    #tabla-blog-estadisticas tbody tr:hover,
    #tabla-blog-estadisticas tbody tr.is-active { background:var(--color-primary-light); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$summary = $evolution['summary'];
$fmtDate = static function (?string $date): string {
    return $date ? date('d/m/Y', strtotime($date)) : '—';
};

// Semanas con incremento calculable: la linea base no tiene variacion todavia.
$chartWeeks = array_values(array_filter(
    $evolution['weeks'],
    static fn ($week) => $week['increment'] !== null
));
$hasChart = count($chartWeeks) >= 2;

if ($hasChart) {
    $pointCount  = count($chartWeeks);
    $chartLabels = array_map(static fn ($week) => date('d/m', strtotime($week['date'])), $chartWeeks);

    // Geometria del SVG: viewBox fijo, el navegador lo escala al ancho disponible.
    $vbW  = 900;
    $vbH  = 320;
    $padL = 46;
    $padR = 16;
    $padT = 16;
    $padB = 34;
    $plotW = $vbW - $padL - $padR;
    $plotH = $vbH - $padT - $padB;
    $baselineY = $padT + $plotH;

    $xPositions = [];
    for ($i = 0; $i < $pointCount; $i++) {
        $xPositions[$i] = $pointCount > 1 ? $padL + ($i / ($pointCount - 1)) * $plotW : $padL + $plotW / 2;
    }

    // No amontonar fechas en el eje X cuando hay muchos cortes visibles.
    $labelStep = $pointCount > 12 ? (int) ceil($pointCount / 10) : 1;

    $niceMax = static function (int $value): int {
        if ($value <= 0) {
            return 10;
        }
        $magnitude = (int) pow(10, floor(log10($value)));
        foreach ([1, 2, 5, 10] as $step) {
            $candidate = $step * $magnitude;
            if ($candidate >= $value) {
                return $candidate;
            }
        }
        return 10 * $magnitude;
    };

    // Serie "total" (todos los articulos sumados) + una serie por articulo.
    // Solo una se muestra a la vez: el selector cambia entre ellas sin recargar.
    $rawSeries = [];
    $rawSeries['total'] = [
        'label'  => 'Total (todos los artículos)',
        'values' => array_map(static fn ($week) => (int) $week['increment'], $chartWeeks),
    ];
    foreach ($evolution['articles'] as $article) {
        $rawSeries[(string) $article['id']] = [
            'label'  => $article['titulo'],
            'values' => array_map(
                static fn ($week) => (int) ($week['byArticle'][$article['id']] ?? 0),
                $chartWeeks
            ),
        ];
    }

    $seriesColor = '#2a78d6';
    $chartSeries = [];
    foreach ($rawSeries as $key => $s) {
        $chartMax = max($s['values']);
        $axisMax  = $niceMax($chartMax);

        $yFor = static function (int $value) use ($padT, $plotH, $axisMax) {
            return $axisMax > 0 ? $padT + $plotH - ($value / $axisMax) * $plotH : $padT + $plotH;
        };

        $linePoints = [];
        for ($i = 0; $i < $pointCount; $i++) {
            $linePoints[] = round($xPositions[$i], 2) . ',' . round($yFor($s['values'][$i]), 2);
        }
        $linePath = 'M' . implode(' L', $linePoints);
        $areaPath = $linePath
            . ' L' . round($xPositions[$pointCount - 1], 2) . ',' . $baselineY
            . ' L' . round($xPositions[0], 2) . ',' . $baselineY
            . ' Z';

        $dots = [];
        $points = [];
        for ($i = 0; $i < $pointCount; $i++) {
            $dots[]   = ['x' => round($xPositions[$i], 2), 'y' => round($yFor($s['values'][$i]), 2)];
            $points[] = ['date' => $chartLabels[$i], 'value' => $s['values'][$i]];
        }

        $ticks = [];
        for ($t = 0; $t <= 4; $t++) {
            $fraction  = $t / 4;
            $tickValue = (int) round($axisMax * $fraction);
            $ticks[] = [
                'y'    => round($yFor($tickValue), 2),
                'text' => number_format($tickValue, 0, ',', '.'),
            ];
        }

        $chartSeries[$key] = [
            'label'    => $s['label'],
            'linePath' => $linePath,
            'areaPath' => $areaPath,
            'dots'     => $dots,
            'points'   => $points,
            'ticks'    => $ticks,
        ];
    }

    $defaultSeries = $chartSeries['total'];
}
?>

<section class="page-hero">
    <div class="container">
        <div class="admin-bar">
            <div>
                <span class="eyebrow" style="display:inline-block; text-transform:uppercase; letter-spacing:.12em; font-size:.8rem; font-weight:600; color:var(--color-secondary); margin-bottom:8px;">Panel de administración</span>
                <h1 style="margin-bottom:6px;">Evolución de visitas del blog</h1>
                <p style="color:var(--color-muted); margin:0;">Incrementos entre snapshots semanales tomados los viernes.</p>
            </div>
            <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <form method="post" action="<?= base_url('admin/blog/snapshot') ?>" style="margin:0;" data-confirmar="¿Tomar un snapshot de las visitas actuales? Si ya existe uno de hoy, se actualizará.">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-primary">Tomar snapshot ahora</button>
                </form>
                <a href="<?= base_url('admin/blog') ?>" class="btn btn-ghost">← Volver al blog</a>
            </div>
        </div>

        <?php $error = session()->getFlashdata('error'); if (is_string($error) && $error !== ''): ?>
            <div class="auth-alert auth-alert-error"><?= esc($error) ?></div>
        <?php endif; ?>
        <?php $success = session()->getFlashdata('success'); if (is_string($success) && $success !== ''): ?>
            <div class="auth-alert auth-alert-success"><?= esc($success) ?></div>
        <?php endif; ?>

        <div class="admin-card">
            <form method="get" action="<?= base_url('admin/blog/estadisticas') ?>" class="admin-form" style="margin:0; display:flex; gap:10px; align-items:flex-end; flex-wrap:wrap;">
                <label style="min-width:190px;">
                    <span>Periodo visible</span>
                    <select name="weeks">
                        <?php foreach ([8, 12, 26, 52] as $option): ?>
                            <option value="<?= $option ?>" <?= $weeksFilter === $option ? 'selected' : '' ?>>Últimos <?= $option ?> cortes</option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <span style="color:var(--color-muted); font-size:.85rem; padding-bottom:8px;">Último corte: <strong><?= esc($fmtDate($summary['lastDate'])) ?></strong></span>
            </form>
        </div>

        <div class="admin-card">
            <div class="bv-kpis">
                <div class="bv-kpi">
                    <span class="bv-kpi-label">Visitas acumuladas</span>
                    <strong class="bv-kpi-value"><?= number_format((int) $summary['currentTotal'], 0, ',', '.') ?></strong>
                </div>
                <div class="bv-kpi">
                    <span class="bv-kpi-label">Última semana</span>
                    <strong class="bv-kpi-value"><?= $summary['lastWeek'] === null ? 'Línea base' : '+' . number_format((int) $summary['lastWeek'], 0, ',', '.') ?></strong>
                </div>
                <div class="bv-kpi">
                    <span class="bv-kpi-label">Crecimiento del periodo</span>
                    <strong class="bv-kpi-value">+<?= number_format((int) $summary['periodGain'], 0, ',', '.') ?></strong>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <h2 style="font-size:1.1rem; margin:0 0 4px;">Evolución semanal por artículo</h2>
            <p style="margin:0; color:var(--color-muted); font-size:.85rem;">Por defecto se muestra la suma de todos los artículos. Elige uno del selector, o haz clic en una fila de la tabla, para ver solo su crecimiento semana a semana.</p>

            <?php if (! $hasChart): ?>
                <div style="padding:34px 12px; text-align:center; color:var(--color-muted);">
                    <?php if ((int) $summary['snapshotCount'] === 0): ?>
                        Aún no hay snapshots. Ejecuta <code>php spark blog:snapshot-visitas</code> para crear la línea base.
                    <?php elseif ((int) $summary['snapshotCount'] === 1): ?>
                        Línea base guardada el <?= esc($fmtDate($summary['firstDate'])) ?>. El primer crecimiento semanal aparecerá con el próximo snapshot.
                    <?php else: ?>
                        Ya tienes <?= (int) $summary['snapshotCount'] ?> cortes guardados. La tendencia se grafica en cuanto haya al menos dos semanas con crecimiento calculado.
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="bv-chart-toolbar">
                    <p class="bv-chart-hint">La gráfica no consolida artículos distintos al mismo tiempo: siempre representa uno solo (o el total).</p>
                    <label class="bv-select-field">
                        <span>Artículo a analizar</span>
                        <select id="bv-article-select">
                            <option value="total">Total (todos los artículos)</option>
                            <?php foreach ($evolution['articles'] as $article): ?>
                                <option value="<?= (int) $article['id'] ?>"><?= esc($article['titulo']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>

                <div class="bv-linechart-wrap" data-bv-chart>
                    <div class="bv-linechart-inner">
                        <svg class="bv-linechart" viewBox="0 0 <?= $vbW ?> <?= $vbH ?>" preserveAspectRatio="none" role="img" aria-label="Gráfico de líneas de visualizaciones semanales">
                            <?php foreach ($defaultSeries['ticks'] as $tick): ?>
                                <line class="bv-grid-line" data-bv-gridline x1="<?= $padL ?>" x2="<?= $vbW - $padR ?>" y1="<?= $tick['y'] ?>" y2="<?= $tick['y'] ?>"></line>
                                <text class="bv-axis-label" data-bv-gridlabel x="<?= $padL - 8 ?>" y="<?= round($tick['y'] + 3, 2) ?>" text-anchor="end"><?= esc($tick['text']) ?></text>
                            <?php endforeach; ?>
                            <line class="bv-baseline" x1="<?= $padL ?>" x2="<?= $vbW - $padR ?>" y1="<?= $baselineY ?>" y2="<?= $baselineY ?>"></line>

                            <?php for ($i = 0; $i < $pointCount; $i++): ?>
                                <?php if ($i % $labelStep === 0 || $i === $pointCount - 1): ?>
                                    <text class="bv-axis-label" x="<?= round($xPositions[$i], 2) ?>" y="<?= $vbH - 10 ?>" text-anchor="middle"><?= esc($chartLabels[$i]) ?></text>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <path class="bv-series-area" data-bv-area d="<?= esc($defaultSeries['areaPath'], 'attr') ?>" fill="<?= $seriesColor ?>" fill-opacity="0.1"></path>
                            <path class="bv-series-line" data-bv-line stroke="<?= $seriesColor ?>" d="<?= esc($defaultSeries['linePath'], 'attr') ?>"></path>
                            <?php foreach ($defaultSeries['dots'] as $dot): ?>
                                <circle class="bv-series-dot" data-bv-dot cx="<?= $dot['x'] ?>" cy="<?= $dot['y'] ?>" r="4" fill="<?= $seriesColor ?>"></circle>
                            <?php endforeach; ?>

                            <line class="bv-crosshair" x1="<?= $padL ?>" x2="<?= $padL ?>" y1="<?= $padT ?>" y2="<?= $baselineY ?>"></line>
                            <rect class="bv-hit" tabindex="0" role="application" aria-label="Explorar visualizaciones por semana con las flechas del teclado" x="<?= $padL ?>" y="<?= $padT ?>" width="<?= $plotW ?>" height="<?= $plotH ?>"></rect>
                        </svg>
                        <div class="bv-tooltip" hidden></div>
                    </div>
                </div>

                <script type="application/json" id="bv-chart-data"><?= json_encode($chartSeries, JSON_UNESCAPED_UNICODE) ?></script>
            <?php endif; ?>
        </div>

        <div class="admin-card">
            <h2 style="font-size:1.1rem; margin:0 0 4px;">Detalle por artículo</h2>
            <p style="margin:0 0 12px; color:var(--color-muted); font-size:.85rem;">Busca, ordena o exporta. Haz clic en una fila para verla en la gráfica de arriba.</p>
            <?php if (empty($evolution['articles'])): ?>
                <p style="color:var(--color-muted); margin:0;">No hay datos históricos todavía.</p>
            <?php else: ?>
                <div class="ficha-table-wrap dt-wrap">
                    <table class="ficha-table" id="tabla-blog-estadisticas">
                        <thead><tr><th>Artículo</th><th>Acumulado</th><th>Última semana</th><th>Periodo visible</th></tr></thead>
                        <tbody>
                        <?php foreach ($evolution['articles'] as $article): ?>
                            <tr data-article-id="<?= (int) $article['id'] ?>" title="Ver este artículo en la gráfica">
                                <td><strong><?= esc($article['titulo']) ?></strong><div style="font-size:.78rem; color:var(--color-muted);">/blog/<?= esc($article['slug']) ?></div></td>
                                <td data-order="<?= (int) $article['total'] ?>"><strong style="color:var(--color-primary);"><?= number_format((int) $article['total'], 0, ',', '.') ?></strong></td>
                                <td data-order="<?= $article['lastWeek'] === null ? -1 : (int) $article['lastWeek'] ?>"><?= $article['lastWeek'] === null ? '—' : '+' . number_format((int) $article['lastWeek'], 0, ',', '.') ?></td>
                                <td data-order="<?= (int) $article['periodGain'] ?>">+<?= number_format((int) $article['periodGain'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if ($hasChart): ?>
<script <?= csp_script_nonce() ?>>
(function () {
    'use strict';

    var wrap = document.querySelector('[data-bv-chart]');
    var dataEl = document.getElementById('bv-chart-data');
    var select = document.getElementById('bv-article-select');
    if (! wrap || ! dataEl || ! select) { return; }

    var seriesData = JSON.parse(dataEl.textContent);
    var svg = wrap.querySelector('.bv-linechart');
    var areaEl = wrap.querySelector('[data-bv-area]');
    var lineEl = wrap.querySelector('[data-bv-line]');
    var dotEls = wrap.querySelectorAll('[data-bv-dot]');
    var gridLineEls = wrap.querySelectorAll('[data-bv-gridline]');
    var gridLabelEls = wrap.querySelectorAll('[data-bv-gridlabel]');
    var hit = wrap.querySelector('.bv-hit');
    var crosshair = wrap.querySelector('.bv-crosshair');
    var tooltip = wrap.querySelector('.bv-tooltip');
    var VBW = <?= $vbW ?>;
    var currentIndex = -1;
    var currentPoints = (seriesData.total || {}).points || [];

    function applySeries(key) {
        var s = seriesData[key];
        if (! s) { return; }

        areaEl.setAttribute('d', s.areaPath);
        lineEl.setAttribute('d', s.linePath);

        s.dots.forEach(function (dot, i) {
            if (dotEls[i]) { dotEls[i].setAttribute('cy', dot.y); }
        });
        s.ticks.forEach(function (tick, i) {
            if (gridLineEls[i]) {
                gridLineEls[i].setAttribute('y1', tick.y);
                gridLineEls[i].setAttribute('y2', tick.y);
            }
            if (gridLabelEls[i]) {
                gridLabelEls[i].setAttribute('y', tick.y + 3);
                gridLabelEls[i].textContent = tick.text;
            }
        });

        currentPoints = s.points;
        hide();
    }

    function selectArticle(key) {
        key = String(key);
        applySeries(key);
        if (select.value !== key) {
            select.value = key;
        }
        document.querySelectorAll('#tabla-blog-estadisticas tbody tr').forEach(function (tr) {
            tr.classList.toggle('is-active', tr.getAttribute('data-article-id') === key);
        });
    }

    select.addEventListener('change', function () { selectArticle(this.value); });

    document.addEventListener('click', function (evt) {
        var tr = evt.target.closest ? evt.target.closest('#tabla-blog-estadisticas tbody tr') : null;
        if (! tr) { return; }
        selectArticle(tr.getAttribute('data-article-id'));
    });

    function nearestIndex(vbX) {
        var best = 0;
        var bestDist = Infinity;
        for (var i = 0; i < dotEls.length; i++) {
            var x = parseFloat(dotEls[i].getAttribute('cx'));
            var dist = Math.abs(x - vbX);
            if (dist < bestDist) {
                bestDist = dist;
                best = i;
            }
        }
        return best;
    }

    function showAt(index) {
        if (! currentPoints[index]) { return; }
        currentIndex = index;
        var point = currentPoints[index];
        var x = dotEls[index].getAttribute('cx');
        crosshair.setAttribute('x1', x);
        crosshair.setAttribute('x2', x);
        crosshair.setAttribute('opacity', '1');

        tooltip.replaceChildren();
        var title = document.createElement('div');
        title.className = 'bv-tooltip-date';
        title.textContent = point.date;
        var value = document.createElement('div');
        value.className = 'bv-tooltip-value';
        value.textContent = '+' + point.value.toLocaleString('es-CO') + ' visitas nuevas';
        tooltip.appendChild(title);
        tooltip.appendChild(value);
        tooltip.hidden = false;

        var rect = svg.getBoundingClientRect();
        var left = (parseFloat(x) / VBW) * rect.width;
        var maxLeft = Math.max(8, rect.width - tooltip.offsetWidth - 8);
        tooltip.style.left = Math.max(8, Math.min(left + 12, maxLeft)) + 'px';
    }

    function hide() {
        crosshair.setAttribute('opacity', '0');
        tooltip.hidden = true;
        currentIndex = -1;
    }

    function handlePointer(evt) {
        var rect = svg.getBoundingClientRect();
        var clientX = evt.touches && evt.touches.length ? evt.touches[0].clientX : evt.clientX;
        var relX = ((clientX - rect.left) / rect.width) * VBW;
        showAt(nearestIndex(relX));
    }

    hit.addEventListener('pointermove', handlePointer);
    hit.addEventListener('pointerdown', handlePointer);
    hit.addEventListener('pointerleave', hide);
    hit.addEventListener('focus', function () { showAt(currentPoints.length - 1); });
    hit.addEventListener('blur', hide);
    hit.addEventListener('keydown', function (evt) {
        if (evt.key !== 'ArrowLeft' && evt.key !== 'ArrowRight') { return; }
        evt.preventDefault();
        var base = currentIndex === -1 ? currentPoints.length - 1 : currentIndex;
        var next = evt.key === 'ArrowLeft' ? base - 1 : base + 1;
        next = Math.max(0, Math.min(currentPoints.length - 1, next));
        showAt(next);
    });
}());
</script>
<?php endif; ?>

<?php if (! empty($evolution['articles'])): ?>
<script src="<?= base_url('assets/vendor/datatables/jquery.min.js') ?>?v=<?= $dtVer ?>"></script>
<script src="<?= base_url('assets/vendor/datatables/datatables.min.js') ?>?v=<?= $dtVer ?>"></script>
<script <?= csp_script_nonce() ?>>
(function ($) {
    'use strict';

    var COL_ACUMULADO = 1;

    var hoy = new Date();
    var stamp = hoy.getFullYear()
        + '-' + String(hoy.getMonth() + 1).padStart(2, '0')
        + '-' + String(hoy.getDate()).padStart(2, '0');
    var nombreArchivo = 'blog-estadisticas-enterprisesst-' + stamp;

    var tabla = new DataTable('#tabla-blog-estadisticas', {
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
        order: [[COL_ACUMULADO, 'desc']],
        layout: {
            top1Start: {
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Descargar Excel',
                        title: '',
                        filename: nombreArchivo,
                        sheetName: 'Estadisticas blog'
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'Descargar CSV',
                        className: 'dt-btn-soft',
                        title: '',
                        filename: nombreArchivo,
                        bom: true,
                        fieldSeparator: ';'
                    },
                    {
                        extend: 'copyHtml5',
                        text: 'Copiar',
                        className: 'dt-btn-soft',
                        title: ''
                    }
                ]
            },
            topStart: 'pageLength',
            topEnd: 'search',
            bottomStart: 'info',
            bottomEnd: 'paging'
        },
        language: {
            emptyTable: 'No hay artículos para mostrar',
            info: 'Mostrando _START_ a _END_ de _TOTAL_ artículos',
            infoEmpty: 'Mostrando 0 de 0 artículos',
            infoFiltered: '(filtrados de _MAX_ artículos en total)',
            lengthMenu: 'Mostrar _MENU_ artículos',
            loadingRecords: 'Cargando...',
            processing: 'Procesando...',
            search: 'Buscar:',
            searchPlaceholder: 'Título del artículo',
            zeroRecords: 'Ningún artículo coincide con la búsqueda',
            paginate: {
                first: 'Primero',
                last: 'Último',
                next: 'Siguiente',
                previous: 'Anterior'
            },
            aria: {
                sortAscending: ': activar para ordenar de forma ascendente',
                sortDescending: ': activar para ordenar de forma descendente'
            },
            buttons: {
                copyTitle: 'Copiado al portapapeles',
                copyKeys: 'Presiona Ctrl + C para copiar los datos.',
                copySuccess: { _: '%d filas copiadas', 1: '1 fila copiada' }
            }
        }
    });

    $('#tabla-blog-estadisticas').wrap('<div class="dt-scrollx"></div>');
}(jQuery));
</script>
<?php endif; ?>
<?= $this->endSection() ?>
