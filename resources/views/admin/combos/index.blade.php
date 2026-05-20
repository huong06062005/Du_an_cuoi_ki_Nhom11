@extends('admin.layouts.admin') 
@section('title', 'QUẢN LÝ COMBO')

@section('admin_content')
@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl shadow-sm text-sm text-emerald-800 flex items-center font-semibold">
        <i class="fas fa-check-circle mr-2 text-emerald-500 text-base"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm text-sm text-red-800 flex items-center font-semibold">
        <i class="fas fa-exclamation-triangle mr-2 text-red-500 text-base"></i>
        {{ session('error') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-slate-800 uppercase tracking-tight">Danh sách Combo Du Lịch</h2>
    <a href="{{ route('admin.combos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold transition-all shadow-sm flex items-center text-sm uppercase tracking-wider">
        <i class="fas fa-plus-circle mr-2"></i> Thêm combo mới
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="p-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider w-32">Hình ảnh</th>
                    <th class="p-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Thông tin Combo</th>
                    <th class="p-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider w-40">Đơn giá</th>
                    <th class="p-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider w-32">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($combos as $item)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-4">
                        <img src="{{ $item->image_url }}" alt="Ảnh Combo" class="w-24 h-16 object-cover rounded-xl border border-slate-200 p-0.5 shadow-sm bg-white">
                    </td>
                    
                    <td class="p-4">
                        <div class="font-bold text-slate-800 text-base">{{ $item->name ?? ($item->ten_combo ?? 'Chưa đặt tên') }}</div>
                        <div class="text-xs text-slate-400 mt-1 line-clamp-1 italic max-w-xl">
                            {{ $item->description ?? ($item->mo_ta ?? 'Chưa có mô tả ngắn gọn cho gói combo này.') }}
                        </div>
                    </td>
                    
                    <td class="p-4">
                        <span class="text-blue-600 font-bold text-base bg-blue-50/60 px-3 py-1.5 rounded-lg border border-blue-100/50 inline-block">
                            @php
                                // ĐÃ SỬA: Ưu tiên lấy thuộc tính ảo real_price đã cấu hình tự động tính tổng tiền ở Model Combo
                                $displayPrice = $item->real_price ?? ($item->price ?? ($item->gia_tien ?? 0));
                            @endphp
                            {{ $displayPrice > 0 ? number_format($displayPrice, 0, ',', '.') . 'đ' : '0đ' }}
                        </span>
                    </td>
                    
                    <td class="p-4 text-center">
                        <div class="flex justify-center items-center space-x-3.5">
                            <a href="{{ route('admin.combos.edit', $item->id) }}" class="text-slate-400 hover:text-blue-600 text-base transition-colors p-1" title="Chỉnh sửa combo">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('admin.combos.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa combo này khỏi hệ thống?')" class="inline m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-600 text-base transition-colors p-1" title="Xóa combo">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-12 text-center bg-slate-50/30">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-3 text-slate-300">
                                <i class="fas fa-box-open text-2xl"></i>
                            </div>
                            <p class="text-slate-400 text-sm font-medium">Chưa có dữ liệu combo nào trong hệ thống.</p>
                            <span class="text-[11px] text-slate-300 mt-0.5 block italic">Vui lòng bấm nút phía trên để thêm mới dữ liệu.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection