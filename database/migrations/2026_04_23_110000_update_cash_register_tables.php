<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create withdrawals table
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->decimal('amount', 12, 2);
            $table->string('concept');
            $table->text('description')->nullable();
            $table->integer('store_id');
            $table->string('user');
            $table->integer('user_payee_id');
            $table->timestamps();
            $table->softDeletes();
        });

        // Update movements table to support withdrawals and settlements
        Schema::table('movements', function (Blueprint $table) {
            $table->unsignedBigInteger('withdrawal_id')->nullable();
            $table->unsignedBigInteger('settlement_id')->nullable();
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('movements', function (Blueprint $table) {
            $table->dropColumn(['withdrawal_id', 'settlement_id', 'description']);
        });

        Schema::dropIfExists('withdrawals');
    }
};
