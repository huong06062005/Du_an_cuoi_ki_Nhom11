@extends('client.layouts.master')

@section('content')
<div class="max-w-xl mx-auto py-16 px-4">
    <div class="bg-white rounded-3xl shadow-2xl p-10 border border-gray-100">
        <h2 class="text-3xl font-bold text-center mb-8 text-zinc-800">Thông Tin Đặt Tour</h2>
        
        <form action="{{ route('booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="combo_id" value="{{ $combo->id }}">
            
            @php
                if (isset($combo->real_price) && $combo->real_price > 0) {
                    $bookingPrice = $combo->real_price;
                } else {
                    $bookingPrice = $combo->total_price ?? $combo->price ?? 0;
                }
                if ($bookingPrice == 0) $bookingPrice = 4500000;
            @endphp
            
            <input type="hidden" name="total_price" value="{{ $bookingPrice }}">
            
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Họ tên của bạn</label>
                <input type="text" name="customer_name" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition" value="{{ old('customer_name') }}" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Số điện thoại liên hệ</label>
                <input type="text" name="customer_phone" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition" value="{{ old('customer_phone') }}" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Yêu cầu đặc biệt</label>
                <textarea name="customer_note" rows="3" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition">{{ old('customer_note') }}</textarea>
            </div>

            <div class="mb-8 p-4 bg-zinc-50 rounded-2xl border border-dashed flex justify-between items-center text-sm">
                <span class="text-gray-600 font-bold uppercase tracking-wide">Tổng tiền thanh toán:</span>
                <span class="text-red-600 font-extrabold text-xl">{{ number_format($bookingPrice, 0, ',', '.') }}đ</span>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-blue-700 transition-all uppercase tracking-wider">
                Gửi yêu cầu xác nhận
            </button>
        </form>
    </div>
</div>
@endsection