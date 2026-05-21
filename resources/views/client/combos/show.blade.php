@extends('client.layouts.master')

@section('content')
<div class="bg-zinc-50 py-12">
    <div class="max-w-5xl mx-auto px-4">
        
        <div class="mb-6">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 font-medium inline-flex items-center text-sm transition">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách Combo
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8">
            
            <div>
                <img src="{{ \Illuminate\Support\Str::startsWith($combo->image, ['http://', 'https://']) ? $combo->image : asset('storage/'.$combo->image) }}" 
                     class="w-full h-80 md:h-[400px] object-cover rounded-2xl shadow-inner" 
                     alt="{{ $combo->name }}">
            </div>

            <div class="flex flex-col justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 leading-snug">
                        {{ $combo->name }}
                    </h1>

              @php
                 // Đồng bộ logic: Ưu tiên real_price nếu lớn hơn 0 để tránh bug nhận giá 0.00 từ total_price
                if (isset($combo->real_price) && $combo->real_price > 0) {
                 $currentPrice = $combo->real_price;
                } else {
                $currentPrice = $combo->total_price ?? $combo->price ?? 0;
               }

                 $oldPrice = $combo->old_price ?? ($currentPrice * 1.25); 
             @endphp

                    <div class="mb-6">
                        {{-- Giá cũ gạch ngang (nếu có giá cũ hoặc tự tính) --}}
                        <p class="text-gray-400 line-through text-sm mb-1 font-medium">
                            {{ number_format($oldPrice, 0, ',', '.') }}đ
                        </p>

                        <div class="inline-block bg-red-50 px-4 py-2 rounded-xl">
                             <span class="text-3xl font-black text-red-500">
                               {{ number_format($currentPrice, 0, ',', '.') }}đ
                             </span>
                            <span class="text-sm font-bold text-red-400">/khách</span>
                    </div>
                    </div>

                    <div class="border-t border-b py-4 my-4">
                        <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wider mb-3">
                            <i class="fas fa-concierge-bell text-blue-500 mr-2"></i> Dịch vụ bao gồm trong Combo:
                        </h3>
                        
                        <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                            {{ $combo->description ?? 'Gói combo bao gồm dịch vụ phòng nghỉ dưỡng tiêu chuẩn cao cấp và các tiện ích đi kèm của hệ thống Viettravel.' }}
                        </div>
                    </div>
                </div>

                <div class="mt-6 md:mt-0">
                    <a href="{{ route('booking.create', $combo->id) }}" 
                       class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg shadow-blue-200 transition uppercase tracking-wider text-sm">
                        <i class="fas fa-shopping-cart mr-2"></i> Tiến hành đặt Combo ngay
                    </a>
                    <p class="text-center text-gray-400 text-xs mt-2">Giữ chỗ tức thì - Hỗ trợ hủy đổi linh hoạt</p>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection