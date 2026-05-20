<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;

    protected $table = 'combos';

    protected $fillable = [
        'name',
        'description',
        'image',
        'total_price'
    ];

    // Quan hệ nhiều - nhiều với dịch vụ thành phần
    public function services()
    {
        return $this->belongsToMany(Service::class, 'combo_service', 'combo_id', 'service_id')->withTimestamps();
    }

    // Quan hệ một - nhiều với bảng bookings (đơn đặt)
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'combo_id');
    }
}