<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;

    /**
     * Khai báo tên bảng trong Database
     */
    protected $table = 'combos';

    /**
     * Mở khóa nạp mảng bảo mật để đón nhận dữ liệu tự động từ Controller.
     */
    protected $guarded = [];

    /**
     * Accessor thông minh: Tự động chuẩn hóa Link ảnh đại diện.
     * Giúp hiển thị mượt mà cả ảnh upload local lẫn link ảnh tuyệt đối từ internet.
     */
    public function getImageUrlAttribute()
    {
        // Lấy đường dẫn từ cột 'image' hoặc cột 'hinh_anh' tùy theo cấu trúc database
        $path = $this->image ?? $this->hinh_anh;

        if (empty($path)) {
            // Nếu không có ảnh, trả về ảnh mặc định
            return 'https://ui-avatars.com/api/?name=Combo&background=random&color=fff';
        }

        // Kiểm tra nếu là link ảnh đầy đủ từ internet
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Nếu là ảnh upload lưu trong thư mục storage local
        return asset('storage/' . $path);
    }

    /**
     * Accessor bổ trợ: Tự động đồng bộ trường mô tả dữ liệu
     */
    public function getMoTaTextAttribute()
    {
        return $this->mo_ta ?? $this->description ?? '';
    }

    /**
     * Quan hệ với các Dịch vụ thành phần (Many-to-Many)
     * Một combo gồm nhiều dịch vụ kết nối qua bảng trung gian combo_service
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'combo_service', 'combo_id', 'service_id');
    }

    /**
     * Quan hệ với Đơn đặt hàng (Booking)
     * Một combo có thể được đặt bởi nhiều khách hàng khác nhau
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'combo_id');
    }
}