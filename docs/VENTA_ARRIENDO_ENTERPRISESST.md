# Venta del arriendo de EnterpriseSST

Brújula del sitio `enterprisesst.cycloidtalent.com` y de las redes de EnterpriseSST.

> **El sitio existe para que firmas consultoras y consultores SST pidan una demo y arrienden EnterpriseSST.**
> Todo cambio de contenido, diseño o SEO debe responder: **¿esto acerca a un consultor a pedir una demo?** Si no, no es prioridad.

Creado el 21 de noviembre de 2026. Fuente de la estrategia: reunión estratégica del 20 de noviembre de 2026 y `cycloidtalent/docs/SEO_OBJETIVO.md` (EnterpriseSST es el servicio 3 de Cycloid Talent). Todo lo que este documento afirma sobre el software se verificó en el código de `C:\xampp\htdocs\enterprisesst` en esa fecha (sección 15).

---

## 1. Decisión y alcance

- EnterpriseSST tendrá marca propia, separada de Cycloid Talent:
  - Sitio web: `enterprisesst.cycloidtalent.com`. El dominio se crea en aaPanel cuando el sitio esté listo.
  - Redes sociales: Facebook, Instagram, LinkedIn, YouTube y TikTok, administradas con la cuenta `enterprisesst.oficial@gmail.com`.
- El aplicativo sigue en `dashboard.cycloidtalent.com`. Este sitio no lo reemplaza: lo vende y lleva a la demo.
- Proyecto local: `C:\xampp\htdocs\enterprisesstsite` (CodeIgniter 4.7.6, creado con `composer create-project codeigniter4/appstarter`). Sin repositorio de GitHub por ahora.

---

## 2. A quién se le vende

| Comprador | Situación típica | Qué busca |
| --- | --- | --- |
| **Consultor SST independiente** | Lleva el SG-SST de varias empresas pequeñas con Word, Excel y carpetas | Ahorrar horas, verse más profesional, atender más clientes sin contratar |
| **Firma consultora SST** | Tiene varios consultores y decenas de clientes; necesita controlar el avance de cada uno | Un solo lugar para todo el equipo, control del trabajo de cada consultor, evidencias listas para auditoría |
| **Empresa con área SST propia** (decisión del 21 de noviembre de 2026) | Su responsable SST lleva el sistema de la propia empresa, a veces de varias sedes | Organizar documentos, evidencias, inspecciones y comités sin depender de Excel; estar lista para auditorías y visitas |

Las tres son compradoras de EnterpriseSST. Cuando quien gestiona es un consultor, sus clientes usan el portal pero no pagan: quien arrienda es la firma.

**Empresa con área SST propia:** técnicamente se crea como un espacio propio cuyo único cliente es la misma empresa, y paga la tarifa que le corresponde por su tamaño (sección 5). Hay que tenerlo presente en los textos: a esta empresa no se le habla de "tus clientes", sino de "tu empresa" y "tus sedes". Ojo con no competir con la consultoría SST de Cycloid Talent (servicio 1): el software es para la empresa que ya tiene quién ejecute el SG-SST; la consultoría, para la que necesita que alguien lo ejecute.

---

## 3. Problemas que resuelve (el porqué de la compra)

1. **Documentos repetitivos.** Cada cliente necesita políticas, programas, procedimientos y actas con su propio logo, código y versión. EnterpriseSST los redacta con IA a partir del contexto de cada cliente; el consultor revisa y aprueba.
2. **Evidencias dispersas.** Actas, fotos, firmas e inspecciones quedan en un solo lugar, organizadas por cliente y por estándar.
3. **Firmas en papel.** Cada documento se firma por correo, con verificación pública.
4. **Inspecciones en papel.** Se hacen desde el celular, en una aplicación que se instala en el teléfono.
5. **Seguimiento del cliente.** El cliente consulta su avance en su propio portal, sin pedir informes por correo.
6. **Control del equipo (firmas consultoras).** El administrador ve todos sus clientes y consultores; cada firma trabaja aislada de las demás.

---

## 4. Qué hace EnterpriseSST (solo funciones verificadas en el código)

