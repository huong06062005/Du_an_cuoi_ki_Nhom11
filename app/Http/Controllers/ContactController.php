<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('client.contact'); 
    }

    public function store(Request $request)
    {
        // Kiểm tra dữ liệu
        $validated = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email'  => 'required|email',
            'dien_thoai' => 'required|string|max:20',
            'noi_dung' => 'required|string',
        ]);

        // Gợi ý: Nếu bạn muốn lưu vào database, hãy tạo Model Contact
        // Contact::create($validated);

        return back()->with('success', 'Cảm ơn bạn đã liên hệ, chúng tôi sẽ phản hồi sớm nhất!');
    }
}