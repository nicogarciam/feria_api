<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('address')->nullable();;
            $table->double('latitud')->nullable();;
            $table->double('longitud')->nullable();;
            $table->integer('city_id')->nullable();;
            $table->integer('owner_id');

            $table->string('facebook')->nullable();;
            $table->string('instagram')->nullable();;
            $table->string('phone')->nullable();;
            $table->string('state')->nullable();;

            $table->string('logo')->nullable();;

            $table->text('description')->nullable();;

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
        Schema::dropIfExists('stores');
    }
}
