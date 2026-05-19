@extends('admin.layout.admin')

@section('title', 'CHỈNH SỬA COMBO')

@section('admin_content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('admin.combos.update', $combo->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT') {{--Bắt buộc dùng PUT hoặc PATCH cho chức năng Update --}}
        
        <h2 class="text-lg font-bold text-slate-800 mb-6 uppercase border-l-4 border-blue-600 pl-4">Cập nhật thông tin mã hiệu #{{ $combo->id }}</h2>

        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tên Combo</label>
                <input type="text" name="ten_combo" value="{{ $combo->ten_combo }}" class="w-full border-b-2 border-slate-100 focus:border-blue-600 py-2 outline-none text-lg font-semibold transition-all">
            </div>

            <div class="grid grid-cols-2 gap-8 py-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-3">Hình ảnh hiện tại</label>
                    <img src="{{ asset('storage/'.$combo->hinh_anh) }}" class="w-full h-32 object-cover rounded-xl border-2 border-dashed border-slate-200 p-1">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-3">Thay đổi ảnh mới</label>
                    <input type="file" name="hinh_anh" class="text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Giá Combo hiện tại</label>
                <input type="number" name="gia_tien" value="{{ $combo->gia_tien }}" class="w-full border-b border-slate-100 focus:border-blue-600 py-2 outline-none">
            </div>
        </div>

        <div class="flex space-x-4 mt-10">
            <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-xl font-bold hover:bg-slate-800 transition-all uppercase tracking-widest">
                Cập nhật thay đổi
            </button>
            <a href="{{ route('admin.combos.index') }}" class="flex-1 bg-slate-100 text-slate-600 py-4 rounded-xl font-bold text-center hover:bg-slate-200 transition-all uppercase tracking-widest">
                Hủy bỏ
            </a>
        </div>
    </form>
</div>
@endsection