@extends('client.layouts.master')

@section('content')
<div class="max-w-xl mx-auto py-16 px-4">
    <div class="bg-white rounded-3xl shadow-2xl p-10 border border-gray-100">
        <h2 class="text-3xl font-bold text-center mb-8 text-zinc-800">Thông Tin Đặt Tour</h2>
        
        <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
            @csrf
            <input type="hidden" name="combo_id" value="{{ $combo->id }}">
            
            {{-- Lấy giá gốc --}}
            @php
                $pricePerAdult = $combo->real_price > 0 ? $combo->real_price : ($combo->total_price ?? $combo->price ?? 4500000);
            @endphp
            <input type="hidden" id="pricePerAdult" value="{{ $pricePerAdult }}">

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-6 col-span-2 md:col-span-1">
                    <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Họ tên</label>
                    <input type="text" name="customer_name" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition" required>
                </div>
                <div class="mb-6 col-span-2 md:col-span-1">
                    <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Số điện thoại</label>
                <input type="text" name="phone" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Người lớn</label>
                    <input type="number" name="adult_count" id="adult_count" value="1" min="1" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Trẻ em (<10t)</label>
                    <input type="number" name="child_count" id="child_count" value="0" min="0" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Ngày đi</label>
                <input type="date" name="check_in" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition" required>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-600 mb-2 uppercase tracking-wide">Yêu cầu đặc biệt</label>
                <textarea name="note" rows="2" class="w-full bg-gray-50 border-b-2 border-gray-200 p-3 outline-none focus:border-blue-600 transition"></textarea>
            </div>

            <div class="mb-8 p-4 bg-zinc-50 rounded-2xl border border-dashed flex justify-between items-center text-sm">
                <span class="text-gray-600 font-bold uppercase tracking-wide">Tổng tiền:</span>
                <input type="hidden" name="total_price" id="total_price_input" value="{{ $pricePerAdult }}">
                <span class="text-red-600 font-extrabold text-xl" id="total_price_display">{{ number_format($pricePerAdult, 0, ',', '.') }}đ</span>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-blue-700 transition-all uppercase tracking-wider">
                Gửi yêu cầu đặt tour
            </button>
        </form>
    </div>
</div>

<script>
    const adultInput = document.getElementById('adult_count');
    const childInput = document.getElementById('child_count');
    const pricePerAdult = parseFloat(document.getElementById('pricePerAdult').value);
    const display = document.getElementById('total_price_display');
    const inputTotal = document.getElementById('total_price_input');

    function calculate() {
        let adults = parseInt(adultInput.value) || 0;
        let children = parseInt(childInput.value) || 0;
        let total = (adults * pricePerAdult) + (children * pricePerAdult * 0.7);
        
        display.innerText = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
        inputTotal.value = total;
    }

    adultInput.addEventListener('input', calculate);
    childInput.addEventListener('input', calculate);
</script>
@endsection