<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('invoices')->insert([
          [
            'user_id' => 3,
            'provider_id' => 1,
            'state' => 1,
            'created_at' => now(),
            'updated_at' => now()
          ],
          [
            'user_id' => 3,
            'provider_id' => 2,
            'state' => 0,
            'created_at' => now(),
            'updated_at' => now()
          ],
          [
            'user_id' => 3,
            'provider_id' => 3,
            'state' => 2,
            'created_at' => now(),
            'updated_at' => now()
          ]
        ]);
    }
}
