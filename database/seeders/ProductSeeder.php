<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makanan = Category::where('name', 'Makanan')->first();
        Product::create([
            'category_id' => $makanan->id,
            'name' => 'Indomie Goreng',
            'description' => 'asdasadas',
            'price' => 3500,
            'stock' => 5,
        ]);

        $minuman = Category::where('name', 'Minuman')->first();
        Product::create([
            'category_id' => $minuman->id,
            'name' => 'Coca Cola',
            'description' => 'asdasadas',
            'price' => 9000,
            'stock' => 50,
        ]);

        $kebDapur = Category::where('name', 'Kebutuhan Dapur')->first();
        Product::create([
            'category_id' => $kebDapur->id,
            'name' => 'Garam',
            'description' => 'asdasadas',
            'price' => 7000,
            'stock' => 100,
        ]);

        $kebRumah = Category::where('name', 'Kebutuhan Rumah')->first();
        Product::create([
            'category_id' => $kebRumah->id,
            'name' => 'Sapu',
            'description' => 'asdasadas',
            'price' => 15000,
            'stock' => 50,
        ]);

        $personalCare = Category::where('name', 'Personal Care')->first();
        Product::create([
            'category_id' => $personalCare->id,
            'name' => 'Garnier Men',
            'description' => 'asdasadas',
            'price' => 25000,
            'stock' => 10,
        ]);
    }
}
