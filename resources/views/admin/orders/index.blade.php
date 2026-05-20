@extends('admin.layouts.admin')

@section('title', 'QUẢN LÝ ĐƠN HÀNG')

@section('admin_content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-xl font-bold text-slate-800 uppercase tracking-tight">Danh sách đơn đặt combo</h2>
    <div class="flex space-x-2">
        {{-- Tự động đếm số lượng đơn thật trong cơ sở dữ liệu thay vì gõ cứng số 128 --}}
        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-md text-xs font-bold border border-blue-100">
            Tổng: {{ isset($orders) ? $orders->count() : 0 }} đơn
        </span>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-100">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Mã Đơn</th>
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Khách hàng</th>
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Combo đã chọn</th>
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Ngày đặt</th>
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Trạng thái</th>
                <th class="p-4 text-center text-xs font-bold text-slate-500 uppercase">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            {{-- Bọc vòng lặp an toàn phòng khi chưa có đơn nào đặt --}}
            @if(isset($orders) && $orders->count() > 0)
                @foreach($orders as $order)
                <tr class="hover:bg-slate-50/50 transition-colors text-sm">
                    <td class="p-4 font-mono font-bold text-slate-400">#ORD-{{ $order->id }}</td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $order->user->name ?? 'Khách vãng lai' }}</div>
                        <div class="text-xs text-slate-400">{{ $order->phone ?? ($order->user->phone ?? 'Chưa cập nhật') }}</div>
                    </td>
                    {{-- Sửa đổi từ ten_combo sang thuộc tính name chuẩn hóa chung của dự án --}}
                    <td class="p-4 font-medium text-slate-700">{{ $order->combo->name ?? 'Combo du lịch' }}</td>
                    <td class="p-4 text-slate-500">{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : date('d/m/Y H:i') }}</td>
                    <td class="p-4">
                        @if($order->status == 'pending')
                            <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold uppercase">Chờ xử lý</span>
                        @elseif($order->status == 'confirmed')
                            <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase">Đã xác nhận</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold uppercase">Đã hủy</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center items-center space-x-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="p-2 hover:bg-blue-50 text-blue-600 rounded-lg transition-colors" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            {{-- Chỉ hiển thị nút Duyệt nhanh nếu đơn hàng đang ở trạng thái chờ duyệt --}}
                            @if($order->status == 'pending')
                                {{-- Sửa đổi route từ update_status sang admin.orders.update chuẩn cấu hình web.php --}}
                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" onsubmit="return confirm('Xác nhận phê duyệt đơn đặt combo này?')">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="p-2 hover:bg-emerald-50 text-emerald-600 rounded-lg transition-colors flex items-center space-x-1" title="Xác nhận đơn">
                                        <i class="fas fa-check-circle"></i> <span>Duyệt nhanh</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
                {{-- Hiển thị thông báo thân thiện nếu hệ thống chưa có dữ liệu đơn đặt chỗ --}}
                <tr>
                    <td colspan="6" class="text-center py-12 text-slate-400">
                        <div class="bg-slate-50 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-folder-open text-slate-300 text-xl"></i>
                        </div>
                        <p class="text-xs">Không tìm thấy dữ liệu đơn đặt combo du lịch nào.</p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@php
    // Giao dien bảng quản lý danh sach don hang chu và fix cac loi goi sai route update_status gay crash backend
@endphp

@endsection