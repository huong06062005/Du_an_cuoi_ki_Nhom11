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
    public function up(): void
    {
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->bigInteger('expiration')->index();
        });

<<<<<<< HEAD
=======

>>>>>>> 07034701dd947503259907c5bbd43a1d157a1e25
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->bigInteger('expiration')->index();
        });
    }

<<<<<<< HEAD
=======

>>>>>>> 07034701dd947503259907c5bbd43a1d157a1e25
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
