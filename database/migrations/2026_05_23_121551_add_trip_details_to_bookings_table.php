<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // 🔥 ĐÃ BỎ LỆNH AFTER: Tự động thêm cột xuống cuối bảng để tránh lỗi đồng bộ MySQL
            if (!Schema::hasColumn('bookings', 'departure_date')) {
                $table->date('departure_date')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'adults')) {
                $table->integer('adults')->default(1);
            }
            if (!Schema::hasColumn('bookings', 'children')) {
                $table->integer('children')->default(0);
            }
            if (!Schema::hasColumn('bookings', 'note')) {
                $table->text('note')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Rollback an toàn
            $table->dropColumn(['departure_date', 'adults', 'children', 'note']);
        });
    }
};