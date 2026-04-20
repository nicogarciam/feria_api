<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->boolean('activated')->nullable();
            $table->string('email')->nullable();
            $table->string('langKey', 20)->nullable();
            $table->integer('city_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('dni', 50)->nullable();
            $table->timestamps();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('birthday')->nullable();
            $table->string('account_cod', 150)->nullable();
        });

        Schema::create('authorities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('authority', 30)->nullable();
        });

        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id');
            $table->string('bank', 125);
            $table->string('cbu', 125);
            $table->string('cvu', 125);
            $table->string('alias', 125);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('category_id')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('state');
            $table->string('country');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id');
            $table->string('code');
            $table->string('description');
            $table->double('limit_discount');
            $table->integer('category_id');
            $table->double('discount');
            $table->date('date_to');
            $table->string('state');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('dni')->nullable();
            $table->date('birthday')->nullable();
            $table->string('email');
            $table->string('address')->nullable();
            $table->string('token')->nullable();
            $table->string('password')->nullable();
            $table->integer('city_id')->nullable();
            $table->boolean('is_provider')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('phone', 30)->nullable();
            $table->integer('store_id')->nullable();
        });

        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id');
            $table->date('date_from');
            $table->date('date_to');
            $table->string('description');
            $table->double('limit_discount');
            $table->integer('category_id');
            $table->integer('product_id');
            $table->double('discount');
            $table->boolean('active');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 500)->nullable();
            $table->boolean('primary')->nullable();
            $table->integer('benefit_id')->nullable();
            $table->integer('store_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('event_id')->nullable();
            $table->string('src', 150)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('movements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->integer('sale_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->string('concept');
            $table->double('amount');
            $table->string('type');
            $table->string('state');
            $table->string('user');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('store_id')->nullable();
            $table->integer('pay_id')->nullable();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at')->nullable();
            $table->index('email');
        });

        Schema::create('payment_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('payment_id');
            $table->string('concept');
            $table->double('amount');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('date')->nullable();
            $table->boolean('paid')->nullable();
            $table->integer('ref_id')->nullable();
        });

        Schema::create('payment_states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->nullable();
            $table->text('description')->nullable();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('pay_date');
            $table->integer('sale_id');
            $table->string('note')->nullable();
            $table->double('amount');
            $table->double('discount')->nullable();
            $table->double('total')->nullable();
            $table->string('coupon_code')->nullable();
            $table->integer('payment_type_id')->nullable();
            $table->integer('payment_state_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('pay_method', 30)->nullable();
            $table->string('pay_ref', 50)->nullable();
            $table->integer('store_id')->nullable();
            $table->integer('bank_account_id')->nullable();
            $table->string('user', 100)->nullable();
            $table->string('concept')->nullable();
        });

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tokenable_type');
            $table->unsignedBigInteger('tokenable_id');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
            $table->index(['tokenable_type', 'tokenable_id']);
        });

        Schema::create('product_states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('color', 50)->nullable();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 200)->nullable();
            $table->string('code');
            $table->string('description')->nullable();
            $table->integer('store_id');
            $table->integer('provider_id')->nullable();
            $table->integer('category_id');
            $table->integer('state_id')->nullable();
            $table->string('color')->nullable();
            $table->integer('size')->nullable();
            $table->double('price')->nullable();
            $table->double('cost')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('fee')->nullable();
            $table->string('brand', 150)->nullable();
        });

        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('cuil')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('token')->nullable();
            $table->string('password')->nullable();
            $table->integer('city_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('fee')->nullable();
            $table->string('alias', 150)->nullable();
            $table->string('bank', 150)->nullable();
        });

        Schema::create('sale_states', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('color')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('sale_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event', 50)->nullable();
            $table->string('note')->nullable();
            $table->timestamp('date_from');
            $table->timestamp('date_to')->nullable();
            $table->integer('sale_id');
            $table->integer('state_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('user_email', 200)->nullable();
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_id');
            $table->integer('customer_id')->nullable();
            $table->integer('sale_state_id');
            $table->date('date_sale')->nullable();
            $table->date('date_pay')->nullable();
            $table->string('note')->nullable();
            $table->integer('total_price');
            $table->string('coupon_code')->nullable();
            $table->integer('days_to_confirm')->nullable();
            $table->integer('days_to_cancel')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('user', 50)->nullable();
            $table->string('code', 100)->nullable();
        });

        Schema::create('sales_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year')->nullable();
            $table->integer('h_id')->nullable();
            $table->integer('sec')->nullable();
            $table->string('code', 150)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('settlements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('provider_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_sales', 12, 2);
            $table->decimal('amount_to_pay', 12, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->timestamp('generated_at')->useCurrent();
            $table->unsignedBigInteger('generated_by')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->unsignedBigInteger('paid_by')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->timestamps();
            $table->integer('store_id')->nullable();
            $table->string('user', 200)->nullable();
            $table->integer('items_count')->nullable();

            $table->index('provider_id');
            $table->index('status');
            $table->index('generated_at');
            $table->index('generated_by');
            $table->index('paid_by');
            $table->index('cancelled_by');
        });

        Schema::create('sale_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sale_id');
            $table->integer('product_id');
            $table->double('price');
            $table->boolean('settled')->default(false);
            $table->unsignedBigInteger('settlement_id')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('status', 100)->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('settlement_id')->references('id')->on('settlements');
        });

        Schema::create('settlement_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('settlement_id');
            $table->unsignedBigInteger('sale_item_id');
            $table->decimal('sale_amount', 12, 2);
            $table->decimal('product_fee', 5, 2);
            $table->decimal('calculated_amount', 12, 2);
            $table->timestamps();

            $table->unique(['settlement_id', 'sale_item_id']);
            $table->index('sale_item_id');
            $table->index('settlement_id');
        });

        Schema::create('store_discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sale_id');
            $table->integer('discount_id');
            $table->string('description');
            $table->double('discount');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('address')->nullable();
            $table->double('latitud')->nullable();
            $table->double('longitud')->nullable();
            $table->integer('city_id');
            $table->integer('owner_id');
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('phone')->nullable();
            $table->string('state')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('user_store', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('store_id');
            $table->string('role');
            $table->boolean('active');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('logins')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->string('google_id', 50)->nullable();
            $table->string('role', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('users');
        Schema::dropIfExists('user_store');
        Schema::dropIfExists('stores');
        Schema::dropIfExists('store_discounts');
        Schema::dropIfExists('settlement_details');
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('settlements');
        Schema::dropIfExists('sales_codes');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('sale_statuses');
        Schema::dropIfExists('sale_states');
        Schema::dropIfExists('providers');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_states');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payment_states');
        Schema::dropIfExists('payment_items');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('movements');
        Schema::dropIfExists('images');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('authorities');
        Schema::dropIfExists('accounts');

        Schema::enableForeignKeyConstraints();
    }
};
