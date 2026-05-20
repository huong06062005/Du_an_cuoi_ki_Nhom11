<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;

    // Thêm dòng này để cho phép nạp dữ liệu nhanh vào các cột
    protected $fillable = ['name', 'description', 'price', 'image'];
}
