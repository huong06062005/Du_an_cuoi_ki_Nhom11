<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController; // <--- ĐẢM BẢO PHẢI CÓ DÒNG NÀY

// Tuyến đường trang chủ của bạn
Route::get('/', [HomeController::class, 'index'])->name('home');