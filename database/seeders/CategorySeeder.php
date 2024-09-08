<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Phone',
                'slug' => 'phone',
                'icon' => 'assets/icons/phone.png',
            ],
            [
                'name' => 'Laptop',
                'slug' => 'laptop',
                'icon' => 'assets/icons/laptop.png',
            ],
            [
                'name' => 'Audio',
                'slug' => 'audio',
                'icon' => 'assets/icons/audio.png',
            ],
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'icon' => 'assets/icons/electronics.png',
            ],
            [
                'name' => 'Others',
                'slug' => 'others',
                'icon' => 'assets/icons/others.png',
            ],
        ]);
    }
}
