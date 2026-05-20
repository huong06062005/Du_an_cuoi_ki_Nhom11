@extends('client.layouts.master') @section('content')
<div class="container mt-5" style="margin-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-file-earmark-text"></i> FORM ĐĂNG KÝ ĐẶT COMBO DU LỊCH</h4>
                </div>
                <div class="card-body p-4">
                    
                    <div class="alert alert-info border-0 rounded-3 mb-4">
                        <h5 class="fw-bold text-dark mb-1">Bạn đang đặt: {{ $combo->name }}</h5>
                        <p class="mb-0 text-danger fw-bold fs-5">Đơn giá: {{ number_format($combo->price, 0, ',', '.') }} đ / khách</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('client.booking.store', $combo->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ và tên khách hàng <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" class="form-control p-2.5" placeholder="Ví dụ: Nguyễn Văn A" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số điện thoại liên hệ <span class="text-danger">*</span></label>
                            <input type="text" name="customer_phone" class="form-control p-2.5" placeholder="Ví dụ: 0912345678" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ Email <span class="text-danger">*</span></label>
                            <input type="email" name="customer_email" class="form-control p-2.5" placeholder="name@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số lượng người đi <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control p-2.5" value="1" min="1" required>
                        </div>

                        <hr class="my-4">

                        <button type="submit" class="btn btn-success btn-lg w-100 fw-bold p-3 text-white shadow-sm rounded-3">
                            <i class="bi bi-shield-check"></i> XÁC NHẬN ĐẶT TOUR NGAY
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection