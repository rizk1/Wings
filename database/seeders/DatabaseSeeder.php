<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Product::insert([
            ['product_code' => 'SKP12', 'product_name' => 'So Klin Pewangi', 'price' => 15000, 'currency' => 'IDR', 'discount' => 10, 'dimension' => '13 cm x 10 cm', 'unit' => 'PCS'],
            ['product_code' => 'SKP13', 'product_name' => 'Daia Pemutih', 'price' => 15000, 'currency' => 'IDR', 'discount' => 25, 'dimension' => '13 cm x 10 cm', 'unit' => 'PCS'],
            ['product_code' => 'SKP14', 'product_name' => 'Ale - Ale', 'price' => 35000, 'currency' => 'IDR',  'discount' => null, 'dimension' => '13 cm x 10 cm', 'unit' => 'BOX'],
            ['product_code' => 'SKP15', 'product_name' => 'Mie Sedap Goreng', 'price' => 43000, 'currency' => 'IDR', 'discount' => null, 'dimension' => '13 cm x 10 cm', 'unit' => 'BOX'],
        ]);
    }
}
