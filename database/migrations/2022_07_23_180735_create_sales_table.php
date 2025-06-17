<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->integer('store_id');
            $table->integer('customer_id');

            $table->integer('sale_state_id');

            $table->date('date_sale');
            $table->date('date_pay');

            $table->string('note')->nullable();

            $table->integer('total_price');

            $table->string('coupon_code')->nullable();
            $table->integer('days_to_confirm')->nullable();
            $table->integer('days_to_cancel')->nullable();

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
        Schema::dropIfExists('sales');
    }
}
