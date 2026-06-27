# TESTING BACKLOG

Checklist de QA para el tester. Organizado por módulo/feature. Marcar cada ítem
con `[x]` al verificar, o `[!]` si se detecta un bug (anotar descripción debajo).

Ambiente: `https://ospos-dev.josevaldivia.com` — usuario `admin` / `pointofsale`

---

## NAVEGACIÓN Y LAYOUT

### Sidebar (desktop)
- [ ] El sidebar arranca colapsado (solo íconos, ancho ~56px) o expandido según el último estado guardado en `localStorage`
- [ ] Al hacer clic en el botón `‹`/`›` del sidebar, alterna entre íconos-solo y íconos+texto con animación suave
- [ ] El estado (colapsado/expandido) persiste al refrescar la página
- [ ] Todos los ítems del menú tienen ícono Phosphor (no el SVG plano de colores antiguo)
- [ ] Los labels de texto desaparecen al colapsar y reaparecen al expandir (sin texto cortado)
- [ ] El ítem activo (módulo actual) se resalta visualmente (fondo `brand-primary-soft`)
- [ ] El sidebar queda `sticky` y no hace scroll con el contenido de la página

### Menú mobile (< md)
- [ ] En pantalla angosta no se ve el sidebar — se ve el botón hamburguesa en el top bar
- [ ] Al tocar el hamburguesa, se abre el drawer lateral desde la izquierda con animación
- [ ] Al tocar fuera del drawer (backdrop), se cierra
- [ ] Todos los ítems del menú están presentes en el drawer mobile
- [ ] El drawer tiene scroll si la lista de módulos no cabe en pantalla

### Top bar
- [ ] Logo y nombre de empresa visibles en el top bar
- [ ] Reloj en vivo (`#liveclock`) se actualiza cada segundo
- [ ] Botón de logout visible — al hacer clic, cierra sesión y redirige al login (GET, no POST)
- [ ] El top bar queda fijo (`sticky top-0`) al hacer scroll

### Footer de licencia
- [ ] En todas las páginas internas el footer muestra el texto de copyright, URL de opensourcepos.org, versión y commit hash
- [ ] El texto de licencia no está modificado (solo el contenedor es visual)

---

## HOME PAGE (`/home`)

- [ ] Hero: logo de empresa (o SVG OSPOS por defecto) con fondo blanco, centrado, grande
- [ ] Hero: nombre de empresa en tipografía display grande
- [ ] Hero: mensaje de bienvenida con el nombre del usuario logueado
- [ ] Widget reloj: muestra la hora actual `HH:MM:SS` y se actualiza cada segundo
- [ ] Widget fecha: muestra la fecha larga en el idioma del navegador (ej. "sábado, 28 de junio de 2026")
- [ ] Widget versión: muestra el número de versión de OSPOS
- [ ] Grid de accesos rápidos: muestra los módulos a los que el usuario tiene permiso
- [ ] Grid de accesos rápidos: **no** muestra `home` ni `office` (módulos de navegación interna)
- [ ] Cada card de acceso rápido tiene ícono Phosphor + nombre del módulo
- [ ] Al hacer clic en una card, navega al módulo correcto
- [ ] Con usuario vendedor (rol limitado): la grid muestra menos cards que con admin

## OFFICE PAGE (`/office`)
- [ ] Idéntico al Home en estructura y comportamiento (mismos 3 widgets + grid de accesos)
- [ ] El reloj y la fecha funcionan (IDs `office-clock` / `office-date`, sin conflicto con `home-clock`)

---

## TOAST NOTIFICATIONS

Verificar en cualquier módulo con operaciones CRUD (ej. Employees, Customers, Items).

- [ ] Toast de **éxito** (guardar/actualizar): fondo `state-success-soft` (verde suave del tema), texto `state-success` — **no** teal/verde brillante `#18bc9c` de Bootstrap
- [ ] Toast de **error** (fallo de validación o servidor): fondo `state-danger-soft`, texto `state-danger` — no rojo Bootstrap
- [ ] Toast de **advertencia** (si aplica): fondo `state-warning-soft`, texto `state-warning`
- [ ] Botón `×` para cerrar el toast visible y funcional
- [ ] El toast desaparece automáticamente después de unos segundos

> **Nota conocida:** inmediatamente después de guardar, la fila actualizada en la tabla
> destella en verde claro (`#e1ffdd`) durante ~5 segundos (animación jQuery hardcodeada
> en el JS legacy de OSPOS). Esto es comportamiento esperado, **no** es un bug del theme.

---

## TABLAS / LISTAS (bootstrap-table)

Verificar en cualquier vista "manage" con tabla: Employees, Customers, Suppliers, Items, etc.

