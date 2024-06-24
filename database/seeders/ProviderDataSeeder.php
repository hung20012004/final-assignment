<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('providers')->insert([
            [
                'name' => 'GEARVN',
                'address' => 'Hà Nội',
                'phone' => '0242525252',
                'email' => 'gearvn@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HACOM',
                'address' => 'Hà Nội',
                'phone' => '0399998888',
                'email' => 'hacom@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ANPHAT',
                'address' => 'Hà Nội',
                'phone' => '0898989898',
                'email' => 'anphat@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MEMORY ZONE',
                'address' => 'Hà Nội',
                'phone' => '0388445566',
                'email' => 'memoryzone@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'LAPTOP88',
                'address' => 'Hà Nội',
                'phone' => '0811112323',
                'email' => 'laptop88@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
