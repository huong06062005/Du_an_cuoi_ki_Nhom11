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
    Schema::table('bookings', function (SubscribingTable $table) {
        // Thêm cột user_id, cho phép null (unsignedBigInteger) và đặt nó ngay sau cột id
        $table->unsignedBigInteger('user_id')->nullable()->after('id');
        
        // Tạo khóa ngoại liên kết sang bảng users để bảo mật dữ liệu
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('bookings', function (SubscribingTable $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}
};
