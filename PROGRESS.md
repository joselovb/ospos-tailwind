## 2026-06-20 - Vista: PASO 0 (Exploración inicial)
- Archivos: ninguno modificado, solo lectura. Creados: CLAUDE.md, PROGRESS.md, BACKLOG.md
- Estado: completo
- Notas:
  - El repo es **CodeIgniter 4**, no CI3. Las reglas duras del prompt original mencionaban
    `application/controllers`, `application/models`, `application/config/database.php` —
    se adaptaron a las rutas reales: `app/Controllers`, `app/Models`, `app/Config/Database.php`.
    Confirmado y documentado en CLAUDE.md.
  - Estructura de vistas: `app/Views/<modulo>` (sales, items, customers, suppliers, reports,
    receivings, attributes, taxes, expenses, expenses_categories, barcodes, configs, cashups,
    people, employees, item_kits, giftcards, home, messages, errors) + `app/Views/partial`
    para includes compartidos.
  - Layout principal compartido: `app/Views/partial/header.php` (abre html/head/navbar) +
    `app/Views/partial/footer.php` (cierra contenedores, incluye el bloque de licencia
    obligatorio). Cada vista hace `view('partial/header')` ... `view('partial/footer')`.
  - `header_js.php` (incluido por header.php) contiene JS inline crítico: liveclock,
    wiring de CSRF para `$.ajax`/`$.fn.submit`, logout AJAX (`#logout`). Debe preservarse
    funcionalmente al rediseñar el header.
  - Assets actuales: Bootstrap 3.4.1 vía Bootswatch (tema seleccionable por config) +
    CSS propio en `public/css/*.css`. Pipeline de build: **Gulp** (`gulpfile.js`), que
    inyecta bloques `<!-- inject:debug:css/js -->` y `<!-- inject:prod:css/js -->`
    directamente dentro de `app/Views/partial/header.php` (y bloques propios en
    `app/Views/login.php`). Estos marcadores NO se deben romper.
  - No existía ningún archivo Tailwind/Alpine en el repo antes de este refactor.
  - Siguiente paso: setup de Tailwind v4 (input.css, tokens.css, theme-*.css) sin tocar
    el pipeline gulp existente, luego Fase 0 (layout/header/footer/componentes genéricos).

## 2026-06-20 - Vista: Setup Tailwind v4 + Alpine.js (Fase 0 - fundación)
- Archivos:
  - `tailwind/theme-default.css` (paleta cruda, Capa 1 - azul/índigo + dorado de acento)
  - `tailwind/tokens.css` (tokens semánticos, Capa 2 - brand-primary, state-danger, etc.)
  - `tailwind/input.css` (entry point que el Tailwind CLI compila)
  - `public/css/tailwind-build.css` (output compilado, generado por `tailwindcss -i
    tailwind/input.css -o public/css/tailwind-build.css`)
  - `app/Views/partial/header.php` (agregado `<link>` al CSS compilado + `<script>` de
    Alpine.js vía CDN, jsdelivr `alpinejs@3.x.x`, ambos justo después del bloque de
    gulp-inject sin tocar sus marcadores)
- Estado: completo
- Notas:
  - Arquitectura de 2 capas implementada exactamente como en CLAUDE.md: `theme-default.css`
    (hex crudos) -> `tokens.css` (semántico, `@import "tailwindcss"` + `@import
    "./theme-default.css"`) -> `input.css` (solo importa tokens.css, es el archivo que se
    pasa a `--input`).
  - Paleta default elegida: azul/índigo (`--palette-primary-*`) cercano al azul corporativo
    original de OSPOS, con dorado (`--palette-accent-*`) como acento premium para CTAs/cards
    destacadas. Esto es solo el theme "default" del fork - cambiar de negocio = duplicar
    `theme-default.css` con otro nombre y cambiar el import en `tokens.css`.
  - Comando de build/watch (lo corre el usuario en tmux, Claude no lo ejecuta):
    `tailwindcss -i tailwind/input.css -o public/css/tailwind-build.css --watch`
  - El `<link>` de Tailwind se agregó DESPUÉS del bloque `<?php endif; ?>` que cierra el
    if/else de gulp-inject (debug vs prod), para no romper esos marcadores y para que las
    clases de Tailwind puedan sobreescribir Bootstrap 3 durante la transición vista por
    vista (Bootstrap sigue siendo la base hasta que cada vista se migre).
  - Alpine.js se agregó vía CDN (jsdelivr) en el mismo punto, con `defer` - no genera
    ningún efecto hasta que las vistas usen `x-data`, así que es seguro tenerlo cargado
    globalmente desde ya.
  - El output compilado (`tailwind-build.css`) NO se agregó a `.gitignore` y se versiona
    en el repo: el pipeline Gulp existente no procesa archivos Tailwind, así que si no se
    versiona el CSS compilado, un deploy sin correr `tailwindcss` a mano se quedaría sin
    estilos. Esto es una decisión de infraestructura, no de diseño - anotada también en
    BACKLOG.md por si se prefiere otro enfoque (ej. build step en CI) más adelante.
  - LIMITACIÓN DE TESTING: no hay PHP ni un contenedor Docker corriendo en este entorno, así
    que no fue posible levantar la app y verificar visualmente que la página carga sin
    errores PHP. El cambio en `header.php` es una sola línea de HTML puro (un `<link>` y un
    `<script>`) sin tocar ninguna etiqueta `<?php ?>` existente ni los marcadores de
    gulp-inject - revisado manualmente y el diff es mínimo y seguro. Build de Tailwind
    verificado localmente (`tailwindcss -i ... -o ...` corrió sin errores y generó los
    tokens semánticos esperados en el CSS de salida).
  - Siguiente paso: Fase 0.1/0.2 - rediseño real de layout + header/nav con colapso mobile
    (Alpine `x-data`), usando los tokens ya definidos.

## 2026-06-20 - Vista: Setup ambiente de desarrollo local (LAMP nativo, sin Docker)
- Archivos de repo: ninguno commiteado en esta unidad (es infraestructura local, no una
  vista). `.env` creado localmente (gitignored, no se versiona). `app/Views/partial/header.php`
  y `app/Views/login.php` quedan con cambios locales sin commitear (ver nota abajo).
- Estado: completo - la app corre y se puede usar en el browser
- Notas:
  - A pedido explícito del usuario, NO se usó Docker. Se instaló un stack LAMP nativo en
    esta máquina: PHP 8.3 (fpm + cli, con todas las extensiones requeridas: mysqli, gd,
    bcmath, intl, mbstring, curl, xml, zip), MariaDB 10.11, Nginx 1.24, Composer.
  - Nginx escucha en **puerto 8090** (no 80/443, que ya estaban ocupados por un proxy
    Caddy preexistente en esta máquina) como reverse proxy + servidor de archivos
    estáticos, con PHP-FPM vía fastcgi para los `.php`. Config en
    `/etc/nginx/sites-available/ospos.conf` (fuera del repo, no versionado).
  - DB creada: `ospos`, usuario `admin`/`pointofsale` (coincide con los defaults de
    `.env.example`), igual que la configuración estándar de OSPOS.
  - Se corrió el build de assets requerido por `BUILD.md` (`composer install`,
    `npm install`, `npm run build` → gulp). Esto inyecta automáticamente los bloques
    `<!-- inject:debug/prod:css|js -->` dentro de `app/Views/partial/header.php` y
    `app/Views/login.php` con los `<link>`/`<script>` de Bootstrap 3 y demás libs - esto
    es el comportamiento NORMAL y esperado del proyecto (la versión committeada de esos
    archivos tiene esos bloques vacíos a propósito; gulp los llena localmente en cada
    build). Nuestra línea de Tailwind+Alpine agregada en la sesión anterior sobrevivió
    intacta dentro de `header.php` después del build.
  - **IMPORTANTE para futuros commits**: mientras el ambiente de dev esté activo,
    `git status` va a mostrar `header.php` y `login.php` como modificados por el ruido del
    build de gulp (los `<link>`/`<script>` inyectados). Esto NO debe commitearse tal cual -
    antes de cada commit de una vista nueva hay que revisar el diff de esos dos archivos y
    asegurarse de solo commitear los cambios de diseño reales, no el contenido inyectado
    por gulp. (Se puede usar `git diff` para revisar y `git add -p` para stage selectivo si
    hace falta, o simplemente recordar que esos bloques inject siempre vuelven a quedar
    vacíos en el HEAD committeado).
  - Se generó `encryption.key` (vacío en `.env.example`, requerido por CodeIgniter para
    cualquier request que use sesiones/encriptación) y se agregó `localhost:8090` a
    `app.allowedHostnames` (además de `localhost`) - sin esto, la protección anti
    Host-Header-Injection (GHSA-jchf-7hr6-h4f3) hace fallback silencioso y genera URLs sin
    puerto, rompiendo todos los links de la app al navegar en :8090. Ninguno de estos dos
    cambios toca código de la aplicación, solo configuración vía `.env` (gitignored).
  - Se corrieron las migraciones de stock de CodeIgniter (`php spark migrate --all`) UNA
    SOLA VEZ para poblar el esquema inicial vacío - confirmado explícitamente con el
    usuario antes de hacerlo, ya que la regla dura #4 menciona no correr migraciones. El
    usuario aceptó que la regla aplica a no crear/modificar migraciones como parte del
    refactor visual, no al setup inicial del entorno. No se va a volver a correr
    `spark migrate` salvo que el usuario lo pida de nuevo.
  - Problema de permisos encontrado y resuelto: añadí por error `www-data` al grupo `root`
    para darle acceso a `/root/ospos-tailwind` (ya que el proyecto vive bajo `/root`, que
    por defecto es `700`). Esto causó 403 en nginx, porque en Linux, si el proceso
    pertenece al grupo propietario del archivo, se evalúan los bits de GRUPO, no los de
    "otros" - y el grupo `root` no tenía permisos. Se revirtió (`gpasswd -d www-data root`)
    y en su lugar se hizo `chmod o+x /root` (solo bit de tránsito, sin listado) - así
    `www-data` puede atravesar `/root` sin pertenecer a su grupo. Hubo que reiniciar
    nginx/php-fpm después del cambio porque los workers ya corriendo tenían cacheada la
    membresía de grupo vieja desde que arrancaron.
  - Verificado con curl + manejo manual de cookies/CSRF: login (admin/pointofsale) OK,
    dashboard OK, y las vistas `/sales`, `/items`, `/customers`, `/reports`, `/employees`
    devuelven 200. `/configs` devolvió 404 - probablemente el path real es distinto
    (revisar rutas reales del módulo de configuración), anotado en BACKLOG, no bloqueante.
  - Persistencia: mariadb, nginx y php8.3-fpm quedaron `enabled` por systemd (arrancan solos
    si la máquina/contenedor se reinicia). El comando de build de Tailwind (watch) sigue
    siendo responsabilidad del usuario en su sesión de tmux, como ya estaba planeado.
  - **Cómo acceder (local, dentro de la máquina)**: `http://localhost:8090` - login
    `admin` / `pointofsale`.

## 2026-06-20 - Vista: Acceso externo vía dominio (ospos-dev.josevaldivia.com)
- Archivos fuera del repo: `/etc/caddy/Caddyfile` (agregado bloque para el nuevo
  subdominio), `/etc/nginx/sites-available/ospos.conf` (agregado `server_name` para el
  subdominio + detección de `X-Forwarded-Proto` para HTTPS). `.env` actualizado
  (`app.allowedHostnames` con el nuevo hostname).
- Estado: completo
- Notas:
  - El servidor ya corre un Caddy que enrutaba `dev.josevaldivia.com -> localhost:8080`
    (otro servicio existente, no tocado). Se agregó un bloque nuevo para
    `ospos-dev.josevaldivia.com -> localhost:8090` (donde vive nginx+OSPOS), en vez de
    reusar un sub-path del dominio existente - mucho menos esfuerzo, porque CodeIgniter 4
    no está pensado para vivir bajo un sub-path sin tocar `baseURL`/rewrite rules de la
    app, y un subdominio nuevo es solo config de proxy, sin tocar nada de la aplicación.
  - El DNS de `ospos-dev.josevaldivia.com` ya resolvía a la IP del servidor (probablemente
    un wildcard `*.josevaldivia.com` ya configurado) - no hizo falta pedirle al usuario que
    cree un registro DNS nuevo. Caddy obtuvo un certificado Let's Encrypt automáticamente
    (challenge TLS-ALPN-01) sin intervención manual.
  - nginx ahora mapea `X-Forwarded-Proto` (que Caddy envía) a `HTTPS=on` para PHP-FPM, así
    que CodeIgniter genera URLs `https://` cuando se accede vía el dominio público, pero
    sigue generando `http://` para el acceso directo local en `:8090` (no se forzó
    `FORCE_HTTPS=true` a propósito, para no romper el acceso local sin TLS).
  - Verificado: `https://ospos-dev.josevaldivia.com/` responde 200 en GET, con todos los
    `href`/`src` generados correctamente con el dominio público y `https://`.
  - **Cómo acceder desde fuera (para testeo del usuario)**:
    `https://ospos-dev.josevaldivia.com` - login `admin` / `pointofsale`.

## 2026-06-20 - Vista: Fase 0.1/0.2/0.3 - Layout principal + Header/Nav + Footer
- Archivos: `app/Views/partial/header.php`, `app/Views/partial/footer.php`,
  `public/css/tailwind-build.css` (recompilado)
