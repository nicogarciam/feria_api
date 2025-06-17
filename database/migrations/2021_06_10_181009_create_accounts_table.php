<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
            $table->softDeletes();
            $table->string('dni', 50)->nullable();
            $table->timestamps();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('birthday')->nullable();
            $table->string('account_cod', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
