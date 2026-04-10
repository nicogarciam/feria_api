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
        $connection = Schema::getConnection();
        
        // Disable foreign key checks
        $connection->statement('SET FOREIGN_KEY_CHECKS=0;');
        
        try {
            Schema::table('sale_items', function (Blueprint $table) {
                if (!Schema::hasColumn('sale_items', 'settled')) {
                    $table->boolean('settled')->default(false)->after('price');
                }
                if (!Schema::hasColumn('sale_items', 'settlement_id')) {
                    $table->unsignedBigInteger('settlement_id')->nullable()->after('settled');
                }
            });

            // Check if foreign key already exists
            $dbName = $connection->getDatabaseName();
            $fkExists = $connection->select("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = ? AND TABLE_NAME = 'sale_items' AND CONSTRAINT_NAME = 'sale_items_settlement_id_foreign'", [$dbName]);
            
            if (empty($fkExists)) {
                $connection->statement('ALTER TABLE sale_items ADD CONSTRAINT sale_items_settlement_id_foreign FOREIGN KEY (settlement_id) REFERENCES settlements(id) ON DELETE RESTRICT;');
            }
        } finally {
            // Re-enable foreign key checks
            $connection->statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_items', function (Blueprint $table) {
            if (Schema::hasColumn('sale_items', 'settlement_id')) {
                $table->dropForeign(['settlement_id']);
                $table->dropColumn('settlement_id');
            }
            if (Schema::hasColumn('sale_items', 'settled')) {
                $table->dropColumn('settled');
            }
        });
    }
};