| Grupo | Funciones |
| --- | --- |
| **Documentos SG-SST con IA** | 75 tipos de documento: política SST y políticas complementarias (acoso laboral y sexual, alcohol y drogas, desconexión laboral, violencias de género, discriminación, emergencias…), programas (capacitación, inducción, inspecciones, mantenimiento, estilos de vida, residuos, evaluaciones médicas…), procedimientos (control documental, investigación de accidentes e incidentes, gestión del cambio, adquisiciones, proveedores, matriz legal, auditoría, rendición de cuentas…), plan de trabajo anual, plan de objetivos y metas, plan de emergencias, PVE de riesgo psicosocial y biomecánico, reglamento de higiene y seguridad, manual de convivencia, informe de revisión por la dirección, registro estadístico ATEL. Cada documento sale con el logo, la razón social, el código y la versión del cliente, con control de versiones y exportación a PDF y Word. |
| **Comités** | Actas de constitución y recomposición de COPASST, COCOLAB, brigada y vigía; informes trimestrales y anuales; procesos electorales con votación electrónica e importación de votantes; actas de reunión con compromisos y firma. |
| **Diagnóstico y planeación** | Evaluación de estándares mínimos (Decreto 1072 y Resolución 0312) con historial de puntajes; plan de trabajo anual por ciclo PHVA; presupuesto SST; matriz legal; matriz de comunicación; contexto SST del cliente. |
| **Peligros y salud** | Matriz IPEVR (GTC 45) con sugerencias de IA y exportación a Excel y PDF; matriz de EPP y entrega de dotación; profesiograma; perfiles de cargo y diccionario de competencias; exámenes ocupacionales; encuesta sociodemográfica; evaluación ergonómica de trabajo en casa; pausas activas. |
| **Inspecciones** | Locativa, extintores, botiquín, señalización, EPP, gabinetes, recursos de seguridad, hoja de vida de brigadistas, preparación y evaluación de simulacros; desde el celular, con fotos. |
| **Seguimiento y evidencias** | Actas de visita, actas y listas de asistencia de capacitación, cronograma de capacitación, inducción por etapas, investigación de accidentes con análisis causal, declaración del trabajador accidentado, acciones correctivas, mantenimientos, vencimientos, pendientes, registro de evidencias. |
| **Indicadores** | 17 indicadores SST (frecuencia, severidad, ausentismo, cobertura, entre otros) e informe de avances. |
| **Firma electrónica** | Firma por enlace personal enviado al correo; huella SHA-256 del documento y página pública de verificación. |
| **Celular** | Aplicaciones instalables para inspecciones, miembros de comité, IPEVR e ingreso. |
| **Importación** | Desde CSV o Excel: maestros del cliente (procesos, cargos, sedes…), matriz legal, matriz de comunicación, votantes de comités, evaluaciones, ergonomía. |
| **Portal del cliente** | El cliente consulta en solo lectura su plan de trabajo, documentos, indicadores y matrices. |
| **Otto (asistente con IA)** | Responde preguntas sobre la información del SG-SST de cada cliente. |

**Regla:** no publicar ninguna función que no esté en esta tabla sin verificarla antes en el código. Si el aplicativo agrega o retira un módulo, se actualiza esta sección en el mismo cambio.

---

## 5. Cómo funciona el arriendo

### Espacio propio por firma consultora
- Cada firma recibe un espacio aislado con su administrador, sus consultores y sus clientes. Ninguna otra firma ve su información.
- Cycloid Talent entra como superadministrador solo para dar soporte, con un modo que registra cada acceso.
- **Alta:** Cycloid crea la firma con su primer administrador → el sistema envía un correo de bienvenida con las credenciales y una guía de primeros pasos → la firma crea sus consultores y sus clientes.

### Cobro
Se cobra **una mensualidad por cada empresa cliente activa** en el mes, según los estándares mínimos que le aplican y su número de trabajadores (tabla `tbl_suscripcion_tarifa`, editable sin tocar el código):

| Estándares | Trabajadores | Mensual por empresa cliente |
| --- | --- | --- |
| 7 | 1 a 10 | $100.000 |
| 21 | 1 a 50 | $200.000 |
| 60 | 1 a 10 | $120.000 |
| 60 | 11 a 30 | $200.000 |
| 60 | 31 a 50 | $250.000 |
| 60 | 51 o más | $400.000 |

(Si la clasificación del cliente está desactualizada, se cobra según su tamaño real; ver `enterprisesst/docs/SUSCRIPCIONES_TENANT/01_DISENO.md`.)

- La orden de cobro se genera el día 1 y se envía por correo; plazo de pago hasta el día 10.
- Pago por transferencia a la llave Bre-B de Cycloid Talent; el comprobante se sube en la plataforma o se envía por correo.
- Si no paga, el día 11 se bloquea **solo al personal de la firma**. Sus clientes, comités e inspectores siguen trabajando sin ver ningún aviso.
- Hay descuentos configurables por firma (por ejemplo, por antigüedad).
- **No se cobra por consultor ni por usuario.**

**Decisión del 21 de noviembre de 2026: las tarifas se publican** en el sitio, con la tabla de arriba. **Sin ejemplos de cálculo** (decisión del usuario del 22 de noviembre de 2026); en su lugar: "Sin cláusulas de permanencia ni paquetes rígidos: activas o desactivas empresas según el movimiento real de tu cartera." Antes de publicar, confirmar que la tabla de producción (`tbl_suscripcion_tarifa`) sigue igual.

---

## 6. Lo que todavía no se puede prometer

