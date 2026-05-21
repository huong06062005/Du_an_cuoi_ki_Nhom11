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
     */
    public function store(Request $request)
    {
        // 1. Validation: Kiểm tra dữ liệu người dùng nhập vào (Đã đồng bộ tên ô nhập liệu)
        $request->validate([
            'combo_id' => 'required|exists:combos,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|numeric',
            'note' => 'nullable|string',
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên người đặt.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại liên hệ.',
            'customer_phone.numeric' => 'Số điện thoại phải là định dạng số.',
        ]);

        // 2. Lấy thông tin combo để xác định giá tiền (Tính giá tự động)
        $combo = Combo::findOrFail($request->combo_id);

        // 3. ĐÃ SỬA: Bỏ hoàn toàn cột note để tránh lỗi database không có cột này
        Booking::create([
            'user_id'     => Auth::id(), 
            'combo_id'    => $combo->id,
            'total_price' => $combo->total_price, 
            'status'      => 'pending', 
        ]);

        // 4. Chuyển hướng về trang lịch sử với thông báo thành công
        return redirect()->route('booking.history')
                         ->with('success', 'Bạn đã đặt combo thành công! Vui lòng chờ nhân viên xác nhận.');
    }

    /**
     * Hiển thị lịch sử đặt combo của người dùng
     */
   public function history()
    {
        // ĐÃ FIX: Chỉ lấy danh sách đã đặt của CHÍNH KHÁCH HÀNG ĐANG ĐĂNG NHẬP để đảm bảo bảo mật
        $bookings = Booking::where('user_id', auth()->id())
                            ->with('combo')
                            ->latest()
                            ->get();

        // Trả về view lịch sử đặt combo của khách hàng
        return view('client.bookings.history', compact('bookings'));
    }
}