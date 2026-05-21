<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Combo;
use App\Models\Booking;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Thống kê cơ bản
        $totalCombos   = Combo::count();
        $totalBookings = Booking::count();

        // 2. 🔥 ĐÃ TỐI ƯU: Tính doanh thu thông minh, bẫy lỗi cột tiền bằng 0 và tự động lấy giá gốc của Combo
        $totalRevenue = 0;
        if (Schema::hasTable('bookings')) {
            // Xác định tên cột tiền hiện tại của bảng bookings
            $priceColumn = '';
            foreach (['gia_tien', 'total_price', 'price'] as $col) {
                if (Schema::hasColumn('bookings', $col)) {
                    $priceColumn = $col;
                    break;
                }
            }

            // Lấy tất cả đơn hàng (Tính cho cả trạng thái confirmed và pending để hiển thị chính xác)
            // Đồng thời eager load quan hệ 'combo' để lôi giá gốc nếu cần
            $bookings = Booking::with('combo')
                ->whereIn('status', ['confirmed', 'pending']) 
                ->get();

            foreach ($bookings as $booking) {
                // Thử lấy giá lưu ở bảng booking trước
                $currentPrice = $priceColumn ? ($booking->$priceColumn ?? 0) : 0;

                // 💡 BẪY LỖI THẦN THÁNH: Nếu giá trị bằng 0, chủ động lôi giá từ bảng combo đắp vào tính toán
                if ($currentPrice == 0 && isset($booking->combo)) {
                    $currentPrice = $booking->combo->real_price ?? ($booking->combo->price ?? ($booking->combo->gia_tien ?? 0));
                }

                // Cộng dồn vào tổng doanh thu
                $totalRevenue += $currentPrice;
            }
        }

        // 3. Đếm người dùng
        $totalUsers = Schema::hasColumn('users', 'role') 
                      ? User::where('role', 'user')->count() 
                      : User::count();

        // 4. Thống kê phần trăm trạng thái đơn hàng (Tối ưu hóa chỉ với 1 query)
        $statusCounts = Booking::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $confirmedCount = $statusCounts['confirmed'] ?? 0;
        $pendingCount   = $statusCounts['pending'] ?? 0;
        $cancelledCount = $statusCounts['cancelled'] ?? 0;

        $confirmedPercentage = $totalBookings > 0 ? round(($confirmedCount / $totalBookings) * 100) : 0;
        $pendingPercentage   = $totalBookings > 0 ? round(($pendingCount / $totalBookings) * 100) : 0;
        $cancelledPercentage = $totalBookings > 0 ? round(($cancelledCount / $totalBookings) * 100) : 0;

        return view('admin.dashboard', compact(
            'totalCombos', 'totalBookings', 'totalRevenue', 'totalUsers',
            'confirmedPercentage', 'pendingPercentage', 'cancelledPercentage'
        ));
    }

    public function users()
    {
        $users = Schema::hasColumn('users', 'role') 
                 ? User::where('role', 'user')->latest()->get() 
                 : User::latest()->get();

        return view('admin.users.index', compact('users'));
    }
}