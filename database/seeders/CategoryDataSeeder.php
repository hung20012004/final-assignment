<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryDataSeeder extends Seeder
{
    // Insert loại laptops
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Gaming'],
            ['name' => 'Văn phòng'],
            ['name' => 'Đồ họa'],
        ]);
    }
}
