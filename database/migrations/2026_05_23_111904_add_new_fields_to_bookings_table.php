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
            if (!Schema::hasColumn('bookings', 'email')) {
                $table->string('email')->after('customer_name')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'adult_count')) {
                $table->integer('adult_count')->default(1)->after('phone');
            }
            if (!Schema::hasColumn('bookings', 'child_count')) {
                $table->integer('child_count')->default(0)->after('adult_count');
            }
            if (!Schema::hasColumn('bookings', 'check_in')) {
                $table->date('check_in')->after('child_count')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['email', 'adult_count', 'child_count', 'check_in']);
        });
    }
};