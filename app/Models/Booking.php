<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Giữ nguyên đống fillable chuẩn của bảng bookings máy em
    protected $fillable = [
        'user_id',
        'combo_id',
        'customer_name',
        'email',
        'phone_number',   
        'adults',         
        'children',       
        'departure_date', 
        'total_price',
        'status',
        'note',
    ];

    /**
     * 1. THÊM MỚI: Thiết lập mối quan hệ liên kết ngược với Model User (SỬA LỖI ĐỎ LÒM NÃY GIỜ)
     * Mỗi đơn đặt tour (Booking) bắt buộc phải thuộc về một tài khoản Khách hàng (User)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 2. Thiết lập mối quan hệ liên kết ngược với Model Combo
     */
    public function combo()
    {
        return $this->belongsTo(Combo::class, 'combo_id');
    }
}