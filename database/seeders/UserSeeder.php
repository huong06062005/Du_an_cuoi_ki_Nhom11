<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
    \App\Models\User::create([
        'name' => 'Vũ Thu Hương',
        'email' => 'huong@gmail.com',
        'password' => bcrypt('123456'), // Mật khẩu mặc định
        'role' => 'admin'
    ]);
}
}
