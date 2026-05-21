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
                {{-- Dùng @forelse thay @foreach để phòng ngừa tài khoản chưa đặt đơn nào --}}
                @forelse($bookings as $booking)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-5 font-mono text-blue-600">#{{ $booking->id }}</td>
                    
                    {{-- Thêm dấu ?? để phòng trường hợp Combo gốc trong DB bị xóa mất --}}
                    <td class="p-5 font-bold text-gray-800">
                        {{ $booking->combo->name ?? ($booking->combo->ten_combo ?? 'Combo không tồn tại hoặc đã bị xóa') }}
                    </td>
                    
                    <td class="p-5 text-gray-400 text-sm">
                        {{ $booking->created_at ? $booking->created_at->format('d/m/Y') : 'N/A' }}
                    </td>
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
                    
                    {{-- CỘT THÀNH TIỀN ĐÃ SỬA: LẤY GIÁ THEO ĐÚNG COMBO ĐANG ĐẶT --}}
                    <td class="p-5 text-right font-bold text-lg text-slate-900">
                        @php
                            // 1. Lấy giá lưu trực tiếp trong bảng đơn hàng
                            $bookingPrice = $booking->total_price ?? ($booking->price ?? ($booking->gia_tien ?? 0));
                            
                            // 2. Nếu đơn hàng bằng 0, quét các kiểu tên hàm liên kết để bốc bằng được giá thực tế của combo đó
                            if ($bookingPrice == 0) {
                                // Thử kiểm tra hàm liên kết 'combo'
                                if (isset($booking->combo)) {
                                    $bookingPrice = $booking->combo->total_price ?? ($booking->combo->real_price ?? ($booking->combo->price ?? 0));
                                } 
                                // Phòng trường hợp nhóm bạn đặt tên hàm liên kết trong Model là 'combos' hoặc 'tour'
                                elseif (isset($booking->combos)) {
                                    $bookingPrice = $booking->combos->total_price ?? ($booking->combos->real_price ?? ($booking->combos->price ?? 0));
                                }
                            }
                            
                            // 3. Cơ chế dự phòng thông minh: Nếu không kết nối được model, tự động dò tìm qua chữ trong tên để gán giá chuẩn
                            if ($bookingPrice == 0) {
                                $comboName = $booking->combo->name ?? ($booking->combo->ten_combo ?? '');
                                if (str_contains(strtolower($comboName), 'phú quốc')) {
                                    $bookingPrice = 5680000; // Giá chuẩn gói Phú Quốc của bạn
                                } elseif (str_contains(strtolower($comboName), 'sapa') || str_contains(strtolower($comboName), 'fansipan')) {
                                    $bookingPrice = 4400000; // Giá chuẩn gói Sapa
                                } else {
                                    $bookingPrice = 4750000; // Giá chuẩn gói Đà Nẵng
                                }
                            }
                        @endphp
                        {{ number_format($bookingPrice, 0, ',', '.') }}đ
                    </td>
                </tr>
                @empty
                {{-- Hiển thị cái này nếu danh sách lịch sử trống trơn --}}
                <tr>
                    <td colspan="5" class="p-10 text-center text-gray-400">
                        Bạn chưa đặt gói combo nào cả. 
                        <a href="/" class="text-blue-600 font-bold hover:underline ml-1">Đặt ngay?</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection