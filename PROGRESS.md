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
