<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Combo;
use App\Models\Service;
use Illuminate\Support\Facades\Schema;

class ComboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh sách 15 combo chuẩn cú pháp PHP, không xuống dòng lỗi
        $combos = [
            // 🔥 6 COMBO PHỔ BIẾN / NỔI BẬT (is_featured = 1)
            [
                'name' => 'Combo Siêu Tiết Kiệm Đà Nẵng - Hội An 3 Ngày 2 Đêm',
                'price' => 3490000,
                'old_price' => 4200000,
                'description' => 'Gói combo trọn gói bao gồm vé máy bay khứ hồi, nghỉ dưỡng khách sạn Novotel view sông Hàn và vé vui chơi Bà Nà Hills check-in Cầu Vàng.',
                'image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 1,
                'keyword' => 'Đà Nẵng'
            ],
            [
                'name' => 'Sapa Mờ Sương - Chinh phục đỉnh Fansipan Nóc Nhà Đông Dương',
                'price' => 1950000,
                'old_price' => 2500000,
                'description' => 'Trải nghiệm cáp treo Sun World Fansipan Legend, di chuyển xe giường nằm VIP khứ hồi và nghỉ dưỡng tại Hotel de la Coupole đẳng cấp Pháp.',
                'image' => 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 1,
                'keyword' => 'Sapa'
            ],
            [
                'name' => 'Phú Quốc United Center - Kỳ nghỉ thiên đường 4 Ngày 3 Đêm',
                'price' => 5850000,
                'old_price' => 6900000,
                'description' => 'Khám phá trọn vẹn đảo ngọc với vé máy bay khứ hồi, lưu trú Villa Vinpearl Resort & Spa và vé vui chơi không giới hạn VinWonders & Safari.',
                'image' => 'https://images.unsplash.com/photo-1583212292454-1fe6229603b7?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 1,
                'keyword' => 'Phú Quốc'
            ],
            [
                'name' => 'Tuyệt tác Kỳ quan Thiên nhiên Vịnh Hạ Long - Du thuyền 5 Sao',
                'price' => 2650000,
                'old_price' => 3200000,
                'description' => 'Nghỉ dưỡng sang chảnh tại Mường Thanh Luxury Hạ Long, kết hợp hải trình 6 tiếng ăn buffet hải sản và chèo thuyền Kayak trên vịnh.',
                'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 1,
                'keyword' => 'Hạ Long'
            ],
            [
                'name' => 'Cố đô Huế cổ kính - Lãng mạn vẻ đẹp cung đình miền Trung',
                'price' => 2200000,
                'old_price' => 2700000,
                'description' => 'Hành trình di chuyển Vietnam Airlines, lưu trú khách sạn Silk Path Grand Huế sang trọng và thưởng thức show diễn Ký ức Hội An.',
                'image' => 'https://images.unsplash.com/photo-1571508601936-6ca847b47ae6?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 1,
                'keyword' => 'Huế'
            ],
            [
                'name' => 'Hành trình Vòng cung Tây Bắc - Hà Giang mùa hoa tam giác mạch',
                'price' => 3100000,
                'old_price' => 3800000,
                'description' => 'Trải nghiệm xe giường nằm phòng đôi VIP Hà Nội - Hà Giang, thuê xe máy tự lái chinh phục đèo Mã Pì Lèng và sông Nho Quế.',
                'image' => 'https://images.unsplash.com/photo-1605538032432-a9f0c8d9baac?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 1,
                'keyword' => 'Hà Giang'
            ],

            // 🌟 9 COMBO THƯỜNG KHÁC (is_featured = 0)
            [
                'name' => 'Combo Sapa Cuối Tuần - Nghỉ dưỡng mây ngàn giá rẻ',
                'price' => 1250000,
                'old_price' => 1600000,
                'description' => 'Bao gồm xe Limousine khứ hồi và phòng nghỉ view thung lũng Mường Hoa thơ mộng.',
                'image' => 'https://images.unsplash.com/photo-1508444845599-a3bfb667e402?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 0,
                'keyword' => 'Sapa'
            ],
            [
                'name' => 'Đà Nẵng City Tour - Khám phá thành phố đáng sống nhất Việt Nam',
                'price' => 1600000,
                'old_price' => 1990000,
                'description' => 'Gói di chuyển bằng xe 16 chỗ trọn gói tham quan Ngũ Hành Sơn, chùa Linh Ứng và cầu Rồng.',
                'image' => 'https://images.unsplash.com/photo-1559592413-7ece35937723?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 0,
                'keyword' => 'Đà Nẵng'
            ],
            [
                'name' => 'Phú Quốc Tự Do - Thuê xe máy phượt đảo ngọc 3 Ngày 2 Đêm',
                'price' => 1890000,
                'old_price' => 2300000,
                'description' => 'Dành cho các bạn trẻ thích khám phá: Vé máy bay Vietjet và xe máy ga giao tận nơi tại sân bay.',
                'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 0,
                'keyword' => 'Phú Quốc'
            ],
            [
                'name' => 'Hạ Long Cuối Tuần - Trốn khói bụi thành phố 2 Ngày 1 Đêm',
                'price' => 2100000,
                'old_price' => 2500000,
                'description' => 'Nghỉ ngơi thư giãn tại Mường Thanh Luxury và tắm biển bãi cháy mát lạnh.',
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 0,
                'keyword' => 'Hạ Long'
            ],
            [
                'name' => 'Hà Nội City Tour - Chiêm ngưỡng vẻ đẹp văn hóa ngàn năm văn hiến',
                'price' => 950000,
                'old_price' => 1300000,
                'description' => 'Nghỉ dưỡng phòng 5 sao InterContinental Tây Hồ lãng mạn và xe 4 chỗ đưa đón sân bay.',
                'image' => 'https://motogo.vn/wp-content/uploads/2023/10/du-lich-ha-noi-1-minh-19.jpg',
                'is_featured' => 0,
                'keyword' => 'Hà Nội'
            ],
            [
                'name' => 'Gói trăng mật lãng mạn tại Khách sạn Silk Path Huế',
                'price' => 2800000,
                'old_price' => 3500000,
                'description' => 'Combo đặc biệt cho cặp đôi gồm phòng cao cấp, tiệc tối lãng mạn và vé xem show Ký ức.',
                'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 0,
                'keyword' => 'Huế'
            ],
            [
                'name' => 'Chinh phục Fansipan - Sapa săn mây mùa lúa chín',
                'price' => 1750000,
                'old_price' => 2100000,
                'description' => 'Vé cáp treo Fansipan kèm xe Limousine Sao Việt chạy cao tốc êm ái.',
                'image' => 'https://images.unsplash.com/photo-1624314138470-5a2f24623f10?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 0,
                'keyword' => 'Sapa'
            ],
            [
                'name' => 'Nghỉ dưỡng đẳng cấp đại gia tại Vinpearl Resort Phú Quốc',
                'price' => 6900000,
                'old_price' => 8500000,
                'description' => 'Gói Luxury cao cấp nhất bảng: Villa hồ bơi riêng, vé máy bay Vietnam Airlines giờ đẹp.',
                'image' => 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 0,
                'keyword' => 'Phú Quốc'
            ],
            [
                'name' => 'Đà Nẵng - Hội An Hành trình di sản miền Trung mến khách',
                'price' => 2990000,
                'old_price' => 3600000,
                'description' => 'Sự kết hợp hoàn hảo giữa vé Bà Nà Hills và phòng nghỉ Novotel đẳng cấp quốc tế.',
                'image' => 'https://images.unsplash.com/photo-1568849676085-51415703900f?auto=format&fit=crop&w=800&q=80',
                'is_featured' => 0,
                'keyword' => 'Đà Nẵng'
            ],
        ];

        $index = 0;

        foreach ($combos as $item) {
            // Tự động set mặc định 6 combo đầu tiên luôn là phổ biến
            $isFeaturedValue = ($index < 6 || $item['is_featured'] == 1) ? 1 : 0;

            $rawInputs = [
                'name'         => $item['name'],
                'ten_combo'    => $item['name'],
                'price'        => $item['price'],
                'gia_tien'     => $item['price'],
                'gia_ban'      => $item['price'],
                'old_price'    => $item['old_price'],
                'gia_cu'       => $item['old_price'],
                'gia_goc'      => $item['old_price'],
                'description'  => $item['description'],
                'mo_ta'        => $item['description'],
                'image'        => $item['image'],
                'anh'          => $item['image'],
                'hinh_anh'     => $item['image'],
                'is_featured'  => $isFeaturedValue,
                'noi_bat'      => $isFeaturedValue,
                'pho_bien'     => $isFeaturedValue,
                'status'       => 'available'
            ];

            $safeData = array_filter($rawInputs, function ($key) {
                return Schema::hasColumn('combos', $key);
            }, ARRAY_FILTER_USE_KEY);

            $combo = Combo::create($safeData);

            $relatedServiceIds = Service::where('name', 'LIKE', '%' . $item['keyword'] . '%')->pluck('id')->toArray();
            
            if (!empty($relatedServiceIds)) {
                if (method_exists($combo, 'services')) {
                    $combo->services()->attach($relatedServiceIds);
                } elseif (method_exists($combo, 'dichVus')) {
                    $combo->dichVus()->attach($relatedServiceIds);
                }
            }

            $index++;
        }
    }
}