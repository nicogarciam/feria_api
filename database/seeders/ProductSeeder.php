<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//        DB::table('product')->insert([
//            'code' => '456',
//            'description' => 'descrip cion del producto',
//            'store_id' => 1,
//            'provider_id' => 1,
//            'category_id' => 3,
//            'state_id' => 1,
//            'color' => '#334455',
//            'size' => 23,
//            'price' => 9000,
//        ]);


        Product::factory()->count(50)
            ->create();

    }
}
