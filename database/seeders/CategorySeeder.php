<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'HARDWARE',
                'description' => 'Masalah perangkat keras',
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                'name' => 'SOFTWARE',
                'description' => 'Masalah aplikasi dan sistem',
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                'name' => 'NETWORK',
                'description' => 'Masalah jaringan',
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                'name' => 'ACCOUNT',
                'description' => 'Masalah akun dan akses',
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                'name' => 'OTHER',
                'description' => 'Masalah lainnya',
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ]);
    }
}