| Tema | Situación real | Cómo comunicarlo |
| --- | --- | --- |
| Marca propia de la firma | Los documentos salen con el logo de cada cliente y los correos llevan el nombre "EnterpriseSST". El nombre de la firma aparece en su panel. Pero el remitente técnico de los correos es de cycloidtalent.com y las vistas tienen 236 enlaces a cycloidtalent.com (revisado el 21 de noviembre de 2026) | **Decisión del 21 de noviembre de 2026: el sitio sí promete "usa la plataforma con la marca de tu firma".** Codex la termina en el aplicativo con el prompt `enterprisesst/docs/PROMPT_MARCA_BLANCA_TENANT.md`. El sitio se construye **como si la marca blanca ya existiera** (Codex la termina el 21 de noviembre de 2026). Antes de poner el sitio en línea, confirmar que el cambio está desplegado. |
| La IA | Redacta borradores; el consultor revisa, ajusta y aprueba | "La IA te ahorra la redacción; tú pones el criterio profesional" |
| Licencia SST | El software es una herramienta; diseñar y ejecutar el SG-SST exige que el profesional cumpla los requisitos de formación y licencia | Decirlo en las preguntas frecuentes |
| Precio | Por empresa cliente activa, no por consultores | Corregir la página de Cycloid, que hoy dice "según el número de clientes y consultores" |

---

## 7. Mensaje y lenguaje

- **Público profesional:** se habla de productividad y control, no de cumplimiento normativo general.
- **Frase central (propuesta):** "Gestiona el SG-SST de todos tus clientes en una sola plataforma."
- Apoyos: "Documentos con el logo de cada cliente, redactados con IA y aprobados por ti", "Inspecciones desde el celular", "Firma electrónica con verificación", "Tus clientes consultan su avance sin pedirte informes", "Pagas solo por los clientes activos".
- **Sin "desde $100.000" ni cifras sueltas fuera de la página de precios** (decisión del usuario del 22 de noviembre de 2026: la cifra suelta espanta). El precio se comunica como valor: "Pagas solo por las empresas que gestionas", "Una mensualidad por empresa, según su tamaño", "Sin cláusulas de permanencia". La tabla completa sigue publicada en `/precios`. Tampoco va precio en los datos estructurados ni en las descriptions.
- Español claro para Colombia, sin anglicismos (decir "panel", no "dashboard"; "arriendo", no "SaaS"). Usar "consultores" y "psicólogos" en masculino genérico.
- **Prueba social (21 de noviembre de 2026):** la plataforma la usa Cycloid Talent con sus propios clientes y **dos profesionales SST ya pagan el arriendo** (confirmado por el usuario; coincide con las órdenes de cobro de octubre de 2026). Se puede publicar "profesionales SST que ya arriendan la plataforma". Sus nombres o testimonios solo con autorización escrita de cada uno.

---

## 7A. Identidad visual y persona de contacto

**Logo:** símbolo de circuito hexagonal en dorado, palabra ENTERPRISESST en azul oscuro con letras espaciadas y lema **"Sistemas que evolucionan"** en dorado.
- Original: `public/assets/img/marca/logo-enterprisesst-lema-original.png` (5100 × 3300, fondo blanco; copiado de `D:\Descargas\logoenterprisesstblancoslogan (1).png`). En la fase 3 se generan versiones livianas (WebP y PNG en varios tamaños), una versión para fondo oscuro, el ícono suelto para favicon y aplicación instalable, e imágenes para redes (Open Graph).

**Colores oficiales:**

| Uso | Color | HEX | RGB | CMYK |
| --- | --- | --- | --- | --- |
| Azul oscuro (principal, textos y fondos) | Azul noche | `#1c2437` | 28, 36, 55 | 94, 80, 48, 60 |
| Dorado (acento, símbolo, botones) | Dorado | `#bd9751` | 189, 151, 81 | 24, 36, 73, 11 |
| Blanco | Blanco | `#ffffff` | 255, 255, 255 | 0, 0, 0, 0 |

El símbolo se usa en dorado sobre azul, en blanco sobre dorado y en azul sobre blanco. Revisar el contraste del texto dorado sobre blanco (es bajo para textos pequeños): en párrafos y botones usar texto azul o blanco, y el dorado para fondos de botón, íconos y títulos grandes.

**Lema:** "Sistemas que evolucionan" acompaña la frase central de la sección 7.

**Persona de contacto (decisión del 21 de noviembre de 2026):** todo el sitio usa los datos de **Diana Cuestas, Directora Comercial**, que atiende las demos.

**Autor de los artículos del blog: Cycloid Talent** (la empresa), no una persona. En los datos estructurados, el autor de cada artículo es la organización Cycloid Talent.
- Correo: diana.cuestas@cycloidtalent.com
- WhatsApp y teléfono: +57 311 7919191
- LinkedIn: https://www.linkedin.com/in/diana-patricia-cuestas-183024399/
- Foto: la de `cycloidtalent/public/assets/img/team/diana-cuestas.webp`
- Los datos están tomados del sitio de Cycloid Talent; si cambian allá, se cambian aquí en el mismo momento.

---

## 8. Páginas del sitio (fase 3)

