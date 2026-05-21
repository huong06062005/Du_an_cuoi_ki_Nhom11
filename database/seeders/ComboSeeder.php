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
                'image' => 'https://vcdn1-dulich.vnecdn.net/2022/06/03/cauvang-1654247842-9403-1654247849.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=Swd6JjpStebEzT6WARcoOA',
                'is_featured' => 1,
                'keyword' => 'Đà Nẵng'
            ],
            [
                'name' => 'Sapa Mờ Sương - Chinh phục đỉnh Fansipan Nóc Nhà Đông Dương',
                'price' => 1950000,
                'old_price' => 2500000,
                'description' => 'Trải nghiệm cáp treo Sun World Fansipan Legend, di chuyển xe giường nằm VIP khứ hồi và nghỉ dưỡng tại Hotel de la Coupole đẳng cấp Pháp.',
                'image' => 'https://images.vietnamtourism.gov.vn/en//images/2025/sep/0909.sapa-2.jpg',
                'is_featured' => 1,
                'keyword' => 'Sapa'
            ],
            [
                'name' => 'Phú Quốc United Center - Kỳ nghỉ thiên đường 4 Ngày 3 Đêm',
                'price' => 5850000,
                'old_price' => 6900000,
                'description' => 'Khám phá trọn vẹn đảo ngọc với vé máy bay khứ hồi, lưu trú Villa Vinpearl Resort & Spa và vé vui chơi không giới hạn VinWonders & Safari.',
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPLeQKQrmqxxe9zUCUM1z7MGwKktPEY94UXQ&s',
                'is_featured' => 1,
                'keyword' => 'Phú Quốc'
            ],
            [
                'name' => 'Tuyệt tác Kỳ quan Thiên nhiên Vịnh Hạ Long - Du thuyền 5 Sao',
                'price' => 2650000,
                'old_price' => 3200000,
                'description' => 'Nghỉ dưỡng sang chảnh tại Mường Thanh Luxury Hạ Long, kết hợp hải trình 6 tiếng ăn buffet hải sản và chèo thuyền Kayak trên vịnh.',
                'image' => 'https://bizweb.dktcdn.net/100/101/075/files/ha-long-bay.jpg?v=1767845461645',
                'is_featured' => 1,
                'keyword' => 'Hạ Long'
            ],
            [
                'name' => 'Cố đô Huế cổ kính - Lãng mạn vẻ đẹp cung đình miền Trung',
                'price' => 2200000,
                'old_price' => 2700000,
                'description' => 'Hành trình di chuyển Vietnam Airlines, lưu trú khách sạn Silk Path Grand Huế sang trọng và thưởng thức show diễn Ký ức Hội An.',
                'image' => 'https://cdn-media.sforum.vn/storage/app/media/ctvseo_MH/hu%E1%BA%BF%20mi%E1%BB%81n%20n%C3%A0o/hue-thuoc-mien-nao-thumbnail.jpg',
                'is_featured' => 1,
                'keyword' => 'Huế'
            ],
            [
                'name' => 'Hành trình Vòng cung Tây Bắc - Hà Giang mùa hoa tam giác mạch',
                'price' => 3100000,
                'old_price' => 3800000,
                'description' => 'Trải nghiệm xe giường nằm phòng đôi VIP Hà Nội - Hà Giang, thuê xe máy tự lái chinh phục đèo Mã Pì Lèng và sông Nho Quế.',
                'image' => 'https://images.vietnamtourism.gov.vn/vn/images/2019/nhung-diem-chup-hoa-tam-giac-mach-dep-nhat-o-ha-giang.jpg',
                'is_featured' => 1,
                'keyword' => 'Hà Giang'
            ],

            [
                'name' => 'Combo Sapa Cuối Tuần - Nghỉ dưỡng mây ngàn giá rẻ',
                'price' => 1250000,
                'old_price' => 1600000,
                'description' => 'Bao gồm xe Limousine khứ hồi và phòng nghỉ view thung lũng Mường Hoa thơ mộng.',
                'image' => 'https://vcdn1-dulich.vnecdn.net/2022/05/10/324251873-jpeg-1163-1650134032-1713-1652148548.jpg?w=680&h=0&q=100&dpr=2&fit=crop&s=jIKaf2njsjxp365gVgKsOA',
                'is_featured' => 0,
                'keyword' => 'Sapa'
            ],
            [
                'name' => 'Đà Nẵng City Tour - Khám phá thành phố đáng sống nhất Việt Nam',
                'price' => 1600000,
                'old_price' => 1990000,
                'description' => 'Gói di chuyển bằng xe 16 chỗ trọn gói tham quan Ngũ Hành Sơn, chùa Linh Ứng và cầu Rồng.',
                'image' => 'https://ik.imagekit.io/tvlk/blog/2022/06/ban-do-du-lich-da-nang-10.jpg',
                'is_featured' => 0,
                'keyword' => 'Đà Nẵng'
            ],
            [
                'name' => 'Phú Quốc Tự Do - Thuê xe máy phượt đảo ngọc 3 Ngày 2 Đêm',
                'price' => 1890000,
                'old_price' => 2300000,
                'description' => 'Dành cho các bạn trẻ thích khám phá: Vé máy bay Vietjet và xe máy ga giao tận nơi tại sân bay.',
                'image' => 'https://statics.vinpearl.com/phuot-phu-quoc-bang-xe-may-5_1630807454.jpg',
                'is_featured' => 0,
                'keyword' => 'Phú Quốc'
            ],
            [
                'name' => 'Hạ Long Cuối Tuần - Trốn khói bụi thành phố 2 Ngày 1 Đêm',
                'price' => 2100000,
                'old_price' => 2500000,
                'description' => 'Nghỉ ngơi thư giãn tại Mường Thanh Luxury và tắm biển bãi cháy mát lạnh.',
                'image' => 'https://paddingtonbayviewhalong.com/vnt_upload/news/10_2024/du_lich_ha_long_mua_thu_3.jpg',
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
                'image' => 'https://images.vietnamtourism.gov.vn/vn//images/2019/CNMN/17.8._Silk_Path_Grand_Hue_Hotel_%26_Spa_3.jpg',
                'is_featured' => 0,
                'keyword' => 'Huế'
            ],
            [
                'name' => 'Chinh phục Fansipan - Sapa săn mây mùa lúa chín',
                'price' => 1750000,
                'old_price' => 2100000,
                'description' => 'Vé cáp treo Fansipan kèm xe Limousine Sao Việt chạy cao tốc êm ái.',
                'image' => 'https://ik.imagekit.io/tvlk/blog/2024/11/t0OyiydT-Untitled-design-1.png',
                'is_featured' => 0,
                'keyword' => 'Sapa'
            ],
            [
                'name' => 'Nghỉ dưỡng đẳng cấp đại gia tại Vinpearl Resort Phú Quốc',
                'price' => 6900000,
                'old_price' => 8500000,
                'description' => 'Gói Luxury cao cấp nhất bảng: Villa hồ bơi riêng, vé máy bay Vietnam Airlines giờ đẹp.',
                'image' => 'https://images.trvl-media.com/lodging/35000000/34020000/34014200/34014178/f865e902.jpg?impolicy=resizecrop&rw=575&rh=575&ra=fill',
                'is_featured' => 0,
                'keyword' => 'Phú Quốc'
            ],
            [
                'name' => 'Đà Nẵng - Hội An Hành trình di sản miền Trung mến khách',
                'price' => 2990000,
                'old_price' => 3600000,
                'description' => 'Sự kết hợp hoàn hảo giữa vé Bà Nà Hills và phòng nghỉ Novotel đẳng cấp quốc tế.',
                'image' => 'https://product.hstatic.net/200000735165/product/ha_web__1__7679513993774a318b178ec426ba5cef.jpg',
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