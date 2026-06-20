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