- Estado: completo
- Notas:
  - Rediseño real, no repintado: el viejo `topbar` + `navbar-default` de Bootstrap 3 (dos
    barras separadas, links de texto plano, menú de módulos como botones grandes en fila)
    se reemplazó por un `<header>` único, sticky, con jerarquía clara: marca (logo SVG
    oficial de OSPOS + nombre de la empresa) a la izquierda, reloj en vivo + menú de
    usuario a la derecha (desktop), y una fila de nav de módulos debajo con estado activo
    resaltado (`bg-brand-primary-soft text-brand-primary`) en vez del genérico `.active`
    de Bootstrap.
  - Mobile: el menú de módulos + reloj + usuario colapsan en un panel con Alpine
    (`x-data="{ mobileOpen: false }"`, `x-show`, `x-transition` de opacidad+translate),
    activado por un botón hamburguesa con icono SVG inline que cambia a "X" - reemplaza el
    `navbar-toggle` de Bootstrap que en la versión vieja ni siquiera funcionaba bien
    (dependía de jQuery collapse de Bootstrap 3, no probado/usado realmente porque la app
    no era responsive).
  - Compatibilidad con vistas no migradas (CRÍTICO): el viejo `header.php` abría
    `<div class="container"><div class="row">` y `footer.php` lo cerraba - esto envuelve
    TODAS las vistas de la app, incluso las que usan grids de Bootstrap 3
    (`.col-sm-*`, etc.) internamente. Si se quita o renombra ese wrapper antes de migrar
    cada vista, se rompe el grid de las ~75 vistas que todavía no pasaron por este
    refactor. Decisión: se mantuvo el wrapper `.container > .row` con las mismas clases de
    Bootstrap intacto alrededor del `<main>`, y todo el rediseño real (gradientes,
    jerarquía, tokens semánticos, mobile) se aplicó solo al header/nav/footer (que están
    fuera de ese wrapper). Este wrapper se va a ir reemplazando vista por vista a medida
    que cada módulo se migre (Fases 1-4), y recién se elimina del todo cuando ya no quede
    ninguna vista vieja que dependa de él.
  - Verificado con curl (login + cookies + CSRF) que `/sales`, `/items`, `/customers`,
    `/reports`, `/employees`, `/home` siguen devolviendo 200 después del cambio, y que el
    grid Bootstrap de esas vistas no migradas sigue intacto (`.container`/`.row` presentes
    en el HTML resultante).
  - Footer: texto de licencia (`Common.copyrights`, `Common.website`,
    `application_version`, `commit_sha1`) verificado carácter por carácter idéntico al
    original, solo se restyleó el contenedor (antes `.jumbotron`, ahora `<footer>` con
    tokens semánticos) - sigue siempre visible al fondo de cada página
    (`mt-auto` + `flex flex-col` en `<body>`).
  - JS/AJAX preservados sin cambios: `id="liveclock"` (sigue siendo el único elemento con
    ese id, oculto vía CSS en mobile pero presente en el DOM, así que
    `header_js.php` sigue actualizándolo sin tocar ese archivo), clase `modal-dlg` en el
    anchor de cambiar contraseña, mismos `href`/rutas en todos los `anchor()` (logout,
    changePassword, módulos). No se tocó `header_js.php` ni ningún controller/model.
  - Pendiente/diferido (anotado en BACKLOG): los íconos de cada módulo
    (`images/menubar/$module->module_id.svg`) se dejaron como `<img>` tal cual, NO se
    convirtieron a SVG inline - son assets dinámicos por módulo (pueden variar según
    instalación/plugins) y no es seguro mapear a mano todos los `module_id` posibles sin
    arriesgar romper íconos de módulos no contemplados. Los íconos que sí son nuestros
    (hamburguesa, X de cerrar) están en SVG inline lineal, como pide la regla.
  - Build de gulp: como ya quedó documentado, cada `npm run build` reinyecta los bloques de
    assets legacy en este archivo - antes de este commit se removieron manualmente esos
    bloques inyectados (dejando los markers vacíos como en el HEAD original) para no
    commitear ruido, y se volvió a correr el build después del commit para que el server
    de dev local siga sirviendo los assets de Bootstrap 3 sin problemas.

## 2026-06-20 - Vista: Fase 0.4 - Componentes genéricos (capa de componentes Tailwind)
- Archivos: `tailwind/components.css` (nuevo), `tailwind/input.css` (agregado el import),
  `public/css/tailwind-build.css` (recompilado)
- Estado: completo
- Notas:
  - OSPOS no tiene un archivo central de "botones"/"inputs" - son clases de Bootstrap
    repetidas inline en cada vista. En vez de eso, se creó una capa `@layer components` en
    Tailwind con clases cortas y reutilizables, armadas únicamente con los tokens
    semánticos (nunca colores literales), siguiendo al pie de la letra los "Patrones de
    componentes a replicar" de CLAUDE.md: `.btn-primary` / `.btn-secondary` / `.btn-danger`
    / `.btn-accent` (con gradiente), `.input-base` / `.select-base` / `.label-base` /
    `.help-text`, `.card-base` / `.card-elevated` / `.card-highlight`, `.alert-danger` /
    `.alert-success` / `.alert-warning`, `.badge-success` / `.badge-danger` /
    `.badge-warning` / `.badge-neutral`, `.modal-overlay` / `.modal-panel` /
    `.modal-content` (para modales propios futuros - NO se tocaron los modales existentes
    de `bootstrap3-dialog`/`.modal-dlg`), `.pagination-link` / `.pagination-link-active` /
    `.pagination-link-disabled`, y un set de "empty state" (`.empty-state`,
    `.empty-state-icon`, `.empty-state-title`, `.empty-state-description`) ya que la regla
    de diseño pide estados vacíos diseñados en vez de tablas vacías sin contexto.
  - Detalle técnico de Tailwind v4: dentro de `@layer components`, no se puede hacer
    `@apply` de OTRA clase custom definida en la misma capa (ej. `.select-base { @apply
    input-base ... }` tira `Error: Cannot apply unknown utility class`). Hubo que escribir
    las utilidades completas en cada clase en vez de encadenar referencias entre ellas
    (afectó a `.select-base` y `.modal-content`).
  - Esto no toca ninguna vista todavía - es solo la "caja de herramientas" para que Fase 1
    en adelante (sales, login, items, etc.) sea más rápida y consistente: en vez de repetir
    `bg-gradient-to-br from-brand-primary to-brand-primary-hover text-text-on-brand py-3
    rounded-xl...` en cada botón, se usa `class="btn-primary"`.
  - Verificado: el build de Tailwind compila sin errores y genera las reglas CSS
    correspondientes (`.btn-primary`, `.alert-danger`, `.empty-state`, `.pagination-link`
    confirmados presentes en el CSS de salida), y `https://ospos-dev.josevaldivia.com/`
    sigue respondiendo 200 después del cambio (no afecta ninguna vista renderizada
    todavía, solo agrega CSS no usado aún).

