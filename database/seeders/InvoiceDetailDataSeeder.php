<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceDetailDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('invoice_details')->insert([
            [
              'invoice_id' => 1,
              'laptop_id' => 2,
              'quantity' => 3,
              'price' => '20000000',
              'created_at' => now(),
              'updated_at' => now()
            ],
            [
                'invoice_id' => 1,
                'laptop_id' => 4,
                'quantity' => 2,
                'price' => '25000000',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        
        DB::table('invoice_details')->insert([
            [
              'invoice_id' => 2,
              'laptop_id' => 3,
              'quantity' => 2,
              'price' => '48000000',
              'created_at' => now(),
              'updated_at' => now()
            ],
            [
                'invoice_id' => 2,
                'laptop_id' => 1,
                'quantity' => 5,
                'price' => '25000000',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoice_id' => 2,
                'laptop_id' => 4,
                'quantity' => 4,
                'price' => '12000000',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        DB::table('invoice_details')->insert([
            [
              'invoice_id' => 3,
              'laptop_id' => 4,
              'quantity' => 2,
              'price' => '12000000',
              'created_at' => now(),
              'updated_at' => now()
            ],
            [
                'invoice_id' => 3,
                'laptop_id' => 1,
                'quantity' => 13,
                'price' => '25000000',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoice_id' => 3,
                'laptop_id' => 2,
                'quantity' => 3,
                'price' => '39000000',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
