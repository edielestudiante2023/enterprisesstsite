<?= $this->extend('layouts/main') ?>

<?= $this->section('head') ?>
<link href="<?= base_url('assets/vendor/quill/quill.snow.css') ?>" rel="stylesheet">
<style>
    #editor { background:#fff; min-height:320px; border-radius:0 0 var(--radius-md) var(--radius-md); }
    .ql-toolbar.ql-snow { border-top-left-radius:var(--radius-md); border-top-right-radius:var(--radius-md); border-color:#d1d5db; }
    .ql-container.ql-snow { border-color:#d1d5db; font-family:inherit; font-size:0.95rem; }
    .ql-editor { min-height:300px; }
    .blog-form-field { margin-bottom: 1rem; }
    .blog-form-field label { display:block; font-weight:600; color:var(--color-text); margin-bottom:.35rem; font-size:.9rem; }
    .blog-form-field input[type=text], .blog-form-field textarea {
        width:100%; padding:.55rem .85rem; border:1px solid #d1d5db; border-radius:var(--radius-md);
        font-family:inherit; font-size:.95rem; outline:none; transition:border-color .15s ease, box-shadow .15s ease;
        background:#fff; color:var(--color-text);
    }
    .blog-form-field input[type=text]:focus, .blog-form-field textarea:focus {
        border-color:var(--color-primary); box-shadow:0 0 0 3px var(--color-primary-light);
    }
    .blog-form-field textarea { resize:vertical; }
    .blog-form-contador { display:block; margin-top:.25rem; font-size:.8rem; color:var(--color-muted); }
    .blog-form-contador.excedido { color:#b91c1c; font-weight:600; }
    .blog-form-field input[type=file] {
        width:100%; padding:.4rem; border:1px solid #d1d5db; border-radius:var(--radius-md); background:#fff;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="page-hero">
    <div class="container">
        <div class="admin-bar">
            <div>
                <span class="eyebrow" style="display:inline-block; text-transform:uppercase; letter-spacing:.12em; font-size:.8rem; font-weight:600; color:var(--color-secondary); margin-bottom:8px;">Panel de administración</span>
                <h1 style="margin-bottom:6px;"><?= $post ? 'Editar artículo' : 'Nuevo artículo' ?></h1>
                <p style="color:var(--color-muted); margin:0;">
                    <a href="<?= base_url('admin/blog') ?>" style="color:var(--color-primary);">← Volver al listado</a>
                </p>
            </div>
        </div>

        <?php $errors = session()->getFlashdata('errors'); if (is_array($errors) && ! empty($errors)): ?>
            <div class="auth-alert auth-alert-error">
                <ul style="margin:0; padding-left:1.2em;">
                    <?php foreach ($errors as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php $similares = session()->getFlashdata('similares'); if (is_array($similares) && ! empty($similares)): ?>
            <div class="auth-alert auth-alert-error">
                <p style="margin:0 0 .4em;">Este artículo se parece a otros ya creados y pueden competir entre sí en Google:</p>
                <ul style="margin:0; padding-left:1.2em;">
                    <?php foreach ($similares as $similar): ?>
                        <li><?= esc($similar['titulo']) ?> (<?= (int) $similar['porcentaje'] ?> % de frases en común)</li>
                    <?php endforeach; ?>
                </ul>
                <p style="margin:.4em 0 0;">Si la imagen de portada estaba seleccionada, vuelve a elegirla.</p>
            </div>
        <?php endif; ?>

        <div class="admin-card" style="max-width:880px;">
            <form action="<?= $post ? base_url('admin/blog/actualizar/' . $post['id']) : base_url('admin/blog/guardar') ?>"
                  method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="blog-form-field">
                    <label for="titulo">Título *</label>
                    <input type="text" id="titulo" name="titulo" required maxlength="255"
                           value="<?= esc(old('titulo', $post['titulo'] ?? ''), 'attr') ?>">
                </div>

                <div class="blog-form-field">
                    <label for="extracto">Extracto <span style="font-weight:400; color:var(--color-muted);">(resumen breve para tarjetas y SEO)</span></label>
                    <textarea id="extracto" name="extracto" rows="2" maxlength="500"><?= esc(old('extracto', $post['extracto'] ?? '')) ?></textarea>
                </div>

                <fieldset style="border:1px solid #e5e7eb; border-radius:var(--radius-md); padding:1rem 1.1rem 1.1rem; margin-bottom:1rem;">
                    <legend style="font-weight:600; color:var(--color-secondary); font-size:.85rem; text-transform:uppercase; letter-spacing:.08em; padding:0 .4rem;">Metadata SEO</legend>
                    <p style="color:var(--color-muted); font-size:.85rem; margin:0 0 1rem;">Opcional. Si lo dejas vacío, el sitio usa valores por defecto (título y extracto). Mejora cómo aparece el artículo en Google y redes.</p>

                    <div class="blog-form-field">
                        <label for="meta_titulo">Título SEO <span style="font-weight:400; color:var(--color-muted);">(para Google; ~60 caracteres. Si vacío, usa el título)</span></label>
                        <input type="text" id="meta_titulo" name="meta_titulo" data-limite="70"
                               value="<?= esc(old('meta_titulo', $post['meta_titulo'] ?? ''), 'attr') ?>">
                        <small class="blog-form-contador"></small>
                    </div>

                    <div class="blog-form-field">
                        <label for="meta_descripcion">Meta descripción <span style="font-weight:400; color:var(--color-muted);">(snippet de Google; ~155 caracteres. Si vacío, usa el extracto)</span></label>
                        <textarea id="meta_descripcion" name="meta_descripcion" rows="2" data-limite="160"><?= esc(old('meta_descripcion', $post['meta_descripcion'] ?? '')) ?></textarea>
                        <small class="blog-form-contador"></small>
                    </div>

                    <div class="blog-form-field">
                        <label for="categoria">Categoría <span style="font-weight:400; color:var(--color-muted);">(ej: Riesgo psicosocial, SG-SST)</span></label>
                        <input type="text" id="categoria" name="categoria" maxlength="100"
                               value="<?= esc(old('categoria', $post['categoria'] ?? ''), 'attr') ?>">
                    </div>

                    <div class="blog-form-field">
                        <label for="etiquetas">Etiquetas / palabras clave <span style="font-weight:400; color:var(--color-muted);">(separadas por coma)</span></label>
                        <input type="text" id="etiquetas" name="etiquetas" maxlength="255"
                               value="<?= esc(old('etiquetas', $post['etiquetas'] ?? ''), 'attr') ?>">
                    </div>

                    <div class="blog-form-field">
                        <label for="imagen_alt">Texto alternativo de la portada <span style="font-weight:400; color:var(--color-muted);">(accesibilidad y SEO de imagen. Si vacío, usa el título)</span></label>
                        <input type="text" id="imagen_alt" name="imagen_alt" maxlength="255"
                               value="<?= esc(old('imagen_alt', $post['imagen_alt'] ?? ''), 'attr') ?>">
                    </div>

                    <div class="blog-form-field" style="margin-bottom:0;">
                        <label style="display:flex; align-items:center; gap:.5rem; cursor:pointer; font-weight:500;">
                            <input type="checkbox" name="noindex" value="1"
                                   <?= old('noindex', $post['noindex'] ?? 0) ? 'checked' : '' ?>>
                            <span>No indexar en buscadores (noindex)</span>
                        </label>
                    </div>
                </fieldset>

                <div class="blog-form-field">
                    <label>Contenido *</label>
                    <div id="editor"></div>
                    <textarea name="contenido" id="contenido" style="display:none;"><?= old('contenido', $post['contenido'] ?? '') ?></textarea>
                </div>

                <div class="blog-form-field">
                    <label for="imagen">
                        Imagen de portada
                        <?= $post && ! empty($post['imagen']) ? '<span style="font-weight:400; color:var(--color-muted);">(dejar vacío para conservar la actual)</span>' : '<span style="font-weight:400; color:var(--color-muted);">(máx. 5 MB recomendado)</span>' ?>
                    </label>
                    <?php if ($post && ! empty($post['imagen'])): ?>
                        <div style="margin-bottom:.5rem;">
                            <img src="<?= base_url('assets/img/blog/' . $post['imagen']) ?>"
                                 alt="Imagen actual"
                                 style="max-height:140px; border-radius:var(--radius-md); border:1px solid #e5e7eb;">
                        </div>
                    <?php endif; ?>
                    <input type="file" id="imagen" name="imagen" accept="image/*">
                </div>

                <div class="blog-form-field">
                    <label style="display:flex; align-items:center; gap:.5rem; cursor:pointer; font-weight:500;">
                        <input type="checkbox" name="publicado" value="1"
                               <?= old('publicado', $post['publicado'] ?? 0) ? 'checked' : '' ?>>
                        <span>Publicar inmediatamente</span>
                    </label>
                </div>

                <?php if (is_array($similares) && ! empty($similares)): ?>
                    <div class="blog-form-field">
                        <label style="display:flex; align-items:center; gap:.5rem; cursor:pointer; font-weight:500;">
                            <input type="checkbox" name="confirmar_similar" value="1">
                            <span>Revisé los artículos parecidos y quiero publicar de todas formas</span>
                        </label>
                    </div>
                <?php endif; ?>

                <div style="display:flex; gap:8px; padding-top:8px;">
                    <button type="submit" class="btn btn-primary">
                        <?= $post ? 'Actualizar artículo' : 'Crear artículo' ?>
                    </button>
                    <a href="<?= base_url('admin/blog') ?>" class="btn btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="<?= base_url('assets/vendor/quill/quill.js') ?>"></script>
<script <?= csp_script_nonce() ?>>
(function () {
    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Escribe el contenido del artículo...',
        modules: {
            toolbar: [
                [{ header: [2, 3, 4, false] }, { size: ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ color: [] }, { background: [] }],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ indent: '-1' }, { indent: '+1' }],
                [{ align: [] }],
                ['blockquote', 'code-block', 'link'],
                ['clean']
            ]
        }
    });

    var textarea = document.getElementById('contenido');
    if (textarea.value.trim() !== '') {
        quill.clipboard.dangerouslyPasteHTML(textarea.value);
    }

    // Sincroniza en cada cambio del editor: garantiza que el textarea oculto
    // siempre tenga el HTML actual de Quill antes de cualquier validacion.
    quill.on('text-change', function () {
        textarea.value = quill.root.innerHTML;
    });

    // Contador en vivo: el limite ya no corta en silencio lo que se pega.
    document.querySelectorAll('[data-limite]').forEach(function (campo) {
        var contador = campo.parentNode.querySelector('.blog-form-contador');
        var limite = Number(campo.dataset.limite);
        var actualizar = function () {
            var total = Array.from(campo.value).length;
            contador.textContent = total + ' de ' + limite + ' caracteres';
            contador.classList.toggle('excedido', total > limite);
        };
        campo.addEventListener('input', actualizar);
        actualizar();
    });

    var form = textarea.closest('form');
    form.addEventListener('submit', function () {
        textarea.value = quill.root.innerHTML;
    });
})();
</script>

<?= $this->endSection() ?>
