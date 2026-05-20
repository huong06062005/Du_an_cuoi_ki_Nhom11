<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Combo;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * 1. HÀM HIỂN THỊ TRANG CHỦ (Đã chạy ngon, giữ nguyên)
     */
    public function index(Request $request)
    {
        $query = Combo::with('services');

        $query->where(function($q) {
            if (Schema::hasColumn('combos', 'description')) {
                $q->orWhere('description', 'LIKE', '%[POPULAR]%');
            }
            if (Schema::hasColumn('combos', 'mo_ta')) {
                $q->orWhere('mo_ta', 'LIKE', '%[POPULAR]%');
            }
        });

        $combos = $query->orderByDesc('id')->get();

        if ($combos->count() < 6) {
            $combos = Combo::with('services')->orderBy('id', 'asc')->take(6)->get();
        } else {
            $combos = $combos->take(6);
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

        return view('client.home', compact('combos'));
    }

    /**
     * 2. HÀM HIỂN THỊ TRANG GÓI COMBO - KHÓA TẬN GỐC LỖI LẶP DỮ LIỆU
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

        // Bước 1: Lấy toàn bộ danh sách thô sắp xếp theo ID giảm dần
        $rawCombos = $query->orderByDesc('id')->get();

        // Bước 2: ÉP UNIQUE SẠCH THEO TÊN + GỌI VALUES() ĐỂ RESET KEY MẢNG GỐC (BẮT BUỘC)
        if (Schema::hasColumn('combos', 'name')) {
            $combos = $rawCombos->unique('name')->values();
        } else {
            $combos = $rawCombos->unique('ten_combo')->values();
        }

        // Bước 3: Dọn sạch từ khóa ẩn kỹ thuật [POPULAR]
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