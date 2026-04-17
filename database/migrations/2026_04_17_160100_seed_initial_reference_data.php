<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('sale_states')->insert([
            ['id' => 1, 'name' => 'NEW', 'color' => '#fcfb7c', 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 2, 'name' => 'CONFIRMED', 'color' => '#ffffff', 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 3, 'name' => 'PAID', 'color' => '#ffffff', 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 4, 'name' => 'CANCELED', 'color' => '#ffffff', 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 5, 'name' => 'CART', 'color' => '#ffffff', 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => 6, 'name' => 'CLOSED', 'color' => '#6d6d6e', 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
        ]);

        DB::table('product_states')->insert([
            ['id' => 1, 'name' => 'disponible', 'created_at' => null, 'deleted_at' => null, 'updated_at' => null, 'color' => 'rgb(96,212,96)'],
            ['id' => 2, 'name' => 'prueba', 'created_at' => null, 'deleted_at' => null, 'updated_at' => null, 'color' => 'rgb(68,183,57,87%)'],
            ['id' => 3, 'name' => 'vendido', 'created_at' => null, 'deleted_at' => null, 'updated_at' => null, 'color' => 'rgb(68,183,57,87%)'],
        ]);

        DB::table('payment_states')->insert([
            ['id' => 1, 'name' => 'new', 'description' => null],
            ['id' => 2, 'name' => 'canceled', 'description' => null],
        ]);

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'nicogarciam@gmail.com',
            'email' => 'nicogarciam@gmail.com',
            'email_verified_at' => null,
            'password' => '$2y$10$8X40L68U4NV4QNhVhZRhue5SQA1Ri04Awyi/Bw2bd2c1HO3IcJweu',
            'logins' => 93,
            'remember_token' => null,
            'created_at' => '2023-08-14 15:02:55',
            'updated_at' => '2026-04-15 09:28:14',
            'google_id' => '105090518397034388818',
            'role' => 'SUPER_ADMIN',
        ]);

        DB::table('accounts')->insert([
            'id' => 1,
            'first_name' => 'Nicolas',
            'last_name' => 'Garcia Martinez',
            'activated' => 0,
            'email' => 'nicogarciam@gmail.com',
            'langKey' => null,
            'city_id' => null,
            'gender' => null,
            'image_url' => 'https://lh3.googleusercontent.com/a/ACg8ocLU-5dR08l3d6s_YKhexpXThkpstBhSxcRXKWaq-USuR58sk9Zi7g=s96-c',
            'user_id' => 1,
            'deleted_at' => null,
            'dni' => null,
            'created_at' => '2023-08-14 15:02:55',
            'updated_at' => '2026-04-15 09:28:14',
            'address' => null,
            'phone' => null,
            'birthday' => null,
            'account_cod' => '$2y$10$Ypng51IcyS6f0Dhvlmdsj.MJjcipKJmVVo1F39Lmbqg9BJXNRuZie',
        ]);
    }

    public function down(): void
    {
        DB::table('accounts')->where('id', 1)->delete();
        DB::table('users')->where('id', 1)->delete();
        DB::table('payment_states')->whereIn('id', [1, 2])->delete();
        DB::table('product_states')->whereIn('id', [1, 2, 3])->delete();
        DB::table('sale_states')->whereIn('id', [1, 2, 3, 4, 5, 6])->delete();
    }
};
