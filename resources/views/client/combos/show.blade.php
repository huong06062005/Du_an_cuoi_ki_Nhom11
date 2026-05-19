@extends('client.layouts.master')
@section('content')
<div class="max-w-6xl mx-auto py-12 px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="md:col-span-2">
        <img src="{{ asset('storage/'.$combo->image) }}" class="w-full h-96 object-cover rounded-3xl shadow-lg mb-8">
        <h2 class="text-3xl font-bold mb-6 text-zinc-800">{{ $combo->name }}</h2>
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h4 class="text-lg font-bold mb-4 border-l-4 border-blue-600 pl-3">Dịch vụ bao gồm trong gói:</h4>
            <div class="space-y-4">
                @foreach($combo->services as $service)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-blue-50 transition">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <div>
                            <p class="font-bold text-gray-800">{{ $service->name }}</p>
                            <p class="text-xs text-gray-400">{{ $service->type }}</p>
                        </div>
                    </div>
                    <span class="font-mono text-sm text-gray-500">{{ number_format($service->price) }}đ</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="md:col-span-1">
        <div class="bg-zinc-900 text-white p-8 rounded-3xl sticky top-24 shadow-2xl">
            <p class="text-gray-400 mb-2">Giá trọn gói 1 khách</p>
            <p class="text-4xl font-bold text-yellow-500 mb-8">{{ number_format($combo->total_price) }} VNĐ</p>
            <a href="{{ route('booking.create', $combo->id) }}" class="block text-center bg-yellow-500 text-black py-4 rounded-xl font-bold text-lg hover:scale-105 transition-transform">ĐẶT TOUR NGAY</a>
            <p class="text-[10px] text-gray-500 mt-4 text-center">Hỗ trợ 24/7 qua hotline: 1900 1234</p>
        </div>
    </div>
</div>
@endsection