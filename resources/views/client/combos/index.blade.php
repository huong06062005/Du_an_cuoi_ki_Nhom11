@extends('client.layouts.master')
@section('content')
<div class="bg-zinc-100 py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-8 italic"><i class="fas fa-search mr-2"></i>Kết quả tìm kiếm Combo</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($combos as $combo)
            <div class="bg-white rounded-xl shadow-sm border p-3">
                <img src="{{ asset('storage/'.$combo->image) }}" class="h-40 w-full object-cover rounded-lg mb-3">
                <h4 class="font-bold text-sm mb-2">{{ $combo->name }}</h4>
                <p class="text-red-600 font-bold mb-3">{{ number_format($combo->total_price) }}đ</p>
                <a href="{{ route('combos.show', $combo->id) }}" class="block text-center bg-gray-100 py-2 rounded text-xs font-bold hover:bg-gray-200">XEM CHI TIẾT</a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection