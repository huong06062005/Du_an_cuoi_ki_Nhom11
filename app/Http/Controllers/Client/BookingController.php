<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; // Model quản lý đơn đặt
use App\Models\Combo;   // Model combo để lấy thông tin giá
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Hiển thị form đặt combo
     */
    public function create($combo_id)
    {
        // Lấy thông tin combo để hiển thị trên form đặt hàng
        $combo = Combo::findOrFail($combo_id);
        return view('client.bookings.create', compact('combo'));
    }

    /**
     * Xử lý lưu đơn đặt combo vào database
     * Đáp ứng yêu cầu: Đặt combo trực tuyến & Validation dữ liệu
     */
    public function store(Request $request)
    {
        // 1. Validation: Kiểm tra dữ liệu người dùng nhập vào
        $request->validate([
            'combo_id' => 'required|exists:combos,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|numeric',
            'customer_note' => 'nullable|string',
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên người đặt.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại liên hệ.',
            'customer_phone.numeric' => 'Số điện thoại phải là định dạng số.',
        ]);

        // 2. Lấy thông tin combo để xác định giá tiền (Tính giá tự động)
        $combo = Combo::findOrFail($request->combo_id);

        // 3. Lưu vào bảng bookings trong MySQL
        Booking::create([
            'user_id' => Auth::id(), // ID của người dùng đang đăng nhập
            'combo_id' => $combo->id,
            'total_price' => $combo->total_price, // Lấy giá từ combo
            'customer_note' => $request->customer_note,
            'status' => 'pending', // Mặc định trạng thái là "Chờ xác nhận"
        ]);

        // 4. Chuyển hướng về trang lịch sử với thông báo thành công
        return redirect()->route('booking.history')
                         ->with('success', 'Bạn đã đặt combo thành công! Vui lòng chờ nhân viên xác nhận.');
    }

    /**
     * Hiển thị lịch sử đặt combo của người dùng
     * Đáp ứng yêu cầu: Xem lịch sử đặt combo
     */
    public function history()
{
    // Vì bảng bookings chưa có user_id, tạm thời lấy toàn bộ đơn hàng ra để test giao diện 
    // Sau này khi Admin thêm cột user_id, mình chỉ cần sửa lại điều kiện lọc sau.
    $bookings = Booking::with('combo')
                        ->latest()
                        ->get();

    return view('client.bookings.history', compact('bookings'));
}
}