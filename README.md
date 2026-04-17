# Feria API

API backend de Feria construida con Laravel 8.

## Requisitos

- PHP 8.3+
- Composer 2+
- MySQL 5.7+ o MySQL 8+
- Node.js 18+ y npm (solo si compilás assets)
- Servidor web (Apache o Nginx)

## Instalación local rápida

1. Instalar dependencias de PHP:
   ```bash
   composer install
   ```
2. Crear archivo de entorno:
   ```bash
   cp .env.example .env
   ```
3. Generar claves:
   ```bash
   php artisan key:generate
   php artisan jwt:secret
   ```
4. Configurar credenciales de base de datos en `.env`.
5. Ejecutar migraciones:
   ```bash
   php artisan migrate --force
   ```
6. Levantar servidor local:
   ```bash
   php artisan serve
   ```

## Producción paso a paso

### 1) Preparar servidor

- Crear un virtual host que apunte al directorio `public/` del proyecto.
- Habilitar HTTPS (certificado SSL).
- Instalar extensiones PHP requeridas por Laravel/MySQL (por ejemplo `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`).

### 2) Subir código

1. Clonar o copiar el proyecto en el servidor.
2. Entrar al directorio del proyecto.
3. Instalar dependencias sin paquetes de desarrollo:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

### 3) Configurar variables de entorno

1. Crear `.env` desde `.env.example`.
2. Completar al menos estas variables:

```env
APP_NAME=FeriaAPI
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=feria_prod
DB_USERNAME=usuario
DB_PASSWORD=clave_segura

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

JWT_SECRET=...
GEMINI_API_KEY=...
```

3. Generar claves si todavía no existen:
   ```bash
   php artisan key:generate --force
   php artisan jwt:secret --force
   ```

### 4) Base de datos

1. Crear base de datos y usuario con permisos mínimos necesarios.
2. Ejecutar migraciones:
   ```bash
   php artisan migrate --force
   ```

### 5) Permisos y directorios

Asegurar permisos de escritura para:

- `storage/`
- `bootstrap/cache/`

### 6) Optimización Laravel

Ejecutar en cada deploy:

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan view:cache
php artisan event:cache
```

Nota: no usar `php artisan route:cache` mientras exista un closure en `routes/web.php`.

### 7) Scheduler y procesos en segundo plano

Configurar cron del sistema para ejecutar scheduler cada minuto:

```cron
* * * * * cd /ruta/a/feria_api && php artisan schedule:run >> /dev/null 2>&1
```

Si en el futuro usás colas asíncronas (`QUEUE_CONNECTION=database` o `redis`), agregar un worker (Supervisor/systemd).

### 8) Health checks post-deploy

1. Verificar endpoint principal:
   - `GET https://tu-dominio.com/api/test`
2. Verificar documentación Swagger:
   - `https://tu-dominio.com/api/docs`
3. Revisar logs:
   - `storage/logs/laravel.log`

## Swagger API documentation

Swagger UI queda disponible cuando la aplicación está corriendo en:

- `http://127.0.0.1:8000/api/docs` (con `php artisan serve`)
- `http://localhost/feria_api/public/api/docs` (WAMP sirviendo desde `feria_api/public`)

Archivo JSON generado:

- `storage/docs/api-docs.json`

Configuración en `config/swaggervel.php`:

- `api-docs-route` => `/api/docs`
- `doc-dir` => `storage/docs`
- `auto-generate` => `true`

## MySQL Event/Cron mensual (opcional)

```sql
CREATE EVENT `eCreateFeeForAll`
ON SCHEDULE EVERY 1 MONTH STARTS '2021-07-01 00:00:00'
ON COMPLETION NOT PRESERVE ENABLE
DO CALL pCreateFeeForAll;

DELIMITER $$
CREATE PROCEDURE `pCreateFeeForAll`()
BEGIN
  DECLARE v_membership_id int;
  DECLARE v_fee_amount float;
  DECLARE v_discount int;
  DECLARE v_account_id int;
  DECLARE v_month varchar(50);
  DECLARE v_concept varchar(200);
  DECLARE done INT DEFAULT 0;

  DECLARE curMembresias CURSOR FOR
    SELECT m.id, m.fee_amount, m.discount, m.account_id
    FROM memberships m
    WHERE fee_config_id = 1;

  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;

  OPEN curMembresias;

  SET lc_time_names = 'es_AR';
  SELECT MONTHNAME(now()) INTO v_month;
  SET v_concept = CONCAT('Cuota - ', v_month);

  REPEAT
    FETCH curMembresias INTO v_membership_id, v_fee_amount, v_discount, v_account_id;

    INSERT INTO fees (concept, date, paid, amount, account_id, membership_id, created_at)
    VALUES (v_concept, now(), false, v_fee_amount, v_account_id, v_membership_id, now());

  UNTIL done END REPEAT;

  CLOSE curMembresias;
END$$
DELIMITER ;
```

## Comandos útiles de generación (InfyOm)

```bash
php artisan infyom:api_scaffold $MODEL --fromTable --tableName=$TABLE_NAME --forceMigrate
php artisan infyom:migration $MODEL --fromTable --tableName=$TABLE_NAME
php artisan infyom:rollback $MODEL_NAME api_scaffold
php artisan infyom:api_scaffold $MODEL_NAME --fieldsFile=file.json --datatables=true
# Ejemplo
php artisan infyom:api_scaffold FeeConfig --fieldsFile=FeeConfig.json --datatables=true
```

## Migraciones

```bash
php artisan migrate
php artisan generate:migrations
php artisan schema:dump --prune
```

## JWT

- Documentación: <https://jwt-auth.readthedocs.io/en/develop/auth-guard/>
