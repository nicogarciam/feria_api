<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settlements', function (Blueprint $table) {
            $table->unsignedBigInteger('cash_account_id')->nullable()->after('store_id');
            $table->unsignedBigInteger('origin_user_id')->nullable()->after('cash_account_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settlements', function (Blueprint $table) {
            $table->dropColumn(['cash_account_id', 'origin_user_id']);
        });
    }
};
