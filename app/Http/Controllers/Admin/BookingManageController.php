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
        // 1. Lấy danh sách các đơn hàng mới nhất và phân trang hoặc lấy toàn bộ
        // Đổi tên biến từ $bookings thành $orders để khớp khít với vòng lặp @foreach($orders) ngoài View
        $orders = Booking::with(['user', 'combo'])->latest()->get();

        // 2. Kiểm tra xem file view có nằm trong thư mục admin/orders/index.blade.php không
        if (view()->exists('admin.orders.index')) {
            return view('admin.orders.index', compact('orders'));
        }
        
        // Dự phòng an toàn nếu lỡ xóa nhầm file view
        return redirect()->route('admin.dashboard')->with('error', 'Không tìm thấy file view giao diện quản lý đơn hàng.');
    }

    /**
     * Xử lý phê duyệt trạng thái đơn hàng (Khớp với route PATCH admin.orders.update)
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Booking::findOrFail($id);
        $order->status = $request->input('status', 'confirmed');
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    /**
     * Xem chi tiết đơn hàng (Khớp với route admin.orders.show)
     */
    public function show($id)
    {
        $order = Booking::with(['user', 'combo'])->findOrFail($id);
        
        if (view()->exists('admin.orders.show')) {
            return view('admin.orders.show', compact('order'));
        }
        
        return back()->with('info', 'Tính năng xem chi tiết đơn hàng đang được hoàn thiện.');
    }
}