<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 50)->nullable();
            $table->boolean('primary')->nullable();
            $table->integer('benefit_id')->nullable();
            $table->integer('store_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('event_id')->nullable();
            $table->string('src', 150)->nullable();
            $table->timestamp('updated_at')->nullable();
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
        Schema::dropIfExists('images');
    }
}
