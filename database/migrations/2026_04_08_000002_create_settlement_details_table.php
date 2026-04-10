<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlement_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settlement_id');
            $table->unsignedBigInteger('sale_item_id');
            $table->decimal('sale_amount', 12, 2);
            $table->decimal('product_fee', 5, 2);
            $table->decimal('calculated_amount', 12, 2);
            $table->timestamps();

            $table->foreign('settlement_id')->references('id')->on('settlements')->onDelete('cascade');
            $table->foreign('sale_item_id')->references('id')->on('sale_items')->onDelete('restrict');

            $table->index('settlement_id');
            $table->unique(['settlement_id', 'sale_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settlement_details');
    }
};
