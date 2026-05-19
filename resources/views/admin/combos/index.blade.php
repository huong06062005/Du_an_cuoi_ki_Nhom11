@extends('admin.layouts.admin') 
@section('title', 'QUẢN LÝ COMBO') {{-- Đổi admin_title thành title cho khớp với file layout -}}

@section('admin_content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-slate-800 uppercase tracking-tight">Danh sách Combo Du Lịch</h2>
    <a href="{{ route('admin.combos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold transition-all shadow-sm flex items-center">
        <i class="fas fa-plus-circle mr-2"></i> THÊM COMBO MỚI
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="p-4 text-left text-xs font-bold text-slate-600 uppercase">Hình ảnh</th>
                    <th class="p-4 text-left text-xs font-bold text-slate-600 uppercase">Thông tin Combo</th>
                    <th class="p-4 text-left text-xs font-bold text-slate-600 uppercase">Đơn giá</th>
                    <th class="p-4 text-center text-xs font-bold text-slate-600 uppercase">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($combos as $item)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-4">
                        @if($item->hinh_anh)
                            <img src="{{ asset('storage/'.$item->hinh_anh) }}" class="w-24 h-16 object-cover rounded-md border border-slate-200 shadow-sm">
                        @else
                            <div class="w-24 h-16 bg-slate-100 rounded-md flex items-center justify-center text-slate-400 text-[10px]">Không có ảnh</div>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $item->ten_combo }}</div>
                        <div class="text-xs text-slate-500 mt-1 line-clamp-1 italic">{{ $item->mo_ta }}</div>
                    </td>
                    <td class="p-4">
                        <span class="text-blue-600 font-bold">{{ number_format($item->gia_tien) }}đ</span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center space-x-3">
                            <a href="{{ route('admin.combos.edit', $item->id) }}" class="text-slate-400 hover:text-blue-600 transition-colors" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.combos.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa combo này khỏi hệ thống?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors" title="Xóa">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-10 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-box-open text-slate-200 text-4xl mb-3"></i>
                            <p class="text-slate-400 text-sm italic">Chưa có dữ liệu combo nào trong hệ thống.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection