<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->bigInteger('id', true, true);
            $table->string('name', 100);
            $table->string('cuil', 255);
            $table->string('contact_name', 100);
            $table->string('email', 255);
            $table->string('phone', 150);
            $table->string('address', 255);
            $table->string('token', 255);
            $table->string('password', 100);
            $table->integer('fee', false);
            $table->integer('city_id', false);
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
        Schema::drop('providers');
    }
}
