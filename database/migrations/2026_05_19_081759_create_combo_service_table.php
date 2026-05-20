<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('combo_service', function (Blueprint $table) {
            $table->id();
            // Khóa ngoại nối sang bảng combos (Xóa combo thì tự động xóa dòng tương ứng ở đây)
            $table->foreignId('combo_id')->constrained()->onDelete('cascade');
            // Khóa ngoại nối sang bảng services
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combo_service');
    }
};