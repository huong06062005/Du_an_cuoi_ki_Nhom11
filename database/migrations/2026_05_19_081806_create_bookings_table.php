<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('combo_id')->constrained()->onDelete('cascade'); // Nối với bảng combo
            $table->string('customer_name');  // Tên khách hàng
            $table->string('customer_phone'); // Số điện thoại
            $table->string('customer_email'); // Email khách
            $table->date('departure_date');   // Ngày khởi hành
            $table->integer('slots');         // Số lượng người đi
            $table->decimal('total_price', 15, 2); // Tổng tiền đơn hàng
            $table->integer('status')->default(0); // Trạng thái: 0: Chờ duyệt, 1: Đã duyệt, 2: Hủy
            $table->text('note')->nullable(); // Ghi chú của khách
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};