<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller 
{
    // 1. Hiển thị form đăng nhập 
    public function showLogin() 
    {
        return view('auth.login'); 
    }

    // 2. Hiển thị form đăng ký
    public function showRegister() 
    {
        return view('auth.register'); 
    }

    // 3. Xử lý đăng ký người dùng mới
    public function register(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user' // Mặc định đăng ký trên web là tài khoản thường
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Mời bạn đăng nhập.');
    }

    // 4. Xử lý đăng nhập và phân quyền Admin
    public function login(Request $request) 
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Bảo mật session

            $user = Auth::user();

            // ĐOẠN CỨU HỘ: Tự động nhận diện và kích hoạt quyền Admin tối cao cho Hương
            // Từ giờ dù em có reset database, chỉ cần đăng nhập bằng email này là hệ thống tự thăng chức Admin luôn, không cần gõ lệnh Tinker nữa.
            if ($user->email === 'huong@gmail.com' && $user->role !== 'admin') {
                $user->role = 'admin';
                $user->save();
            }

            // Kiểm tra cột role để điều hướng đi đúng trang công việc
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); 
            }
            
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->withInput($request->only('email'));
    }

    // 5. Đăng xuất sạch sẽ
    public function logout(Request $request) 
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}