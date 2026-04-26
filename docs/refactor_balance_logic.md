# Análisis y Propuesta de Refactorización: Funcionalidad de Balance

## 1. Contexto Actual
La funcionalidad de `balance` en `MovementAPIController` permite obtener un listado de movimientos y el saldo acumulado (previo y final) para un criterio determinado.

Actualmente, los movimientos se asocian a:
- `store_id`: Siempre presente (tenencia).
- `cash_account_id`: Cuenta de caja o banco.
- `user_id`: Usuario (empleado o socio) que tiene un crédito/débito.
- `customer_id` / `provider_id`: Clientes o proveedores.

### Comportamiento de doble entrada
En operaciones como retiros (`Withdrawal`), el sistema genera **dos movimientos**:
1. Un **DEBIT** asociado a la `cash_account_id` (sale dinero de la caja).
2. Un **CREDIT** asociado al `user_id` (el usuario ahora "debe" o tiene ese dinero a su cargo).

## 2. Problemas Identificados

### 2.1. Ambigüedad en la asignación por defecto
En `MovementAPIController.php` (líneas 56-62), si no llega un `cash_account_id`, el sistema busca la caja por defecto de la tienda y la asigna.
```php
if (!isset($for['cash_account_id'])) {
    $defaultAccount = MovementsService::getDefaultCashAccount($for['store_id']);
    if ($defaultAccount) {
        $for['cash_account_id'] = $defaultAccount->id;
    }
}
```
Esto es incorrecto si la intención es obtener el balance de un **Usuario** (`user_id`), ya que filtraría movimientos que tengan AMBOS (`user_id` Y `cash_account_id`), lo cual no suele ocurrir según la lógica de `MovementsService`.

### 2.2. Lógica dispersa
- La suma algebraica (DEBIT/CREDIT) está en `MovementRepository->balance` usando `selectRaw`.
- El cálculo del balance acumulado línea por línea está en un bucle en el controlador.
- La lógica de "qué filtrar" depende de un array `$for` que se pasa directamente a `where()`.

## 3. Propuesta de Refactorización

### 3.1. Definición de "Sujeto" del Balance
El balance debe tener un sujeto claro. Proponemos que la API reciba un parámetro `subject_type` y `subject_id` (o inferirlo de los parámetros enviados).

**Prioridad de filtrado:**
### 3.1. Definición de "Sujeto" del Balance
Para que el balance sea preciso, debemos identificar qué entidad estamos balanceando.

**Lógica de Selección:**
1. Si se provee un `subject_id` específico (`user_id`, `customer_id`, `provider_id`, `cash_account_id`), ese es el sujeto.
2. Si solo se provee `store_id`, se asume **Balance de Tienda** y se utiliza la **Caja por Defecto** como sujeto del saldo.

### 3.2. Diferenciación entre Filtro de Consulta y Filtro de Saldo (Requerimiento Especial)
Para el **Balance de Tienda**, existe un requerimiento particular:
- **Consulta**: Se deben devolver **todos** los movimientos de la tienda (para visibilidad completa).
- **Saldo**: Solo los movimientos de la **Caja por Defecto** deben afectar el cálculo del saldo, créditos y débitos.

Esto implica que en el bucle de cálculo, debemos verificar si cada movimiento pertenece al sujeto del balance antes de sumarlo/restarlo al acumulado.

### 3.3. Implementación en el Controlador
Aunque idealmente esto debería ir a un servicio, por el momento se mantendrá en `MovementAPIController` para facilitar la transición y pruebas.

#### Propuesta de Código en el Controlador:
```php
public function balance(Request $request) {
    $for = $request->get('for', []);
    $storeId = $for['store_id'] ?? session('store_id');
    
    // 1. Identificar Sujeto y Criterios
    $balanceCriteria = ['store_id' => $storeId];
    $queryCriteria = ['store_id' => $storeId];
    
    $subjects = ['user_id', 'customer_id', 'provider_id', 'cash_account_id'];
    $foundSubject = null;
    foreach ($subjects as $s) {
        if (isset($for[$s])) { $foundSubject = $s; break; }
    }

    if (!$foundSubject) {
        // Balance de Tienda: Sujeto = Caja por Defecto
        $defaultAccount = MovementsService::getDefaultCashAccount($storeId);
        $balanceCriteria['cash_account_id'] = $defaultAccount->id;
        // queryCriteria queda solo con store_id para traer todo
    } else {
        // Balance Específico: Sujeto = Filtro enviado
        $balanceCriteria[$foundSubject] = $for[$foundSubject];
        $queryCriteria[$foundSubject] = $for[$foundSubject];
    }

    // 2. Obtener Balance Previo y Movimientos
    $balance_prev = $this->movementRepository->balance(null, $date_from, $balanceCriteria);
    $movements = $this->movementRepository->allBetween($date_from, $date_to, $queryCriteria);

    // 3. Bucle de Acumulación Condicional
    $balance_acum = $balance_prev;
    foreach ($movements as $move) {
        if ($move->matchesCriteria($balanceCriteria)) {
            $balance_acum = $move->calculateBalance($balance_acum);
        }
        $move->balance = $balance_acum;
    }
}
```

### 3.4. Mejoras en el Modelo `Movement`
Añadir un método auxiliar para verificar si un movimiento coincide con los criterios de balance:
```php
public function matchesCriteria($criteria) {
    foreach ($criteria as $key => $value) {
        if ($this->getAttribute($key) != $value) return false;
    }
    return true;
}
```

## 4. Beneficios
- **Claridad**: Evita que un balance de usuario se vea afectado por filtros de caja.
- **Mantenibilidad**: Toda la lógica de "qué suma y qué resta" reside en un solo lugar.
- **Escalabilidad**: Es fácil añadir nuevos sujetos de balance (ej. transportistas, socios) siguiendo el mismo patrón.

---
*Análisis realizado para la refactorización de MovementAPIController.*
