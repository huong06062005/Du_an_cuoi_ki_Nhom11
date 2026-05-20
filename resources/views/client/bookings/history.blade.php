@extends('client.layouts.master')
@section('content')
<div class="max-w-5xl mx-auto py-16 px-4">
    <div class="flex items-center mb-10">
        <div class="w-2 h-10 bg-blue-600 mr-4"></div>
        <h2 class="text-3xl font-bold">Lịch Sử Đặt Tour Của Bạn</h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-5 font-bold text-gray-500 uppercase text-xs">Mã Đơn</th>
                    <th class="p-5 font-bold text-gray-500 uppercase text-xs">Combo Du Lịch</th>
                    <th class="p-5 font-bold text-gray-500 uppercase text-xs">Ngày Đặt</th>
                    <th class="p-5 font-bold text-gray-500 uppercase text-xs text-center">Trạng Thái</th>
                    <th class="p-5 font-bold text-gray-500 uppercase text-xs text-right">Thành Tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-5 font-mono text-blue-600">#{{ $booking->id }}</td>
                    <td class="p-5 font-bold text-gray-800">{{ $booking->combo->name }}</td>
                    <td class="p-5 text-gray-400 text-sm">{{ $booking->created_at->format('d/m/Y') }}</td>
                    <td class="p-5 text-center">
                        @php
                            $statusMap = [
                                'pending' => ['bg-yellow-100 text-yellow-700', 'Đang chờ'],
                                'confirmed' => ['bg-green-100 text-green-700', 'Đã duyệt'],
                                'cancelled' => ['bg-red-100 text-red-700', 'Đã hủy']
                            ];
                            $st = $statusMap[$booking->status] ?? $statusMap['pending'];
                        @endphp
                        <span class="{{ $st[0] }} px-3 py-1 rounded-full text-[10px] font-extrabold uppercase">{{ $st[1] }}</span>
                    </td>
                    <td class="p-5 text-right font-bold text-lg">{{ number_format($booking->total_price) }}đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection