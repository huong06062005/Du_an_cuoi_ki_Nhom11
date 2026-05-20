<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Chỉ định chính xác tên bảng trong database của em
    protected $table = 'services'; 

    // Thay thế $fillable bằng $guarded trống để đón mảng $safeData đã được lọc sạch từ Controller
    protected $guarded = [];
}