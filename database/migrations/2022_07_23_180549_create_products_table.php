<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('description')->nullable();
            $table->integer('store_id');
            $table->integer('provider_id')->nullable();
            $table->integer('category_id');
            $table->integer('state_id')->nullable();
            $table->string('color')->nullable();
            $table->integer('size')->nullable();
            $table->integer('fee', false);

            $table->double('price')->nullable();
            $table->double('cost')->nullable();


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
