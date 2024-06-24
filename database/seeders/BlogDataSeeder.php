<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('blogs')->insert([
            [
                'title' => 'Sinh nhật cửa hàng 13/5',
                'user_id' => 2, // Thay đổi user_id tùy theo id của user trong bảng users
                'content' => 'Mừng sinh nhật cửa hàng',
                'author' => 'Hoàng Duy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Siêu sale 6/6',
                'user_id' => 2, // Thay đổi user_id tùy theo id của user trong bảng users
                'content' => 'Thông báo tri cân khách hàng tháng 6/6',
                'author' => 'Khoa Trần',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Thông báo nghỉ tết Nguyên Đán 2023',
                'user_id' => 2, // Thay đổi user_id tùy theo id của user trong bảng users
                'content' => 'Lịch Nghỉ Tết Nguyên Đán bắt đầu từ 20/1/2023 đến hết 28/1/2023',
                'author' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Thêm các bài đăng blog khác tại đây nếu cần
        ]);

    }
}
