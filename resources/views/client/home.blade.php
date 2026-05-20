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
                    <img src="{{ $combo->image ? asset('storage/' . $combo->image) : 'https://via.placeholder.com/350x200' }}" class="card-img-top" alt="{{ $combo->name }}" style="height: 200px; object-fit: cover;">
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark">{{ $combo->name }}</h5>
                        <p class="card-text text-muted text-truncate">{{ $combo->description }}</p>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="text-danger fw-bold fs-5">{{ number_format($combo->price, 0, ',', '.') }} đ</span>
                            <a href="#" class="btn btn-primary btn-sm px-3 fw-bold">Xem chi tiết</a>
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