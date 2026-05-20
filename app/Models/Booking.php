<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'combo_id',
        'total_price',
        'status',          // 'pending', 'confirmed', 'cancelled'
        'customer_name',   // Tên khách đi thực tế (lưu trữ phục vụ liên hệ)
        'customer_phone',  // SĐT liên hệ
        'customer_email',  // Email liên hệ
        'note'             // Ghi chú phòng nghỉ, giờ đi...
    ];

    // Liên kết với tài khoản đặt đơn
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Liên kết với combo được đặt
    public function combo()
    {
        return $this->belongsTo(Combo::class, 'combo_id');
    }
}