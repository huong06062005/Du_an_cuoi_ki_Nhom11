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

// 1. Trang chủ công cộng (Ai vào cũng xem được)
Route::get('/', [HomeController::class, 'index'])->name('home');


// 2. Toàn bộ khu vực dành riêng cho Giao diện Khách hàng (Client)
Route::prefix('client')->name('client.')->group(function () {
    
    // Tuyến đường xem chi tiết từng Combo
    Route::get('/combos/{id}', [ComboController::class, 'show'])->name('combos.show');
    
    // --- KHU VỰC LUỒNG BOOKING (ĐẶT TOUR) ---
    // 1. Route hiển thị form đặt hàng công khai
    Route::get('/booking/{combo_id}', [BookingController::class, 'create'])->name('booking.create');
    
    // 2. Route xử lý lưu đơn hàng khi khách bấm nút gửi form
    Route::post('/booking/{combo_id}', [BookingController::class, 'store'])->name('booking.store');
    
});