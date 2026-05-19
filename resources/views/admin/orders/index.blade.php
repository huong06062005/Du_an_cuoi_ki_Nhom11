@extends('admin.layout.admin')

@section('title', 'QUẢN LÝ ĐƠN HÀNG')

@section('admin_content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-xl font-bold text-slate-800 uppercase tracking-tight">Danh sách đơn đặt combo</h2>
    <div class="flex space-x-2">
        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-md text-xs font-bold border border-blue-100">Tổng: 128 đơn</span>
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
            @foreach($orders as $order)
            <tr class="hover:bg-slate-50/50 transition-colors text-sm">
                <td class="p-4 font-mono font-bold text-slate-400">#ORD-{{ $order->id }}</td>
                <td class="p-4">
                    <div class="font-bold text-slate-800">{{ $order->user->name ?? 'Khách vãng lai' }}</div>
                    <div class="text-xs text-slate-400">{{ $order->phone }}</div>
                </td>
                <td class="p-4 font-medium text-slate-700">{{ $order->combo->ten_combo }}</td>
                <td class="p-4 text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
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
                    <div class="flex justify-center space-x-2">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="p-2 hover:bg-blue-50 text-blue-600 rounded-lg transition-colors" title="Xem chi tiết">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="p-2 hover:bg-emerald-50 text-emerald-600 rounded-lg transition-colors" title="Xác nhận đơn">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection