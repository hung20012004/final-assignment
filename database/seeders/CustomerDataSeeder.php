<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CustomerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'name' => 'Quách Công Đạt',
                'address' => 'Hà Nội',
                'phone' => '0867465134',
                'email' => 'datquach@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
               'name' => 'Nguyễn Minh Hiển',
                'address' => 'Thái Bình',
                'phone' => '0867465135',
                'email' => 'hienminh@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Trần Hoàng Nam',
                'address' => 'Điện Biên',
                'phone' => '0867466234',
                'email' => 'nam2204@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vũ Minh Hiếu',
                'address' => 'Hòa Bình',
                'phone' => '0384329233',
                'email' => 'hieu2103@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'name' => 'Nguyễn Trí Công',
                'address' => 'Hà Giang',
                'phone' => '0385639233',
                'email' => 'congg3120@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'name' => 'Nguyễn Thị Thuận',
                'address' => 'Nghệ An',
                'phone' => '0384332335',
                'email' => 'thuan2207@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'name' => 'Đinh Thúy Kiều',
                'address' => 'Nam Định',
                'phone' => '0914653227',
                'email' => 'kieu3324@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Trần Hưng Nguyên',
                'address' => 'Lào Cai',
                'phone' => '0914673287',
                'email' => 'nguyentran21@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thái Ngọc Tiến',
                'address' => 'Hà Nội',
                'phone' => '0914483321',
                'email' => 'tienthai3312@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nguyễn Ngọc Trang',
                'address' => 'Lai Châu',
                'phone' => '0867493157',
                'email' => 'trangcute43@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