## 2026-06-20 - Vista: Fase 1.6 - Login
- Archivos: `app/Views/login.php`
- Estado: completo
- Notas:
  - Rediseño real: la vieja card de un solo bloque (logo a la izquierda con borde
    divisorio, formulario a la derecha, todo apretado) se reemplazó por una card partida
    en dos paneles (`md:grid md:grid-cols-2`): panel de marca con gradiente
    (`from-brand-primary to-brand-primary-active`) y el logo oficial de OSPOS en una
    insignia circular blanca con sombra (mismo patrón que el avatar del header), y panel de
    formulario con jerarquía clara (título, campos, botón). En mobile el panel de marca
    pasa arriba y el form abajo, ambos a ancho completo.
  - Inputs: se reemplazó el patrón `.form-floating` de Bootstrap (label flotante animada)
    por el patrón más simple label-arriba-input con los componentes `.label-base`/
    `.input-base` ya creados en Fase 0.4 - decisión de diseño: la animación de label
    flotante depende de CSS específico de Bootstrap5 que no íbamos a reimplementar para
    una sola vista, y usar el mismo patrón de label+input que el resto de los formularios
    del sistema (a medida que se migren) da más consistencia que un caso especial solo en
    login. La variante `input_groups` (ícono dentro del input) también se rehizo sin
    `.input-group` de Bootstrap, con un ícono SVG inline posicionado absoluto - mismos
    nombres/ids que antes.
  - JS intacto, NO se tocó ni una línea: el script de `APP_STATE` y el manejo de
    `showMigrationRequired/Progress/Success/Error/showLoginForm` siguen funcionando
    exactamente igual porque se preservaron todos los ids que usa
    (`#login-form`, `#form-heading`, `#migration-warning`, `#migration-success`,
    `#migration-progress`, `#migration-status`, `#migration-error`,
    `#migration-error-message`, `#login-fields`, `#submit-button`) y, más importante, la
    clase **`d-none`** se mantuvo literal en todos los elementos que el JS
    muestra/oculta vía `addClass('d-none')`/`removeClass('d-none')` - solo se le quitaron
    las clases visuales de Bootstrap (`alert alert-warning`, etc.) y se reemplazaron por
    los componentes propios (`alert-warning`, `alert-success`, `alert-danger`), pero
    `d-none` en sí sigue ahí porque Bootstrap5 (todavía cargado) es quien define esa regla
    `display:none`.
  - La barra de progreso de la migración (que antes era `.progress`/`.progress-bar` de
    Bootstrap con animación de rayas) se rehizo con un gradiente + `animate-pulse` de
    Tailwind - visualmente distinto pero cumple la misma función (indicar "está
    trabajando"), ya que esos elementos no son manipulados por el JS (solo se muestra/
    oculta el contenedor padre).
  - Se dejó de enlazar `public/css/login.css` desde esta vista (sus selectores
    `.box-logo`/`.box-login`/`.container-login` ya no existen en el nuevo markup, hubiera
    quedado código muerto). El archivo NO se borró del repo, solo se desvinculó de esta
    vista - anotado en BACKLOG por si hace falta limpiarlo más adelante.
  - Detalle pendiente de decisión (anotado en BACKLOG): el footer de login (logo + nombre
    del software) nunca mostró el bloque completo de licencia
    (copyright/versión/commit) que sí tiene `partial/footer.php` en el resto de la app -
    esto es comportamiento preexistente de upstream, no algo que cambiamos nosotros, pero
    vale la pena confirmarlo con el usuario porque la regla dura #7 pide ese texto visible
    "en cada página".
  - Verificado con curl (GET /login, login real con CSRF, POST /login -> 303 -> /home 200)
    que el flujo de autenticación sigue funcionando end-to-end, y que todos los ids que
    necesita el JS están presentes en el HTML resultante.

## 2026-06-20 - Corrección: paleta real "Her Appointments" + ajuste de bordes
- Archivos: `tailwind/theme-default.css`, `tailwind/components.css`,
  `app/Views/partial/header.php`, `app/Views/login.php`,
  `public/css/tailwind-build.css`
