@extends('admin.layouts.admin')
@section('title', 'CHỈNH SỬA COMBO')

@section('admin_content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center text-slate-500">
        <a href="{{ route('admin.combos.index') }}" class="hover:text-blue-600 transition-colors flex items-center font-semibold text-sm">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm text-sm text-red-700">
            <div class="flex items-center mb-2 font-bold uppercase tracking-wide">
                <i class="fas fa-exclamation-circle mr-2 text-red-500"></i> Vui lòng kiểm tra lại thông tin:
            </div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.combos.update', $combo->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <h2 class="text-lg font-bold text-slate-800 mb-6 uppercase border-l-4 border-blue-600 pl-4">Cập nhật thông tin combo </h2>

        <div class="space-y-6">
            {{-- 1. Ô Nhập Tên Combo --}}
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1 tracking-wide">Tên Combo du lịch</label>
                <input type="text" name="ten_combo" value="{{ old('ten_combo', $combo->ten_combo ?? $combo->name) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 outline-none font-semibold focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all shadow-sm" required>
                @error('ten_combo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- THÊM MỚI: Ô Checkbox cấu hình Combo Phổ biến / Nổi bật --}}
            <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 flex items-center space-x-3 cursor-pointer shadow-sm">
                @php
                    // Kiểm tra an toàn xem DB đang dùng cột is_featured hay noi_bat
                    $isFeatured = $combo->is_featured ?? ($combo->noi_bat ?? 0);
                @endphp
                <input type="checkbox" name="is_featured" value="1" id="is_featured_input" class="rounded text-amber-600 focus:ring-amber-500 w-5 h-5 border-slate-300 cursor-pointer" {{ $isFeatured == 1 ? 'checked' : '' }}>
                <label for="is_featured_input" class="text-xs font-bold text-slate-700 uppercase tracking-wide cursor-pointer select-none">
                    🔥 Đánh dấu đây là Combo phổ biến
                </label>
            </div>

            {{-- 2. Khối Quản Lý Hình Ảnh --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2 tracking-wide">Hình ảnh hiện tại</label>
                    <div class="p-1 bg-white border border-slate-200 rounded-xl shadow-inner">
                        <img src="{{ $combo->image_url ?? ($combo->image ?? ($combo->hinh_anh ?? '')) }}" class="w-full h-36 object-cover rounded-lg border border-slate-100">
                    </div>
                </div>
                <div class="flex flex-col justify-center space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1 tracking-wide">Cách 1: Tải tệp ảnh mới từ máy</label>
                        <input type="file" name="hinh_anh" class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-lg p-1 bg-white w-full">
                        @error('hinh_anh') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1 tracking-wide">Cách 2: Hoặc Dán trực tiếp Link ảnh mạng</label>
                        <input type="text" name="hinh_anh_url" value="{{ filter_var($combo->image ?? $combo->hinh_anh, FILTER_VALIDATE_URL) ? ($combo->image ?? $combo->hinh_anh) : '' }}" placeholder="https://example.com/image.jpg" class="w-full text-xs border border-slate-200 rounded-lg px-3 py-2 outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                    </div>
                </div>
            </div>

            {{-- 3. Ô Hiển Thị Tổng Giá Tiền --}}
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1 tracking-wide">Giá Combo dự kiến (VNĐ)</label>
                <input type="number" id="total-price-input" name="gia_tien" value="{{ old('gia_tien', $combo->gia_tien ?? ($combo->price ?? 0)) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 outline-none bg-slate-100 text-slate-600 font-bold shadow-sm" readonly>
                <p class="text-[11px] text-slate-400 mt-1 italic">* Giá tiền tự động tính dựa theo các dịch vụ thành phần được tích chọn bên dưới.</p>
            </div>

            {{-- 4. Danh Sách Dịch Vụ Thành Phần --}}
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 tracking-wide">Các dịch vụ bao gồm trong Combo</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50/70 rounded-xl border border-slate-200 shadow-inner">
                    @forelse($services as $service)
                    @php
                        $servicePrice = $service->price ?? ($service->gia_tien ?? ($service->gia_nhap ?? ($service->gia_goc ?? 0)));
                        $serviceName = $service->name ?? ($service->ten_dich_vu ?? 'Chưa đặt tên');
                        
                        $isAttached = false;
                        if (isset($combo->services)) {
                            $isAttached = $combo->services->contains($service->id);
                        } elseif (isset($combo->dichVus)) {
                            $isAttached = $combo->dichVus->contains($service->id);
                        }
                    @endphp
                    <label class="flex items-center space-x-3 p-3 bg-white rounded-xl shadow-sm border border-slate-100 cursor-pointer hover:border-blue-400 hover:shadow transition-all">
                        <input type="checkbox" name="services[]" value="{{ $service->id }}" data-price="{{ $servicePrice }}" class="service-checkbox rounded text-blue-600 focus:ring-blue-500 w-4 h-4 border-slate-300" {{ $isAttached ? 'checked' : '' }}>
                        <div class="text-sm">
                            <span class="font-bold text-slate-800 block">{{ $serviceName }}</span>
                            <span class="text-blue-600 text-xs font-semibold">{{ number_format($servicePrice, 0, ',', '.') }}đ</span>
                        </div>
                    </label>
                    @empty
                    <div class="col-span-2 text-center py-4 text-slate-400 text-xs italic">
                        Chưa có dịch vụ nào tồn tại trong hệ thống.
                    </div>
                    @endforelse
                </div>
                @error('services') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- 5. Ô Mô Tả Ngắn --}}
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1 tracking-wide">Mô tả ngắn gọn</label>
                <textarea name="mo_ta" rows="4" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm" required>{{ old('mo_ta', $combo->mo_ta ?? $combo->description) }}</textarea>
                @error('mo_ta') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Khối Nút Lưu Thay Đổi --}}
        <div class="flex space-x-4 mt-10 pt-4 border-t border-slate-100">
            <button type="submit" class="flex-1 bg-blue-600 text-white py-3.5 rounded-xl font-bold hover:bg-blue-700 shadow-md shadow-blue-100 transition-all uppercase tracking-widest text-sm cursor-pointer">
                <i class="fas fa-save mr-1"></i> Cập nhật thay đổi
            </button>
            <a href="{{ route('admin.combos.index') }}" class="flex-1 bg-slate-100 text-slate-600 py-3.5 rounded-xl font-bold text-center hover:bg-slate-200 transition-all uppercase tracking-widest text-sm">
                Hủy bỏ
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.service-checkbox');
        const totalPriceInput = document.getElementById('total-price-input');

        function calculateTotal() {
            let total = 0;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    total += parseFloat(checkbox.getAttribute('data-price')) || 0;
                }
            });
            totalPriceInput.value = total;
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', calculateTotal);
        });

        calculateTotal();
    });
</script>
@endsection