<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ComboController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ComboManageController;
use App\Http\Controllers\Admin\BookingManageController;

/*
|--------------------------------------------------------------------------
| 1. NHÓM PUBLIC (Ai cũng truy cập được)
|--------------------------------------------------------------------------
*/

// Trang chủ và xem danh sách, chi tiết Combo cho khách hàng
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/combos', [ComboController::class, 'index'])->name('combos.index'); 
Route::get('/combos/{id}', [ComboController::class, 'show'])->name('combos.show');

// Hệ thống xác thực tài khoản (Đăng nhập, Đăng ký, Đăng xuất)
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
| 2. NHÓM CLIENT (Yêu cầu khách hàng phải đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/{combo_id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings', [BookingController::class, 'history'])->name('booking.history');
});


/*
|--------------------------------------------------------------------------
| 3. NHÓM ADMIN (Quản trị hệ thống - Yêu cầu Đăng nhập & Quyền Admin)
|--------------------------------------------------------------------------
*/
// GIẢI PHÁP AN TOÀN: Đưa logic kiểm tra phân quyền chạy lồng bên trong callback group.
// Laravel sẽ biên dịch mượt mà vì mảng middleware chỉ chứa duy nhất chuỗi 'auth' chuẩn framework.
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Thao tác kiểm tra an toàn tại thời điểm chạy: Nếu đăng nhập không phải admin, chặn ngay tại cửa ngõ
    if (auth()->check() && auth()->user()->role !== 'admin') {
        Route::any('{any}', function () {
            return redirect('/')->withErrors(['auth' => 'Bạn không có quyền truy cập vào khu vực quản trị.']);
        })->where('any', '.*');
    }

    // Giao diện chính Dashboard (Thống kê số liệu tổng quan)
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Các cụm chức năng quản lý danh mục (CRUD Services & Combos)
    Route::resource('services', ServiceController::class); 
    Route::resource('combos', ComboManageController::class);

    // Quản lý Đơn hàng (Hỗ trợ song song cả orders và bookings để khớp hoàn toàn với giao diện Dashboard/Sidebar)
    Route::get('/orders', [BookingManageController::class, 'index'])->name('orders.index');
    Route::get('/bookings', [BookingManageController::class, 'index'])->name('bookings.index');
    Route::patch('/orders/{id}/status', [BookingManageController::class, 'updateStatus'])->name('orders.update');

    // Quản lý danh sách thành viên/khách hàng
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
});