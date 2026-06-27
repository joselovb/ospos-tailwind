# OSPOS Tailwind — Refactor Visual

Fork de OpenSourcePOS (v3.4.x, CodeIgniter 4 + PHP + MySQL) para un
rediseño visual completo con Tailwind CSS v4 + Alpine.js. Upstream
apunta a `opensourcepos/opensourcepos` para traer parches de seguridad
ocasionalmente.

> **NOTA DE RUTAS:** este repo usa CodeIgniter **4**, no 3. Las rutas
> reales son `app/Controllers`, `app/Models`, `app/Views`,
> `app/Config/Database.php` (no `application/...`). Las reglas duras
> abajo están escritas usando estas rutas reales — confirmado con el
> usuario.

## REGLAS DURAS - NUNCA ROMPER

1. NO toques `app/Controllers/**` bajo ninguna circunstancia.
2. NO toques `app/Models/**` bajo ninguna circunstancia.
3. NO toques `app/Config/Database.php` ni ningún archivo de config de
   conexión a base de datos.
4. NO ejecutes ninguna migración ni cambies el schema de la DB
   (`app/Database/Migrations/**`).
5. NO renombres ni muevas archivos dentro de `app/Views/**` — esto
   rompería el tracking de git para futuros merges con upstream.
6. NO toques los nombres de los `name=""` de inputs, los IDs usados por
   JS/AJAX existente, ni la estructura de los arrays de datos que el
   controller pasa a la vista (`$this->load->view`/`view()` con
   `$data`). El HTML alrededor cambia, pero los puntos de conexión con
   el backend se mantienen exactos.
7. OSPOS tiene una cláusula de licencia OBLIGATORIA: el footer con el
   texto "© [year] · opensourcepos.org · [version] - [commit hash]"
   (ver `app/Views/partial/footer.php`, usa `lang('Common.copyrights')`,
   `lang('Common.website')`, `config('App')->application_version`,
   `config(OSPOS::class)->commit_sha1`) DEBE permanecer visible, sin
   modificar su contenido/lógica, en cada página. Se puede rediseñar el
   contenedor visualmente pero el texto y su visibilidad se mantienen.
8. Si en algún momento dudas si algo es "solo visual" o "toca lógica",
   PARA y pregunta antes de proceder.
9. NUNCA uses nombres de color literales (rose-600, gold-500, etc.)
   directo en las clases de las Views. SIEMPRE usa los tokens
   semánticos definidos en "Sistema de diseño" (brand-primary,
   state-danger, etc.). Regla dura, no preferencia de estilo.

## MENTALIDAD DEL REFACTOR

Este NO es un ejercicio de "repintar". No es el mismo layout de
Bootstrap 3 con clases de Tailwind encima y otro color. Actuar como
diseñador de producto senior: repensar jerarquía visual, espaciado,
agrupación de información y flujo de cada pantalla — no solo colores.

Elementos esperados en cada vista:
- **Gradientes con intención**: CTAs principales, headers, cards
  destacadas/KPI, acentos premium. No "Tailwind plano" en todos lados.
- **Jerarquía visual real**: el elemento más importante de cada
  pantalla destaca por tamaño/peso/color/posición, no todo al mismo
  nivel.
- **Espaciado generoso y deliberado**: whitespace como herramienta de
  diseño; agrupar información relacionada en cards/secciones, no
  listas planas pegadas.
- **Micro-interacciones vivas**: hover/focus con transición suave,
  loading states (skeletons/spinners con la paleta), empty states
  diseñados.
- **Jerarquía tipográfica clara**: tamaños con propósito, texto
  secundario en `text-text-muted`, títulos que realmente jerarquizan.
- **Flujo, no solo formulario**: si la vista actual es "tabla gigante +
  botón guardar", repensar la organización (cards con resumen + detalle
  expandible, tabs, secciones colapsables) preservando los mismos
  datos y la misma conexión con el backend.
- **User-friendly por encima de todo**: cada pantalla más fácil de usar
  que la original, no solo más bonita. Proponer mejoras de flujo
  activamente en el resumen de cada vista (van a BACKLOG.md si están
  fuera de alcance).

Si en algún momento el cambio se siente como "solo cambiar clases de
color/borde sin tocar estructura", DETENERSE y repensar la composición
visual completa de esa pantalla primero.

## GESTIÓN DE MEMORIA PERSISTENTE

- **CLAUDE.md** (este archivo): la "constitución" del proyecto — reglas
  duras, arquitectura de theming, patrones de componentes, orden de
  migración. NO se edita por iniciativa propia de Claude. Solo cuando
  el usuario indique explícitamente un cambio de regla/decisión de
  fondo. Si Claude cree que algo debería cambiar, lo anota como
  propuesta en BACKLOG.md.
