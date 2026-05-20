@extends('admin.layouts.admin')

@section('title', 'TẠO COMBO MỚI')

@section('admin_content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex items-center text-slate-500">
        <a href="{{ route('admin.combos.index') }}" class="hover:text-blue-600 transition-colors flex items-center font-semibold text-sm">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm text-sm text-red-700">
            <div class="flex items-center mb-2 font-bold uppercase tracking-wide">
                <i class="fas fa-exclamation-circle mr-2 text-red-500"></i> Vui lòng kiểm tra lại các thông tin sau:
            </div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.combos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Tên Combo du lịch</label>
                <input type="text" name="ten_combo" value="{{ old('ten_combo') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all shadow-sm" placeholder="Ví dụ: Combo Đà Nẵng 3 ngày 2 đêm" required>
                @error('ten_combo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Hình ảnh đại diện</label>
                <input type="file" name="hinh_anh" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all border border-slate-200 rounded-xl px-2 py-1.5 shadow-sm" required>
                @error('hinh_anh') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Đơn giá dự kiến (VNĐ)</label>
                <input type="number" id="total-price-input" name="gia_tien" value="{{ old('gia_tien', 0) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none shadow-sm bg-slate-50 text-slate-600 font-bold" placeholder="Hệ thống tự tính..." readonly>
                <p class="text-[11px] text-slate-400 mt-1 italic">* Giá tiền sẽ tự động tính bằng tổng các dịch vụ được chọn dưới đây.</p>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Chọn các dịch vụ bao gồm</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50/70 rounded-xl border border-slate-200 shadow-inner">
                    @forelse($services as $service)
                    @php
                        // Khảo sát xem dịch vụ đang dùng tên cột tiếng Anh hay tiếng Việt
                        $servicePrice = $service->gia_tien ?? $service->price ?? 0;
                        $serviceName = $service->name ?? $service->ten_dich_vu ?? 'Dịch vụ chưa có tên';
                    @endphp
                    <label class="flex items-center space-x-3 p-3 bg-white rounded-xl shadow-sm border border-slate-100 cursor-pointer hover:border-blue-400 hover:shadow transition-all">
                        <input type="checkbox" name="services[]" value="{{ $service->id }}" data-price="{{ $servicePrice }}" class="service-checkbox rounded text-blue-600 focus:ring-blue-500 w-4 h-4 border-slate-300">
                        <div class="text-sm">
                            <span class="font-bold text-slate-800 block">{{ $serviceName }}</span>
                            <span class="text-blue-600 text-xs font-semibold">{{ number_format($servicePrice) }}đ</span>
                        </div>
                    </label>
                    @empty
                    <div class="col-span-2 text-center py-6 text-slate-400 text-sm italic">
                        <i class="fas fa-exclamation-triangle text-amber-500 mr-1"></i> Chưa có dịch vụ nào trong hệ thống. Hãy tạo dịch vụ trước nhé!
                    </div>
                    @endempty
                </div>
                @error('services') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Mô tả ngắn gọn</label>
                <textarea name="mo_ta" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none shadow-sm" placeholder="Nhập tóm tắt các dịch vụ hoặc lịch trình bao gồm trong combo..." required>{{ old('mo_ta') }}</textarea>
                @error('mo_ta') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-6 border-t border-slate-100 flex justify-end">
            <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-10 py-3.5 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all uppercase tracking-widest text-sm">
                <i class="fas fa-save mr-2"></i> Xác nhận lưu hệ thống
            </button>
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

        // Lắng nghe sự kiện click chọn trên từng ô Checkbox dịch vụ
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', calculateTotal);
        });

        // Chạy tính toán một lần ban đầu phòng trường hợp nhấn quay lại trang (old input)
        calculateTotal();
    });
</script>
@endsection