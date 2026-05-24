@extends('admin.layouts.admin')

@section('title', 'QUẢN LÝ ĐƠN HÀNG')

@section('admin_content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-xl font-bold text-slate-800 uppercase tracking-tight">Danh sách đơn đặt combo</h2>
    <div class="flex space-x-2">
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
            @if(isset($orders) && $orders->count() > 0)
                @foreach($orders as $order)
                <tr class="hover:bg-slate-50/50 transition-colors text-sm">
                    <td class="p-4 font-mono font-bold text-slate-400">#ORD-{{ $order->id }}</td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $order->customer_name ?? ($order->user->name ?? 'Khách vãng lai') }}</div>
                        {{-- 🔥 ĐÃ ĐỒNG BỘ: Ưu tiên gọi cột phone_number thực tế trong database máy em --}}
                        <div class="text-xs text-slate-400">
                            {{ $order->phone_number ?? ($order->phone ?? ($order->user->phone ?? 'Chưa cập nhật')) }}
                        </div>
                    </td>
                    <td class="p-4 font-medium text-slate-700">{{ $order->combo->name ?? 'Combo du lịch' }}</td>
                    <td class="p-4 text-slate-500">{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : date('d/m/Y H:i') }}</td>
                    <td class="p-4">
                        @if($order->status == 'pending')
                            <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold uppercase">Chờ xử lý</span>
                        @elseif($order->status == 'confirmed')
                            <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase">Đã xác nhận</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full bg-rose-100 text-rose-700 text-[10px] font-bold uppercase">Đã hủy</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center items-center space-x-1">
                            {{-- Nút xem chi tiết --}}
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="p-2 hover:bg-blue-50 text-blue-600 rounded-lg transition-colors" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            {{-- Khối thao tác xử lý đơn hàng (Chỉ hiện khi trạng thái là pending) --}}
                            @if($order->status == 'pending')
                                {{-- 1. Form Duyệt nhanh --}}
                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" onsubmit="return confirm('Xác nhận phê duyệt đơn đặt combo này?')" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="p-2 hover:bg-emerald-50 text-emerald-600 rounded-lg transition-colors flex items-center space-x-1" title="Xác nhận đơn">
                                        <i class="fas fa-check-circle"></i> <span class="text-xs font-semibold">Duyệt nhanh</span>
                                    </button>
                                </form>

                                {{-- 2. 🔥 FORM HỦY ĐƠN MỚI THÊM: Đồng bộ đổi trạng thái sang 'cancelled' --}}
                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn đặt combo này?')" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="p-2 hover:bg-rose-50 text-rose-600 rounded-lg transition-colors flex items-center space-x-1" title="Hủy đơn hàng">
                                        <i class="fas fa-ban"></i> <span class="text-xs font-semibold">Hủy đơn</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
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
@endsection