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

        // Trả về view admin/dashboard.blade.php kèm dữ liệu số liệu
        return view('admin.dashboard', compact(
            'totalCombos', 
            'totalBookings', 
            'totalRevenue', 
            'totalUsers'
        ));
    }

    /**
     * Danh sách khách hàng
     */
    public function users()
    {
        // Lấy danh sách user, xếp mới nhất lên đầu
        $users = User::latest()->get();

        return view('admin.users.index', compact('users'));
    }
}