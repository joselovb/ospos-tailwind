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

## Decisiones pendientes / dudas para el usuario

(ninguna por ahora)

## Mejoras de UX/flujo identificadas (fuera de alcance de la vista actual)

(ninguna por ahora — se va a llenar a medida que se migre cada vista)

## Decisiones pendientes / dudas para el usuario (actualizado)

- `/configs` devolvió 404 en el ambiente de dev recién montado, mientras que
  `/sales`, `/items`, `/customers`, `/reports`, `/employees` respondieron 200. Revisar
  cuál es la ruta real del módulo de configuración antes de llegar a la Fase 4
  (Configuración) - puede ser simplemente otro nombre de ruta/controlador.

## Deuda técnica visual / casos raros detectados

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
