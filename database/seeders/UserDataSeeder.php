<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Hùng',
                'email' => 'hung@gmail',
                'role' => 'manager',
                'password' => '12345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Duy',
                'email' => 'duy@gmail',
                'role' => 'seller',
                'password' => '12345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Khoa',
                'email' => 'khoa@gmail',
                'role' => 'warehouse',
                'password' => '12345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'A',
                'email' => 'a@gmail',
                'role' => 'accoutant',
                'password' => '12345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
