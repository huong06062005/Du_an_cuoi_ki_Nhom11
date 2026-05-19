<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Thêm cột role vào bảng users
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Thêm cột role sau cột password, mặc định là 'user'
            $table->string('role')->default('user')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     * Xóa cột role nếu muốn quay lại trạng thái cũ
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};