| Página | Papel en la venta | Llamada a la acción |
| --- | --- | --- |
| **Inicio** | Gana las búsquedas de marca y "software SG-SST"; explica en segundos qué es, para quién es y cuánto cuesta | Pedir demo |
| **Funciones** (o una página por grupo grande: documentos con IA, inspecciones desde el celular, comités y votación, firma electrónica) | Gana búsquedas específicas ("software matriz IPEVR", "votación electrónica COPASST") | Pedir demo |
| **Precios** | Responde "cuánto cuesta" con la tabla de la sección 5 | Pedir demo |
| **Cómo funciona el arriendo** | Espacio propio, alta, soporte, aislamiento, cobro y bloqueo | Pedir demo |
| **Para firmas consultoras**, **Para consultores independientes** y **Para empresas con área SST** | Un mensaje por comprador | Pedir demo |
| **Preguntas frecuentes** | Dudas previas a la compra (IA, licencia, aislamiento, migración desde Excel, pago) | Pedir demo |
| **Pedir demo** | Formulario corto: nombre, correo, celular, firma, número de clientes | Enviar |
| **Ingresar** | Enlace a `dashboard.cycloidtalent.com` para quien ya es cliente | — |
| Política de privacidad y términos | Obligatorias por recoger datos | — |
| Guías y blog (fase 5) | Dudas del consultor ("cómo organizar las evidencias de la 0312") que enlazan a una página que vende | Pedir demo |

---

## 9. Búsquedas que debe ganar

Ejemplos de intención de compra, sin cifras de volumen todavía:

- "software SG-SST", "software SG-SST para consultores", "plataforma SG-SST", "programa para gestionar el SG-SST de varios clientes"
- "precio software SG-SST", "arriendo software SST"
- "software estándares mínimos 0312", "software matriz IPEVR", "votación electrónica COPASST", "inspecciones SST desde el celular", "firma electrónica actas SST"

**Choque que hay que resolver antes de publicar:** hoy `cycloidtalent.com/servicios/software-sg-sst` compite por estas mismas búsquedas. Regla del ecosistema: una sola página dueña por búsqueda. **Recomendación:** cuando el sitio nuevo esté en línea, el sitio nuevo es el dueño y la página de Cycloid resume el servicio y enlaza aquí (como ya se hace con el software PsyRisk). Hay que actualizar `SEO_OBJETIVO.md` en ese momento.

---

## 10. Medición

- **Métrica principal:** solicitudes de demo, y arriendos cerrados.
- **Search Console:** la propiedad de dominio `sc-domain:cycloidtalent.com` ya cubre `enterprisesst.cycloidtalent.com`; la carga diaria (`psyrisksite/tools/seo_gsc_import.php`) traerá sus datos sin configuración extra. Agregar las páginas del sitio al informe `psyrisksite/tools/seo_ventas.php`.
- **Solicitudes (decisión del 21 de noviembre de 2026):** todas van al formulario de Cycloid Talent, `cycloidtalent.com/contacto?servicio=Plataforma EnterpriseSST`, que ya guarda servicio, origen, UTM y "cómo nos conoció" y le llega a Diana. Cada botón del sitio lleva `utm_source=enterprisesst` y su propio `utm_campaign`. El sitio no tiene formulario propio.
- **Redes sociales:** cada enlace desde una red lleva `utm_source` (facebook, instagram, linkedin, youtube, tiktok) y `utm_campaign` con el tema de la publicación.
- **Gestión:** cada solicitud se marca en el panel de contactos (contactado, demo realizada, cotización enviada, ganado, perdido).
- **Sin prueba gratis (decisión del 21 de noviembre de 2026):** la venta pasa siempre por una **demo guiada**, porque la puesta en marcha (cargar el contexto, los cargos, los peligros y la información de cada cliente) exige mucho esfuerzo al inicio y una prueba sin acompañamiento dejaría una mala impresión. El sitio no ofrece registro ni prueba: todos los botones llevan a pedir la demo. En los textos, presentar ese acompañamiento como un beneficio ("te acompañamos en la puesta en marcha").

---

## 11. Redes sociales

| Red | Para qué sirve aquí | Contenido |
| --- | --- | --- |
| **LinkedIn** | Llegar a firmas consultoras y profesionales SST | Casos de uso, novedades normativas con la función que las resuelve, anuncios de nuevas funciones |
| **YouTube** | Demos completas y tutoriales; segundo buscador | "Cómo generar la política SST en 2 minutos", "Inspección de extintores desde el celular", demos en vivo |
| **TikTok e Instagram** | Alcance entre consultores jóvenes e independientes | Videos cortos de una función: antes (Excel y papel) y después (EnterpriseSST) |
| **Facebook** | Grupos de profesionales SST y anuncios pagados | Las mismas piezas, con enlace a la demo |

Ya hay antecedente de demos en vivo en TikTok y YouTube con un cliente de prueba (`enterprisesst/docs/CLEANUP_LIVE_DEMO.md`). Para las demos públicas conviene una empresa de demostración fija y limpia, en lugar de crear y borrar datos en producción en cada transmisión.

