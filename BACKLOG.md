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

## Deuda técnica visual / casos raros detectados

- El output compilado `public/css/tailwind-build.css` se versiona en git porque el
  pipeline Gulp existente no lo procesa (evita que un deploy se quede sin estilos si
  nadie corre `tailwindcss` manualmente). Si más adelante se agrega un build step de
  CI/CD, considerar mover esto a `.gitignore` y compilarlo en el pipeline en su lugar.
- No hay PHP/Docker disponible en el entorno de Claude para levantar la app y verificar
  visualmente cada vista tras los cambios - el testing real (visual, en browser) lo debe
  hacer el usuario. Claude solo puede verificar sintaxis/diffs mínimos y que el build de
  Tailwind compila sin errores.

## Ideas multi-marca / futuro

(ninguna por ahora)

## Propuestas de cambio a CLAUDE.md (no aplicadas, requieren aprobación del usuario)

(ninguna por ahora)
