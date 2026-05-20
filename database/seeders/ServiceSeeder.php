<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Facades\Schema;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh sách đúng 20 dịch vụ thành phần thực tế
        $services = [
            // 🏢 KHÁCH SẠN / NGHỈ DƯỠNG (6 dịch vụ)
            ['name' => 'Khách sạn Mường Thanh Luxury 5 sao (Hạ Long)', 'type' => 'hotel', 'price' => 1850000, 'mo_ta_chi_tiet' => 'Phòng Deluxe hướng biển, bao gồm ăn sáng buffet cao cấp.'],
            ['name' => 'Novotel Danang Premier Han River', 'type' => 'hotel', 'price' => 2400000, 'mo_ta_chi_tiet' => 'Phòng Superior view trọn vẹn cầu Sông Hàn và trung tâm thành phố.'],
            ['name' => 'Vinpearl Resort & Spa Phú Quốc', 'type' => 'hotel', 'price' => 3200000, 'mo_ta_chi_tiet' => 'Villa 2 phòng ngủ hướng vườn, có hồ bơi riêng biệt.'],
            ['name' => 'Hôtel de la Coupole - MGallery (Sapa)', 'type' => 'hotel', 'price' => 2950000, 'mo_ta_chi_tiet' => 'Phòng Classic phong cách Pháp thượng lưu giữa lòng Sapa.'],
            ['name' => 'InterContinental Hanoi Westlake', 'type' => 'hotel', 'price' => 2700000, 'mo_ta_chi_tiet' => 'Phòng nghỉ lãng mạn xây dựng hoàn toàn trên mặt nước Hồ Tây.'],
            ['name' => 'Khách sạn Silk Path Grand Huế', 'type' => 'hotel', 'price' => 1450000, 'mo_ta_chi_tiet' => 'Không gian cung đình sang trọng, gần dòng sông Hương thơ mộng.'],

            // 🚗 XE ĐƯA ĐÓN / DI CHUYỂN (5 dịch vụ)
            ['name' => 'Xe Limousine khứ hồi Hà Nội - Sapa (Hãng Sao Việt)', 'type' => 'car', 'price' => 650000, 'mo_ta_chi_tiet' => 'Ghế ngả massage VIP, nước uống, wifi tốc độ cao miễn phí.'],
            ['name' => 'Xe ô tô 4 chỗ đón tiễn sân bay Nội Bài - Trung tâm Hà Nội', 'type' => 'car', 'price' => 280000, 'mo_ta_chi_tiet' => 'Xe đời mới sạch sẽ, tài xế bản địa đón đúng giờ tại sảnh.'],
            ['name' => 'Xe du lịch 16 chỗ đưa đón các điểm tham quan Đà Nẵng - Hội An', 'type' => 'car', 'price' => 1200000, 'mo_ta_chi_tiet' => 'Trọn gói di chuyển 1 ngày phục vụ theo lịch trình tự do của khách.'],
            ['name' => 'Thuê xe máy tay ga tự lái tại Phú Quốc (24 giờ)', 'type' => 'car', 'price' => 150000, 'mo_ta_chi_tiet' => 'Xe Honda AirBlade đời mới kèm 2 mũ bảo hiểm đạt chuẩn.'],
            ['name' => 'Xe giường nằm phòng đôi VIP Hà Nội - Hà Giang', 'type' => 'car', 'price' => 550000, 'mo_ta_chi_tiet' => 'Cabin đôi riêng tư dành cho 2 người, trang bị màn hình giải trí.'],

            // ✈️ VÉ MÁY BAY / TÀU HỎA (4 dịch vụ)
            ['name' => 'Vé máy bay khứ hồi Hà Nội - Đà Nẵng (Vietnam Airlines)', 'type' => 'flight', 'price' => 2650000, 'mo_ta_chi_tiet' => 'Đã bao gồm 7kg hành lý xách tay và 23kg hành lý ký gửi.'],
            ['name' => 'Vé máy bay một chiều TP.HCM - Phú Quốc (Vietjet Air)', 'type' => 'flight', 'price' => 980000, 'mo_ta_chi_tiet' => 'Hạng vé Eco tiết kiệm, giờ bay đẹp vào khung giờ sáng.'],
            ['name' => 'Vé tàu hỏa du lịch giường nằm khứ hồi Hà Nội - Lào Cai', 'type' => 'flight', 'price' => 1100000, 'mo_ta_chi_tiet' => 'Khoang 4 giường nằm điều hòa chất lượng cao Vicaza.'],
            ['name' => 'Vé máy bay khứ hồi Hà Nội - Nha Trang (Bamboo Airways)', 'type' => 'flight', 'price' => 2890000, 'mo_ta_chi_tiet' => 'Suất ăn nhẹ trên máy bay, bay đúng giờ, dịch vụ chu đáo.'],

            // 🎟️ VÉ THAM QUAN / TRẢI NGHIỆM (5 dịch vụ)
            ['name' => 'Vé cáp treo Sun World Fansipan Legend (Sapa)', 'type' => 'ticket', 'price' => 800000, 'mo_ta_chi_tiet' => 'Vé khứ hồi chinh phục đỉnh Fansipan - Nóc nhà Đông Dương.'],
            ['name' => 'Vé vui chơi trọn gói VinWonders & Safari Phú Quốc', 'type' => 'ticket', 'price' => 1350000, 'mo_ta_chi_tiet' => 'Vào cổng không giới hạn khu vui chơi giải trí và vườn thú mở.'],
            ['name' => 'Vé cáp treo và vui chơi Bà Nà Hills Đà Nẵng', 'type' => 'ticket', 'price' => 900000, 'mo_ta_chi_tiet' => 'Bao gồm cáp treo khứ hồi, check-in Cầu Vàng và Fantasy Park.'],
            ['name' => 'Tour du thuyền 5 sao vịnh Hạ Long (Lịch trình 6 tiếng)', 'type' => 'ticket', 'price' => 1250000, 'mo_ta_chi_tiet' => 'Bao gồm tiệc buffet trưa hải sản, chèo thuyền Kayak tại Hang Luồn.'],
            ['name' => 'Vé Ký ức Hội An - Hạng ghế High (H)', 'type' => 'ticket', 'price' => 750000, 'mo_ta_chi_tiet' => 'Thưởng thức show diễn thực cảnh đẹp và hoành tráng nhất thế giới.'],
        ];

        // Duyệt qua mảng và nạp dữ liệu thông minh vào MySQL
        foreach ($services as $item) {
            $rawInputs = [
                'name'           => $item['name'],
                'ten_dich_vu'    => $item['name'],
                'type'           => $item['type'],
                'loai_dich_vu'   => $item['type'],
                'price'          => $item['price'],
                'gia_tien'       => $item['price'],
                'gia_goc'        => $item['price'],
                'gia_nhap'       => $item['price'],
                'mo_ta'          => $item['mo_ta_chi_tiet'],
                'mo_ta_chi_tiet' => $item['mo_ta_chi_tiet'],
                'provider'       => 'VIETTRAVEL',
                'status'         => 'available',
            ];

            // Tự động kiểm tra database thực tế có cột nào thì chỉ giữ lại cột đó
            $safeData = array_filter($rawInputs, function ($key) {
                return Schema::hasColumn('services', $key);
            }, ARRAY_FILTER_USE_KEY);

            Service::create($safeData);
        }
    }
}