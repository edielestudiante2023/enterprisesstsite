<?php

namespace App\Libraries;

/**
 * Contenido comercial reutilizable de EnterpriseSST.
 *
 * Todo lo que se afirma aquí sobre el software está verificado en el código del
 * aplicativo (docs/VENTA_ARRIENDO_ENTERPRISESST.md, sección 4). Las preguntas
 * frecuentes salen de esta misma lista para el texto visible y para el JSON-LD.
 */
class Contenido
{
    /** @return list<array{titulo: string, texto: string, icono: string}> */
    public static function funcionesPrincipales(): array
    {
        return [
            ['icono' => 'documento', 'titulo' => 'Documentos SG-SST con IA', 'texto' => '75 tipos de documento —políticas, programas, procedimientos, actas y planes— redactados a partir del contexto de cada cliente, con su logo, código y versión. Tú revisas y apruebas.'],
            ['icono' => 'check', 'titulo' => 'Estándares mínimos y plan de trabajo', 'texto' => 'Evaluación de la Resolución 0312 con historial de puntajes y plan de trabajo anual organizado por el ciclo PHVA.'],
            ['icono' => 'celular', 'titulo' => 'Inspecciones desde el celular', 'texto' => 'Locativa, extintores, botiquín, señalización, EPP y simulacros, con fotos, en una aplicación que se instala en el teléfono.'],
            ['icono' => 'firma', 'titulo' => 'Firma electrónica verificable', 'texto' => 'Cada firmante recibe su enlace por correo. El documento queda con huella digital y una página pública para verificarlo.'],
            ['icono' => 'personas', 'titulo' => 'Comités y votación electrónica', 'texto' => 'Elecciones de COPASST y comité de convivencia con votación electrónica, actas de constitución, reuniones e informes.'],
            ['icono' => 'matriz', 'titulo' => 'Matrices técnicas', 'texto' => 'Matriz IPEVR (GTC 45) con sugerencias de IA, matriz legal, matriz de EPP, profesiograma y perfiles de cargo.'],
            ['icono' => 'grafica', 'titulo' => 'Indicadores e informes', 'texto' => '17 indicadores SST —frecuencia, severidad, ausentismo, cobertura— e informe de avances para tu cliente.'],
            ['icono' => 'portal', 'titulo' => 'Portal del cliente y asistente Otto', 'texto' => 'Tu cliente consulta su avance en solo lectura y le pregunta a Otto, el asistente con IA, por la información de su SG-SST.'],
        ];
    }

