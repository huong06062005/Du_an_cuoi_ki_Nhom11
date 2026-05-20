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
                <input type="text" name="name" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                @error('name') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Số điện thoại liên hệ</label>
                <input type="text" name="phone" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition" value="{{ old('phone') }}">
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Yêu cầu đặc biệt</label>
                <textarea name="note" rows="3" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition"></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-blue-700 transition-all">GỬI YÊU CẦU XÁC NHẬN</button>
        </form>
    </div>
</div>
@endsection