<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\Client\HomeController; // <--- ĐẢM BẢO PHẢI CÓ DÒNG NÀY

// Tuyến đường trang chủ của bạn
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/combos', [ComboController::class, 'index'])->name('combos.index'); 
Route::get('/combos/{id}', [ComboController::class, 'show'])->name('combos.show');

// Hệ thống xác thực tài khoản
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    
    // Sử dụng match để chấp nhận cả phương thức GET và POST khi Đăng xuất, tránh lỗi giao diện sidebar
    Route::match(['get', 'post'], '/logout', 'logout')->name('logout'); 
});


/*
|--------------------------------------------------------------------------
| 2. NHÓM CLIENT (Yêu cầu phải đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/{combo_id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings', [BookingController::class, 'history'])->name('booking.history');
});


/*
|--------------------------------------------------------------------------
| 3. NHÓM ADMIN (Quản trị hệ thống)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Giao diện chính Dashboard (Thống kê số liệu tổng quan)
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Các cụm chức năng quản lý danh mục (CRUD Services & Combos)
    Route::resource('services', ServiceController::class); 
    Route::resource('combos', ComboManageController::class);

    // Quản lý Đơn hàng (Hỗ trợ alias cả orders và bookings để giải quyết lỗi Route not defined ở Sidebar/Dashboard)
    Route::get('/orders', [BookingManageController::class, 'index'])->name('orders.index');
    Route::get('/bookings', [BookingManageController::class, 'index'])->name('bookings.index'); 
    Route::patch('/orders/{id}/status', [BookingManageController::class, 'updateStatus'])->name('orders.update');

    // Quản lý danh sách thành viên/khách hàng
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
=======
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ComboController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| 1. CÁC ĐƯỜNG DẪN DÀNH CHO KHÁCH HÀNG (CLIENT)
|--------------------------------------------------------------------------
*/
// Trang chủ: Xem danh sách combo + Tìm kiếm
Route::get('/', [HomeController::class, 'index'])->name('home'); 

// Xem chi tiết một gói combo (SỬA LỖI ĐÃ BÁO)
Route::get('/combos/{id}', [ComboController::class, 'show'])->name('combos.show'); 

// Nhóm tính năng bắt buộc phải ĐĂNG NHẬP mới truy cập được
Route::middleware(['auth'])->group(function () {
    // Form nhập thông tin đặt combo
    Route::get('/booking/create/{combo_id}', [BookingController::class, 'create'])->name('booking.create');
    
    // Xử lý lưu đơn đặt combo vào database
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    
    // Xem lịch sử các đơn hàng đã đặt (SỬA LỖI ĐÃ BÁO)
    Route::get('/booking/history', [BookingController::class, 'history'])->name('booking.history');
});

/*
|--------------------------------------------------------------------------
| 2. HỆ THỐNG XÁC THỰC TÀI KHOẢN & SỬA LỖI LOGOUT
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// SỬA LỖI METHOD NOT ALLOWED: Cho phép cả phương thức GET và POST khi Đăng xuất
Route::any('/logout', [AuthController::class, 'logout'])->name('logout'); 

/*
|--------------------------------------------------------------------------
| 3. PHẦN QUẢN TRỊ VIÊN (ADMIN)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { 
        return view('admin.dashboard'); 
    })->name('dashboard');
    
    // Các route quản lý Admin (CRUD) của em và bạn viết tiếp ở dưới này...
>>>>>>> 2130758 (commit lần 6)
});