    /**
     * Grupos completos de funciones (página /funciones).
     *
     * @return list<array{id: string, titulo: string, intro: string, items: list<string>}>
     */
    public static function gruposFunciones(): array
    {
        return [
            ['id' => 'documentos', 'titulo' => 'Documentos SG-SST con inteligencia artificial', 'intro' => 'La IA redacta el borrador con el contexto de cada cliente (actividad, cargos, peligros y normas que le aplican). Tú revisas, ajustas y apruebas. Cada documento sale con el logo, la razón social, el código y la versión del cliente.', 'items' => [
                '75 tipos de documento listos para generar',
                'Política SST y políticas de acoso laboral, acoso sexual, alcohol y drogas, desconexión laboral, discriminación, violencias de género y emergencias',
                'Programas de capacitación, inducción y reinducción, inspecciones, mantenimiento, estilos de vida saludable, gestión de residuos y evaluaciones médicas',
                'Procedimientos de control documental, investigación de accidentes e incidentes, gestión del cambio, adquisiciones, evaluación de proveedores, matriz legal, auditoría y rendición de cuentas',
                'Plan de trabajo anual, plan de objetivos y metas y plan de emergencias',
                'PVE de riesgo psicosocial y biomecánico, reglamento de higiene y seguridad, manual de convivencia e informe de revisión por la dirección',
                'Control de versiones y exportación a PDF y Word',
            ]],
            ['id' => 'diagnostico', 'titulo' => 'Diagnóstico y planeación', 'intro' => 'El punto de partida de cada cliente, con trazabilidad de su evolución.', 'items' => [
                'Evaluación de estándares mínimos (Decreto 1072 de 2015 y Resolución 0312 de 2019) con historial de puntajes',
                'Plan de trabajo anual por ciclo PHVA',
                'Presupuesto SST',
                'Matriz legal y matriz de comunicación',
                'Contexto SST de cada cliente: actividad, trabajadores, sedes y estándares que le aplican',
            ]],
            ['id' => 'peligros', 'titulo' => 'Peligros, salud y personas', 'intro' => 'Las matrices técnicas que sostienen el sistema, conectadas entre sí.', 'items' => [
                'Matriz IPEVR (GTC 45) con sugerencias de IA y exportación a Excel y PDF',
                'Matriz de EPP y entrega de dotación',
                'Profesiograma, perfiles de cargo y diccionario de competencias',
                'Exámenes ocupacionales y encuesta sociodemográfica',
                'Evaluación ergonómica de trabajo en casa y pausas activas',
            ]],
            ['id' => 'inspecciones', 'titulo' => 'Inspecciones desde el celular', 'intro' => 'El consultor o el inspector registra en sitio, con fotos, desde una aplicación que se instala en el teléfono.', 'items' => [
                'Inspección locativa, de extintores, botiquín, señalización, EPP, gabinetes y recursos de seguridad',
                'Hoja de vida de brigadistas',
                'Preparación y evaluación de simulacros',
            ]],
            ['id' => 'comites', 'titulo' => 'Comités y votación electrónica', 'intro' => 'Todo el ciclo de los comités, sin papel.', 'items' => [
                'Procesos electorales de COPASST y comité de convivencia laboral con votación electrónica e importación de votantes',
                'Actas de constitución y recomposición de COPASST, comité de convivencia, brigada y vigía',
                'Actas de reunión con compromisos y firma',
                'Informes trimestrales y anuales de los comités',
                'Aplicación para el celular de los miembros de comité',
            ]],
            ['id' => 'seguimiento', 'titulo' => 'Seguimiento y evidencias', 'intro' => 'Cada actividad queda registrada y lista para una auditoría o una visita.', 'items' => [
                'Actas de visita, actas y listas de asistencia de capacitación, cronograma de capacitación e inducción por etapas',
                'Investigación de accidentes con análisis causal y declaración del trabajador accidentado',
                'Acciones correctivas, mantenimientos, vencimientos y pendientes',
                'Registro de evidencias por estándar',
            ]],
            ['id' => 'indicadores', 'titulo' => 'Indicadores e informes', 'intro' => 'Lo que se mide se puede mostrar.', 'items' => [
                '17 indicadores SST: frecuencia, severidad, ausentismo, cobertura, entre otros',
                'Informe de avances para el cliente',
            ]],
            ['id' => 'firma', 'titulo' => 'Firma electrónica', 'intro' => 'Firmas válidas sin imprimir ni escanear.', 'items' => [
                'Cada firmante recibe un enlace personal en su correo',
                'Huella digital SHA-256 del documento para detectar cambios posteriores',
                'Página pública de verificación de cada firma',
            ]],
            ['id' => 'portal', 'titulo' => 'Portal del cliente y Otto', 'intro' => 'Tu cliente ve su avance sin pedirte informes por correo.', 'items' => [
                'Consulta en solo lectura del plan de trabajo, documentos, indicadores y matrices',
                'Otto, el asistente con IA, responde preguntas sobre la información del SG-SST de cada cliente',
            ]],
            ['id' => 'importacion', 'titulo' => 'Empieza con lo que ya tienes', 'intro' => 'No partes de cero con los clientes que ya atiendes.', 'items' => [
                'Importación desde Excel o CSV de procesos, cargos y sedes, matriz legal, matriz de comunicación, votantes de comités, evaluaciones y ergonomía',
            ]],
        ];
    }

    /** @return list<array{q: string, a: string}> */
    public static function preguntasInicio(): array
    {
        $todas = self::preguntas();

        return [$todas[0], $todas[1], $todas[3], $todas[5]];
    }

