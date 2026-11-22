<?php /** Preguntas visibles. La misma lista va al JSON-LD (partials/jsonld-faq). @var list<array{q: string, a: string}> $faqs */ ?>
<div class="faq">
    <?php foreach ($faqs as $faq): ?>
        <details>
            <summary><?= esc($faq['q']) ?></summary>
            <div class="respuesta"><p><?= esc($faq['a']) ?></p></div>
        </details>
    <?php endforeach; ?>
</div>
