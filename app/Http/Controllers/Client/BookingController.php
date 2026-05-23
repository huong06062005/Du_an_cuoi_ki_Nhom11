<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; 
use App\Models\Combo;   
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Hiển thị form đặt combo
     */
    public function create($combo_id)
    {
        $combo = Combo::findOrFail($combo_id);
        return view('client.bookings.create', compact('combo'));
    }

    /**
     * Xử lý lưu đơn đặt combo vào database
     */
    public function store(Request $request)
    {
        // 1. Validation giữ nguyên để kiểm tra tính hợp lệ từ giao diện
        $request->validate([
            'combo_id'      => 'required|exists:combos,id',
            'customer_name' => 'required|string|max:255',
            'email'         => 'required|email',
            'phone'         => 'required|string|max:20',
            'adult_count'   => 'required|integer|min:1',
            'child_count'   => 'required|integer|min:0',
            'check_in'      => 'required|date',
            'note'          => 'nullable|string',
        ]);

        $combo = Combo::findOrFail($request->combo_id);

        // 2. Tính toán tổng tiền
        $pricePerAdult = $combo->real_price > 0 ? $combo->real_price : ($combo->total_price ?? $combo->price ?? 4500000);
        $pricePerChild = $pricePerAdult * 0.7;

        $totalPrice = ($request->adult_count * $pricePerAdult) + ($request->child_count * $pricePerChild);

        // 3. 🔥 ĐA SỬA: Chỉ lưu đúng những cột thực tế bảng bookings của em đang có trong Database
        Booking::create([
            'user_id'        => Auth::id(), // Hệ thống tự map thông tin Tên, Email qua ID này
            'combo_id'       => $combo->id,
            'adults'         => $request->adult_count,
            'children'       => $request->child_count,
            'departure_date' => $request->check_in,
            'total_price'    => $totalPrice, 
            'status'         => 'pending', 
            'note'           => $request->note,
        ]);

        return redirect()->route('booking.history')
                         ->with('success', 'Bạn đã đặt combo thành công! Vui lòng chờ xác nhận.');
    }

    /**
     * Hiển thị lịch sử đặt combo
     */
    public function history()
    {
        $bookings = Booking::where('user_id', auth()->id())
                            ->with('combo')
                            ->latest()
                            ->get();

        return view('client.bookings.history', compact('bookings'));
    }
}