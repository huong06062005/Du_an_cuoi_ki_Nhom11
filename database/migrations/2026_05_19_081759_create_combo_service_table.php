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
        Schema::create('combo_service', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

=======
    public function up()
{
    Schema::create('combo_service', function (Blueprint $table) {
        $table->id();
        $table->foreignId('combo_id')->constrained('combos')->onDelete('cascade');
        $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
        $table->timestamps();
    });
}
>>>>>>> 07034701dd947503259907c5bbd43a1d157a1e25
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combo_service');
    }
};