---

## 12. Lo que se hereda de psyrisksite (aprendizajes ya probados)

El sitio nuevo no parte de cero: reutiliza lo que ya funciona en `C:\xampp\htdocs\psyrisksite`, adaptado a EnterpriseSST.

**Qué significa "heredar":** se **copian** archivos seleccionados de psyrisksite al proyecto `enterprisesstsite` y se adaptan (textos, diseño, nombres, base de datos). **No se clona** el repositorio completo y **psyrisksite no se modifica**: es solo de lectura para este trabajo. Cada sitio tiene su propia carpeta, su propia base de datos y, más adelante, su propio repositorio. Un cambio en uno no afecta al otro.

### Base de datos propia
- Base `enterprisesstsite` en local (XAMPP) y en producción (servidor DigitalOcean, mismo grupo de conexiones que `psyrisksite`).
- Tablas creadas con migraciones de CodeIgniter **idempotentes** (lección del 2 de noviembre de 2026), aplicadas siempre con un script PHP CLI del repositorio: primero en local y, solo si termina bien, en producción (regla de `D:\DESARROLLO\KEYS\sql.txt`). Nunca SQL manual.
- Conexión `production` en el `.env` local para correr los scripts contra producción desde el equipo (en el servidor de PsyRisk el grupo `production` no existe; ver la memoria del proyecto).
- **Estado al 21 de noviembre de 2026: base local creada y migrada.** Base `enterprisesstsite` en XAMPP con las tablas `roles`, `usuarios`, `password_resets`, `blog_posts` y `blog_visitas_snapshots` (misma estructura que en psyrisksite), más el rol `admin` (`php spark db:seed RolesSeeder`). Las 5 migraciones están en `app/Database/Migrations/2026-11-21-*` y usan `IF NOT EXISTS`: se comprobó que una segunda corrida no hace nada.
- **Producción (nivelada el 22 de noviembre de 2026):** las 6 tablas existen en la base `enterprisesstsite` de DigitalOcean. **No usar `php spark migrate -g production`**: en CodeIgniter 4.7 ese `-g` no cambia la conexión y corre contra la base local (pasó el 22 de noviembre; se corrigió con `tools/limpiar_migraciones_falsas_local.php`). Antes: cuando exista la base en el servidor, poner sus credenciales en el grupo `production` del `.env` local (ya está la plantilla comentada) y correr desde este equipo `php spark db:migrate-production` y luego `php spark db:seed RolesSeeder` contra ese grupo. Sin SQL manual.

### Blog (el componente más importante para el SEO)
| Pieza | En psyrisksite | Para qué sirve |
| --- | --- | --- |
| Blog público | `app/Controllers/Blog.php`, `app/Models/BlogPostModel.php` | Artículos con slug, imagen, extracto, metadatos propios, `noindex` opcional y datos estructurados de artículo |
| Constructor del blog (panel) | `app/Controllers/Admin/Blog.php`, `app/Views/pages/admin/blog/form.php` | Crear y editar artículos con editor visual |
| Metadatos sin cortes | Reglas `REGLAS`/`MENSAJES` en `Admin/Blog.php`, contador en vivo `data-limite` | El título SEO (70) y la description (160) se validan con mensaje en español, nunca se recortan en silencio |
| Encabezados limpios | `blog_limpiar_encabezados()` en `app/Helpers/seo_helper.php` | Elimina encabezados vacíos que deja el editor |
| Description automática | `blog_resumir()` | Si no hay description, la arma desde el extracto cortando en palabra completa |
| Aviso de artículos parecidos | `blog_similitud()`, `blog_articulos_similares()`, `BlogPostModel::getSimilares()` (umbral 0,12) | Al publicar, avisa si el artículo repite a otro; evita contenido duplicado |
| Contador de visitas | `migrate_blog_visitas.php` | Visitas por artículo |
| **Snapshots semanales de visitas** | `app/Commands/SnapshotBlogVisitas.php` (`php spark blog:snapshot-visitas`), `BlogVisitasSnapshotModel`, `tools/migrate_blog_snapshots.php`, vista `admin/blog/estadisticas.php` | Foto semanal de las visitas para ver la tendencia de cada artículo; cron de los viernes a las 8:00 (`docs/SETUP_PRODUCCION.md` de psyrisksite) |
| Regla de enlace | `SEO_OBJETIVO.md` y la brújula de PsyRisk | Cada artículo enlaza a una página que vende; si no, está incompleto |
| Comunicado para quien escribe | Documento "Comunicado: publicación del blog en PsyRisk" | Reglas para la persona que redacta: dónde publicar, límites de metadatos, enlaces |

