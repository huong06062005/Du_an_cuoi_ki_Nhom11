<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;

    // 1. Khai báo tên bảng trong Database (đảm bảo khớp với file migration)
    protected $table = 'combos';

    /**
     * 2. Danh sách các cột cho phép nhập liệu nhanh (Mass Assignment)
     * Thầy đã sửa đổi tên cột giá thành 'gia_tien' cho đồng bộ hoàn toàn
     */
    protected $fillable = [
        'ten_combo',      // Tên gói combo
        'mo_ta',          // Mô tả chi tiết
        'gia_tien',       // Đã đổi từ gia_khuyen_mai thành gia_tien để khớp với Controller và View
        'hinh_anh',       // Đường dẫn ảnh combo
        'trang_thai',     // Trạng thái hiển thị (1: Hiện, 0: Ẩn)
    ];

    /**
     * 3. Quan hệ với các Dịch vụ thành phần (Tour, Khách sạn, Xe...)
     * Một combo sẽ bao gồm nhiều dịch vụ thành phần thông qua bảng trung gian combo_service
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'combo_service', 'combo_id', 'service_id');
    }

    /**
     * 4. Quan hệ với Đơn đặt hàng (Booking)
     * Đổi tên từ orders sang bookings cho đồng bộ với Model Booking và Route hệ thống
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'combo_id');
    }
}