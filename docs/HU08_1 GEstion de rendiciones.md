
# HU-08_1-BE: Gestión de Rendiciones a Proveedores

**Estado:** 🟡 Pendiente  
**Prioridad:** Media  

## Historia de Usuario
Como Desarrollador Backend,  
quiero implementar las migraciones de base de datos y los endpoints REST necesarios para la gestión de rendiciones a proveedores, incluyendo un endpoint que liste los proveedores con sus montos pendientes a rendir para un período determinado,  
para que el frontend pueda consumir la información de forma eficiente y mantener la consistencia de los datos.

## Criterios de Aceptación

### 1. Migraciones de base de datos

Se deben crear las siguientes tablas (naming en español o inglés, según estándar del proyecto):

- **`providers`** (ya existente, se asume)
- **`settlements`** (rendiciones)
  - `id` (PK, autoincremental)
  - `provider_id` (FK → providers.id)
  - `start_date` (date, not null)
  - `end_date` (date, not null)
  - `total_sales` (decimal(12,2), not null) → suma de ventas brutas del período
  - `amount_to_pay` (decimal(12,2), not null) → monto calculado a pagar al proveedor
  - `status` (enum o string: 'pending', 'paid', 'cancelled')
  - `generated_at` (timestamp)
  - `generated_by` (user id, opcional)
  - `paid_at` (timestamp, nullable)
  - `cancelled_at` (timestamp, nullable)

- **`settlement_details`** (detalle de ventas incluidas en la rendición)
  - `id` (PK)
  - `settlement_id` (FK → settlements.id)
  - `sale_item_id` (FK → order_items.id) o `sale_id` según modelo
  - `sale_amount` (decimal(12,2)) → monto de la venta
  - `product_fee` (decimal(5,2)) → % del proveedor en ese producto
  - `calculated_amount` (decimal(12,2)) → monto para el proveedor por esta venta
  - Índice: `(settlement_id)`

- **Agregar columna a la tabla de ventas o items de pedido** (ej. `sale_items`):
  - `settled` (boolean, default false) → indica si ya fue rendido
  - `settlement_id` (FK a settlements.id, nullable) → para trazabilidad

**Reglas de migración:**
- Las migraciones deben ser reversibles (down).
- Se deben agregar las restricciones de clave foránea con `ON DELETE RESTRICT`.

### 2. Endpoints REST

#### 2.1. Listado paginado y filtrado de rendiciones

```
GET /api/settlements
```

