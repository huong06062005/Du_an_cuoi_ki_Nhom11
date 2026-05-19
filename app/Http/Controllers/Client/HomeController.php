<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Combo; // Đảm bảo em đã chạy lệnh: php artisan make:model Combo
use Illuminate\Http\Request;

class HomeController extends Controller 
{
    public function index(Request $request) 
    {
        $query = Combo::query();

        // 1. Lọc theo địa điểm (Phần "Địa điểm" trên giao diện)
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // 2. Lọc theo giá từ (Giá từ)
        if ($request->filled('price_from')) {
            $query->where('price', '>=', $request->price_from);
        }

        // 3. Lọc theo giá đến (Giá đến)
        if ($request->filled('price_to')) {
            $query->where('price', '<=', $request->price_to);
        }

        // 4. Tìm kiếm chung (Nếu có ô search tên)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $combos = $query->latest()->get(); // Lấy các combo mới nhất trước

        return view('client.home', compact('combos'));
    }
}