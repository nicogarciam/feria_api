<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->bigInteger('id', true, true);
            $table->date('date');
            $table->integer('sale_id', false)->nullable();
            $table->integer('store_id', false);
            $table->integer('customer_id', false)->nullable();
            $table->integer('account_id', false)->nullable();
            $table->integer('provider_id', false)->nullable();
            $table->integer('pay_id', false)->nullable();
            $table->string('concept', 150);
            $table->float('amount', 10, 0);
            $table->string('type', 50);
            $table->string('state', 50);
            $table->string('user', false);
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
        Schema::drop('movements');
    }
}
