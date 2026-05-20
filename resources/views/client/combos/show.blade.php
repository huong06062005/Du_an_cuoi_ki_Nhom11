@extends('client.layouts.master') @section('content')
<div class="container mt-5" style="margin-bottom: 100px;">
    <div class="row">
        <div class="col-md-6">
            @php
                $imageUrl = 'https://images.unsplash.com/photo-1583212292454-1fe6229603b7?w=600'; 
                $name = mb_strtolower($combo->name, 'UTF-8');

                if (strpos($name, 'lạt') !== false) $imageUrl = 'https://images.unsplash.com/photo-1627286381530-2234057885b5?w=800';
                elseif (strpos($name, 'nẵng') !== false) $imageUrl = 'https://images.unsplash.com/photo-1555919636-f331627b031c?w=800';
                elseif (strpos($name, 'trang') !== false) $imageUrl = 'https://images.unsplash.com/photo-1571401888144-cb1d3101b44b?w=800';
                elseif (strpos($name, 'long') !== false) $imageUrl = 'https://images.unsplash.com/photo-1528127269322-539801943592?w=800';
                elseif (strpos($name, 'pa') !== false) $imageUrl = 'https://images.unsplash.com/photo-1508873696983-2df519f0397e?w=800';
            @endphp
            <img src="{{ $imageUrl }}" class="img-fluid rounded shadow-sm w-100" alt="{{ $combo->name }}" style="height: 400px; object-fit: cover;">
                </div>

        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chi tiết combo</li>
                </ol>
            </nav>
            
            <h1 class="fw-bold mb-3 text-dark">{{ $combo->name }}</h1>
            <h2 class="text-danger fw-bold mb-4">{{ number_format($combo->price, 0, ',', '.') }} đ <span class="fs-6 text-muted fw-normal">/ khách</span></h2>
            
            <div class="card p-4 mb-4 bg-light border-0 rounded-3">
                <h5 class="fw-bold text-secondary mb-3"><i class="bi bi-patch-check-fill text-success"></i> Dịch vụ bao gồm trong gói:</h5>
                <p class="card-text text-muted" style="font-size: 1.1rem; line-height: 1.8; white-space: pre-line;">
                    {{ $combo->description }}
                </p>
    </div>
    
            <a href="{{ route('client.booking.create', $combo->id) }}" class="btn btn-success btn-lg w-100 p-3 fw-bold rounded-3 shadow">
                <i class="bi bi-calendar-check"></i> TIẾN HÀNH ĐẶT COMBO
            </a>
        </div>
    </div>
</div>
@endsection