@extends('admin.layouts.admin') 

@section('title', 'BẢNG ĐIỀU KHIỂN HỆ THỐNG')

@section('admin_content')
<div class="mb-8">
    <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Báo cáo tổng quan</h2>
    <p class="text-sm text-slate-500 italic">Cập nhật dữ liệu hệ thống tính đến ngày {{ date('d/m/Y') }}</p>
</div>

{{-- Các khối thống kê kết nối trực tiếp dữ liệu Controller --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    
    <a href="{{ Route::has('admin.bookings.index') ? route('admin.bookings.index') : (Route::has('admin.orders.index') ? route('admin.orders.index') : '#') }}" class="block transition-transform hover:-translate-y-1">
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-6 rounded-2xl shadow-lg shadow-blue-200 text-white h-full">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold uppercase opacity-80 tracking-widest">Tổng doanh thu</p>
                    <h3 class="text-2xl font-black mt-1">{{ number_format($totalRevenue ?? 0) }}đ</h3>
                </div>
                <div class="bg-white/20 p-2 rounded-lg">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
            </div>
            <p class="text-[10px] mt-4 font-medium"><i class="fas fa-chart-line mr-1"></i> Dữ liệu thời gian thực</p>
        </div>
    </a>

    <a href="{{ Route::has('admin.bookings.index') ? route('admin.bookings.index') : (Route::has('admin.orders.index') ? route('admin.orders.index') : '#') }}" class="block transition-transform hover:-translate-y-1">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 h-full hover:border-emerald-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold uppercase text-slate-400 tracking-widest">Đơn đặt chỗ</p>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $totalBookings ?? 0 }}</h3>
                </div>
                <div class="bg-emerald-50 text-emerald-600 p-2 rounded-lg">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </div>
            </div>
            <p class="text-[10px] mt-4 text-emerald-600 font-bold uppercase">Đang vận hành tốt</p>
        </div>
    </a>

    <a href="{{ Route::has('admin.combos.index') ? route('admin.combos.index') : '#' }}" class="block transition-transform hover:-translate-y-1">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 h-full hover:border-amber-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold uppercase text-slate-400 tracking-widest">Combo du lịch</p>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $totalCombos ?? 0 }}</h3>
                </div>
                <div class="bg-amber-50 text-amber-600 p-2 rounded-lg">
                    <i class="fas fa-box-open text-xl"></i>
                </div>
            </div>
            <p class="text-[10px] mt-4 text-slate-400 font-medium">Sẵn sàng phục vụ</p>
        </div>
    </a>

    <a href="{{ Route::has('admin.users.index') ? route('admin.users.index') : '#' }}" class="block transition-transform hover:-translate-y-1">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 h-full hover:border-purple-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold uppercase text-slate-400 tracking-widest">Thành viên</p>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $totalUsers ?? 0 }}</h3>
                </div>
                <div class="bg-purple-50 text-purple-600 p-2 rounded-lg">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <p class="text-[10px] mt-4 text-purple-600 font-bold uppercase">Tăng trưởng ổn định</p>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Khối danh sách giao dịch --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h4 class="font-bold text-slate-800 uppercase text-sm tracking-widest">Giao dịch gần đây</h4>
            <a href="{{ Route::has('admin.bookings.index') ? route('admin.bookings.index') : (Route::has('admin.orders.index') ? route('admin.orders.index') : '#') }}" class="text-xs text-blue-600 font-bold hover:underline">Xem tất cả</a>
        </div>
        
        <div class="space-y-4">
            @if(isset($recent_orders) && count($recent_orders) > 0)
                @foreach($recent_orders as $order)
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold uppercase">
                            {{ substr($order->user->name ?? 'K', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $order->user->name ?? 'Khách lẻ' }}</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest">{{ $order->combo->name ?? 'Combo du lịch' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-slate-800">{{ number_format($order->total_price ?? $order->gia_tien ?? 0) }}đ</p>
                        <span class="text-[9px] font-bold text-amber-600 uppercase">Đang chờ duyệt</span>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-10">
                    <div class="bg-slate-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-folder-open text-slate-300 text-2xl"></i>
                    </div>
                    <p class="text-slate-400 text-sm">Chưa có giao dịch mới trong hệ thống</p>
                </div>
            @endif
        </div>
    </div>

    {{-- THAY THẾ MỚI TẠI ĐÂY: Khối thống kê tỷ lệ trạng thái đơn đặt Combo du lịch thực tế --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h4 class="font-bold text-slate-800 uppercase text-sm tracking-widest mb-6">Trạng thái đơn hàng</h4>
        <div class="space-y-6">
            
            {{-- Đơn đã xác nhận thành công --}}
            <div>
                <div class="flex justify-between text-xs mb-2">
                    <span class="font-bold text-slate-500 uppercase">Đã xác nhận / Hoàn thành</span>
                    <span class="text-emerald-600 font-bold">{{ $confirmedPercentage ?? 0 }}%</span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-full transition-all duration-500" style="width: {{ $confirmedPercentage ?? 0 }}%"></div>
                </div>
            </div>

            {{-- Đơn đang chờ xử lý --}}
            <div>
                <div class="flex justify-between text-xs mb-2">
                    <span class="font-bold text-slate-500 uppercase">Đang chờ phê duyệt</span>
                    <span class="text-amber-600 font-bold">{{ $pendingPercentage ?? 0 }}%</span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-amber-500 h-full transition-all duration-500" style="width: {{ $pendingPercentage ?? 0 }}%"></div>
                </div>
            </div>

            {{-- Đơn bị hủy --}}
            <div>
                <div class="flex justify-between text-xs mb-2">
                    <span class="font-bold text-slate-500 uppercase">Yêu cầu hủy đơn</span>
                    <span class="text-red-600 font-bold">{{ $cancelledPercentage ?? 0 }}%</span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-red-500 h-full transition-all duration-500" style="width: {{ $cancelledPercentage ?? 0 }}%"></div>
                </div>
            </div>

        </div>
        <div class="mt-10 bg-slate-900 rounded-xl p-4 text-center">
            <p class="text-white text-[10px] font-bold tracking-widest uppercase">Thống kê đơn đặt trực tuyến</p>
        </div>
    </div>
</div>

@php
    // Day la file giao dien Dashboard thong ke, da dong bo voi cac bien phan tram don hang thuc te tu AdminController
@endphp

@endsection