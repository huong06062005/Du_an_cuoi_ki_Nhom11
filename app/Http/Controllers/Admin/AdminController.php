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

        // 2. Tính doanh thu an toàn (Tự động tìm tên cột tiền)
        $totalRevenue = 0;
        if (Schema::hasTable('bookings')) {
            $priceColumn = '';
            foreach (['gia_tien', 'total_price', 'price'] as $col) {
                if (Schema::hasColumn('bookings', $col)) {
                    $priceColumn = $col;
                    break;
                }
            }
            if ($priceColumn) {
                $totalRevenue = Booking::where('status', 'confirmed')->sum($priceColumn);
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