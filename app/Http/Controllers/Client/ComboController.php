<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use Illuminate\Http\Request;

class ComboController extends Controller
{
    /**
     * Hàm hiển thị chi tiết 1 combo cho khách xem
     */
    public function show($id)
    {
        // Tìm Combo trong Database theo ID truyền lên.
        // Nếu gõ bừa ID không tồn tại, Laravel tự báo lỗi 404 để bảo mật hệ thống.
        $combo = Combo::findOrFail($id);

        // Trả dữ liệu sang file view hiển thị (tụi mình làm ở Bước 3)
        return view('client.combos.show', compact('combo'));
    }
}