- Estado: completo
- Notas:
  - El usuario corrigió dos cosas después de ver el login/header en vivo: (1) la paleta
    azul/dorado que yo había elegido como "default" en la Fase 0 NO era la real - el
    negocio real es "Her Appointments" con paleta rosa/dorado/marfil, y (2) algunos
    elementos se veían inconsistentes entre redondeado y duro (puntualmente, el rojo de la
    alerta de error en login "no cuadraba").
  - Se reemplazaron los valores hex de `tailwind/theme-default.css` (Capa 1) por los
    reales de Her Appointments que pasó el usuario (rose-900..100, gold-600..100,
    ivory-50, ink-900/500, sage-600..100, wine-600/100), mapeados 1 a 1 a las variables ya
    existentes (`--palette-primary-*` = rose, `--palette-accent-*` = gold, `--palette-bg`
    = ivory-50, `--palette-text-*` = ink, `--palette-success-*` = sage,
    `--palette-danger-*` = wine). El color de "warning" no estaba en la paleta del
    cliente - se agregó un ámbar coherente con el resto (#a16207/#f5e6c8), documentado
    como decisión propia en la memoria del proyecto.
  - `--font-display` pasó de ser un placeholder ("Inter" duplicado) a "Playfair Display"
    real - se agregó la carga de Google Fonts (`Playfair Display` + `Inter`) en el
    `<head>` de `header.php` y `login.php` (las únicas dos plantillas con `<head>` propio).
  - Ajuste de consistencia: `.alert-danger/success/warning` en `components.css` pasaron de
    `rounded-lg` a `rounded-xl` para que el radio combine con `input-base`/`btn-*` (mismo
    radio en elementos que aparecen juntos en un form, como en login).
  - Como esta paleta es la real del cliente (no un ejemplo), se guardó en memoria
    persistente (`brand_palette_her_appointments.md`) para no perderla en futuras
    sesiones, y se documentó el concepto de arquitectura de 3 capas como patrón reusable
    para proyectos futuros (`theming_architecture_3_layers.md`) - el usuario pidió
    explícitamente que esta separación se mantenga como plantilla general, no solo para
    este proyecto.
  - Verificado: `--palette-primary-600` en el CSS servido en producción ahora es
    `#b23a66` (antes `#2563a8`), y `https://ospos-dev.josevaldivia.com/login` y `/` siguen
    en 200 después del cambio.

## 2026-06-20 - Fix: logo del header respeta $config['company_logo']
- Archivos: `app/Views/partial/header.php`, `public/css/tailwind-build.css`
- Estado: completo
- Notas:
  - El usuario preguntó cómo encajaría el logo real de la empresa en el header. Al
    revisar, encontré que `login.php` (Fase 1.6) sí respeta `$config['company_logo']`
    (logo subido en Configuración) con fallback al ícono genérico de OSPOS, pero
    `header.php` (Fase 0.2) siempre mostraba el ícono genérico sin chequear esa config -
    inconsistencia entre las dos vistas. Se corrigió `header.php` para usar el mismo
    patrón condicional que login: si hay `company_logo` configurado, se muestra como
    `<img>` recortado dentro del mismo badge circular con gradiente; si no, cae al SVG de
    OSPOS de siempre.
  - De paso se resolvió la duda anotada en BACKLOG sobre `/configs` 404: el controlador
    real se llama `Config` (singular, `app/Controllers/Config.php`), la ruta correcta es
    `/config`. Confirmado con curl que responde 200 logueado - ahí está el campo para
    subir el logo de Her Appointments cuando el usuario quiera probarlo.
  - No se tocó ningún controller/model - el campo `$config['company_logo']` ya lo pasa el
    controller de `home`/layout a todas las vistas, solo se agregó el `<?php if ?>` en el
    markup del header, igual que ya existía en login.php y en los recibos/facturas.

## 2026-06-20 - Rediseño login v2: referencia visual "Her Appointments"
- Archivos: `app/Views/login.php`, `public/css/tailwind-build.css`
- Estado: completo
- Notas:
  - El usuario compartió una imagen de referencia (`uploads/her appointments login.png`,
    fuera del repo) del diseño original de Her Appointments y pidió acercarse más a eso.
    Cambios respecto a la v1 de Fase 1.6:
    - El panel de marca pasó de la izquierda a la **derecha** y ahora es más ancho que el
      formulario (grid de 12 columnas, form `col-span-5`, panel decorativo
      `col-span-7` en desktop) en vez del 50/50 con marca a la izquierda.
    - El logo ya NO es un círculo flotante sobre fondo de color - ahora es un **recuadro
      rectangular** (`rounded-2xl border bg-surface p-4`) arriba del formulario, con el
      nombre de la empresa en `font-display` debajo y el tagline (`Common.software_title`)
      más abajo en gris muted - igual que el mock.
    - El panel decorativo (antes plano con el ícono chico) ahora tiene un marco interior
      punteado (`border-dashed`) como en la referencia, y dentro un medallón circular
      blanco translúcido con el logo en grande + nombre + tagline en blanco - reusa el
      mismo logo/fallback SVG que el resto de la app (OSPOS no tiene un campo de "foto del
      local" como el mock sugiere, así que no se inventó esa función).
    - El fondo general de la página pasó de gradiente sutil a `bg-surface-muted` plano
      (el gradiente ahora vive solo dentro del panel decorativo, como en la referencia).
  - **Animación de entrada** agregada (pedido explícito: "full animaciones al cargar"): un
    `@keyframes fade-up` (la card entera sube + aparece) y `@keyframes fade-in` (el panel
    decorativo aparece con un pequeño delay de 120ms) definidos en un `<style>` scoped
    dentro de `login.php` (mismo patrón que ya usa `header.php` con su bloque `<style>`),
    aplicados vía sintaxis arbitraria de Tailwind (`animate-[fade-up_0.6s_ease-out_both]`).
    Es CSS puro, no requiere Alpine ni JS adicional.
  - No se inventó copy nueva en español hardcodeado (el mock tenía textos como "Tu logo
    aquí 240x80px" o "Foto o ilustración del salón, Vertical 1200x1800px") porque esos
    eran anotaciones de mockup/Figma para el diseñador, no textos reales de producto - se
    tradujo la idea visual (recuadro de logo, panel con marco punteado) sin agregar
    strings nuevos fuera de los `lang()` ya existentes.
  - JS, ids y `d-none` intactos - mismo cuidado que en la v1, no se tocó el script.
  - Verificado: todos los ids que usa el JS (`#login-form`, `#form-heading`,
    `#migration-warning/success/progress/error/status`, `#login-fields`,
    `#submit-button`) presentes en el HTML servido, `/login` responde 200.
  - LIMITACIÓN: no hay navegador headless en este entorno para que Claude verifique
    visualmente el resultado - el usuario tiene que confirmar cómo se ve en su propio
    navegador.

## 2026-06-20 - Login v3: jerarquía marca-negocio vs atribución OSPOS
- Archivos: `app/Views/login.php`, `public/css/tailwind-build.css`
- Estado: completo
- Notas:
  - El usuario subió su logo (Her Studio Perú) y notó que "OSPOS"/"Open Source Point of
    Sale" se veía más resaltado que el nombre del propio negocio - pidió invertir esa
    jerarquía y usar la tipografía para reforzar la distinción (negocio = grande/display,
    sistema = chico/discreto).
  - Cambios concretos:
    - Logo: de `h-12`/`h-14` a `h-20`/`h-24` en el recuadro del form, y de `h-28`/`h-32` a
      mantenerse grande en el medallón del panel decorativo (ya era el elemento más
      grande ahí, no se tocó).
    - Nombre de la empresa: de `text-2xl font-semibold` a `text-3xl font-bold` en ambos
      paneles (form y decorativo) - mismo `font-display` (Playfair Display) que ya tenía,
      pero con más peso y tamaño para que gane la jerarquía visual.
    - Atribución de OSPOS: en vez de `lang('Common.software_title')` ("Open Source Point
      of Sale", frase larga) en tamaño `text-sm` debajo del nombre de la empresa, ahora es
      `lang('Common.software_short')` ("OSPOS") en `text-xs uppercase tracking-wider
      text-muted` - mucho más chico, discreto, tipo etiqueta secundaria en vez de subtítulo
      con el mismo peso que el nombre del negocio.
    - Footer de la página: antes era una píldora con ícono + "Open Source Point of Sale"
      con la misma jerarquía visual (shadow, fondo, mismo tamaño de texto) que el resto de
      la marca. Se redujo a una línea de texto chica (`text-xs`) tipo
      "Powered by **OSPOS**" sin ícono ni fondo - atribución mínima, no compite con la
      marca del negocio.
  - Esto es exactamente la "distinción de tipografías para dar visibilidad" que pidió el
    usuario: `font-display` + tamaño/peso grande para lo que debe destacar (negocio),
    `font-sans` + tamaño chico/muted/uppercase para lo que es secundario (atribución del
    software).
  - JS/ids intactos (mismo cuidado de siempre). Verificado con curl que `/login` responde
    200 y todos los ids del script de migración siguen presentes.

## 2026-06-20 - Login v4: ocultar heading redundante + memoria de convenciones
- Archivos: `app/Views/login.php`, `public/css/tailwind-build.css`
- Estado: completo
- Notas:
  - El usuario pidió quitar el texto "Welcome to OSPOS" del login. El `<h3
    id="form-heading">` lo escribe dinámicamente el JS existente en varios estados
    (welcome, migration_required, etc. vía `.text()`) - no se podía borrar del DOM sin
    tocar esa lógica. Se ocultó con `class="hidden"` en vez de borrar el elemento: el JS
    sigue llamando `.text()` sin error ni cambio de comportamiento, solo que ya no se ve
    nada. La información de cada estado (migración requerida, error, éxito) ya está
    cubierta por los recuadros de alerta (`#migration-warning/success/error`) que tienen
    su propio texto explicativo, así que no se perdió ninguna comunicación funcional al
    ocultar este heading genérico.
  - Se guardó en memoria persistente (`visual_hierarchy_and_animation_conventions.md`) la
    convención completa para que se replique igual en TODAS las pantallas siguientes, no
    solo login:
    - Jerarquía: nombre del negocio siempre `font-display` grande/bold/color de marca;
      mención a OSPOS siempre `software_short` (no `software_title`) en `text-xs
      uppercase tracking-wider text-muted`, nunca con el mismo peso que la marca.
    - Animación: patrón `fade-up` (contenedor principal) + `fade-in` con delay ~120ms
      (paneles secundarios), definidos en un `<style>` scoped por vista, aplicados con
      `animate-[nombre_duración_easing_both]` de Tailwind v4 - sin Alpine, CSS puro.
    - Filosofía: ante la duda, quitar/simplificar antes que agregar decoración que no
      aporte información nueva.
  - Verificado: `/login` sigue en 200, `#form-heading` presente en el HTML con
    `class="hidden"`.

## 2026-06-20 - Fase 1.5: Sales/POS (app/Views/sales/register.php)
- Archivos: `app/Views/sales/register.php`, `tailwind/components.css`
  (agregada `.input-compact`), `public/css/tailwind-build.css`
- Estado: completo
- Notas:
  - Esta es la vista más compleja del refactor hasta ahora (911 líneas, un `<form>` por
    cada línea del carrito, decenas de selectores jQuery atados a ids/names/clases
    específicas, atajos de teclado, autocomplete de items/clientes/giftcards). Se trabajó
    con cuidado especial para no tocar NINGÚN id, name, atributo `data-*`, ni la lógica del
    `<script>` al final del archivo - todos los cambios son de clases CSS, iconos y
    estructura de wrapping `<div>`.
  - **El problema más grande que se resolvió**: `public/css/register.css` (legacy, cargado
    globalmente en el `<head>`) define `#register_wrapper { float: left; width: 70%; }` y
    `#overall_sale { float: left; width: 29%; }` - un layout de 2 columnas fijo, sin
    ningún media query, que es la razón por la que esta pantalla nunca fue usable en
    mobile. Como son selectores por ID (mayor especificidad que cualquier clase de
    Tailwind), no se podían pisar agregando solo clases - se neutralizó con un `<style>`
    scoped dentro de la vista (mismo patrón que login/header) que pone `float: none; width:
    100%;` en esos dos ids, y el layout real ahora lo controla un flex de Tailwind: columna
    única en mobile, `lg:flex-row` con 2/3 + 1/3 en desktop.
  - **Decisión de scope deliberada sobre la tabla del carrito**: la tabla de items
    (`#register`/`#cart_contents`) tiene un `<form>` independiente por línea
    (`cart_$line`) con múltiples inputs (`item_number`, `name`, `price`, `quantity`,
    `discount`, `discount_toggle`, `discounted_total`, `description`, `serialnumber`) cuyo
    `onChange`/`onClick`/`keypress` dependen de la posición exacta en el DOM
    (`$(this).parents('tr').prevAll('form:first').submit()`). Reestructurar esto a "cards"
    apiladas en mobile (como se hizo conceptualmente con otras tablas densas) habría
    significado tocar esa estructura form>tr>tr y arriesgar romper esos handlers, sin
    poder probarlo en un navegador real. Se optó por la alternativa más segura: mantener la
    tabla real (con scroll horizontal en mobile vía `overflow-x-auto` en el wrapper
    `card-base`), restylar el header de la tabla con los tokens de marca, agregar hover de
    fila, y usar la nueva clase `.input-compact` (variante chica de `.input-base`) para que
    los inputs no se vean como Bootstrap plano. Documentado en BACKLOG como posible mejora
    futura (cards reales en mobile) una vez se pueda probar en navegador de verdad.
  - Componente nuevo: `.input-compact` en `components.css` - variante de `input-base` con
    padding/tamaño reducido para celdas densas de tabla (este mismo input gigante no cabía
    en una tabla). Reemplaza el `form-control input-sm` de Bootstrap en las ~15 ocurrencias
    de inputs dentro del carrito, panel de pagos, comentarios, etc.
  - Reemplazo de iconos: todos los `glyphicon-*` (trash, refresh, print, tag, user,
    share-alt, ok, credit-card, remove, align-justify, list-alt) por SVG inline lineales,
    siguiendo la regla de diseño. Los íconos de módulo (`images/menubar/*.svg`, dinámicos
    por instalación) NO se tocaron, igual que en el header.
  - Botones que antes eran `<div class="btn btn-sm btn-success">` (no son `<button>` real,
    el JS hace `.click()` sobre el div) se mantuvieron como `<div>` - solo se les agregó
    `cursor-pointer` y las clases de componente (`.btn-accent`, `.btn-secondary`,
    `.btn-danger`) ya que cambiar el tag a `<button>` real habría sido un cambio de
    estructura innecesario para esta pasada.
  - Los `<select>` con plugin bootstrap-select (`selectpicker`, mode/dinner_table/
    stock_location/payment_type) NO se restylearon visualmente - ese plugin genera su
    propio dropdown con CSS de Bootstrap 3 y tocar sus clases (`selectpicker`,
    `show-menu-arrow`, `data-style`, `data-width`) podría romper su inicialización JS.
    Quedan con apariencia Bootstrap hasta una futura decisión de reemplazar el plugin
    entero por un select nativo + Tailwind (cambio de mayor alcance, anotado en BACKLOG).
  - El formulario de grid Bootstrap (`container-fluid`/`row`/`col-xs-*`) de la sección de
    comentarios/checkboxes al final se reemplazó por flex de Tailwind.
  - **Limitación de testing importante**: la base de datos de desarrollo está vacía (sin
    items cargados), así que el carrito nunca tiene líneas y las secciones condicionales
    `if (count($cart) > 0)` (tabla de pagos, botones de completar venta, panel de
    comentarios) nunca se renderizaron en las pruebas con curl - no se pudieron verificar
    visualmente. La lógica de esas condiciones no se tocó (mismas condiciones PHP exactas,
    solo cambian clases/iconos por dentro), pero recomiendo que el usuario cargue al menos
    un item de prueba y revise esa parte del flujo en su navegador.
  - Verificado: `php -l` sin errores, conteo de `<div>`/`</div>` balanceado (30/30) en todo
    el archivo, login real + `/sales` responde 200, todos los ids visibles en el HTML
    (mode_form, add_item_form, item, register_wrapper, register, cart_contents,
    overall_sale, select_customer_form, sale_totals, new_item_button,
    show_suspended_sales_button, sales_takings_button, show_keyboard_help, customer_label,
    etc.) presentes, sin clases `glyphicon`/`btn btn-*`/`panel panel-*` de Bootstrap
    sobrantes en el HTML resultante.

## 2026-06-21 - FIX CRÍTICO: Tailwind perdía contra Bootstrap (cascade layers)
- Archivos: `tailwind/tokens.css`, `tailwind/components.css`, `app/Views/login.php`,
  `app/Views/partial/header.php`, `app/Views/sales/register.php`, `CLAUDE.md`,
  `public/css/tailwind-build.css`
- Estado: completo
- Notas:
  - El usuario reportó que todo "se ve horrible" después de Sales/POS: header sin nav ni
    reloj, menú mobile ausente, imposible crear items/clientes, y la alerta roja de login
    seguía mal a pesar del cambio de paleta de la sesión anterior. Se instaló Playwright +
    Chromium headless (`npx playwright install chromium --with-deps`) para poder
    inspeccionar de verdad en un navegador real en vez de solo curl, y se encontraron DOS
    bugs sistémicos completamente distintos a "el diseño está mal":
  - **Bug 1 (infraestructura)**: PHP-FPM/OPcache servía versiones viejas de las vistas a
    pesar de `opcache.validate_timestamps=On`. Síntoma: jQuery nunca llegaba a cargar en
    el navegador (`$ is not defined`), lo que rompía absolutamente todo el JS de la app
    (autocomplete, bootstrap3-dialog, dialog_support, table_support) - de ahí "no carga
    items ni crea clientes". Fix: `sudo systemctl restart php8.3-fpm`. Esto NO era un bug
    de código, era puramente de este entorno de dev.
  - **Bug 2 (estructural, CSS)**: Tailwind v4 envuelve todas sus utilidades en
    `@layer theme, base, components, utilities`. Bootstrap 3/5 y el resto del CSS legacy
    de OSPOS (`ospos.css`, `register.css`) se cargan SIN `@layer`. Por la spec de CSS
    Cascade Layers, una regla sin layer le gana SIEMPRE a una con layer en un empate de
    importancia, sin importar la especificidad. Esto causó:
    - Clases de componentes propias con el MISMO NOMBRE que clases de Bootstrap
      (`.btn-primary`, `.btn-danger`, `.alert-danger`, `.alert-success`, `.alert-warning`)
      perdían contra Bootstrap. Confirmado con Playwright: el botón "Daily Sales"
      mostraba `background-color: rgb(44,62,80)` (navy de Bootstrap flatly) en vez del
      gradiente de marca, y la alerta de error de login mostraba el rojo sólido de
      Bootstrap (`#e74c3c`) en vez del wine-100/600 de la paleta - **el cambio de paleta
      de la sesión anterior nunca tuvo efecto ahí por esta razón exacta**, no porque el
      theme estuviera mal configurado.
    - Utilidades de Tailwind sobre tags HTML5 con reset de Bootstrap (`nav`, `header`,
      `footer`, `main`, `section`, etc. - Bootstrap tiene una regla genérica
      `article, aside, ..., nav, section { display: block }`) perdían incluso siendo
      clases (mayor especificidad) contra ese reset de tag (menor especificidad) - el
      `<nav>` del header nunca se ocultaba en mobile aunque la clase `max-md:hidden`
      era correcta y el media query matcheaba.
    - Confirmado también con una regla aún más genérica de `ospos.css`:
      `* { padding: 0; ... }` pisando CUALQUIER `px-*`/`py-*` de Tailwind en cualquier
      elemento (encontrado al ver que el contenido de `/sales` en mobile tocaba el borde
      de la pantalla sin el padding que sí estaba en el HTML).
  - **Fix aplicado (estructural, no parche por parche)**:
    1. `tailwind/tokens.css`: `@import "tailwindcss";` → `@import "tailwindcss"
       important;` - hace que toda utilidad usada directo en el HTML (`px-4`, `hidden`,
       `md:flex`, etc.) salga con `!important`, ganándole a cualquier regla no-importante
       de Bootstrap/legacy sin importar layers.
    2. `tailwind/components.css`: TODAS las clases de componentes renombradas con
       prefijo `ui-` (`.btn-primary` → `.ui-btn-primary`, `.alert-danger` →
       `.ui-alert-danger`, etc. - 23 clases en total) porque el `important` del punto 1
       NO cubre las reglas `@apply` dentro de `@layer components` (son dos fixes
       complementarios, no uno sustituye al otro). Se actualizaron todos los usos en
       `login.php` y `register.php` con `sed`, verificado que no quedó ninguna clase sin
       prefijo.
    3. Documentado como **regla dura nueva en CLAUDE.md** (sección Sistema de diseño,
       con autorización explícita del usuario para editar ese archivo) y como memoria
       persistente detallada (`tailwind_bootstrap_cascade_layers_bug.md`) con checklist
       para cada vista futura - este bug iba a repetirse en items/customers/reports si no
       quedaba como regla explícita desde ahora.
  - **Verificado end-to-end con Playwright real** (no solo curl): login con paleta
    correcta (alerta de error en wine-100/600, confirmado por RGB exacto), header con
    nav/reloj/menú de usuario visibles en desktop, menú hamburguesa funcional en mobile
    (390px), botones con gradientes de marca correctos (RGB exacto verificado, no el de
    Bootstrap), y el flujo completo de **crear un cliente nuevo de punta a punta**
    (formulario → validación → submit → cliente seleccionado en la venta) funcionando
    sin errores - confirmando que "no crea clientes" está resuelto.
  - Limitación: Playwright/Chromium quedó instalado en este entorno
    (`/root/.cache/ms-playwright/`) pero los scripts de prueba usados están en `/tmp/`
    (no versionados) - si se pierden, hay que recrearlos para la próxima verificación
    visual real.

## 2026-06-21 - Sales/POS v2: feedback de usuario tras el fix de cascade layers
- Archivos: `app/Views/sales/register.php`
- Estado: completo
- Notas:
  - El usuario, ya con el fix de cascade layers aplicado, dio 5 puntos de feedback
    puntual viendo la pantalla con un item real en el carrito (se cargó un item de
    prueba "Test" vía el modal para poder ver el carrito con datos, antes solo se había
    probado vacío):
    1. **Toggle de descuento (%/$) se veía muy mal** - confirmado con zoom de Playwright:
       era el plugin `bootstrap-toggle` sin reskinear, una cajita gris de 45x35px con
       colores default de Bootstrap (verde/gris), apretada contra el input de descuento.
       Se reemplazó por un switch propio hecho solo con Tailwind (checkbox `sr-only` +
       `peer-checked`, sin el plugin), con "%"/"$" como etiquetas dentro del track y un
       thumb blanco deslizante en los colores de marca. Mismo `name="discount_toggle"`,
       `id`, `data-line` y comportamiento `checked` que antes - el JS existente
       (`$('[name="discount_toggle"]').change(...)`) no se tocó y sigue funcionando
       igual, verificado con Playwright haciendo click real y confirmando
       `checked: true/false` después del click.
    2. **Botón "New Item" dorado "rompe todo"** - era el único elemento dorado (accent)
       en esa zona de la pantalla, sin nada más dorado alrededor, lo que lo hacía ver
       como un error de paleta en vez de un acento intencional. Se cambió a
       `ui-btn-primary` (rosa de marca, igual que "Daily Sales") para que sea consistente
       con el resto de acciones de esa columna. El dorado (`ui-btn-accent`) quedó
       reservado para los botones que de verdad avanzan el cobro ("Add Payment",
       "Complete Sale", "Finish Invoice"), que es coherente con la regla de "acento para
       lo premium/CTA principal", no para cualquier botón secundario.
    3. **Modales incompletos** - el usuario mismo aclaró que esto es para una revisión
       posterior (los modales de items/customers no están migrados todavía) - no se tocó.
    4. **Faltan animaciones** - se agregó el mismo patrón `fade-up` ya usado en login al
       contenedor principal de la vista (entrada sutil al cargar la pantalla),
       consistente con la convención ya guardada en memoria.
    5. **El seccionado/UX no mejoró realmente** - el panel de venta (`#overall_sale`) era
       un solo bloque continuo (Cliente → Totales → Pago → Botones) sin separación
       visual real más allá de líneas finísimas entre filas de tabla. Se agregaron
       divisores claros (`border-top` + `padding-top`) entre esos 4 grupos, vía CSS puro
       sobre los ids ya existentes (`#sale_totals`, `#payment_details`, `#buttons_sale`) -
       **a propósito no se reestructuró el árbol de divs/condicionales PHP** (es
       profundamente anidado con múltiples `if` superpuestos para los distintos modos de
       venta/pago) para no arriesgar romper esa lógica sin poder probar cada combinación
       de estado en un navegador real.
  - Para poder ver el carrito con datos reales se cargó un item de prueba llamado "Test"
    (price 35.00) a través del propio modal de la app - queda en la base de datos de dev,
    no es parte del refactor, es solo data de prueba para verificar visualmente.
  - Verificado con Playwright: toggle funcional (click real + estado `checked`
    confirmado), botones con colores correctos, divisores de sección visibles en
    desktop (1280px) y mobile (390px), `php -l` sin errores.

## 2026-06-21 - FIX CRÍTICO #2: las clases ui-* tampoco heredaban "important"
- Archivos: `tailwind/components.css`, `app/Views/sales/register.php`, `CLAUDE.md`,
  `public/css/tailwind-build.css`
- Estado: completo
- Notas:
  - El usuario reportó: tipografía del botón "New Item" descuadrada dentro del botón, y
    los placeholders de búsqueda de item/cliente con letra grande poco estética. También
    pidió achicar la columna "Item #" del carrito para darle más aire al descuento (se
    consultó si la columna era necesaria - se mantuvo, solo se redujo el ancho, ya que
    sigue siendo un dato útil).
  - Investigando con Playwright (`getComputedStyle` en `#new_item_button`, clase
    `.ui-btn-primary`) se confirmó la continuación EXACTA del bug de cascade layers de la
    sesión anterior, en una capa distinta: `padding: 0px` (debía ser `6.25px 10px`),
    `font-weight: 400` (debía ser `500`), `font-size: 15px` (debía ser `8.75px`). El
    prefijo `ui-` evitaba que Bootstrap pintara SU propio botón encima (el color/gradiente
    de fondo ya era correcto), pero el padding/tamaño/peso de letra de nuestra propia
    clase seguían perdiendo contra reglas genéricas no-importantes de Bootstrap/
    `ospos.css` - el modificador global `important` de `tokens.css` (fix de la sesión
    anterior) NO cubre las reglas `@apply` dentro de `@layer components`, solo las
    utilidades usadas directo en el HTML. Era exactamente la "limitación importante" que
    ya había quedado anotada en la memoria del bug anterior, confirmada en la práctica.
  - **Fix**: script en Python (regex sobre `tailwind/components.css`) que agrega el
    modificador `!` a CADA utilidad dentro de TODOS los `@apply` (`@apply inline-flex
    px-4 text-sm hover:shadow-lg` → `@apply !inline-flex !px-4 !text-sm
    hover:!shadow-lg`), respetando variantes (el `!` va después del último `:`).
    Confirmado en el CSS compilado que ahora cada declaración sale con `!important`.
  - De paso se agregó `text-sm` explícito + `placeholder:text-text-muted/70` (gris más
    claro que el texto escrito, como pidió el usuario) a `.ui-input`/`.ui-select`/
    `.ui-input-compact` - antes no tenían tamaño de fuente propio y heredaban el del
    body de Bootstrap (15px), de ahí que se vieran "grandes" y descuadrados contra el
    padding pensado para cajas chicas.
  - Columna "Item #" de la tabla del carrito: de 15% a 8% de ancho, columna "Discount" de
    15% a 20% (más espacio para el switch nuevo), "Item Name" de 30% a 32% para
    compensar.
  - Esto es un fix GLOBAL (afecta el archivo de componentes compartido) - se verificó con
    Playwright que también mejoró el botón "Go" y los inputs de login, que tenían el
    mismo problema silencioso sin que el usuario lo hubiera reportado todavía ahí.
  - Documentado como continuación del bug anterior en CLAUDE.md (nueva regla #3 en la
    sección de cascade layers) y en memoria persistente, con la regla dura para
    cualquier clase nueva: SIEMPRE `!` en cada utilidad dentro de `@apply`, además del
    prefijo `ui-` - son dos fixes en capas distintas, ninguno sustituye al otro.

## 2026-06-21 - Fix: animación de entrada quitada de Sales/POS (causaba flicker)
- Archivos: `app/Views/sales/register.php`
- Estado: completo
- Notas:
  - El usuario reportó que la pantalla "se siente inestable, hace mucho flicker" después
    de probar el toggle de descuento. Causa real: Sales/POS recarga la página COMPLETA en
    casi cada interacción (agregar item, cambiar cantidad, tocar el toggle, agregar pago -
    todos son `form.submit()` síncronos, no AJAX), así que la animación `fade-up` que se
    le había agregado al contenedor principal se reproducía de nuevo en CADA recarga -
    en vez de sentirse "viva" (la intención original), se sentía como parpadeo constante
    cada vez que se tocaba cualquier cosa.
  - Se quitó por completo la animación de `register.php` (la clase
    `animate-[fade-up_0.5s_ease-out_both]` y el `@keyframes fade-up` del `<style>` scoped).
    Login SÍ la mantiene (carga una sola vez por sesión, no tiene este problema).
  - Se documentó en memoria la regla general: la animación de entrada solo aplica a
    vistas que cargan una vez por visita/sesión (login, dashboards) - vistas con flujo
    transaccional que recargan la página en casi cada click (sales/register, y
    probablemente otras pantallas de edición con guardado por POST+reload) NO deben
    llevarla. Hay que revisar el patrón de recarga de cada vista nueva antes de copiar la
    animación por costumbre, en vez de aplicarla a ciegas en todo.
  - Verificado: `php -l` sin errores, 0 referencias a `fade-up` en el HTML servido de
    `/sales`, página responde 200.

## 2026-06-22 - Vista: Items/Inventario - manage.php (lista, Fase 2.7)
- Archivos: `app/Views/items/manage.php`, `tailwind/components.css`,
  `app/Views/partial/header.php`, `app/Views/login.php` (estos 2 últimos solo por el
  fix de infraestructura abajo, no por la migración de la vista).
- Estado: completo
- Notas:
  - **Bug de infraestructura descubierto y arreglado primero**: los marcadores
    `<!-- inject:debug:js -->` / `<!-- inject:prod:js -->` de `header.php` y `login.php`
    estaban VACÍOS - gulp nunca había corrido en este entorno - así que NINGUNA página
    cargaba jQuery/bootstrap-table/bootstrap-select/manage_tables.js, etc. Confirmado con
    Playwright (`pageerror: jQuery is not defined`). Esto NO es parte de la migración
    visual, es un gap de build pendiente del entorno. Se corrió `npm run build` (gulp) y
    se reinició `php8.3-fpm` - confirmado con Playwright que jQuery/bootstrap-select/
    bootstrap-table ya inicializan. Sin este fix no se podía verificar ninguna vista con
    JS real (ni siquiera las ya migradas), así que probablemente afecta a TODAS las
    sesiones anteriores que solo verificaron con curl/screenshots estáticos.
  - Rediseño de `manage.php`: header de página con `<h1>` + botones de acción
    (CSV Import, New Item) como `ui-btn-secondary`/`ui-btn-primary` con iconos SVG
    inline (reemplazando glyphicons, que no tienen hook de JS). Toolbar de filtros
    (`#toolbar`) envuelto en `ui-card`, botones de acción en lote (`#delete`,
    `#bulk_edit`, `#generate_barcodes`) como `ui-btn-secondary`. Tabla (`#table_holder`)
    envuelta en `ui-card`. Se mantuvieron EXACTOS todos los IDs/names/estructura de
    datos que usa `manage_tables.js`/`table_support.init()`.
  - `#table`/`#toolbar` son manipulados en runtime por el plugin bootstrap-table (mueve
    el contenido de `#toolbar` dentro de su propio `.fixed-table-toolbar`, y agrega sus
    propios botones de columnas/export y paginación que NO existen en el .php). No se
    puede darle clases `ui-*` a ese HTML porque no lo escribimos nosotros - se agregó una
    sección nueva en `components.css` con selectores descendientes scoped a
    `#table_holder`/`#toolbar` apuntando a las clases reales que bootstrap-table/
    bootstrap-select ya ponen (`.fixed-table-toolbar`, `.pagination`, `.dropdown-menu`,
    `.columns .btn`, `.export .btn`, `table.table thead/tbody`), con `!important` (mismo
    motivo de cascade layers que el resto del archivo). Documentado en el comment del
    bloque para que quede claro por qué rompe la regla de prefijo `ui-` (no hay otra
    forma de tocar DOM que no existe en el HTML servido).
  - **Bug evitado a tiempo**: el input `#daterangepicker` recibe un `width: 180px` por
    JS inline (`$('#daterangepicker').css("width", "180")` en
    `partial/daterangepicker.php`) DESPUÉS de cargar. Un `!important` en una clase
    Tailwind (`!w-auto`/`!w-full`) le gana a un estilo inline SIN `!important`, así que
    casi se pisaba el ancho que pone el plugin. Se resolvió no declarando ningún ancho
    en las clases custom de ese input (solo borde/padding/foco), dejando que el inline
    style de JS controle el ancho como siempre. Anotado como caso general: antes de
    forzar `!w-*` en un input que algún plugin JS toca con `.css()`/`.width()`, verificar
    que no le esté peleando al inline style.
  - Verificado con Playwright (login real + screenshot desktop 1440px y mobile 390px):
    toolbar, botones, tabla con datos reales, dropdown de filtros (bootstrap-select) y
    columnas/export de bootstrap-table ya con la piel de la marca. Modal "New Item" abre
    correctamente (BootstrapDialog) - el contenido interno (`form.php`) queda pendiente,
    es la siguiente vista del Fase 2.7.
  - Mobile: tabla sigue siendo tabla real con scroll horizontal (mismo patrón ya
    aceptado en Sales/POS), toolbar se reacomoda en columna.
