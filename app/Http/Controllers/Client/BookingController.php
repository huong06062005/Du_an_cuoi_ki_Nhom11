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
        // 1. Validation
        $request->validate([
            'combo_id'       => 'required|exists:combos,id',
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|numeric',
            'customer_note'  => 'nullable|string',
        ], [
            'customer_name.required'  => 'Vui lòng nhập họ tên.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'customer_phone.numeric'  => 'Số điện thoại phải là số.',
        ]);

        $combo = Combo::findOrFail($request->combo_id);

        // 2. Lưu vào Database (Đảm bảo tên cột khớp với CSDL của bạn)
        Booking::create([
            'user_id'       => Auth::id(), 
            'combo_id'      => $combo->id,
            'customer_name' => $request->customer_name, // Phải có dòng này
            'phone'         => $request->customer_phone, // Phải có dòng này
            'note'          => $request->customer_note,  // Phải có dòng này
            'total_price'   => $combo->total_price, 
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