<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('order_details')->insert([
            [
                'order_id' => 1, 
                'laptop_id' => 1, 
                'quantity' => 2, 
                'price' => 30000000, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2,
                'laptop_id' => 2,
                'quantity' => 1,
                'price' => 10000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
