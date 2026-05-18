<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Makanan',
                'description' => 'Kategori produk makanan'
            ],
            [
                'name' => 'Minuman',
                'description' => 'Kategori produk minuman'
            ],
            [
                'name' => 'Kebutuhan Rumah Tangga',
                'description' => 'Kategori produk kebutuhan rumah tangga'
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
