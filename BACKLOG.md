# BACKLOG

## Orden de migración pendiente (ver CLAUDE.md para detalle completo)

- [ ] Fase 0.1 - Layout/template principal compartido
- [ ] Fase 0.2 - Header + nav (mobile collapse)
- [ ] Fase 0.3 - Footer (verificar licencia intacta)
- [ ] Fase 0.4 - Componentes genéricos (botones, inputs, alertas, modales, paginación)
- [ ] Fase 1.5 - Ventas/POS (app/Views/sales)
- [ ] Fase 1.6 - Login (app/Views/login.php)
- [ ] Fase 2.7 - Items/Inventario (app/Views/items)
- [ ] Fase 2.8 - Categorías
- [ ] Fase 3.9 - Customers (app/Views/customers)
- [ ] Fase 3.10 - Reportes (app/Views/reports)
- [ ] Fase 4.11 - Configuración, empleados/usuarios, proveedores, y resto
      (taxes, receivings, attributes, expenses, expenses_categories,
      barcodes, cashups, item_kits, giftcards)

## Nota importante para sesiones futuras

- Se descubrió y arregló un bug estructural (Tailwind perdía contra Bootstrap por CSS
  Cascade Layers - ver memoria `tailwind_bootstrap_cascade_layers_bug.md` y la nueva
  sección en CLAUDE.md). El fix (`important` global + prefijo `ui-` en componentes) ya
  se aplicó a header/login/sales (las 3 vistas hechas hasta ahora) y se verificó con
  Playwright que quedaron visualmente correctas. Las vistas NUEVAS de acá en adelante ya
  nacen con el fix aplicado (no hace falta repetirlo), pero hay que seguir el checklist
  de la memoria en cada una (rebuild + restart php-fpm + verificar con Playwright, no
  solo curl).

## Decisiones pendientes / dudas para el usuario

(ninguna por ahora)

## Mejoras de UX/flujo identificadas (fuera de alcance de la vista actual)

(ninguna por ahora — se va a llenar a medida que se migre cada vista)

## Decisiones pendientes / dudas para el usuario (actualizado)

- ~~`/configs` devolvió 404...~~ RESUELTO: el controlador se llama `Config` (singular,
  `app/Controllers/Config.php`), la ruta real es `/config`, no `/configs`. Confirmado con
  curl que responde 200 logueado. Ahí está la opción para subir el logo real de la
  empresa (`company_logo`, usado en recibos/facturas y ahora en header+login).
- El footer de `login.php` (logo + nombre del software) nunca mostró el bloque de
  licencia completo (copyright/versión/commit) que sí tiene `partial/footer.php` en el
  resto de la app - es comportamiento preexistente de upstream, no algo introducido en
  este refactor, pero la regla dura #7 pide ese texto visible "en cada página". Confirmar
  con el usuario si hay que agregarlo también al footer de login, o si login queda exento
  a propósito (página pública/pre-login, distinta del resto del sistema).

## Deuda técnica visual / casos raros detectados (login)

- `public/css/login.css` quedó sin usar (la vista `login.php` rediseñada ya no enlaza ese
  archivo, sus selectores `.box-logo`/`.box-login`/`.container-login` no existen en el
  nuevo markup). No se borró el archivo por las dudas, pero se puede limpiar más adelante
  si se confirma que nada más lo referencia.

## Deuda técnica visual / casos raros detectados

- **Sales/POS - tabla del carrito en mobile**: por ahora queda como tabla real con scroll
  horizontal (`overflow-x-auto`), no como cards apiladas, porque cada línea tiene un
  `<form>` independiente con handlers JS atados a la posición exacta en el DOM
  (`$(this).parents('tr').prevAll('form:first').submit()`) y no había forma de probar en
  un navegador real que una reestructuración a cards no rompiera esos handlers. Si en
  algún momento se puede probar con un navegador de verdad (Playwright, o el usuario
  mismo testeando en vivo), vale la pena revisar si se puede migrar a cards en mobile.
- **Sales/POS - selects con bootstrap-select**: los dropdowns de modo/mesa/ubicación de
  stock/tipo de pago usan el plugin `bootstrap-select` (clase `selectpicker`), que pinta
  su propio dropdown con CSS de Bootstrap 3 por fuera del control de Tailwind. No se
  tocó para no arriesgar romper su inicialización JS. Pendiente decidir si en algún
  punto se reemplaza por un `<select>` nativo + estilos Tailwind (cambio de mayor
  alcance, afecta varias vistas que usan el mismo patrón, no solo sales).
- **Sales/POS - sin datos de prueba**: la DB de dev está vacía, así que no se pudo
  verificar visualmente el carrito con items reales, ni las secciones de pago/checkout
  que solo aparecen cuando `count($cart) > 0`. Recomendado: cargar un item de prueba y
  revisar ese flujo completo en el navegador.
- El output compilado `public/css/tailwind-build.css` se versiona en git porque el
  pipeline Gulp existente no lo procesa (evita que un deploy se quede sin estilos si
  nadie corre `tailwindcss` manualmente). Si más adelante se agrega un build step de
  CI/CD, considerar mover esto a `.gitignore` y compilarlo en el pipeline en su lugar.
- ~~No hay PHP/Docker disponible...~~ RESUELTO: se montó un ambiente LAMP nativo (sin
  Docker, a pedido del usuario) - ver entrada "Setup ambiente de desarrollo local" en
  PROGRESS.md. La app corre en `http://localhost:8090` (login admin/pointofsale). Esto
  permite verificar con curl/HTTP que cada vista carga sin error 500, aunque la
  verificación VISUAL real en navegador sigue siendo necesaria y la debe hacer el usuario
  (Claude no tiene navegador).
- Cada vez que se corre `npm run build` (gulp) localmente, inyecta bloques de assets
  legacy directo en `app/Views/partial/header.php` y `app/Views/login.php` (comportamiento
  normal del proyecto). Hay que tener cuidado de NO commitear ese ruido al hacer commit de
  una vista - revisar el diff de esos dos archivos antes de cada `git add`.

## Ideas multi-marca / futuro

(ninguna por ahora)

## Propuestas de cambio a CLAUDE.md (no aplicadas, requieren aprobación del usuario)

(ninguna por ahora)
