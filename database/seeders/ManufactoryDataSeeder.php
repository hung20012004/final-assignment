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
            ['name' => 'ASUS',
             'address' => 'Quận Beitou (Bắc Đầu), Đài Bắc, Đài Loan',
             'website' => 'https://www.asus.com/vn/',
             'created_at' => now(),
             'updated_at' => now()]
        ]);

        DB::table('manufactories')->insert([
            ['name' => 'DELL',
             'address' => 'Round Rock, Texas, Hoa Kỳ',
             'website' => 'https://www.dell.com/en-vn',
             'created_at' => now(),
             'updated_at' => now()],
        ]);

        DB::table('manufactories')->insert([
            ['name' => 'ACER',
             'address' => 'Tịch Chỉ, Tân Bắc, Đài Loan',
             'website' => 'https://www.acer.com/vn-vi',
             'created_at' => now(),
             'updated_at' => now()],
        ]);

        DB::table('manufactories')->insert([
            ['name' => 'GIGABYTE',
             'address' => 'Quận Tân Điếm, Tân Bắc, Đài Loan; City of Industry, California, Hoa Kỳ',
             'website' => 'https://www.gigabyte.com/vn',
             'created_at' => now(),
             'updated_at' => now()],
        ]);

        DB::table('manufactories')->insert([
            ['name' => 'HP',
             'address' => 'Palo Alto, California, Hoa Kỳ',
             'website' => 'https://www.hp.com/vn-vi/home.html',
             'created_at' => now(),
             'updated_at' => now()],
        ]);
        
        DB::table('manufactories')->insert([
            ['name' => 'LENOVO',
             'address' => 'Hải Điến, Bắc Kinh, Trung Quốc; Morrisville, Bắc Carolina, Hoa Kỳ',
             'website' => 'https://www.lenovo.com/vn/vi/pc',
             'created_at' => now(),
             'updated_at' => now()],
        ]);
        
        DB::table('manufactories')->insert([
            ['name' => 'LG',
             'address' => '128 Yeoui-daero, Yeongdeungpo, Seoul, Hàn Quốc',
             'website' => 'https://www.lg.com/vn/laptops',
             'created_at' => now(),
             'updated_at' => now()],
        ]);
        
        DB::table('manufactories')->insert([
            ['name' => 'MSI',
             'address' => 'Trung Hòa, Tân Bắc, Đài Loan',
             'website' => 'https://www.msi.com',
             'created_at' => now(),
             'updated_at' => now()],
        ]);
        
        DB::table('manufactories')->insert([
            ['name' => 'Không thương hiệu',
            'address' => 'không có'],
        ]);
    }
}
