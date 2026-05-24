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
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| 1. NHOM PUBLIC (AI CŨNG TRUY CẬP ĐƯỢC)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/combos', [HomeController::class, 'allCombos'])->name('combos.index');
Route::get('/combos/{id}', [ComboController::class, 'show'])->name('combos.show');

// Route Liên hệ (Bổ sung thêm POST để xử lý form)
Route::get('/lien-he', [ContactController::class, 'index'])->name('contact');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::match(['get', 'post'], '/logout', 'logout')->name('logout'); 
});

/*
|--------------------------------------------------------------------------
| 2. NHÓM CLIENT (BẮT BUỘC ĐĂNG NHẬP)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/{combo_id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings', [BookingController::class, 'history'])->name('booking.history');
});

/*
|--------------------------------------------------------------------------
| 3. NHÓM ADMIN (QUẢN TRỊ HỆ THỐNG)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('services', ServiceController::class); 
    Route::resource('combos', ComboManageController::class);

    // QUẢN LÝ ĐƠN HÀNG (BOOKINGS / ORDERS)
    Route::get('/orders', [BookingManageController::class, 'index'])->name('orders.index');
    Route::get('/bookings', [BookingManageController::class, 'index'])->name('bookings.index');
    
    // 🔥 ĐÃ ĐỒNG BỘ: Đổi chú thích chuẩn PHP để sạch lỗi ParseError
    Route::patch('/orders/{id}', [BookingManageController::class, 'updateStatus'])->name('orders.update');
    
    // Tuyến đường xem chi tiết đơn đặt tour tách biệt sạch lỗi 500
    Route::get('/orders/{id}', [BookingManageController::class, 'show'])->name('orders.show');

    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
});