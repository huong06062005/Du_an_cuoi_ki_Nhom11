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
<<<<<<< HEAD
=======
     * Thêm cột role vào bảng users
>>>>>>> 07034701dd947503259907c5bbd43a1d157a1e25
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
<<<<<<< HEAD
            //
        });
    }

    /**
     * Reverse the migrations.
=======
            // Thêm cột role sau cột password, mặc định là 'user'
            $table->string('role')->default('user')->after('password');
        });
    }


    /**
     * Reverse the migrations.
     * Xóa cột role nếu muốn quay lại trạng thái cũ
>>>>>>> 07034701dd947503259907c5bbd43a1d157a1e25
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
<<<<<<< HEAD
            //
=======
            $table->dropColumn('role');
>>>>>>> 07034701dd947503259907c5bbd43a1d157a1e25
        });
    }
};
