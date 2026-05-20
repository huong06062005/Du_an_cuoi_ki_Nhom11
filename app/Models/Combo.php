<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Combo extends Model
{
    use HasFactory;

    protected $table = 'combos';

    /**
     * Mở khóa tất cả các trường để nhận dữ liệu từ Controller.
     */
    protected $guarded = [];

    /**
     * Tự động thêm các thuộc tính ảo vào kết quả JSON/Array.
     */
    protected $appends = ['image_url', 'mo_ta_text'];

    /**
     * Accessor: Tự động chuẩn hóa Link ảnh đại diện.
     */
    public function getImageUrlAttribute()
    {
        $path = $this->image ?? $this->hinh_anh;

        if (empty($path)) {
            return asset('images/default-combo.jpg'); // Nên có ảnh mặc định trong thư mục public/images
        }

        // Nếu là link http/https thì trả về nguyên bản
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Nếu là file upload thì trả về đường dẫn Storage
        return asset('storage/' . $path);
    }

    /**
     * Accessor: Tự động đồng bộ trường mô tả.
     */
    public function getMoTaTextAttribute()
    {
        return $this->mo_ta ?? $this->description ?? 'Đang cập nhật...';
    }

    /**
     * Quan hệ Many-to-Many với Dịch vụ.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'combo_service', 'combo_id', 'service_id');
    }

    /**
     * Quan hệ với Đơn đặt hàng.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'combo_id');
    }
}