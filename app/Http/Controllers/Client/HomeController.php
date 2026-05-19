<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Mock Data: Dữ liệu giả định tự tạo bằng Code, không dính dáng tới DB của bạn khác
        $combos = [
            (object)[
                'id' => 1,
                'name' => 'Combo Phú Quốc Thiên Đường Hạ Giới 3N2Đ',
                'price' => 3500000,
                'duration' => '3 Ngày 2 Đêm',
                'description' => 'Bao gồm vé máy bay khứ hồi khứ hồi và phòng nghỉ Vinpearl Resort 5 sao view biển cực chill.'
            ],
            (object)[
                'id' => 2,
                'name' => 'Combo Đà Nẵng - Hội An Phố Cổ Lãng Mạn',
                'price' => 2800000,
                'duration' => '4 Ngày 3 Đêm',
                'description' => 'Trải nghiệm cáp treo Bà Nà Hills, tham quan Ngũ Hành Sơn và lưu trú khách sạn 4 sao trung tâm thành phố.'
            ],
            (object)[
                'id' => 3,
                'name' => 'Combo Khám Phá Sapa Sương Mù Mờ Ảo',
                'price' => 1950000,
                'duration' => '2 Ngày 1 Đêm',
                'description' => 'Chinh phục đỉnh Fansipan huyền thoại, ở phòng Bungalow view thung lũng Mường Hoa tuyệt đẹp.'
            ],
        ];

        return view('client.home', compact('combos'));
    }
}