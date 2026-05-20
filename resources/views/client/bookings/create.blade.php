@extends('client.layouts.master')

@section('content')
<div class="max-w-xl mx-auto py-16 px-4">
    <div class="bg-white rounded-3xl shadow-2xl p-10 border border-gray-100">
        <h2 class="text-3xl font-bold text-center mb-8 text-zinc-800">Thông Tin Đặt Tour</h2>
        
        <form action="{{ route('booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="combo_id" value="{{ $combo->id }}">
            
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Họ tên của bạn</label>
                <input type="text" name="customer_name" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition @error('customer_name') border-red-500 @enderror" value="{{ old('customer_name') }}">
                @error('customer_name') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Số điện thoại liên hệ</label>
                <input type="text" name="customer_phone" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition @error('customer_phone') border-red-500 @enderror" value="{{ old('customer_phone') }}">
                @error('customer_phone') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Yêu cầu đặc biệt</label>
                <textarea name="customer_note" rows="3" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition">{{ old('customer_note') }}</textarea>
            </div>

            <div class="mb-8 p-4 bg-zinc-50 rounded-2xl border border-dashed flex justify-between items-center text-sm">
                <span class="text-gray-600 font-bold uppercase tracking-wide">Tổng tiền thanh toán:</span>
                <span class="text-red-600 font-extrabold text-xl">
                    {{ number_format($combo->total_price ?? 0) }}đ
                </span>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-blue-700 transition-all uppercase tracking-wider">
                Gửi yêu cầu xác nhận
            </button>
        </form>
    </div>
</div>
@endsection