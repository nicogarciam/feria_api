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
        // Table payment_states already exists in the database
        // This migration was previously executed, we're just marking it as completed
        if (!Schema::hasTable('payment_states')) {
            Schema::create('payment_states', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('color');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_states');
    }
};