- **PROGRESS.md**: bitácora histórica, **append-only**. Una entrada por
  vista/componente completado, inmediatamente después de cada commit.
  Formato:
  ```
  ## [fecha y hora] - Vista: [nombre]
  - Archivos: [lista]
  - Estado: completo / bloqueado
  - Notas: [decisiones de diseño tomadas, dudas, etc.]
  ```
- **BACKLOG.md**: pendientes e ideas, vivo y editable (sí se puede
  reorganizar/marcar completado). Contiene: vistas pendientes del orden
  de migración, mejoras de UX/flujo identificadas pero fuera de
  alcance, deuda técnica visual, ideas multi-marca, propuestas de
  cambio a CLAUDE.md.

## TRABAJO NOCTURNO / SEMI-DESATENDIDO — REGLAS DE CHECKPOINT

1. Unidad de trabajo = una vista/componente completo del "Orden de
   migración". Nunca dejar una vista a medias entre commits — si se
   empieza, se termina (con testing básico de que carga sin errores
   PHP) antes de comitear y pasar a la siguiente.
2. Commit al terminar cada vista, no al final de la sesión.
3. Después de cada commit, entrada correspondiente en PROGRESS.md.
   Mejoras de UX fuera de alcance o decisiones no bloqueantes →
   BACKLOG.md. Si es bloqueante (duda sobre lógica, decisión de diseño
   irresoluble sola), anotar en PROGRESS.md como "BLOQUEADO" y
   detenerse ahí.
4. Si no hay certeza de poder terminar una vista completa en el
   presupuesto restante de la sesión, parar en el último commit limpio
   en vez de empezar una vista nueva.
5. Si la sesión se corta, lo peor que puede pasar es perder tiempo de
   espera — nunca código roto o a medio camino. Al reconectar, retomar
   leyendo PROGRESS.md y el último commit.

## STACK Y SETUP

- Tailwind CSS v4, sintaxis `@theme` (NO `tailwind.config.js` clásico)
- Compilado con Tailwind CLI standalone (`/usr/local/bin/tailwindcss`),
  sin Node/npm/Vite para el CSS nuevo (el proyecto ya tiene un pipeline
  gulp/npm para los assets legacy de Bootstrap 3 — no tocar ese
  pipeline, el nuevo Tailwind vive en paralelo)
- **Comando de build CORRECTO** (siempre usar `input.css` como entrada,
  NO `tokens.css` ni `components.css` directamente):
  `tailwindcss -i tailwind/input.css -o public/css/tailwind-build.css --minify`
  `input.css` importa tanto `tokens.css` como `components.css`. Sin él,
  los componentes `ui-*` no se compilan (bug silencioso, detectado 2026-06-27).
- Alpine.js (CDN o vendored) para interactividad ligera: menú mobile,
  dropdowns, transiciones, toggles — reemplaza lo que en otros stacks
  sería Framer Motion
- `tailwind/input.css` es el entry point del build. El usuario puede tener
  watch corriendo en tmux: `tailwindcss -i tailwind/input.css -o public/css/tailwind-build.css --watch`
  Claude puede hacer el build manual cuando sea necesario con el comando arriba.

## SISTEMA DE DISEÑO — ARQUITECTURA DE THEMING

Preparado para reusarse en otros negocios cambiando un solo archivo de
variables, sin tocar ninguna vista. Dos capas:

### Capa 1 — Paleta cruda (`theme-<negocio>.css`)

Único archivo que cambia entre negocios/marcas. Ejemplo (paleta
HerStudio, solo de referencia):

```css
@theme {
  --palette-primary-900: #7a2e45;
  --palette-primary-700: #93304f;
  --palette-primary-600: #b23a66;
  --palette-primary-500: #c25a7d;
  --palette-primary-400: #d88ba3;
  --palette-primary-200: #f0c7d3;
  --palette-primary-100: #fbe9ee;

  --palette-accent-600: #ab8531;
  --palette-accent-500: #c9a24b;
  --palette-accent-200: #e6d4a3;
  --palette-accent-100: #f3e8ce;

  --palette-bg: #fdf8f4;

  --palette-text-900: #2b1b20;
  --palette-text-500: #7d6b70;

  --palette-success-600: #557a5b;
  --palette-success-500: #6b8f71;
  --palette-success-100: #e3ede4;

  --palette-danger-600: #9b2c2c;
  --palette-danger-100: #f6e3e3;

  --font-display: "Playfair Display", serif;
  --font-sans: "Inter", system-ui, sans-serif;
}
```

