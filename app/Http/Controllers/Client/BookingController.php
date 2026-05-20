<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class BookingController extends Controller
{
    /**
     * 1. Hàm hiển thị Form điền thông tin đặt Combo
     */
    public function create($combo_id)
    {
        // Kiểm tra xem combo khách muốn đặt có tồn tại không
        $combo = Combo::findOrFail($combo_id);
        
        // Trả về file giao diện form đặt hàng (sẽ tạo ở Bước 3)
        return view('client.bookings.create', compact('combo'));
    }

    /**
     * 2. Hàm xử lý lưu đơn hàng khi khách bấm nút "XÁC NHẬN ĐẶT NGAY"
     */
    public function store(Request $request, $combo_id)
    {
        $combo = Combo::findOrFail($combo_id);

        // Kiểm tra dữ liệu khách nhập vào xem có hợp lệ không
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'quantity' => 'required|integer|min:1',
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên của bạn',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại',
            'customer_email.required' => 'Vui lòng nhập đúng định dạng email',
            'quantity.min' => 'Số lượng người đi phải ít nhất là 1 người',
        ]);

        // Tính tổng tiền = giá 1 combo x số lượng người đi
        $totalPrice = $combo->price * $request->quantity;

        // Lưu thông tin đơn hàng vào bảng 'orders' trong Database
        // (Lưu ý: Nếu bảng quản lý đơn của nhóm bạn tên là 'bookings' thì bạn đổi chữ 'orders' thành 'bookings' nhé)
        DB::table('orders')->insert([
            'combo_id' => $combo->id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'pending', // Trạng thái: Chờ admin duyệt đơn
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Đặt thành công thì quay về trang chủ và bắn một thông báo xanh lè động viên khách
        return redirect()->route('home')->with('success', 'Đặt combo thành công! Đội ngũ DuLịch123 sẽ liên hệ duyệt đơn cho bạn sớm nhất.');
    }
}