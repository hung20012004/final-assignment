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
                'title' => 'First Blog Post',
                'user_id' => 2, // Thay đổi user_id tùy theo id của user trong bảng users
                'content' => 'Mừng sinh nhật cửa hàng',
                'author' => 'Hoàng Duy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Second Blog Post',
                'user_id' => 2, // Thay đổi user_id tùy theo id của user trong bảng users
                'content' => 'Thông báo tri cân khách hàng tháng 6/6',
                'author' => 'Khoa Trần',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Thêm các bài đăng blog khác tại đây nếu cần
        ]);

    }
}
