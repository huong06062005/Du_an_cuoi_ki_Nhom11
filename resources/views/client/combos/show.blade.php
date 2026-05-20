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

                    <div class="bg-red-50 text-red-600 inline-block px-4 py-2 rounded-xl font-extrabold text-xl md:text-2xl mb-6">
                        {{ number_format($combo->total_price ?? $combo->price ?? 0) }}đ <span class="text-xs text-gray-500 font-normal">/ khách</span>
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