@extends('client.layouts.master')

@section('content')
<div class="bg-zinc-100 py-10">
    <div class="max-w-7xl mx-auto px-4">
        
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
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition uppercase text-sm tracking-wider">
                        Tìm kiếm ngay
                    </button>
                </div>
            </form>
        </div>

        <h2 class="text-2xl font-bold mb-6 italic"><i class="fas fa-search mr-2"></i>Kết quả tìm kiếm Combo</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @forelse($combos as $combo)
            <div class="bg-white rounded-xl shadow-sm border p-3 flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <img src="{{ \Illuminate\Support\Str::startsWith($combo->image, ['http://', 'https://']) ? $combo->image : asset('storage/'.$combo->image) }}" 
                         class="h-40 w-full object-cover rounded-lg mb-3" 
                         alt="{{ $combo->name }}">
                         
                    <h4 class="font-bold text-sm mb-2 line-clamp-2 h-10 text-gray-800">{{ $combo->name }}</h4>
                </div>
                
                <div>
                    <p class="text-red-600 font-bold mb-3 text-base">
                        {{ number_format($combo->total_price ?? 0) }}đ
                    </p>
                    <a href="{{ route('combos.show', $combo->id) }}" class="block text-center bg-blue-50 hover:bg-blue-100 text-blue-600 py-2.5 rounded-xl text-xs font-bold transition tracking-wider">
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