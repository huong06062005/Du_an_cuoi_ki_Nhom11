<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('services', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Tên dịch vụ
        $table->string('type'); // Loại: tour, hotel, bus...
        $table->decimal('price', 15, 2); // Giá tiền
        $table->text('description')->nullable(); 
        $table->string('image')->nullable(); // Upload hình ảnh
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
