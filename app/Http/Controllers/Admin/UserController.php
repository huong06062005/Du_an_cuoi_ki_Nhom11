<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Sử dụng Model User để quản lý tài khoản

class UserController extends Controller
{
    /**
     * Hiển thị danh sách khách hàng
     * Đáp ứng yêu cầu: Quản lý khách hàng (Xem tài khoản người dùng)
     */
    public function index()
    {
        // Lấy danh sách tất cả người dùng có vai trò là khách hàng (user)
        // Không hiển thị tài khoản admin để đảm bảo an toàn
        $users = User::where('role', 'user')->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Hiển thị chi tiết thông tin một khách hàng và lịch sử đặt combo của họ
     */
    public function show($id)
    {
        // Lấy thông tin khách hàng cùng với các đơn hàng họ đã đặt
        $user = User::with('bookings.combo')->findOrFail($id);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Xóa tài khoản khách hàng (nếu cần thiết)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Kiểm tra nếu là tài khoản admin thì không cho phép xóa qua trang này
        if ($user->role == 'admin') {
            return redirect()->back()->with('error', 'Không thể xóa tài khoản Quản trị viên!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Đã xóa tài khoản khách hàng thành công!');
    }
}