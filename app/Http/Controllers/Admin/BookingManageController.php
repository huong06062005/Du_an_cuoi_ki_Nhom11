<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; // Đã import Model Booking để lấy dữ liệu từ database

class BookingManageController extends Controller
{
    /**
     * Danh sách đơn đặt chỗ / đơn đặt tour
     */
    public function index()
    {
        // Lấy danh sách các đơn hàng mới nhất và phân trang (mỗi trang 10 đơn)
        $bookings = Booking::latest()->paginate(10);

        // Kiểm tra xem nhóm đã tạo file view danh sách chưa
        if (view()->exists('admin.bookings.index')) {
            return view('admin.bookings.index', compact('bookings'));
        }
        
        // Nếu lỡ nhóm chưa làm file view riêng, tạm thời trả về trang dashboard 
        // để không bị màn hình lỗi đỏ cho đến khi thiết kế xong view
        return redirect()->route('admin.dashboard')->with('info', 'Hệ thống đã nhận lệnh nhưng file view danh sách đơn hàng (admin.bookings.index) đang được xây dựng.');
    }
}