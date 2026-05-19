<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ComboController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Admin\OrderController;

/*
|--------------------------------------------------------------------------
| LUỒNG GIAO DIỆN KHÁCH HÀNG (CLIENT)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/combos/{id}', [ComboController::class, 'show'])->name('combos.show');
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/history', [BookingController::class, 'history'])->name('booking.history');

/*
|--------------------------------------------------------------------------
| LUỒNG GIAO DIỆN QUẢN TRỊ (ADMIN DUYỆT ĐƠN)
|--------------------------------------------------------------------------
*/
Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
Route::post('/admin/orders/{id}/update', [OrderController::class, 'updateStatus'])->name('admin.orders.update');