- [ ] Encabezados de tabla: fondo `surface-muted`, texto uppercase pequeño `text-muted`
- [ ] Filas: borde inferior suave, fila alterna (`table-striped`) en `surface-muted/50`
- [ ] Hover de fila: fondo `brand-primary-soft/60` (no verde Bootstrap)
- [ ] **Fila seleccionada** (clic en checkbox o en la fila): fondo `brand-primary-soft` — **no** verde/teal
- [ ] Se puede seleccionar varias filas con los checkboxes
- [ ] Botón "Delete" / "Email" en toolbar se habilita solo cuando hay filas seleccionadas
- [ ] Paginación: links con estilo de marca (no Bootstrap default)
- [ ] Dropdowns "Columns" / "Export" con bordes y hover del tema
- [ ] Búsqueda en la tabla (campo search): input con estilo `ui-input`

---

## MODALES (BootstrapDialog)

Verificar en cualquier botón "New" / "Edit" que abre un modal.

- [ ] Header del modal: gradiente `brand-primary` → `brand-primary-hover` (no azul Bootstrap)
- [ ] Título del modal en blanco sobre el gradiente
- [ ] Botón `×` de cierre: visible en blanco (no invisible/negro)
- [ ] Cuerpo del modal: fondo `surface`, texto `text-default`
- [ ] Footer del modal: botón Submit con gradiente marca; botón Delete/Cancel con estilo outlined danger
- [ ] El modal tiene bordes redondeados y sombra
- [ ] Al cerrar el modal, la tabla se refresca correctamente

---

## MÓDULOS MIGRADOS — SMOKE TEST

Para cada módulo, abrir la vista principal y verificar que carga sin errores PHP y tiene el estilo del tema (no Bootstrap plano).

### Ventas / POS (`/sales`)
- [ ] Carga sin errores
- [ ] Botones y campos con estilo de marca
- [ ] Carrito funcional (agregar ítem, cambiar cantidad, finalizar venta)
- [ ] En mobile: vista adaptada (no tabla con scroll horizontal enorme)

### Login (`/`)
- [ ] Carga sin errores
- [ ] Formulario con estilo de marca (inputs, botón, logo)
- [ ] Con credenciales incorrectas: mensaje de error visible con estilo `state-danger`

### Items / Inventario (`/items`)
- [ ] Lista con tabla estilizada
- [ ] Modal "New Item" y "Edit" abren correctamente y tienen el estilo del modal
- [ ] Formulario de ítem (tabs: Basic Info, Prices, Taxes, Kit) carga sin errores

### Customers (`/customers`)
- [ ] Lista con tabla
- [ ] Modal "New Customer" funcional

### Employees (`/employees`)
- [ ] Lista con tabla
- [ ] Modal "New Employee" / editar empleado funcional
- [ ] Después de guardar: toast de éxito con colores del tema (no verde Bootswatch)
- [ ] Después de guardar: fila en tabla con highlight de marca (no verde Bootswatch)

### Suppliers (`/suppliers`)
- [ ] Lista con tabla; modal funcional

### Receivings (`/receivings`)
- [ ] Lista con tabla; formulario de receiving funcional

### Reports (`/reports`)
- [ ] Carga sin errores; gráficos/tablas visibles

### Configs (`/config`)
- [ ] Las ~18 sub-vistas de configuración cargan sin errores
- [ ] Formularios con inputs y botones del tema

### Taxes (`/taxes`)
- [ ] Manage + form funcionales

### Expenses (`/expenses`) y Expenses Categories (`/expenses_categories`)
- [ ] Manage + form funcionales

### Attributes (`/attributes`)
- [ ] Manage + form funcionales

### Cashups (`/cashups`)
- [ ] Manage + form funcionales

### Item Kits (`/item_kits`)
- [ ] Manage + form funcionales

### Gift Cards (`/giftcards`)
- [ ] Manage + form funcionales

---

## RESPONSIVE / MOBILE

- [ ] En mobile (375px): top bar no desborda, hamburguesa visible
- [ ] En mobile: el sidebar NO se ve (solo el drawer al abrir)
- [ ] En mobile: botones con altura mínima ~44px (touch-friendly)
- [ ] En tablet (768px): sidebar colapsado visible; contenido se expande bien
- [ ] En desktop (1280px+): sidebar expandido por defecto (si el usuario no lo colapsó)

---

## REGRESIONES A VIGILAR

- [ ] El texto de copyright/licencia en el footer sigue igual en TODAS las páginas (regla dura #7)
- [ ] Los `name=""` de los inputs y los IDs usados por JS no fueron modificados
- [ ] Las operaciones CRUD siguen funcionando (crear, editar, eliminar registros reales)
- [ ] El CSRF token sigue funcionando en formularios POST
- [ ] No hay errores de PHP en ninguna vista (revisar logs o encabezado de respuesta)
