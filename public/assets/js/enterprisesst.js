/* EnterpriseSST · comportamiento del sitio sin scripts en línea (compatible con la política CSP). */
(function () {
    'use strict';

    // Menú en celular.
    var boton = document.querySelector('.menu-boton');
    var nav = document.getElementById('nav-principal');
    if (boton && nav) {
        boton.addEventListener('click', function () {
            var abierto = nav.classList.toggle('abierto');
            boton.setAttribute('aria-expanded', abierto ? 'true' : 'false');
            boton.setAttribute('aria-label', abierto ? 'Cerrar menú' : 'Abrir menú');
        });
    }

    // Mostrar u ocultar contraseña (partials/password-field.php).
    document.querySelectorAll('.password-field').forEach(function (campo) {
        var input = campo.querySelector('input');
        var toggle = campo.querySelector('.password-toggle');
        if (!input || !toggle) { return; }
        toggle.addEventListener('click', function () {
            var visible = input.type === 'password';
            input.type = visible ? 'text' : 'password';
            toggle.setAttribute('aria-pressed', visible ? 'true' : 'false');
            toggle.setAttribute('aria-label', visible ? 'Ocultar contraseña' : 'Mostrar contraseña');
            input.focus();
        });
    });

    // Confirmación antes de acciones del panel: <form data-confirmar="¿Seguro?">.
    document.addEventListener('submit', function (evento) {
        var formulario = evento.target;
        var mensaje = formulario && formulario.getAttribute ? formulario.getAttribute('data-confirmar') : null;
        if (mensaje && !window.confirm(mensaje)) {
            evento.preventDefault();
        }
    });
})();
