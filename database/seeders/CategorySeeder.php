<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Makanan'
        ]);
        Category::create([
            'name' => 'Minuman'
        ]);
        Category::create([
            'name' => 'Kebutuhan Dapur'
        ]);
        Category::create([
            'name' => 'Kebutuhan Rumah'
        ]);
        Category::create([
            'name' => 'Personal Care'
        ]);
    }
}
