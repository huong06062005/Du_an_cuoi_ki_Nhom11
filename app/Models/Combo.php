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
    protected $appends = ['image_url', 'mo_ta_text', 'real_price'];

    /**
     * Accessor: Tự động chuẩn hóa Link ảnh đại diện (ĐÃ SỬA CHỐNG MẤT ẢNH)
     */
    public function getImageUrlAttribute()
    {
        // Quét tất cả các cột ảnh có thể có trong DB của em
        $path = $this->image ?? ($this->hinh_anh ?? $this->anh);

        if (empty($path)) {
            // Trả về ảnh tạm chất lượng cao để giao diện lúc nào cũng có ảnh đẹp, không bị lỗi ô vỡ
            return 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=500&auto=format&fit=crop&q=60';
        }

        // Nếu là link mạng http/https từ Seeder thì giữ nguyên để hiển thị luôn
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Nếu là file do em tự chọn tải lên từ máy tính
        return asset('storage/' . $path);
    }

    /**
     * Accessor: Tự động đồng bộ trường mô tả.
     */
    public function getMoTaTextAttribute()
    {
        return $this->mo_ta ?? ($this->description ?? 'Đang cập nhật...');
    }

    /**
     * Accessor: Tự động tính tổng tiền của Combo dựa trên các dịch vụ đã liên kết
     */
    public function getRealPriceAttribute()
    {
        if ($this->services()->exists()) {
            $firstService = $this->services()->first();
            $priceColumn = 'price';
            
            if (isset($firstService->gia_tien)) $priceColumn = 'gia_tien';
            elseif (isset($firstService->gia_nhap)) $priceColumn = 'gia_nhap';
            elseif (isset($firstService->gia_goc)) $priceColumn = 'gia_goc';

            return $this->services()->sum($priceColumn);
        }

        return $this->gia_tien ?? ($this->price ?? 0);
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