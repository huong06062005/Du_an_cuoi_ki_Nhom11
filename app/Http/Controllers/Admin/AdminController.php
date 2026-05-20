<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Đảm bảo em đã tạo các Model này
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
        // Đảm bảo Model Booking đã tồn tại, nếu chưa hãy chạy: php artisan make:model Booking
        $totalBookings = Booking::count();

        // 3. Tính tổng doanh thu từ các đơn hàng đã xác nhận
        // Thầy đổi 'total_price' thành 'gia_tien' cho đồng bộ với các file khác em đã sửa
        $totalRevenue = Booking::where('status', 'confirmed')->sum('gia_tien') ?? 0;

        // 4. Đếm số lượng khách hàng (Không tính admin)
        // LƯU Ý QUAN TRỌNG: Em phải chắc chắn đã thêm cột 'role' vào bảng users
        // Nếu chưa có cột 'role', dòng này sẽ gây lỗi màn hình đỏ ngay lập tức
        try {
            $totalUsers = User::where('role', 'user')->count();
        } catch (\Exception $e) {
            // Nếu lỡ bảng chưa có cột role thì tạm thời trả về 0 để không bị vỡ trang
            $totalUsers = User::count(); 
        }

        // Trả về view admin/dashboard.blade.php kèm dữ liệu
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
        // Tương tự dashboard, phần này cần cột 'role' trong database
        $users = User::latest()->get();

        return view('admin.users.index', compact('users'));
    }
}