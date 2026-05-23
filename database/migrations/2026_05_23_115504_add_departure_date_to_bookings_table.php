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
            // 🔥 THÊM CỘT departure_date (kiểu DATE) vào sau cột combo_id và cho phép trống (nullable)
            $table->date('departure_date')->nullable()->after('combo_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Xóa cột departure_date nếu rollback migration
            $table->dropColumn('departure_date');
        });
    }
};