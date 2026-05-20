<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Combo;

class HomeController extends Controller
{
    public function index(Request $request)
{
    $query = Combo::query();

    // Tìm kiếm theo tên hoặc mô tả
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%')
              ->orWhere('description', 'LIKE', '%' . $search . '%');
        });
    }

    // Lọc theo loại hình trải nghiệm
    if ($request->has('category') && $request->category != '') {
        $query->where('description', 'LIKE', '%' . $request->category . '%');
    }

    // ĐÃ SỬA: Lọc mức giá theo đúng cột `total_price` trong Database của bạn
    if ($request->has('price_range') && $request->price_range != '') {
        if ($request->price_range == 'under_2m') {
            $query->where('total_price', '<', 2000000);
        } elseif ($request->price_range == '2m_5m') {
            $query->whereBetween('total_price', [2000000, 5000000]);
        } elseif ($request->price_range == 'over_5m') {
            $query->where('total_price', '>', 5000000);
        }
    }

   $combos = $query->latest()->get();

    return view('client.home', compact('combos'));
}
}