### Capa 2 — Tokens semánticos (`tokens.css`)

Importa la paleta cruda y mapea a nombres semánticos basados en
función, no en color. No cambia entre negocios.

```css
@import "tailwindcss";
@import "./theme-herstudio.css"; /* única línea que cambiaría por negocio */

@theme {
  --color-brand-primary: var(--palette-primary-600);
  --color-brand-primary-hover: var(--palette-primary-700);
  --color-brand-primary-active: var(--palette-primary-900);
  --color-brand-primary-soft: var(--palette-primary-100);
  --color-brand-primary-border: var(--palette-primary-100);
  --color-brand-primary-ring: var(--palette-primary-400);

  --color-brand-accent: var(--palette-accent-500);
  --color-brand-accent-hover: var(--palette-accent-600);
  --color-brand-accent-soft: var(--palette-accent-100);

  --color-surface: #ffffff;
  --color-surface-muted: var(--palette-bg);

  --color-text-default: var(--palette-text-900);
  --color-text-muted: var(--palette-text-500);
  --color-text-on-brand: #ffffff;

  --color-state-success: var(--palette-success-600);
  --color-state-success-soft: var(--palette-success-100);
  --color-state-danger: var(--palette-danger-600);
  --color-state-danger-soft: var(--palette-danger-100);
}

body {
  font-family: var(--font-sans);
  background-color: var(--color-surface-muted);
  color: var(--color-text-default);
}
```

### REGLA OBLIGATORIA para todas las Views

Usar siempre clases semánticas (`bg-brand-primary`,
`text-brand-primary`, `border-brand-primary-border`,
`bg-state-danger-soft`, `text-state-danger`, etc.) — nunca un nombre de
color literal directo en una vista. Si Tailwind v4 no genera la
utilidad automáticamente, crearla en la Capa 2 o usar sintaxis
arbitraria `bg-[var(--color-brand-primary)]` antes que volver a un
color literal.

Cambiar de negocio = duplicar `theme-<negocio>.css` con otros hex,
cambiar el import en `tokens.css`. Cero cambios en las vistas.

### REGLA DURA - Tailwind vs Bootstrap (cascade layers)

Tailwind v4 envuelve TODAS sus utilidades en `@layer theme, base,
components, utilities;`. Bootstrap 3/5 y el resto del CSS legacy de
OSPOS (`ospos.css`, `register.css`, etc.) se cargan como hojas de
estilo NORMALES, sin `@layer`. Por la spec de CSS Cascade Layers, una
declaración SIN layer le gana SIEMPRE a una declaración CON layer en
un empate de importancia, sin importar la especificidad del selector.
Esto ya causó bugs reales (botones con colores de Bootstrap en vez de
la marca, `<nav>` que no se ocultaba en mobile, padding en 0 por un
`* { padding: 0 }` de `ospos.css`) - no es teórico, hay que prevenirlo
siempre, en cada vista:

1. **`tailwind/tokens.css` importa Tailwind con el modificador
   `important`** (`@import "tailwindcss" important;`, no
   `@import "tailwindcss";` a secas). Esto hace que toda clase de
   utilidad usada directo en el HTML (`px-4`, `hidden`, `md:flex`,
   etc.) salga con `!important` y le gane a cualquier regla no
   importante de Bootstrap/legacy. NO TOCAR este modificador.
2. **Toda clase de componente en `tailwind/components.css` lleva el
   prefijo `ui-`** (`.ui-btn-primary`, `.ui-alert-danger`, `.ui-card`,
   `.ui-input`, etc.) - nunca un nombre que pueda coincidir con
   vocabulario de Bootstrap (`btn-primary`, `btn-danger`, `btn-secondary`,
   `alert-danger`, `alert-success`, `alert-warning`, `modal-content`,
   `card`, etc.). El modificador `important` del punto 1 NO cubre estas
   clases (son `@apply` dentro de `@layer components`, no utilidades
   directas) - el prefijo es la única protección para ellas, son dos
   fixes complementarios.
3. **Dentro de cada `@apply` en `components.css`, TODA utilidad lleva el
   modificador `!` manualmente**: `@apply !inline-flex !px-4 !text-sm
   hover:!shadow-lg;`, nunca `@apply inline-flex px-4 text-sm
   hover:shadow-lg;` sin el `!`. Confirmado con Playwright: sin esto,
   propiedades como `padding`/`font-size`/`font-weight` de las clases
   `ui-*` seguían perdiendo contra reglas genéricas no-importantes de
   Bootstrap/`ospos.css` (ej. `* { padding: 0 }`) AUNQUE el nombre de
   clase ya tuviera el prefijo `ui-` del punto 2 - son fixes en capas
   distintas (utilidades directas en HTML vs. utilidades dentro de
   `@apply`), hay que aplicar los dos siempre, uno no sustituye al otro.