### SEO técnico
- `app/Filters/SeoIndexing.php`: `noindex, nofollow` (metadato y encabezado `X-Robots-Tag`) en páginas operativas (ingreso, gracias, recuperar contraseña, fuera de línea).
- `app/Controllers/PageNotFound.php`: 404 real con `noindex`.
- `app/Controllers/Sitemap.php`: sitemap dinámico que excluye artículos con `noindex` y no inventa fechas.
- `app/Helpers/seo_helper.php`: canonical estable, Open Graph con formato y medidas reales de la imagen (`tools/generate_og_images.php`), datos estructurados `Organization`, `SoftwareApplication`, `FAQPage`, `BreadcrumbList`, `BlogPosting`.
- **Lección del 23 de octubre de 2026:** una vista parcial de JSON-LD que recibe `description` reemplaza la description del controlador en el `<head>`. En el sitio nuevo, el JSON-LD toma la description del controlador; no se pasa otra.
- Preguntas frecuentes visibles y de JSON-LD generadas desde **la misma lista** (en PsyRisk varias páginas quedaron con diferencias).
- `public/robots.txt` con el sitemap y `public/llms.txt` con exactamente lo que vende el sitio. Recordar que Cloudflare agrega bloqueos a bots de IA en el `robots.txt` publicado (decisión del panel de Cloudflare).
- Pruebas automáticas de SEO como `tests/feature/SeoTest.php`: título, description, canonical, un solo H1, `noindex` donde corresponde, 404 real, sitemap.

### Seguridad
- CSRF global con `$expires = 0` y `$regenerate = false` (no se pierde un artículo largo al guardar), y redirección amable si el token falla.
- Acciones del panel solo por POST con `csrf_field()`.
- Panel con usuarios, roles y recuperación de contraseña (`AuthFilter`, `UserModel`, `RoleModel`, `PasswordResetModel`).
- Archivos privados fuera de `public/` (lección del aplicativo de gestión: los documentos subidos quedaron en Google).
- Credenciales solo en `.env`; nunca en Git ni en documentos (`.env` fuera del repositorio desde el primer commit).

### Captación y medición
- `app/Filters/UtmFirstTouch.php`: guarda los UTM de la primera visita en una cookie de 90 días para atribuir la solicitud aunque el visitante navegue por varias páginas.
- `app/Helpers/marketing_helper.php` (`contact_url()`): cada botón de demo lleva su `utm_campaign`.
- Solicitudes con servicio, origen, UTM y "cómo nos conoció", y estados de gestión (nuevo, contactado, cotización enviada, ganado, perdido).
- Correo: campañas, importación de contactos por CSV, lista negra de correos rebotados, baja de suscripción y recordatorio semanal (`Admin/Campanas.php`, `EmailService`, `CsvContactImporter`, comandos `email:*`). Para la fase 5.
- Search Console: la carga diaria y el informe `seo_ventas.php` ya cubren el subdominio.

### Otros
- Página de licencia SST y logos de clientes como prueba social (con autorización).
- Aplicación instalable básica (`manifest.webmanifest`, `sw.js`) y página fuera de línea con `noindex`.
- Flujo de despliegue `cycloid → main` y `git pull` en el servidor.

## 13. Fases

| Fase | Contenido | Estado |
| --- | --- | --- |
| 1 | Estudio del aplicativo, este documento y proyecto CodeIgniter 4 en blanco | Hecho el 21 de noviembre de 2026 |
| 2 | Decisiones (sección 14), identidad visual (sección 7A: logo y colores definidos; falta tipografía), textos de cada página | En curso: decisiones principales e identidad tomadas el 21 de noviembre de 2026 |
| 3 | **Hecho en local el 21 de noviembre de 2026 (sección 13A).** Base de datos propia (producción pendiente) y construcción de las páginas de la sección 8, con todo lo heredado de psyrisksite (sección 12): blog con constructor, snapshots de visitas, SEO técnico, seguridad, captación con UTM y pruebas | Pendiente |
| 4 | Puesta en línea: dominio y SSL en aaPanel, repositorio de GitHub, despliegue con el flujo `cycloid → main`, solicitud de indexación | Pendiente |
| 5 | Medición semanal, guías y blog, contenido para redes, resolver el choque con la página de Cycloid | Pendiente |

---

## 13A. Estado de la construcción (21 de noviembre de 2026)

**Sitio construido en local:** http://localhost/enterprisesstsite/public/

