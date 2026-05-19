<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; // Sử dụng Model Booking để quản lý đơn hàng

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách tất cả đơn đặt combo của khách hàng
     * Đáp ứng yêu cầu: Quản lý đơn đặt combo 
     */
    public function index()
    {
        // Lấy toàn bộ đơn hàng, kèm thông tin Khách hàng (user) và Gói dịch vụ (combo)
        $orders = Booking::with(['user', 'combo'])->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Cập nhật trạng thái đơn hàng (Xác nhận hoặc Hủy)
     * Đáp ứng yêu cầu: Xác nhận hoặc hủy đơn đặt combo 
     */
    public function updateStatus(Request $request, $id)
    {
        // 1. Tìm đơn hàng theo ID
        $order = Booking::findOrFail($id);

        // 2. Validation: Đảm bảo trạng thái gửi lên là hợp lệ
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        // 3. Cập nhật trạng thái mới
        $order->update([
            'status' => $request->status
        ]);

        // 4. Trả về thông báo thành công
        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
    }

    /**
     * Xem chi tiết một đơn đặt hàng cụ thể
     */
    public function show($id)
    {
        $order = Booking::with(['user', 'combo.services'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}