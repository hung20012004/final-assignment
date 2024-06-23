<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaryTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('salaries')->insert([
                 [
                    'user_id' => 1,
                    'year' => 2024, 
                    'month' => 6,
                    'base_salary' => 15000000,
                    'allowances' => 500000,
                    'deductions' => 0,
                    'total_salary' => 15500000, 
                    'created_at' => now(),
                    'updated_at' => now(),
                 ],
                  [
                    'user_id' => 2,
                    'year' => 2024, 
                    'month' => 6,
                    'base_salary' => 13000000,
                    'allowances' => 500000,
                    'deductions' => 100000,
                    'total_salary' => 1340000, 
                    'created_at' => now(),
                    'updated_at' => now(),
                  ], 
                   [
                    'user_id' => 2,
                    'year' => 2024, 
                    'month' => 6,
                    'base_salary' => 13000000,
                    'allowances' => 500000,
                    'deductions' => 0,
                    'total_salary' => 13500000, 
                    'created_at' => now(),
                    'updated_at' => now(),
                   ],
                 [
                    'user_id' => 3,
                    'year' => 2024, 
                    'month' => 6,
                    'base_salary' => 13000000,
                    'allowances' => 500000,
                    'deductions' => 0,
                    'total_salary' => 13500000, 
                    'created_at' => now(),
                    'updated_at' => now(),
                 ]
        ]);
    }
}