4. Después de cualquier cambio de vista: rebuild completo
   (`npm run build && tailwindcss build`) Y `sudo systemctl restart
   php8.3-fpm` - PHP-FPM puede servir versiones viejas en caché aunque
   el archivo en disco ya esté actualizado.
5. Verificar cambios visuales con Playwright (headless Chromium, ya
   instalado) en vez de solo `curl` - `curl` no ejecuta CSS/JS y no
   detecta ninguno de estos problemas.

## PATRONES DE COMPONENTES A REPLICAR

(Ejemplos con nombres de color literales solo como referencia de TONO —
al implementar, traducir siempre a tokens semánticos.)

1. **Inputs**: `border border-brand-primary-border rounded-xl px-4 py-2.5
   focus:outline-none focus:ring-2 focus:ring-brand-primary-ring transition`

2. **Botón primario**: `bg-gradient-to-br from-brand-primary to-brand-primary-hover
   text-text-on-brand py-3 rounded-xl font-medium shadow-md hover:shadow-lg
   hover:to-brand-primary-active transition-all disabled:opacity-50
   active:scale-[0.97]`

3. **Cards/paneles**: `bg-surface rounded-3xl shadow-xl` (o
   `rounded-2xl shadow-lg` para paneles internos),
   `border-brand-primary-border` en bordes sutiles. Cards destacadas:
   `bg-gradient-to-br from-surface to-brand-primary-soft` o franja
   superior `bg-gradient-to-r from-brand-primary to-brand-accent`.

4. **Header/nav**: `sticky top-0 z-20`, `bg-surface` o
   `bg-gradient-to-r from-surface to-brand-primary-soft`,
   `border-b border-brand-primary-border`, altura h-16, logo+nombre
   `font-display text-brand-primary-active`, activo
   `bg-brand-primary-soft text-brand-primary` vs inactivo
   `text-text-muted hover:text-brand-primary hover:bg-brand-primary-soft`.
   Avatar circular `bg-gradient-to-br from-brand-primary-soft to-brand-primary-border
   text-brand-primary`. Mobile: hamburguesa + Alpine
   (`x-data="{ open: false }"`, `x-show`, `x-transition`).

5. **Mensajes de error**: `text-state-danger bg-state-danger-soft
   rounded-lg text-sm text-center py-2 px-3`, Alpine `x-show` +
   `x-transition`.

6. **Autocomplete**: input con `focus:ring-brand-primary-ring`,
   dropdown `rounded-xl bg-surface shadow-lg border border-brand-primary-border`,
   opciones `hover:bg-brand-primary-soft`, texto secundario
   `text-text-muted text-xs`. Alpine.js + fetch a los mismos endpoints
   AJAX existentes.

7. **Animaciones Alpine**: `x-transition:enter="transition ease-out
   duration-300" x-transition:enter-start="opacity-0 translate-y-4"
   x-transition:enter-end="opacity-100 translate-y-0"`.

8. **Iconos**: reemplazar todos los iconos por SVG inline, estilo
   lineal minimalista (`stroke="currentColor" stroke-width="2"`, sin
   relleno), sin librería de iconos pesada.

## MOBILE-FIRST — REQUISITO CENTRAL

OSPOS actualmente NO es responsive. Objetivo principal, no extra:

- Nav/sidebar: colapsa a hamburguesa en mobile (breakpoint `md:`)
- Tablas densas (ventas, inventario, reportes): en mobile NO achicar la
  tabla — rediseñar como cards apiladas o patrón "ver más detalles" que
  oculte columnas secundarias. Decidir caso por caso, priorizando info
  clave legible sin scroll horizontal.
- Inputs/botones: touch-friendly (mínimo ~44px alto en mobile)
- Diseñar primero para pantalla chica, expandir con `md:`/`lg:` para
  desktop.

## ORDEN DE MIGRACIÓN

**Fase 0 — Fundación** (primero, antes de cualquier vista de negocio):
1. Layout/template principal compartido
2. Header + nav (`app/Views/partial/header.php`, `header_js.php`) con
   colapso mobile
3. Footer (`app/Views/partial/footer.php`) — verificar texto de
   licencia intacto
4. Componentes genéricos: botones, inputs, alertas, modales base,
   paginación

**Fase 1 — Alta prioridad mobile:**
5. Pantalla de ventas/POS (`app/Views/sales`)
6. Login (`app/Views/login.php`)

