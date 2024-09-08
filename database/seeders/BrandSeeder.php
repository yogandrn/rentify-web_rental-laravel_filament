<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'logo' => 'assets/logo/apple.png',
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'logo' => 'assets/logo/samsung.png',
            ],
            [
                'name' => 'Huawei',
                'slug' => 'huawei',
                'logo' => 'assets/logo/huawei.png',
            ],
            [
                'name' => 'Sony',
                'slug' => 'sony',
                'logo' => 'assets/logo/sony.png',
            ],
            [
                'name' => 'LG',
                'slug' => 'lg',
                'logo' => 'assets/logo/lg.png',
            ],
        ]);
    }
}
