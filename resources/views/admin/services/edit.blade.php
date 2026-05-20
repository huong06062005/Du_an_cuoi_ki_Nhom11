@extends('admin.layouts.admin') {{-- Sửa lỗi từ layout thành layouts cho đồng bộ --}}

@section('title', 'CẬP NHẬT DỊCH VỤ')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    {{-- Bổ sung thêm nút quay lại nhanh để tăng trải nghiệm người dùng --}}
    <div class="mb-4">
        <a href="{{ route('admin.services.index') }}" class="text-sm text-slate-500 hover:underline">
            <i class="fas fa-arrow-left mr-1"></i> Quay lại danh sách dịch vụ
        </a>
    </div>

    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100">
        @csrf 
        @method('PUT')
        
        <div class="mb-10">
            <h3 class="text-2xl font-black text-slate-800">Chỉnh sửa dịch vụ</h3>
            <p class="text-sm text-slate-400">Thay đổi thông tin nhà cung cấp, phân loại hoặc đơn giá</p>
        </div>

        <div class="space-y-6">
            {{-- 1. Ô Nhập Tên Dịch Vụ (Đổi từ ten_dich_vu sang name cho khớp Controller) --}}
            <div>
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tên dịch vụ</label>
                <input type="text" name="name" value="{{ old('name', $service->name ?? ($service->ten_dich_vu ?? '')) }}" class="w-full mt-2 p-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none text-slate-700">
                @error('name') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            {{-- 2. Hàng chứa Loại dịch vụ và Đơn giá (Bổ sung ô chọn Loại dịch vụ bắt buộc của đề bài) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Loại dịch vụ thành phần</label>
                    @php
                        // Lấy giá trị type hiện tại trong DB để check selected
                        $currentType = $service->type ?? ($service->loai_dich_vu ?? 'hotel');
                    @endphp
                    <select name="type" class="w-full mt-2 p-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none text-slate-700 font-medium">
                        <option value="hotel" {{ $currentType == 'hotel' ? 'selected' : '' }}>🏨 Khách sạn nghỉ dưỡng</option>
                        <option value="car" {{ $currentType == 'car' ? 'selected' : '' }}>🚗 Xe đưa đón tận nơi</option>
                        <option value="flight" {{ $currentType == 'flight' ? 'selected' : '' }}>✈️ Vé máy bay / Tàu hỏa</option>
                        <option value="ticket" {{ $currentType == 'ticket' ? 'selected' : '' }}>🎟️ Vé tham quan / Tour lẻ</option>
                    </select>
                    @error('type') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                {{-- Ô Nhập Đơn Giá (Đổi từ gia_nhap sang price cho khớp Controller) --}}
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Đơn giá gốc (VNĐ)</label>
                    <input type="number" name="price" value="{{ old('price', $service->price ?? ($service->gia_tien ?? ($service->gia_nhap ?? 0))) }}" class="w-full mt-2 p-4 rounded-xl border border-slate-200 font-bold text-blue-600 focus:ring-2 focus:ring-blue-500 outline-none">
                    @error('price') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- 3. Hàng chứa Nhà cung cấp và Trạng thái vận hành --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nhà cung cấp / Đối tác</label>
                    <input type="text" name="provider" value="{{ old('provider', $service->provider ?? 'VIETTRAVEL') }}" class="w-full mt-2 p-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none text-slate-700">
                </div>

                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Trạng thái kinh doanh</label>
                    @php
                        $currentStatus = $service->status ?? 'available';
                    @endphp
                    <select name="status" class="w-full mt-2 p-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none text-slate-700 font-medium">
                        <option value="available" {{ $currentStatus === 'available' || $currentStatus == '1' ? 'selected' : '' }}>🟢 Đang hoạt động / Sẵn sàng</option>
                        <option value="unavailable" {{ $currentStatus === 'unavailable' || $currentStatus == '0' ? 'selected' : '' }}>🔴 Tạm ngưng hoạt động</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Khối nút bấm submit form --}}
        <div class="mt-10 pt-10 border-t border-slate-50 flex justify-end">
            <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold uppercase tracking-widest shadow-xl hover:bg-blue-600 transition-all cursor-pointer">
                <i class="fas fa-save mr-2"></i> Lưu thay đổi
            </button>
        </div>
    </form>
</div>
@endsection