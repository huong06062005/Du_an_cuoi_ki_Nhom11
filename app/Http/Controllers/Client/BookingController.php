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
        // 1. Validation cho các trường mới
        $request->validate([
            'combo_id'    => 'required|exists:combos,id',
            'customer_name' => 'required|string|max:255',
            'email'       => 'required|email',
            'phone'       => 'required|string|max:20',
            'adult_count' => 'required|integer|min:1',
            'child_count' => 'required|integer|min:0',
            'check_in'    => 'required|date',
            'note'        => 'nullable|string',
        ]);

        $combo = Combo::findOrFail($request->combo_id);

        // 2. Tính toán giá (Backend xử lý lại để đảm bảo bảo mật)
        // Lấy giá gốc từ combo (ưu tiên real_price)
        $pricePerAdult = $combo->real_price > 0 ? $combo->real_price : ($combo->total_price ?? $combo->price ?? 4500000);
        $pricePerChild = $pricePerAdult * 0.7;

        $totalPrice = ($request->adult_count * $pricePerAdult) + ($request->child_count * $pricePerChild);

        // 3. Lưu vào Database
        Booking::create([
            'user_id'       => Auth::id(), 
            'combo_id'      => $combo->id,
            'customer_name' => $request->customer_name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'adult_count'   => $request->adult_count,
            'child_count'   => $request->child_count,
            'check_in'      => $request->check_in,
            'note'          => $request->note,
            'total_price'   => $totalPrice, 
            'status'        => 'pending', 
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