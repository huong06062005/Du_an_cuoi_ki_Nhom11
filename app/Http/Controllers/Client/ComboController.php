<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Combo; // Đảm bảo em đã tạo Model Combo

class ComboController extends Controller
{
    /**
     * Hiển thị danh sách combo và xử lý tìm kiếm
     * Đáp ứng yêu cầu: Xem danh sách combo & Tìm kiếm combo 
     */
    public function index(Request $request)
    {
        // Khởi tạo query lấy danh sách combo
        $query = Combo::query();

        // 1. Tìm kiếm theo tên hoặc địa điểm (nếu có nhập) 
        if ($request->has('keyword') && $request->keyword != '') {
            $query->where('name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
        }

        // 2. Lọc theo giá (nếu có chọn khoảng giá) 
        if ($request->has('price_range')) {
            if ($request->price_range == 'low') {
                $query->where('total_price', '<', 2000000); // Dưới 2 triệu
            } elseif ($request->price_range == 'mid') {
                $query->whereBetween('total_price', [2000000, 5000000]); // Từ 2 - 5 triệu
            } elseif ($request->price_range == 'high') {
                $query->where('total_price', '>', 5000000); // Trên 5 triệu
            }
        }

        // Lấy dữ liệu và phân trang (ví dụ 9 combo mỗi trang)
        $combos = $query->latest()->paginate(9);

        // Trả về view kèm dữ liệu
        return view('client.combos.index', compact('combos'));
    }

    /**
     * Hiển thị chi tiết một combo cụ thể
     * Đáp ứng yêu cầu: Xem chi tiết thông tin các dịch vụ có trong combo 
     */
    public function show($id)
    {
        // Tìm combo theo ID, đồng thời lấy luôn danh sách dịch vụ đi kèm (Eager Loading) 
        // Mối quan hệ 'services' cần được định nghĩa trong Model Combo
        $combo = Combo::with('services')->findOrFail($id);

        // Trả về view chi tiết
        return view('client.combos.show', compact('combo'));
    }
}