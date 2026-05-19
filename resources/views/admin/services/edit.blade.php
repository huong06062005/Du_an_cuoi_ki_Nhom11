@extends('admin.layout.admin')

@section('title', 'CẬP NHẬT DỊCH VỤ')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100">
        @csrf @method('PUT')
        
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800">Chỉnh sửa dịch vụ #{{ $service->id }}</h3>
            <p class="text-sm text-slate-400">Thay đổi thông tin nhà cung cấp hoặc đơn giá</p>
        </div>

        <div class="space-y-6">
            <div>
                <label class="text-xs font-bold text-slate-400 uppercase">Tên dịch vụ</label>
                <input type="text" name="ten_dich_vu" value="{{ $service->ten_dich_vu }}" class="w-full mt-2 p-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase">Đơn giá mới</label>
                    <input type="number" name="gia_nhap" value="{{ $service->gia_nhap }}" class="w-full mt-2 p-4 rounded-xl border border-slate-200 font-bold text-blue-600">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase">Trạng thái kinh doanh</label>
                    <select name="status" class="w-full mt-2 p-4 rounded-xl border border-slate-200">
                        <option value="1" {{ $service->status ? 'selected' : '' }}>Đang hoạt động</option>
                        <option value="0" {{ !$service->status ? 'selected' : '' }}>Tạm ngưng</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-10 border-t border-slate-50 flex justify-end">
            <button class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold uppercase tracking-widest shadow-xl hover:bg-blue-600 transition-all">
                Lưu thay đổi
            </button>
        </div>
    </form>
</div>
@endsection