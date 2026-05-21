<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Combo;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{

    /**
     * 1. HÀM HIỂN THỊ TRANG CHỦ - CHỈ HIỂN THỊ ĐÚNG 6 COMBO PHỔ BIẾN NHẤT
     */
    public function index(Request $request)
    {
        $query = Combo::with('services');

        // Lọc tìm các gói phổ biến có chữ [POPULAR] trong mô tả
        $query->where(function($q) {
            if (Schema::hasColumn('combos', 'description')) {
                $q->orWhere('description', 'LIKE', '%[POPULAR]%');
            }
            if (Schema::hasColumn('combos', 'mo_ta')) {
                $q->orWhere('mo_ta', 'LIKE', '%[POPULAR]%');
            }
        });

        $rawFeatured = $query->orderByDesc('id')->get();

        // Ép unique lọc trùng tên
        if (Schema::hasColumn('combos', 'name')) {
            $featuredCombos = $rawFeatured->unique('name')->values();
        } else {
            $featuredCombos = $rawFeatured->unique('ten_combo')->values();
        }

        // BẪY LỖI: Nếu số gói tích POPULAR ít hơn 6, lấy thêm gói nền gốc nạp vào cho đủ 6 ô khít giao diện
        if ($featuredCombos->count() < 6) {
            $rawDefault = Combo::with('services')->orderBy('id', 'asc')->get();
            if (Schema::hasColumn('combos', 'name')) {
                $defaultCombos = $rawDefault->unique('name')->values();
            } else {
                $defaultCombos = $rawDefault->unique('ten_combo')->values();
            }
            // Gộp mảng và cắt đúng 6 gói đầu tiên
            $combos = $featuredCombos->merge($defaultCombos)->unique('id')->take(6);
        } else {
            // Nếu nhiều hơn 6 gói phổ biến, cũng chỉ lấy đúng 6 gói nổi bật nhất
            $combos = $featuredCombos->take(6);
        }

        // Dọn sạch từ khóa ẩn kỹ thuật [POPULAR]
        foreach ($combos as $combo) {
            if (isset($combo->description)) {
                $combo->description = trim(str_replace('[POPULAR]', '', $combo->description));
            }
            if (isset($combo->mo_ta)) {
                $combo->mo_ta = trim(str_replace('[POPULAR]', '', $combo->mo_ta));
            }
            if (isset($combo->mo_ta_text)) {
                $combo->mo_ta_text = trim(str_replace('[POPULAR]', '', $combo->mo_ta_text));
            }
        }

        return view('client.home', compact('combos'));
    }

    /**
     * 2. HÀM HIỂN THỊ TRANG GÓI COMBO - BUNG ĐẦY ĐỦ 20 GÓI SẠCH LỖI LẶP
     */
public function allCombos(Request $request)
{
    $query = Combo::with('services');

    // 1. Xử lý tìm kiếm theo từ khóa thông thường
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%');
            if (Schema::hasColumn('combos', 'ten_combo')) {
                $q->orWhere('ten_combo', 'LIKE', '%' . $search . '%');
            }
        });
    }

    // Lấy dữ liệu thô ra trước để tránh lỗi sập SQL do sai lệch bảng chứa cột
    $rawCombos = $query->orderByDesc('id')->get();

    // 2. Xử lý bộ lọc mức giá THÔNG MINH trực tiếp trên mảng dữ liệu (Collection Filter)
    if ($request->filled('price_range')) {
        $rawCombos = $rawCombos->filter(function($combo) use ($request) {
            // Lấy giá trị tiền triệu thực tế giống hệt logic hiển thị trên giao diện
            if (isset($combo->real_price) && $combo->real_price > 0) {
                $priceToCheck = $combo->real_price;
            } else {
                $priceToCheck = $combo->total_price ?? $combo->price ?? 0;
            }

            // Nếu giá rỗng thì gán mặc định
            if ($priceToCheck == 0) {
                $priceToCheck = 4500000;
            }

            // Tiến hành phân loại mức giá để giữ lại hoặc loại bỏ gói tour
            switch ($request->price_range) {
                case 'under_2m':
                    return $priceToCheck < 2000000;
                case '2m_5m':
                    return $priceToCheck >= 2000000 && $priceToCheck <= 5000000;
                case 'over_5m':
                    return $priceToCheck > 5000000;
                default:
                    return true;
            }
        });
    }

    // 3. Lọc trùng tên để giữ lại đúng các gói gốc độc nhất
    if (Schema::hasColumn('combos', 'name')) {
        $combos = $rawCombos->unique('name')->values();
    } else {
        $combos = $rawCombos->unique('ten_combo')->values();
    }

    // Loại bỏ tag [POPULAR] khỏi mô tả
    foreach ($combos as $combo) {
        if (isset($combo->description)) {
            $combo->description = trim(str_replace('[POPULAR]', '', $combo->description));
        }
        if (isset($combo->mo_ta)) {
            $combo->mo_ta = trim(str_replace('[POPULAR]', '', $combo->mo_ta));
        }
        if (isset($combo->mo_ta_text)) {
            $combo->mo_ta_text = trim(str_replace('[POPULAR]', '', $combo->mo_ta_text));
        }
    }

    return view('client.combos.index', compact('combos'));
}
}