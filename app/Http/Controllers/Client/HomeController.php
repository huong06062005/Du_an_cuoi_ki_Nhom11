<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Combo; // <--- ĐẢM BẢO PHẢI NẠP MODEL COMBO VÀO ĐÂY

class HomeController extends Controller
{
    public function index()
    {
        // Lấy ra 6 combo mới nhất từ Database
        $combos = Combo::latest()->take(6)->get();

        // Truyền biến $combos sang giao diện trang chủ
        return view('client.home', compact('combos'));
    }
}