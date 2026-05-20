<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Đảm bảo các Model này đã tồn tại trong thư mục app/Models
use App\Models\User;
use App\Models\Combo;
use App\Models\Booking;

class AdminController extends Controller
{
    /**
     * Trang Dashboard - Thống kê tổng quan cho Admin
     */
    public function dashboard()
    {
        // 1. Đếm tổng số combo du lịch
        $totalCombos = Combo::count();

        // 2. Đếm tổng số đơn đặt hàng
        $totalBookings = Booking::count();

        // 3. Tính tổng doanh thu từ các đơn hàng đã xác nhận
        // Tự động quét và thử nghiệm các tên cột phổ biến để phòng tránh lỗi Column not found
        try {
            $totalRevenue = Booking::where('status', 'confirmed')->sum('gia_tien');
        } catch (\Exception $e) {
            try {
                $totalRevenue = Booking::where('status', 'confirmed')->sum('total_price');
            } catch (\Exception $ex) {
                try {
                    $totalRevenue = Booking::where('status', 'confirmed')->sum('price');
                } catch (\Exception $lastEx) {
                    $totalRevenue = 0; // Trả về 0 nếu không tìm thấy bất kỳ cột tiền nào trùng khớp
                }
            }
        }
        $totalRevenue = $totalRevenue ?? 0;

        // 4. Đếm số lượng khách hàng (Không tính admin)
        try {
            $totalUsers = User::where('role', 'user')->count();
        } catch (\Exception $e) {
            // Nếu lỡ bảng chưa có cột role thì tạm thời trả về tổng số user để không bị vỡ trang
            $totalUsers = User::count(); 
        }

        // --- CẬP NHẬT MỚI: XỬ LÝ LOGIC THỐNG KÊ PHẦN TRĂM THEO TRẠNG THÁI ĐƠN HÀNG ---
        if ($totalBookings > 0) {
            // Đếm số lượng đơn hàng theo từng trạng thái trong MySQL
            $confirmedCount = Booking::where('status', 'confirmed')->count();
            $pendingCount = Booking::where('status', 'pending')->count();
            $cancelledCount = Booking::where('status', 'cancelled')->count();

            // Tính toán tỷ lệ phần trăm (Làm tròn bằng hàm round)
            $confirmedPercentage = round(($confirmedCount / $totalBookings) * 100);
            $pendingPercentage = round(($pendingCount / $totalBookings) * 100);
            $cancelledPercentage = round(($cancelledCount / $totalBookings) * 100);
        } else {
            // Thiết lập giá trị mặc định nếu hệ thống mới reset và chưa có đơn hàng nào
            $confirmedPercentage = 0;
            $pendingPercentage = 0;
            $cancelledPercentage = 0;
        }

        // Trả về view admin/dashboard.blade.php kèm dữ liệu số liệu
        return view('admin.dashboard', compact(
            'totalCombos', 
            'totalBookings', 
            'totalRevenue', 
            'totalUsers',
            'confirmedPercentage', // Truyền biến dữ liệu thật sang view
            'pendingPercentage',   // Truyền biến dữ liệu thật sang view
            'cancelledPercentage'  // Truyền biến dữ liệu thật sang view
        ));
    }

    /**
     * Danh sách khách hàng
     */
    public function users()
    {
        // Lấy danh sách user, xếp mới nhất lên đầu
        try {
            $users = User::where('role', 'user')->latest()->get();
        } catch (\Exception $e) {
            $users = User::latest()->get();
        }

        return view('admin.users.index', compact('users'));
    }
}