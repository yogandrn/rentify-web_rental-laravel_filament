<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stores')->insert([
            [
                'name' => 'MainStore',
                'slug' => 'main-store',
                'thumbnail' => 'assets/stores/2024/main-store.png',
                'address' => 'Jalan Sisingamangaraja No. 19A',
                'is_open' => true,
            ]
            ]);
    }
}
