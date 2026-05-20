<?php

use Illuminate\Support\Facades\Route;
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
});