    /** @return list<array{q: string, a: string}> */
    public static function preguntas(): array
    {
        return [
            ['q' => '¿Qué es EnterpriseSST?', 'a' => 'Es un software para gestionar el Sistema de Gestión de Seguridad y Salud en el Trabajo (SG-SST) de una o varias empresas: documentos, estándares mínimos, plan de trabajo, inspecciones, comités, indicadores y firmas. EnterpriseSST es una marca de Cycloid Talent, que lo usa con sus propios clientes.'],
            ['q' => '¿Cuánto cuesta arrendar EnterpriseSST?', 'a' => 'Pagas una mensualidad por cada empresa cliente activa, según sus estándares mínimos y su número de trabajadores. No se cobra por consultor ni por usuario y no hay cláusulas de permanencia. Los valores están en la página de precios.'],
            ['q' => '¿Para quién es la plataforma?', 'a' => 'Para firmas consultoras SST, consultores independientes que llevan el SG-SST de varias empresas y empresas que tienen su propia área SST.'],
            ['q' => '¿Mis clientes ven la marca de mi firma?', 'a' => 'Sí. Tus consultores y tus clientes ven el logo, el nombre y el color de tu firma, y los documentos de cada cliente salen con el logo de ese cliente.'],
            ['q' => '¿Otras consultoras o Cycloid Talent pueden ver a mis clientes?', 'a' => 'No. Cada firma trabaja en un espacio aislado: tus consultores solo ven tus clientes y nadie más los ve. Cycloid Talent solo entra para darte soporte, y cada acceso queda registrado.'],
            ['q' => '¿Hay prueba gratis?', 'a' => 'No ofrecemos prueba sin acompañamiento, porque poner en marcha un SG-SST exige cargar bien la información de cada cliente. En su lugar te damos una demo guiada y te acompañamos en la puesta en marcha.'],
            ['q' => '¿La inteligencia artificial reemplaza al consultor?', 'a' => 'No. La IA redacta borradores a partir del contexto de cada cliente para ahorrarte tiempo. El consultor SST revisa, ajusta y aprueba cada documento: el criterio profesional sigue siendo tuyo.'],
            ['q' => '¿Necesito licencia en SST para usar la plataforma?', 'a' => 'EnterpriseSST es una herramienta de gestión. Diseñar, administrar y ejecutar el SG-SST de una empresa exige que el profesional cumpla los requisitos de formación y licencia que fija la norma colombiana.'],
            ['q' => '¿Puedo pasar la información que ya tengo en Excel?', 'a' => 'Sí. Puedes importar desde Excel o CSV procesos, cargos y sedes, la matriz legal, la matriz de comunicación, los votantes de los comités y otros registros.'],
            ['q' => '¿Cómo se paga?', 'a' => 'El día 1 de cada mes recibes la orden de servicio del mes anterior y tienes hasta el día 10 para pagar por transferencia a la llave Bre-B de Cycloid Talent. El comprobante se sube en la misma plataforma.'],
            ['q' => '¿Qué pasa con mis clientes si me atraso en un pago?', 'a' => 'Tus clientes, sus comités y sus inspectores siguen trabajando con normalidad y nunca ven avisos de cobro. Mientras el pago esté pendiente, solo tu equipo interno ve la pantalla de su cuenta.'],
            ['q' => '¿Funciona en el celular?', 'a' => 'Sí. Las inspecciones, la participación de los miembros de comité, la matriz IPEVR y el ingreso tienen aplicaciones que se instalan en el teléfono.'],
            ['q' => '¿Sirve para una empresa que gestiona su propio SG-SST?', 'a' => 'Sí. La empresa tiene su propio espacio y paga la tarifa que corresponde a su tamaño. Si además necesita que alguien ejecute su SG-SST, Cycloid Talent ofrece consultoría SST.'],
        ];
    }

    /**
     * JSON-LD SoftwareApplication. Sin precio en los datos estructurados (decisión del usuario
     * del 22 de noviembre de 2026): Google podía mostrar "desde $100.000" en el resultado de
     * búsqueda. Las tarifas siguen publicadas en /precios.
     */
    public static function softwareLd(): array
    {
        return [
            '@context'            => 'https://schema.org',
            '@type'               => 'SoftwareApplication',
            '@id'                 => base_url('/') . '#software',
            'name'                => 'EnterpriseSST',
            'applicationCategory' => 'BusinessApplication',
            'applicationSubCategory' => 'Software SG-SST',
            'operatingSystem'     => 'Web, Android, iOS',
            'url'                 => base_url('/'),
            'image'               => base_url('assets/img/marca/og-enterprisesst.png'),
            'description'         => 'Software para gestionar el SG-SST de varias empresas: documentos con IA, estándares mínimos de la Resolución 0312, inspecciones desde el celular, comités con votación electrónica, indicadores y firma electrónica.',
            'inLanguage'          => 'es-CO',
            'publisher'           => ['@id' => base_url('/') . '#organizacion'],
        ];
    }
}
