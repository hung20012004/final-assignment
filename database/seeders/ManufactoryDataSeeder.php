<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Manufactory;

class ManufactoryDataSeeder extends Seeder
{
    // Insert nhà sản xuất
    public function run(): void
    {
        DB::table('manufactories')->insert([
            ['name' => 'ASUS'],
            ['name' => 'DELL'],
            ['name' => 'ACER'],
            ['name' => 'GIGABYTE'],
            ['name' => 'HP'],
            ['name' => 'LENOVO'],
            ['name' => 'LG'],
            ['name' => 'MSI'],
            ['name' => 'Không thương hiệu'],
        ]);
    }
}
