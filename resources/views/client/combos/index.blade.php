@extends('client.layouts.master')

@section('content')
<div class="bg-zinc-100 py-10">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- Form Tìm Kiếm và Lọc Nâng Cao --}}
        <div class="mb-10">
            <form action="{{ route('home') }}" method="GET" class="bg-white p-6 rounded-2xl shadow-sm border grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Bạn muốn đi đâu?</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full px-4 py-3 rounded-xl border focus:outline-none focus:border-blue-500 text-sm" 
                           placeholder="Nhập địa điểm (Sapa, Đà Nẵng...)">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Chọn mức giá</label>
                    <select name="price_range" class="w-full px-4 py-3 rounded-xl border focus:outline-none focus:border-blue-500 text-sm">
                        <option value="">Tất cả các mức giá</option>
                        <option value="under_2m" {{ request('price_range') == 'under_2m' ? 'selected' : '' }}>Dưới 2 Triệu</option>
                        <option value="2m_5m" {{ request('price_range') == '2m_5m' ? 'selected' : '' }}>Từ 2 - 5 Triệu</option>
                        <option value="over_5m" {{ request('price_range') == 'over_5m' ? 'selected' : '' }}>Trên 5 Triệu</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Loại hình trải nghiệm</label>
                    <select name="category" class="w-full px-4 py-3 rounded-xl border focus:outline-none focus:border-blue-500 text-sm">
                        <option value="">Tất cả dịch vụ</option>
                        <option value="Máy bay" {{ request('category') == 'Máy bay' ? 'selected' : '' }}>Combo kèm Vé máy bay</option>
                        <option value="Du thuyền" {{ request('category') == 'Du thuyền' ? 'selected' : '' }}>Nghỉ dưỡng du thuyền</option>
                        <option value="Khách sạn" {{ request('category') == 'Khách sạn' ? 'selected' : '' }}>Khách sạn / Villa cao cấp</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition uppercase text-sm tracking-wider cursor-pointer">
                        Tìm kiếm ngay
                    </button>
                </div>
            </form>
        </div>

        <h2 class="text-2xl font-bold mb-6 italic"><i class="fas fa-search mr-2"></i>Kết quả tìm kiếm Combo</h2>
        
        {{-- lưới hiển thị danh sách Card Combo --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @forelse($combos as $combo)
            <div class="bg-white rounded-xl shadow-sm border p-4 flex flex-col justify-between hover:shadow-md transition group">
                <div>
                    {{-- ĐÃ SỬA: Gọi qua thuộc tính ảo $combo->image_url từ Model để tự động sửa lỗi vỡ ảnh --}}
                    <div class="overflow-hidden rounded-lg mb-3 h-40 w-full relative">
                        <img src="{{ $combo->image_url }}" 
                             class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500" 
                             alt="{{ $combo->name ?? $combo->ten_combo }}">
                        
                        {{-- Hiển thị tag bán chạy nếu được tích chọn trong admin --}}
                        @if(($combo->is_featured ?? 0) == 1 || ($combo->noi_bat ?? 0) == 1)
                            <div class="absolute top-2 left-2 bg-red-500 text-white px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-wider shadow-sm">
                                BÁN CHẠY 🔥
                            </div>
                        @endif
                    </div>
                         
                    <h4 class="font-extrabold text-sm mb-2 line-clamp-2 h-10 text-gray-800 group-hover:text-blue-600 transition-colors">
                        {{ $combo->name ?? $combo->ten_combo }}
                    </h4>
                </div>
                
                <div class="mt-4">
                    {{-- ĐÃ SỬA: Đồng bộ gọi thuộc tính real_price tính tổng tiền triệu từ các dịch vụ thành phần --}}
                    @php
                        $currentPrice = $combo->real_price ?? ($combo->price ?? ($combo->gia_tien ?? 0));
                        $oldPrice = $combo->old_price ?? ($combo->gia_cu ?? ($currentPrice * 1.25));
                    @endphp

                    {{-- Hiển thị giá cũ gạch ngang kích thích mua hàng --}}
                    <p class="text-gray-400 line-through text-xs mb-0.5 font-medium">
                        {{ number_format($oldPrice, 0, ',', '.') }}đ
                    </p>

                    {{-- Giá bán chính thức màu đỏ chuẩn chỉ --}}
                    <p class="text-red-600 font-black mb-4 text-lg">
                        {{ number_format($currentPrice, 0, ',', '.') }}đ
                    </p>

                    <a href="{{ route('combos.show', $combo->id) }}" class="block text-center bg-blue-50 hover:bg-blue-100 text-blue-600 py-2.5 rounded-xl text-xs font-bold transition tracking-wider uppercase">
                        XEM CHI TIẾT
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-12 bg-white rounded-2xl border">
                <p class="text-gray-400 font-medium text-lg">Không tìm thấy gói combo nào phù hợp với yêu cầu của bạn.</p>
                <a href="{{ route('home') }}" class="text-blue-600 font-bold hover:underline mt-2 inline-block">Hiển thị tất cả combo</a>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection