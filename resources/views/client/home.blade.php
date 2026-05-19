@extends('client.layouts.master')

@section('content')
    <div class="relative w-full h-[550px] flex items-center justify-center bg-cover bg-center" 
         style="background-image: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80');">
        
        <div class="text-center w-full px-4">
            <h1 class="text-white text-5xl font-extrabold mb-4 drop-shadow-lg uppercase tracking-tight">
                Khám Phá Thế Giới Với Combo Tiết Kiệm
            </h1>
            <p class="text-white/90 text-lg font-medium mb-12 drop-shadow-md">
                Khách sạn + Máy bay + Tham quan giá tốt nhất
            </p>

            <div class="max-w-6xl mx-auto bg-white p-5 rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,0.3)] flex flex-col md:flex-row items-center gap-4 border border-white/20">
                <div class="flex-1 w-full text-left px-6 border-r border-slate-100">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Giá từ</label>
                    <input type="text" value="1,000,000" class="w-full focus:outline-none font-bold text-slate-700 text-lg bg-transparent">
                </div>
                <div class="flex-1 w-full text-left px-6 border-r border-slate-100">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Giá đến</label>
                    <input type="text" value="5,000,000" class="w-full focus:outline-none font-bold text-slate-700 text-lg bg-transparent">
                </div>
                <div class="flex-1 w-full text-left px-6">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Địa điểm</label>
                    <input type="text" placeholder="Đà Nẵng..." class="w-full focus:outline-none font-bold text-slate-700 text-lg bg-transparent">
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-5 rounded-xl font-black uppercase tracking-widest transition-all shadow-xl shadow-blue-200">
                    TÌM COMBO
                </button>
            </div>
        </div>
    </div>

    <div class="w-full bg-[#f8fafc] py-24">
        <div class="max-w-[1440px] mx-auto px-6"> <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 uppercase">Gói Combo Phổ Biến</h2>
                    <div class="h-1.5 w-20 bg-blue-600 mt-2 rounded-full"></div>
                </div>
                <a href="#" class="text-blue-600 font-bold text-sm hover:underline">Xem tất cả combo →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($combos as $combo)
                    <div class="bg-white rounded-[32px] overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.04)] hover:shadow-[0_30px_70px_rgba(0,0,0,0.12)] transition-all duration-500 group border border-slate-100 flex flex-col h-full">
                        <div class="relative h-80 overflow-hidden">
                            <img src="{{ asset('storage/' . $combo->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-md text-blue-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm">
                                {{ $combo->location }}
                            </div>
                        </div>

                        <div class="p-10 flex flex-col flex-grow">
                            <h3 class="font-extrabold text-2xl text-slate-800 mb-4 leading-tight group-hover:text-blue-600 transition-colors">
                                {{ $combo->name }}
                            </h3>
                            <div class="flex items-baseline gap-1 mb-8">
                                <span class="text-3xl font-black text-red-500">{{ number_format($combo->price) }}</span>
                                <span class="text-sm font-bold text-red-400">VNĐ</span>
                            </div>

                            <div class="mt-auto space-y-4">
                                <a href="#" class="block w-full py-4 rounded-2xl bg-[#1a1a2e] text-white font-black text-xs uppercase tracking-[0.2em] text-center hover:bg-blue-600 transition-all shadow-lg">
                                    ĐẶT TOUR NGAY
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection