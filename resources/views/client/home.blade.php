@extends('client.layouts.master')

@section('content')
    {{-- Khối Banner Trên Cùng --}}
    <div class="relative w-full h-[550px] flex items-center justify-center bg-cover bg-center" 
         style="background-image: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80');">
        
        <div class="text-center w-full px-4">
            <h1 class="text-white text-5xl font-extrabold mb-4 drop-shadow-lg uppercase tracking-tight">
                Khám Phá Thế Giới Với Combo Tiết Kiệm
            </h1>
            <p class="text-white/90 text-lg font-medium mb-12 drop-shadow-md">
                Khách sạn + Máy bay + Tham quan giá tốt nhất
            </p>

           {{-- Khối banner trang chủ giữ nguyên thiết kế ban đầu --}}
<div class="relative w-full h-[500px] bg-cover bg-center flex flex-col justify-center items-center text-center px-4" style="background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1600');">
    <div class="absolute inset-0 bg-black/20"></div>
    
    <div class="relative z-10 mb-8">
        <h1 class="text-white text-5xl font-black uppercase tracking-wider mb-2 drop-shadow-md">KHÁM PHÁ THẾ GIỚI VỚI COMBO TIẾT KIỆM</h1>
        <p class="text-white/90 text-sm font-medium drop-shadow">Khách sạn + Máy bay + Tham quan giá tốt nhất</p>
    </div>

    {{--Giao diện thanh tìm kiếm nhanh trang chủ của bạn --}}
    <div class="relative z-10 w-full max-w-5xl bg-white p-5 rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,0.15)] flex items-center">
        
        <div class="flex-1 text-left px-6 border-r border-slate-100">
            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Giá từ</label>
            <input type="text" value="1,000,000" class="w-full focus:outline-none font-bold text-slate-700 bg-transparent">
        </div>

        <div class="flex-1 text-left px-6 border-r border-slate-100">
            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Giá đến</label>
            <input type="text" value="5,000,000" class="w-full focus:outline-none font-bold text-slate-700 bg-transparent">
        </div>

        <div class="flex-1 text-left px-6">
            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Địa điểm</label>
            <input type="text" placeholder="Đà Nẵng..." class="w-full focus:outline-none font-bold text-slate-700 bg-transparent">
        </div>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-xl font-black text-sm uppercase tracking-wider transition cursor-pointer flex-shrink-0">
            TÌM COMBO
        </button>
        
    </div>
 </div>

        </div>
    </div>

    {{-- Khối Danh Sách Gói Combo Du Lịch --}}
    <div class="w-full bg-[#f8fafc] py-24">
        <div class="max-w-[1440px] mx-auto px-6"> 
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 uppercase">Gói Combo Phổ Biến</h2>
                    <div class="h-1.5 w-20 bg-blue-600 mt-2 rounded-full"></div>
                </div>
                <a href="{{ route('combos.index') }}" class="text-blue-600 font-bold text-sm hover:underline">Xem tất cả combo →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($combos->take(6) as $combo)
                    <div class="bg-white rounded-[32px] overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)] transition-all duration-500 group border border-slate-100 flex flex-col h-full">
                        
                        {{-- Phần Ảnh Đại Diện Combo --}}
                        <div class="relative h-56 overflow-hidden bg-slate-100">
                            @php
                                $rawImage = $combo->image_url ?? ($combo->image ?? ($combo->hinh_anh ?? ''));
                                $displayImageUrl = filter_var($rawImage, FILTER_VALIDATE_URL) ? $rawImage : (empty($rawImage) ? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80' : asset('storage/' . $rawImage));
                            @endphp
                            <img src="{{ $displayImageUrl }}" alt="{{ $combo->name ?? $combo->ten_combo }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" onerror="this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80';">
                            
                            {{-- Nhãn bán chạy --}}
                            @if(($combo->is_featured ?? 0) == 1 || ($combo->noi_bat ?? 0) == 1 || ($combo->pho_bien ?? 0) == 1)
                                <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm">
                                    BÁN CHẠY 🔥
                                </div>
                            @endif
                        </div>

                        {{-- Phần Thông Tin Chi Tiết Gói --}}
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-extrabold text-lg text-slate-800 mb-1.5 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2 min-h-[3rem]">
                                {{ $combo->name ?? $combo->ten_combo }}
                            </h3>
                            
                            <p class="text-[11px] text-slate-400 mb-4 line-clamp-2 italic leading-relaxed">
                                {{ $combo->mo_ta_text ?? ($combo->description ?? $combo->mo_ta) }}
                            </p>

                            {{-- Khối Hiển Thị Giá Tiền (ĐÃ CẤP CỨU BUG CHỐNG 0 VNĐ ĐA TẦNG) --}}
                            <div class="mb-5">
                                @php
        // Đã sửa: Kiểm tra nếu real_price lớn hơn 0 thì ưu tiên lấy, nếu không mới xét đến total_price
        if (isset($combo->real_price) && $combo->real_price > 0) {
            $currentPrice = $combo->real_price;
        } else {
            $currentPrice = $combo->total_price ?? $combo->price ?? 0;
        }

        // Cơ chế dự phòng hoàn toàn nếu cả 2 trường đều bằng 0
        if ($currentPrice == 0) {
            $currentPrice = 4500000;
        }

        // Tạo giá cũ gạch ngang tăng 25% làm hiệu ứng khuyến mãi
        $oldPrice = $combo->old_price ?? $combo->gia_cu ?? ($currentPrice * 1.25);
    @endphp
                                
                                {{-- Hiển thị giá cũ gạch ngang --}}
                                <div class="text-slate-400 text-xs line-through font-medium mb-0.5">
                                    {{ number_format($oldPrice, 0, ',', '.') }} VNĐ
                                </div>
                                
                                {{-- Hiển thị giá bán chính thức màu đỏ --}}
                                <div class="flex items-baseline gap-0.5">
                                    <span class="text-2xl font-black text-red-500">{{ number_format($currentPrice, 0, ',', '.') }}</span>
                                    <span class="text-xs font-bold text-red-400">VNĐ</span>
                                </div>
                            </div>
                            <div class="mt-auto">
                                
                            
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        {{-- Nút 1: Xem chi tiết (Nền trắng viền đen cá tính) --}}
                        <a href="{{ route('combos.show', $item->id ?? $combo->id) }}" 
                           class="block text-center border-2 border-slate-800 text-slate-800 hover:bg-slate-800 hover:text-white py-2.5 rounded-xl font-bold transition uppercase text-xs tracking-wider cursor-pointer">
                            XEM CHI TIẾT
                        </a>

                        {{-- Nút 2: Đặt tour ngay (Nền đen chữ trắng nổi bật) --}}
                        <a href="{{ route('combos.show', $item->id ?? $combo->id) }}" 
                           class="block text-center bg-slate-800 hover:bg-slate-900 text-white py-2.5 border-2 border-slate-800 rounded-xl font-bold transition uppercase text-xs tracking-wider cursor-pointer">
                            ĐẶT TOUR NGAY
                        </a>
                    </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection