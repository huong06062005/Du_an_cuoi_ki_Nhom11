@extends('admin.layout.admin')

@section('title', 'KHO DỊCH VỤ THÀNH PHẦN')

@section('admin_content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-black text-slate-800 tracking-tighter uppercase">Danh mục dịch vụ</h2>
        <p class="text-sm text-slate-500">Quản lý các yếu tố cấu thành Combo du lịch</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="bg-slate-900 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> THÊM DỊCH VỤ
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200">
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Loại</th>
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Tên dịch vụ</th>
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Giá gốc</th>
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Trạng thái</th>
                <th class="p-4 text-center text-xs font-bold text-slate-500 uppercase">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($services as $sv)
            <tr class="hover:bg-blue-50/30 transition-colors">
                <td class="p-4">
                    <span class="p-2 bg-white border border-slate-200 rounded-lg text-blue-600">
                        @if($sv->type == 'hotel') <i class="fas fa-hotel"></i>
                        @elseif($sv->type == 'flight') <i class="fas fa-plane"></i>
                        @else <i class="fas fa-car"></i> @endif
                    </span>
                </td>
                <td class="p-4">
                    <div class="font-bold text-slate-800">{{ $sv->ten_dich_vu }}</div>
                    <div class="text-[10px] text-slate-400 uppercase tracking-widest">{{ $sv->provider }}</div>
                </td>
                <td class="p-4 font-mono font-bold text-slate-700">{{ number_format($sv->gia_nhap) }}đ</td>
                <td class="p-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sv->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $sv->status ? 'Sẵn sàng' : 'Ngưng cung cấp' }}
                    </span>
                </td>
                <td class="p-4 text-center">
                    <div class="flex justify-center space-x-2">
                        <a href="{{ route('admin.services.edit', $sv->id) }}" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-blue-100 text-blue-600 transition-all">
                            <i class="fas fa-pen-nib text-xs"></i>
                        </a>
                        <form action="{{ route('admin.services.destroy', $sv->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-red-100 text-red-600 transition-all">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@php
    // Day la file danh sach hien thi toan bo cac dich vu thanh phan trong he thong, ho tro sua va xoa nhanh
@endphp

@endsection