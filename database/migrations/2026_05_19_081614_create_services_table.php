<?php

<<<<<<< HEAD
=======

>>>>>>> 07034701dd947503259907c5bbd43a1d157a1e25
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD
=======

>>>>>>> 07034701dd947503259907c5bbd43a1d157a1e25
return new class extends Migration
{
    /**
     * Run the migrations.
     */
<<<<<<< HEAD
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
=======
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
>>>>>>> 07034701dd947503259907c5bbd43a1d157a1e25
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