**Fase 2 — Catálogo:**
7. Items/Inventario (`app/Views/items`)
8. Categorías

**Fase 3 — Clientes y reportes:**
9. Customers (`app/Views/customers`)
10. Reportes (`app/Views/reports`)

**Fase 4 — Resto:**
11. Configuración (`app/Views/configs`), empleados/usuarios
    (`app/Views/employees`, `app/Views/people`), proveedores
    (`app/Views/suppliers`), y demás vistas administrativas (taxes,
    receivings, attributes, expenses, expenses_categories, barcodes,
    cashups, item_kits, giftcards)

No avanzar a la siguiente vista sin un commit limpio y entrada en
PROGRESS.md de la anterior. En sesiones nocturnas/desatendidas se puede
avanzar de una vista a la siguiente sin esperar aprobación explícita,
documentando cada paso en PROGRESS.md. Si se necesita input real
(decisión de diseño ambigua, duda sobre si algo toca lógica), anotar en
PROGRESS.md como "BLOQUEADO — necesito tu input en: [pregunta]" y
detenerse ahí.

## FLUJO DE TRABAJO

- El usuario tiene `tailwindcss --watch` corriendo en tmux separado —
  Claude no necesita correr el build, solo editar `.php`/`.css`.
- Rama de trabajo: `develop`. Commits pequeños y descriptivos por
  vista/componente (ej. "refactor: header y nav con Tailwind + Alpine,
  mobile menu").
- Orden: este documento (CLAUDE.md) ya guardado → PASO 0 exploración
  (reportado en PROGRESS.md) → setup Tailwind → Fase 0 en adelante.

## NOTAS DE EXPLORACIÓN INICIAL (PASO 0)

- **Stack real**: CodeIgniter 4 (`app/Controllers`, `app/Models`,
  `app/Views`), no CI3 con `application/`.
- **Vistas**: `app/Views/<modulo>` por módulo (sales, items, customers,
  suppliers, reports, receivings, attributes, taxes, expenses,
  expenses_categories, barcodes, configs, cashups, people, employees,
  item_kits, giftcards, home, messages, errors) + `app/Views/partial`
  para includes compartidos + algunas vistas sueltas en la raíz de
  `app/Views` (ej. `login.php`).
- **Partials existentes** (`app/Views/partial/`): `header.php`,
  `header_js.php`, `footer.php`, y partials específicos de
  funcionalidad (`daterangepicker.php`, `dinner_tables.php`,
  `print_receipt.php`, `tax_codes.php`, `tax_categories.php`,
  `tax_jurisdictions.php`, `stock_locations.php`,
  `bootstrap_tables_locale.php`, `datepicker_locale.php`,
  `customer_rewards.php`, `table_filter_persistence.php`,
  `visibility_js.php`, `lang_lines.php`).
- **Layout principal**: `app/Views/partial/header.php` envuelve cada
  vista (abre `<html>`, `<head>`, navbar/topbar, abre `<div class="container">`)
  y `app/Views/partial/footer.php` la cierra (incluye el bloque de
  licencia obligatorio con `lang('Common.copyrights')`,
  `lang('Common.website')`, `application_version`, `commit_sha1`). Las
  vistas individuales hacen `view('partial/header')` ... contenido ...
  `view('partial/footer')`.
- **Assets actuales**: Bootstrap 3.4.1 vía temas Bootswatch
  (`public/resources/bootswatch/<theme>/bootstrap.min.css`, theme
  seleccionable por config), más CSS propio en `public/css/*.css`
  (`ospos.css`, `register.css`, `reports.css`, `login.css`, etc.). El
  pipeline de build es **Gulp** (`gulpfile.js`) con `gulp-inject`, que
  inyecta bloques `<!-- inject:debug:css -->` / `<!-- inject:prod:css -->`
  y sus equivalentes `:js` directamente en
  `app/Views/partial/header.php` (y bloques propios en
  `app/Views/login.php`). Esto significa que el `<head>` de
  `header.php` tiene marcadores gulp que NO deben romperse al
  rediseñar — el nuevo `tokens.css`/Tailwind se agrega como hoja
  adicional, sin tocar esos marcadores ni el pipeline gulp existente.
- **JS inline relevante**: `header_js.php` define el reloj en vivo
  (`#liveclock`), CSRF token wiring para `$.ajax`/`$.fn.submit`, y el
  logout vía AJAX (`#logout` click handler) — estos IDs/handlers deben
  conservarse igual si se rediseña el header.
- No existe aún ningún archivo Tailwind/Alpine en el repo — se crea
  desde cero en el setup.
