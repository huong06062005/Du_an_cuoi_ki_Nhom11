<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ComboController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Admin\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes - Tuyến đường hiển thị Web
|--------------------------------------------------------------------------
*/

// 1. Trang chủ công cộng
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Toàn bộ khu vực dành riêng cho Giao diện Khách hàng (Client)
Route::prefix('client')->name('client.')->group(function () {
    
    // Tuyến đường xem chi tiết từng Combo
    Route::get('/combos/{id}', [ComboController::class, 'show'])->name('combos.show');
    
    // --- LUỒNG BOOKING (ĐẶT TOUR) ---
    // Hiển thị form đặt hàng
    Route::get('/booking/{combo_id}', [BookingController::class, 'create'])->name('booking.create');
    
    // Xử lý lưu đơn hàng khi bấm gửi form
    Route::post('/booking/{combo_id}', [BookingController::class, 'store'])->name('booking.store');
    
});

// 3. Khu vực dành riêng cho Quản lý (Admin) - Cần duyệt đơn hàng
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Trang danh sách toàn bộ đơn hàng khách đã đặt
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    
    // Route xử lý khi Admin bấm nút "Duyệt đơn"
    Route::post('/orders/{id}/approve', [OrderController::class, 'approve'])->name('orders.approve');
    
    // Route xử lý khi Admin bấm nút "Hủy đơn"
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    
});