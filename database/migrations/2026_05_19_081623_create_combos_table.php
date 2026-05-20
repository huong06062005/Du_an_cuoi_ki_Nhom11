<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('combos', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // Tên combo
            $table->text('description')->nullable(); // Mô tả
            $table->decimal('price', 15, 2); // Giá tiền
            $table->string('image')->nullable(); // Đường dẫn ảnh
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combos');
    }
};
