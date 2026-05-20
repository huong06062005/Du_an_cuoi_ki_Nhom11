<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. TỰ ĐỘNG TẠO TÀI KHOẢN ADMIN ĐỂ ĐĂNG NHẬP
        $adminData = [
            'name'     => 'Admin Vũ Thu Hường',
            'email'    => 'huong@gmail.com',
            'password' => Hash::make('123456'), // Mật khẩu đăng nhập
            'role'     => 'admin', // Phân quyền Admin cơ bản
            'quyen'    => 'admin', // Dự phòng nếu nhóm đặt tên cột tiếng Việt
        ];

        // Lọc cột thông minh tránh lỗi MySQL
        $safeAdmin = array_filter($adminData, function ($key) {
            return Schema::hasColumn('users', $key);
        }, ARRAY_FILTER_USE_KEY);

        // Tiến hành tạo tài khoản nếu chưa tồn tại email này
        if (!User::where('email', 'huong@gmail.com')->exists()) {
            User::create($safeAdmin);
        }

        // 2. TỰ ĐỘNG TẠO THÊM 1 TÀI KHOẢN USER THƯỜNG ĐỂ TEST CƠ CHẾ CLIENT
        $userData = [
            'name'     => 'Nguyễn Trung Anh',
            'email'    => 'trunganh@gmail.com',
            'password' => Hash::make('123456'),
            'role'     => 'user',
            'quyen'    => 'user',
        ];
        $safeUser = array_filter($userData, function ($key) {
            return Schema::hasColumn('users', $key);
        }, ARRAY_FILTER_USE_KEY);

        if (!User::where('email', 'trunganh@gmail.com')->exists()) {
            User::create($safeUser);
        }

        // 3. GỌI CÁC SEEDER DỊCH VỤ VÀ COMBO ĐÃ LÀM BIẾN BAN NÃY
        if (class_exists(ServiceSeeder::class)) {
            $this->call(ServiceSeeder::class);
        }
        
        if (class_exists(ComboSeeder::class)) {
            $this->call(ComboSeeder::class);
        }
    }
}