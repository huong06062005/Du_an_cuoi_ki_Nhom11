@extends('client.layouts.app')

@section('content')
<div class="p-5 mb-4 bg-light rounded-3 shadow-sm border text-center">
    <h1 class="display-5 fw-bold text-primary">Khám Phá Sắc Màu Du Lịch</h1>
    <p class="fs-5 text-muted">Hệ thống trải nghiệm đặt combo du lịch nhanh chóng, an toàn và tiện lợi.</p>
</div>

<h2 class="fw-bold mb-4 text-center text-dark">🔥 Danh Sách Các Combo Hiện Có</h2>
<div class="row row-cols-1 row-cols-md-3 g-4">
    @foreach($combos as $combo)
        <div class="col">
            <div class="card h-100 shadow-sm border-0 position-relative">
                <span class="position-absolute top-0 end-0 bg-danger text-white px-3 py-1 fw-bold" style="border-bottom-left-radius: 10px;">
                    {{ number_format($combo->price) }}đ
                </span>
                <div class="card-body pt-5">
                    <h5 class="card-title fw-bold">{{ $combo->name }}</h5>
                    <p class="card-text text-muted">{{ $combo->description }}</p>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-secondary">⏱️ {{ $combo->duration }}</small>
                        <a href="{{ route('combos.show', $combo->id) }}" class="btn btn-primary btn-sm fw-bold">Xem Chi Tiết</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection