<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ComboController;
use App\Http\Controllers\Client\BookingController;

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