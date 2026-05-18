<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Rokok Sukun Putih isi 16',
                'stock' => 50,
                'minimum_stock' => 10,
                'price' => 1300000,
                'unit' => '26000'
            ],
            [
                'name' => 'Mie Sedap',
                'stock' => 60,
                'minimum_stock' => 15,
                'price' => 210000,
                'unit' => '3500'
            ],
            [
                'name' => 'Mio Sukses isi 2',
                'stock' => 30,
                'minimum_stock' => 10,
                'price' => 150000,
                'unit' => '5000'
            ],
            [
                'name' => 'Galon Aqua',
                'stock' => 10,
                'minimum_stock' => 5,
                'price' => 600000,
                'unit' => '60000'
            ],
            [
                'name' => 'Aqua botol',
                'stock' => 32,
                'minimum_stock' => 10,
                'price' => 160000,
                'unit' => '5000'
            ],
            [
                'name' => 'Floridina',
                'stock' => 30,
                'minimum_stock' => 10,
                'price' => 120000,
                'unit' => '4000'
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],
                [
                    'stock' => $product['stock'],
                    'minimum_stock' => $product['minimum_stock'],
                    'price' => $product['price'],
                    'unit' => $product['unit']
                ]
            );
        }
    }
}
