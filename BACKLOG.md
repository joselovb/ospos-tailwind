# BACKLOG

## Orden de migración

- [x] Fase 0.1 - Layout/template principal compartido
- [x] Fase 0.2 - Header + nav (mobile collapse)
- [x] Fase 0.3 - Footer (verificar licencia intacta)
- [x] Fase 0.4 - Componentes genéricos (botones, inputs, alertas, modales, paginación)
- [x] Fase 1.5 - Ventas/POS (app/Views/sales/register.php) - completa, con 2 rondas de
      feedback del usuario ya aplicadas (ver PROGRESS.md)
- [x] Fase 1.6 - Login (app/Views/login.php)
- [x] Fase 2.7 - Items/Inventario (app/Views/items) - completa (manage.php + todos los modales)
- [x] Fase 2.8 - Categorías - no existe vista dedicada (autocomplete en items/form.php)
- [x] Fase 3.9 - Customers (app/Views/customers + people/manage + people/form_basic_info)
- [x] Fase 3.10 - Reportes (app/Views/reports)
- [x] Fase 4.11a - Configuración/Configs (app/Views/configs/) - 18 vistas + 3 partials
- [x] Fase 4.11b - Empleados/usuarios (app/Views/employees/form.php)
- [x] Fase 4.11c - Proveedores (app/Views/suppliers/form.php)
- [x] Fase 4.11d - Taxes (app/Views/taxes — 5 vistas + 3 partials)
- [x] Fase 4.11e - Receivings (app/Views/receivings — form, receipt, receiving)
- [x] Fase 4.11f - Attributes (app/Views/attributes — manage, form, item)
- [x] Fase 4.11g - Expenses + expenses_categories (manage + form para ambos)
- [x] Fase 4.11h - Barcodes (barcode_sheet.php — NO tocado, página standalone de impresión)
- [x] Fase 4.11i - Cashups (manage + form)
- [x] Fase 4.11j - Item kits (manage + form)
- [x] Fase 4.11k - Giftcards (manage + form)

## Para empezar la próxima sesión (handoff)

- Ambiente vivo en `https://ospos-dev.josevaldivia.com` (admin/pointofsale). LAMP nativo,
  no Docker. Ver memoria del proyecto para detalles de infraestructura.
- **Antes de tocar cualquier vista nueva**, leer la memoria
  `tailwind_bootstrap_cascade_layers_bug.md` y aplicar su checklist desde el primer
  commit (prefijo `ui-` + `!` en cada utilidad de `@apply` + rebuild/restart php-fpm +
  verificar con Playwright, no solo curl). Ya causó 3 rondas de bugs visuales reales en
  esta sesión por no aplicarlo desde el principio.
- Hay un item de prueba ("Test", $35, item_id=1) y al menos un cliente de prueba
  ("Playwright Test") cargados en la DB de dev para poder ver tablas/carrito con datos
  reales - no son parte del refactor, son solo datos de QA.
- Scripts de Playwright usados para verificar (login + screenshot) están en `/tmp/`, NO
  versionados - se pierden entre sesiones, hay que recrearlos (patrón: login con
  admin/pointofsale, goto a la vista, screenshot fullPage).

## Decisiones pendientes / dudas para el usuario

- El footer de `login.php` (logo + nombre del software) nunca mostró el bloque de
  licencia completo (copyright/versión/commit) que sí tiene `partial/footer.php` en el
  resto de la app - es comportamiento preexistente de upstream, no algo introducido en
  este refactor, pero la regla dura #7 pide ese texto visible "en cada página". Confirmar
  con el usuario si hay que agregarlo también al footer de login, o si login queda exento
  a propósito (página pública/pre-login, distinta del resto del sistema).

## Mejoras de UX/flujo identificadas (fuera de alcance de la vista actual)

(ninguna por ahora — se va a llenar a medida que se migre cada vista)

## Deuda técnica visual / casos raros detectados

- **Sales/POS - tabla del carrito en mobile**: queda como tabla real con scroll
  horizontal (`overflow-x-auto`), no como cards apiladas, porque cada línea tiene un
  `<form>` independiente con handlers JS atados a la posición exacta en el DOM
  (`$(this).parents('tr').prevAll('form:first').submit()`). Revisar si conviene migrar a
  cards en mobile más adelante, ahora que sí hay forma de probarlo con Playwright.
- **Sales/POS - selects con bootstrap-select**: los dropdowns de modo/mesa/ubicación de
  stock/tipo de pago usan el plugin `bootstrap-select` (clase `selectpicker`), con su
  propio look de Bootstrap 3 por fuera del control de Tailwind. No se tocó para no
  arriesgar romper su inicialización JS. Pendiente decidir si se reemplaza por un
  `<select>` nativo + Tailwind (afecta varias vistas, no solo sales).
- `public/css/login.css` quedó sin usar (login.php ya no lo enlaza, sus selectores
  `.box-logo`/`.box-login`/`.container-login` no existen en el nuevo markup). No se
  borró por las dudas, se puede limpiar más adelante.
- `public/css/tailwind-build.css` se versiona en git (el pipeline Gulp no lo procesa) -
  si se agrega un build step de CI/CD más adelante, considerar moverlo a `.gitignore`.
- Cada `npm run build` (gulp) inyecta bloques de assets legacy en `header.php` y
  `login.php` (comportamiento normal). Revisar el diff de esos dos archivos antes de
  cada `git add` para no commitear ese ruido.

## Ideas multi-marca / futuro

(ninguna por ahora)

## Propuestas de cambio a CLAUDE.md (no aplicadas, requieren aprobación del usuario)

(ninguna por ahora)
