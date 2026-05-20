@extends('client.layouts.master')

@section('content')
<div class="container">
    <div class="p-5 mb-4 bg-white rounded-3 shadow-sm border">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-5 fw-bold text-primary">Khám Phá Thế Giới Cùng DuLịch123</h1>
            <p class="col-md-8 fs-4 mx-auto text-muted">Đặt combo vé máy bay & khách sạn giá rẻ nhất thị trường chỉ trong 3 bước.</p>
        </div>
    </div>

    <h2 class="fw-bold mb-4 text-secondary">🔥 Các Combo Du Lịch Hot Nhất</h2>
    
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($combos as $combo)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 transition">
                @php
    // Cứ cho tất cả dùng chung ảnh san hô trước để xóa sổ hoàn toàn cái icon vỡ hình đáng ghét
    $imageUrl = 'https://images.unsplash.com/photo-1583212292454-1fe6229603b7?w=600'; 

    // Chuyển tên combo về chữ thường
    $name = mb_strtolower($combo->name, 'UTF-8');

    // Kiểm tra từ khóa xuất hiện trong tên bằng hàm thô sơ nhất của PHP
    if (strpos($name, 'lạt') !== false) {
        $imageUrl = 'https://images.unsplash.com/photo-1627286381530-2234057885b5?w=600'; // Đà Lạt
    } elseif (strpos($name, 'nẵng') !== false) {
        $imageUrl = 'https://images.unsplash.com/photo-1555919636-f331627b031c?w=600'; // Đà Nẵng
    } elseif (strpos($name, 'trang') !== false) {
        $imageUrl = 'https://images.unsplash.com/photo-1571401888144-cb1d3101b44b?w=600'; // Nha Trang
    } elseif (strpos($name, 'long') !== false) {
        $imageUrl = 'https://images.unsplash.com/photo-1528127269322-539801943592?w=600'; // Hạ Long
    } elseif (strpos($name, 'pa') !== false) {
        $imageUrl = 'https://images.unsplash.com/photo-1508873696983-2df519f0397e?w=600'; // Sa Pa
    }
@endphp

<img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $combo->name }}" style="height: 200px; object-fit: cover;">
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark">{{ $combo->name }}</h5>
                        <p class="card-text text-muted text-truncate">{{ $combo->description }}</p>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="text-danger fw-bold fs-5">{{ number_format($combo->price, 0, ',', '.') }} đ</span>
                            <a href="{{ route('client.combos.show', $combo->id) }}" class="btn btn-primary btn-sm px-3 fw-bold">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">Hiện tại chưa có combo du lịch nào được đăng bán.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection