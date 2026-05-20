<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Đã sửa tại đây: Thêm tất cả các cột cần lưu dữ liệu của bảng bookings vào
    protected $fillable = [
        'user_id',
        'combo_id',
        'total_price',
        'status',
    ];

    /**
     * Thiết lập mối quan hệ liên kết ngược với Model Combo (nếu nhóm bạn cần dùng)
     */
    public function combo()
    {
        return $this->belongsTo(Combo::class, 'combo_id');
    }
}