| Parte | Qué hay |
| --- | --- |
| Páginas que venden | Inicio (hero con "EnterpriseSST es una marca de Cycloid Talent"), Funciones, Precios (tarifas publicadas desde `app/Config/Sitio.php`), Cómo funciona el arriendo, Para firmas consultoras, Para consultores independientes, Para empresas con área SST, Preguntas frecuentes |
| Legal | Política de privacidad y Términos de uso |
| Blog | Listado y artículo, con contador de visitas por sesión, autor Cycloid Talent en los datos estructurados |
| Panel (`/admin`) | Ingreso, recuperación de contraseña por SendGrid, usuarios, constructor del blog (metadatos validados con contador, limpieza de encabezados vacíos, aviso de artículos parecidos), evolución semanal de visitas con snapshots |
| SEO técnico | Títulos ≤ 70 y descriptions ≤ 160, canonical, Open Graph con medidas reales, JSON-LD `Organization` (Cycloid Talent con la marca EnterpriseSST), `WebSite`, `SoftwareApplication` con las tarifas, `FAQPage` desde la misma lista que el texto visible, `BreadcrumbList`, `Article`; sitemap dinámico; `robots.txt`; `llms.txt`; `noindex` en ingreso y panel; 404 real |
| Captación | Todos los botones "Pedir demo" van a `cycloidtalent.com/contacto?servicio=Plataforma EnterpriseSST` con `utm_source=enterprisesst` y una campaña por botón; UTM de la primera visita guardados 90 días; WhatsApp flotante con Diana |
| Seguridad | CSRF global (sin vencimiento ni regeneración), acciones del panel por POST, rutas sin enrutamiento automático |
| Marca | Logo, ícono, favicon, versión para fondo oscuro e imagen para redes generados con `php tools/generar_marca.php` |
| Pruebas | `php -d extension=sqlite3 vendor/bin/phpunit -c phpunit.dist.xml --no-coverage`: 34 pruebas en verde |

**Calidad técnica (22 de noviembre de 2026, con Modern Web Guidance de Google y Lighthouse en celular, modo producción):**

| Página | Antes | Después |
| --- | --- | --- |
| Inicio | Rendimiento 91 · Accesibilidad 94 · contenido principal 2,8 s | Rendimiento 99 · Accesibilidad 100 · 1,9 s |
| Precios | 90 · 94 · 2,9 s | 97 · 100 · 1,8 s |
| Funciones / Blog | — | 99 · 100 · 1,7 s |

Buenas prácticas y SEO en 100. Cambios:
- Fuentes Inter y Montserrat alojadas en el sitio y precargadas (`public/assets/fonts/`); Google Fonts bloqueaba unos 850 ms.
- `font-size-adjust` para que el texto no salte mientras carga la fuente.
- Imagen principal con `fetchpriority="high"` e imágenes del tamaño justo (`php tools/generar_marca.php`).
- Precarga de la página siguiente con Speculation Rules (`prefetch`, `moderate`), excluidos el panel, el ingreso, los enlaces externos y los que llevan `nofollow`. El contador del blog ignora esas precargas (`Sec-Purpose: prefetch`).
- Contraste AA del dorado sobre crema, blanco y azul; orden de títulos del pie; nombre accesible del logo; enlace "Saltar al contenido".
- Seguridad: política de contenido (CSP) con nonce y sin scripts en línea ni atributos `on…` (`app/Config/ContentSecurityPolicy.php` y `public/assets/js/enterprisesst.js`), y encabezados en `app/Filters/EncabezadosSeguridad.php`. `Referrer-Policy: strict-origin-when-cross-origin` para que el formulario de Cycloid siga sabiendo de dónde viene la solicitud. No se usa `Cross-Origin-Opener-Policy`: rompe las mediciones de Lighthouse y PageSpeed Insights.
- Panel: editor Quill alojado en el sitio (sin CDN) y el botón para ver la contraseña, que no funcionaba porque dependía de un script de psyrisksite.
- `public/.htaccess`: compresión y caché larga de archivos estáticos. **Verificar en el servidor al publicar** (el XAMPP local no tiene `mod_expires`).

**Contenido y verificación:** los textos sobre el software salen de `app/Libraries/Contenido.php` y solo usan funciones de la sección 4. La marca propia de la firma se presenta como existente (decisión del 21 de noviembre de 2026); antes de poner el sitio en línea, confirmar que Codex desplegó la marca blanca en el aplicativo.

**Panel local:** usuario `admin@enterprisesst.local`, creado con `php spark admin:crear`. La contraseña local quedó en la sesión de trabajo de Claude, no en el repositorio; para cambiarla: `php spark admin:crear admin@enterprisesst.local "Administrador local"`.

**Comandos útiles**
- `php spark admin:crear correo "Nombre"`: crea o reactiva un administrador.
- `php spark blog:snapshot-visitas`: toma el snapshot semanal (cron de los viernes a las 8:00 en producción).
- `php tools/generar_marca.php`: regenera las versiones del logo.
- `php tools/limpiar_blog_local.php --confirmar`: vacía el blog de la base local después de pruebas.

**Producción (22 de noviembre de 2026): sitio en línea en https://enterprisesst.cycloidtalent.com**
- Repositorio: https://github.com/edielestudiante2023/enterprisesstsite (ramas `main`, que sirve el servidor, y `cycloid`, de trabajo).
- Servidor: carpeta **`/www/wwwroot/enterprisesst`** (así la creó aaPanel), raíz web `public/`, Apache. Git ignora los permisos (`core.fileMode false`) y los archivos de aaPanel (`.git/info/exclude`).
- `.env` del servidor (root:www, 640): `CI_ENVIRONMENT = production`, base de DigitalOcean como grupo `default` y SendGrid de la misma cuenta de psyrisksite, con remitente "EnterpriseSST".
- Base `enterprisesstsite` (DigitalOcean) nivelada con `php spark db:migrate-production` desde el equipo local, y rol `admin` creado.
- Tarea programada: `0 8 * * 5 cd /www/wwwroot/enterprisesst && php spark blog:snapshot-visitas` (respaldo del crontab: `/root/crontab.bak-20261122`).
- Verificado en vivo: todas las páginas, 404 real, `.env` bloqueado (403), compresión gzip, caché de un año en CSS, JS y fuentes, CSP, HSTS y demás encabezados.
- Despliegue: `cycloid` → `main` → `git push origin main` → en el servidor `cd /www/wwwroot/enterprisesst && git pull origin main`.

