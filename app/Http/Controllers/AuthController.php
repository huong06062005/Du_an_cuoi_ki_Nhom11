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
            'role' => 'user' // Mặc định là khách hàng
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

            // Kiểm tra role để điều hướng trực tiếp vào Admin hoặc User
            if (Auth::user()->role === 'admin') {
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