**Query params:**
- `page` (default 1)
- `limit` (default 10, max 100)
- `provider_id` (opcional)
- `start_date` (opcional, ISO date, filtro por `generated_at >= start_date`)
- `end_date` (opcional, `generated_at <= end_date`)
- `status` (opcional: pending, paid, cancelled)
- `sort_by` (opcional: `generated_at`, `total_sales`, `amount_to_pay`)
- `sort_order` (asc/desc)

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "provider": { "id": 5, "name": "Proveedor A" },
      "start_date": "2026-04-01",
      "end_date": "2026-04-30",
      "total_sales": 15000.00,
      "amount_to_pay": 1500.00,
      "status": "pending",
      "generated_at": "2026-05-01T10:00:00Z"
    }
  ],
  "meta": { "total": 45, "page": 1, "last_page": 5 }
}
```

#### 2.2. Previsualización de rendición (sin guardar)

```
GET /api/settlements/preview
```

**Query params:**
- `provider_id` (obligatorio)
- `start_date` (obligatorio)
- `end_date` (obligatorio)

**Response:**
```json
{
  "provider_id": 5,
  "provider_name": "Proveedor A",
  "start_date": "2026-04-01",
  "end_date": "2026-04-30",
  "total_sales": 15000.00,
  "amount_to_pay": 1500.00,
  "details": [
    {
      "order_item_id": 101,
      "order_id": 1001,
      "sale_date": "2026-04-15",
      "sale_amount": 500.00,
      "provider_percentage": 10.00,
      "calculated_amount": 50.00
    }
  ]
}
```

- Si no hay ventas no rendidas, `total_sales` y `amount_to_pay` = 0, `details` = [].

#### 2.3. Crear una rendición

```
POST /api/settlements
```

**Body:**
```json
{
  "provider_id": 5,
  "start_date": "2026-04-01",
  "end_date": "2026-04-30"
}
```

**Validaciones:**
- El proveedor debe existir.
- El rango de fechas no debe solapar con otra rendición existente para el mismo proveedor (mismo rango o rangos que se superpongan, según regla de negocio: se permite rendir períodos no superpuestos).
- Debe existir al menos una venta no rendida en ese rango para ese proveedor.
- El cálculo de `total_sales` y `amount_to_pay` se realiza automáticamente en el backend (basado en `order_items` no rendidos del proveedor en el rango).

**Response exitoso (201):**
```json
{
  "id": 10,
  "message": "Rendición generada correctamente",
  "settlement": { ... }
}
```

**Efectos secundarios:**
- Marcar las ventas incluidas como `settled = true` y asignar `settlement_id`.
- Registrar `generated_at` y `generated_by` (desde token de autenticación).

#### 2.4. Obtener detalle de una rendición

```
GET /api/settlements/{id}
```

**Response:** similar a la previsualización, pero incluye `status`, `generated_at`, `generated_by`, y opcionalmente `paid_at`, `cancelled_at`.

#### 2.5. Anular una rendición (solo si status = pending)

```
DELETE /api/settlements/{id}
```

- Cambia status a `cancelled`.
- Revertir `settled = false` y `settlement_id = null` en las ventas asociadas.
- Registrar `cancelled_at` y opcionalmente `cancelled_by`.

#### 2.6. **Endpoint adicional:** Proveedores con montos a rendir para un plazo determinado

```
GET /api/providers/pending-settlement
```

**Query params:**
- `start_date` (ISO date, si esta vacio toma la fecha de la ultima rendicion para cada proveedor)
- `end_date` (ISO date, fecha de hoy)

**Propósito:** Retornar una lista de todos los proveedores que tienen al menos una venta no rendida en el período, con el total de ventas y el monto a pagar calculado para cada uno.

**Response:**
```json
{
  
  "providers": [
    
    {
      "provider_id": 5,
      "provider_name": "Proveedor A",
      "total_sales_pending": 15000.00,
      "amount_to_pay": 1500.00,
      "sales_count": 12,
        "period": {
        "start_date": "2026-04-01",
        "end_date": "2026-04-30"
      },
    },
    {
      "provider_id": 8,
      "provider_name": "Proveedor B",
      "total_sales_pending": 8000.00,
      "amount_to_pay": 800.00,
      "sales_count": 5
      "period": {
        "start_date": "2026-04-01",
        "end_date": "2026-04-30"
      },
    }
  ]
}
```

- Si un proveedor no tiene ventas pendientes en el período, no aparece en la lista.
- El cálculo debe ser idéntico al usado en el endpoint de previsualización (`/settlements/preview`), pero agrupado por proveedor.

**Uso desde el frontend:** Este endpoint puede ser utilizado para mostrar un resumen rápido antes de seleccionar un proveedor específico, o para generar rendiciones masivas (varios proveedores a la vez).

## Reglas de negocio implementadas en backend

- **No duplicar rendiciones:** Validar que no exista otra rendición (activa o anulada) con el mismo proveedor y rangos de fechas solapados. La regla exacta: no se puede rendir un período que ya fue total o parcialmente rendido. Se recomienda implementar una función que verifique si alguna venta del rango ya tiene `settled = true`.
- **Monto a pagar:** Se calcula como `sum( (sale_amount * provider_percentage) / 100 )` sobre cada `order_item` asociado a productos de ese proveedor.
- **Solo ventas pagadas/confirmadas:** (opcional) Solo considerar pedidos con estado "pagado" o "completado", no pedidos pendientes.

## Notas técnicas

- Usar transacciones de base de datos al crear o anular una rendición para asegurar consistencia.
- Los cálculos deben realizarse a nivel de base de datos (consultas agregadas) para eficiencia, no en el lenguaje de aplicación.
- Implementar rate limiting y validación de permisos (solo roles administrador/finanzas).
- Documentar la API con OpenAPI/Swagger.
