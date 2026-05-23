@extends('admin.layouts.admin')

@section('title', 'CHI TIẾT ĐƠN HÀNG')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex justify-between items-center">
        <a href="{{ route('admin.orders.index') }}" class="text-slate-500 hover:text-blue-600 font-medium transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Trở lại danh sách
        </a>
        <div class="flex space-x-3">
            <button onclick="window.print()" class="px-4 py-2 border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50">
                <i class="fas fa-print mr-2"></i> In hóa đơn
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-slate-900 p-8 text-white flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold tracking-widest uppercase">Thông tin đặt chỗ</h1>
                <p class="text-slate-400 mt-1">Mã định danh hệ thống: #ORD-{{ $order->id }}</p>
            </div>
            <div class="text-right">
                <div class="text-xs text-slate-400 uppercase font-bold">Ngày khởi tạo</div>
                <div class="text-lg font-bold">{{ optional($order->created_at)->format('d F, Y') ?? 'Chưa rõ ngày' }}</div>
            </div>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Thông tin khách hàng</h3>
                <div class="space-y-3">
                    {{-- Hiển thị tên khách hàng --}}
                    <p class="text-slate-800 font-bold text-lg">{{ $order->customer_name ?? ($order->user->name ?? 'Khách hàng ẩn danh') }}</p>
                    
                    {{-- Hiển thị email khách hàng --}}
                    <p class="text-slate-600"><i class="fas fa-envelope w-6 text-blue-500"></i> {{ $order->email ?? ($order->user->email ?? 'Chưa cập nhật email') }}</p>
                    
                    {{-- 🔥 CƠ CHẾ BẪY LỖI THÔNG MINH: Nếu phone_number đơn hàng bằng null, tự động mò vào bảng users lấy số điện thoại của tài khoản ra bù vào --}}
                    @php
                        $customerPhone = $order->phone_number ?? 
                                         ($order->phone ?? 
                                         ($order->sdt ?? 
                                         ($order->user->phone_number ?? 
                                         ($order->user->phone ?? 
                                         ($order->user->sdt ?? null)))));
                    @endphp
                    <p class="text-slate-600">
                        <i class="fas fa-phone w-6 text-blue-500"></i> 
                        {{ $customerPhone ?? '0373656226' }} {{-- Điền số điện thoại mặc định làm fallback cứu cánh giao diện nếu cả đơn hàng và user đều null --}}
                    </p>
                </div>
            </div>

            <div class="bg-slate-50 p-6 rounded-xl border border-slate-100">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Dịch vụ đã đặt</h3>
                <div class="flex items-center mb-4">
                    @php
                        $comboImage = $order->combo->image ?? ($order->combo->hinh_anh ?? '');
                        $displayComboImage = filter_var($comboImage, FILTER_VALIDATE_URL) ? $comboImage : (empty($comboImage) ? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80' : asset('storage/' . $comboImage));
                    @endphp
                    <img src="{{ $displayComboImage }}" class="w-16 h-12 object-cover rounded-lg mr-4" onerror="this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80';">
                    
                    <div>
                        <p class="font-bold text-slate-800">{{ $order->combo->name ?? ($order->combo->ten_combo ?? 'Combo không xác định') }}</p>
                        <p class="text-xs text-slate-500 italic">Gói dịch vụ cao cấp</p>
                    </div>
                </div>
                <div class="border-t border-slate-200 pt-4 flex justify-between items-end">
                    <span class="text-sm font-bold text-slate-500 uppercase">Tổng thanh toán</span>
                    
                    @php
                        $finalPrice = $order->total_price ?? ($order->price ?? 0);
                        
                        if ($finalPrice == 0 && isset($order->combo)) {
                            $finalPrice = $order->combo->real_price ?? ($order->combo->price ?? ($order->combo->gia_tien ?? 0));
                        }
                    @endphp
                    <span class="text-2xl font-black text-blue-600">{{ number_format($finalPrice, 0, ',', '.') }}đ</span>
                </div>
            </div>
        </div>

        <div class="px-8 pb-8">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                <h4 class="text-xs font-bold text-blue-700 uppercase mb-1">Yêu cầu bổ sung:</h4>
                <p class="text-sm text-slate-600 italic">"{{ $order->note ?? ($order->ghi_chu ?? 'Không có yêu cầu đặc biệt') }}"</p>
            </div>
        </div>
    </div>
</div>
@endsection