<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Generando Codigo

php artisan infyom:api_scaffold $MODEL --fromTable --tableName=$TABLE_NAME --forceMigrate
php artisan infyom:migration $MODEL --fromTable --tableName=$TABLE_NAME

php artisan infyom:rollback $MODEL_NAME api_scaffold

php artisan infyom:api_scaffold $MODEL_NAME --fieldsFile=file.json --datatables=true

 - php artisan infyom:api_scaffold FeeConfig --fieldsFile=FeeConfig.json --datatables=true


### Crear Migraciones

- php artisan migrate

- php artisan generate:migrations

write a "schema" file to your application's database/schema directory

- php artisan schema:dump --prune

## JWT

https://jwt-auth.readthedocs.io/en/develop/auth-guard/




## Swagger API documentation

Swagger UI is available when the application is running at:

- `http://127.0.0.1:8000/api/docs` (when using `php artisan serve`)
- `http://localhost/feria_api/public/api/docs` (when using WAMP and the project is served from `feria_api/public`)

The generated Swagger JSON file is stored at `storage/docs/api-docs.json`.

The route is configured in `config/swaggervel.php`:

- `api-docs-route` => `/api/docs`
- `doc-dir` => `storage/docs`
- `auto-generate` => `true`

If the UI does not load, make sure the Laravel server is running and refresh the page.

## My Sql Cron

CREATE EVENT `eCreateFeeForAll` ON SCHEDULE EVERY 1 MONTH STARTS '2021-07-01 00:00:00'
ON COMPLETION NOT PRESERVE ENABLE DO CALL pCreateFeeForAll;


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
DECLARE curMembresias CURSOR FOR SELECT m.id, m.fee_amount, m.discount, m.account_id
FROM memberships m
WHERE  fee_config_id = 1;
DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
OPEN curMembresias;

    SET lc_time_names = 'es_AR';
    SELECT MONTHNAME(now()) into v_month;
    set v_concept = concat('Cuota - ', v_month);

    REPEAT
        FETCH curMembresias INTO v_membership_id, v_fee_amount,v_discount,v_account_id;

        INSERT INTO fees
                   (concept, date, paid, amount, account_id, membership_id, created_at)
            VALUES (v_concept, now(), false, v_fee_amount, v_account_id, v_membership_id, now());

    UNTIL done END REPEAT;
    CLOSE curMembresias;
    END$$
DELIMITER ;



- server
  https://admin.alwaysdata.com/
- feriar
- Fe123qwe.
- DB: feriar_prod
