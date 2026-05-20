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

        // Xử lý tìm kiếm nếu người dùng nhập từ khóa
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
                if (Schema::hasColumn('combos', 'ten_combo')) {
                    $q->orWhere('ten_combo', 'LIKE', '%' . $search . '%');
                }
            });
        }

        $rawCombos = $query->orderByDesc('id')->get();

        // Lọc trùng tên để giữ lại đúng 20 gói gốc độc nhất
        if (Schema::hasColumn('combos', 'name')) {
            $combos = $rawCombos->unique('name')->values();
        } else {
            $combos = $rawCombos->unique('ten_combo')->values();
        }

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