**Pendiente (fase 4)**
1. Confirmar que la marca blanca de Codex está desplegada en el aplicativo.
2. Crear la base `enterprisesstsite` en el servidor de bases de datos, poner sus credenciales en el grupo `production` del `.env` local y correr `php spark db:migrate-production` y el seeder de roles.
3. Crear el dominio y el SSL en aaPanel; repositorio de GitHub y flujo `cycloid → main`.
4. `.env` del servidor: `CI_ENVIRONMENT = production`, `app.baseURL = 'https://enterprisesst.cycloidtalent.com/'`, base de datos, y para recuperar contraseñas `email.fromEmail`, `email.fromName` y `email.SMTPPass` (SendGrid).
5. Crear el administrador real con `php spark admin:crear` y la tarea programada del snapshot.
6. Agregar las páginas al informe `psyrisksite/tools/seo_ventas.php` y pedir indexación en Search Console.
7. Revisar las tarifas contra `tbl_suscripcion_tarifa` de producción.

---

## 14. Decisiones

**Tomadas el 21 de noviembre de 2026:**
1. Las tarifas se publican.
2. Las solicitudes de demo llegan al formulario de Cycloid Talent.
3. Diana Cuestas atiende las demos; el sitio usa siempre sus datos de contacto.
4. Logo con el lema "Sistemas que evolucionan" y colores `#1c2437`, `#bd9751` y `#ffffff` (sección 7A).
5. También se vende a empresas con área SST propia (sección 2).
6. Sin prueba gratis: solo demo guiada, porque la puesta en marcha exige mucho esfuerzo inicial (sección 10).
7. Los artículos del blog los firma Cycloid Talent.
8. El sitio promete la marca propia de la firma y se construye como si ya existiera; Codex la termina en el aplicativo (sección 6).
9. Prueba social disponible: Cycloid Talent la usa con sus clientes y dos profesionales SST ya pagan el arriendo.

**Pendientes:**
1. **Prueba social.** Ya se sabe que dos profesionales SST pagan el arriendo (sección 7). Falta: pedirles un testimonio con autorización escrita y decidir si se calculan cifras agregadas. Propuesta original: (a) calcular, con una consulta de solo lectura a la base del aplicativo, cifras reales y agregadas (empresas gestionadas, documentos generados, inspecciones registradas, firmas electrónicas) y publicarlas solo si el usuario las aprueba; (b) pedir a una o dos firmas que ya arriendan (por ejemplo GESSEG) un testimonio con autorización escrita; (c) mientras tanto, usar solo lo verificable: "la plataforma que Cycloid Talent usa con sus propios clientes".
2. ¿Quién redacta en la práctica los artículos? Recibirá un comunicado con las reglas, como en PsyRisk.

---

## 15. Fuentes en el código (verificadas el 21 de noviembre de 2026)

| Tema | Dónde |
| --- | --- |
| Módulos y stack | `enterprisesst/README.md`, `app/Config/Routes.php` (2.955 líneas, más de 70 grupos de rutas) |
| Tipos de documento con IA | `enterprisesst/app/Libraries/DocumentosSSTTypes/` (75 archivos) |
| Espacio por firma consultora | `enterprisesst/docs/MULTI_TENANT_EMPRESA_CONSULTORA/03_ESTADO_FINAL.md`, `app/Libraries/TenantFilter.php`, `app/Models/Traits/TenantScopedModel.php` |
| Cobro y bloqueo | `enterprisesst/docs/SUSCRIPCIONES_TENANT/01_DISENO.md`, `app/Libraries/Suscripciones/`, `app/Filters/CarteraTenantFilter.php` |
| Firma electrónica | `enterprisesst/app/Controllers/FirmaElectronicaController.php` (SHA-256), ruta `/firma/verificar/(:any)` |
| Aplicaciones para el celular | `enterprisesst/public/manifest_inspecciones.json`, `manifest_miembro.json`, `manifest_ipevr.json`, `manifest_login.json` |
| Portal del cliente | `enterprisesst/docs/PORTAL_CLIENTE_SOLO_LECTURA.md` |
| Otto | `enterprisesst/docs/OTTO_PLAN_MAESTRO.md`, rutas `agente-chat/*` |
| Página actual de venta en Cycloid | `cycloidtalent/app/Controllers/ServiciosController.php::softwareSgSst` |
