<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->date('pay_date');
            $table->integer('sale_id');
            $table->string('note');
            $table->string('pay_method');
            $table->string('pay_ref');



            $table->double('amount');
            $table->double('discount');

            $table->double('total');

            $table->string('coupon_code');

            $table->integer('payment_type_id');
            $table->integer('payment_state_id');

            $table->integer('user_id');

            $table->integer('bank_account_id');

            $table->integer('store_id');



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
        Schema::dropIfExists('payments');
    }
}
