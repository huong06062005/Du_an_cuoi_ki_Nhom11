<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Đặt Combo Du Lịch</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
            background-color: #f8f9fa;
        } 
        .main-content { 
            flex: 1; 
        }
        .navbar-brand {
            font-size: 1.4rem;
        }
        /* Style riêng cho Footer chuyên nghiệp */
        .main-footer {
            background-color: #1a202c; /* Màu nền xám đen sang trọng */
            color: #a0aec0;
            font-size: 0.9rem;
        }
        .main-footer h5 {
            font-size: 1.05rem;
            letter-spacing: 0.5px;
        }
        .footer-link {
            color: #cbd5e0;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            margin-bottom: 8px;
        }
        .footer-link:hover {
            color: #ffc107 !important; /* Đổi màu vàng khi hover giống web thật */
            transform: translateX(5px); /* Hiệu ứng đẩy nhẹ sang phải */
        }
        .social-icons a {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #2d3748;
            color: #fff;
            margin-right: 8px;
            transition: all 0.3s;
            text-decoration: none;
        }
        .social-icons a:hover {
            background-color: #ffc107;
            color: #1a202c;
            transform: translateY(-3px);
        }
        .payment-badge {
            background-color: #2d3748;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            color: #fff;
            margin-right: 5px;
            display: inline-block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">✈️ DuLịchNhóm11</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home') ? 'active fw-bold text-warning' : '' }}" href="{{ route('home') }}">
                            <i class="fa-solid fa-house me-1"></i> Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('booking.history') ? 'active fw-bold text-warning' : '' }}" href="{{ route('booking.history') }}">
                            <i class="fa-solid fa-clock-history me-1"></i> Lịch sử đặt hàng
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket me-1"></i> Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i class="fa-solid fa-user-plus me-1"></i> Đăng ký</a>
                        </li>
                    @else
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-circle-user text-info me-1"></i> Chào, {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                                @if(Auth::user()->role === 'admin')
                                    <li>
                                        <a class="dropdown-item fw-bold text-primary" href="{{ route('admin.dashboard') }}">
                                            <i class="fa-solid fa-user-shield me-1"></i> Vào Trang Admin Dashboard
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                        <i class="fa-solid fa-power-off me-1"></i> Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endguest

                    <li class="nav-item">
                        <a class="btn btn-warning btn-sm fw-bold px-3 shadow-sm" href="{{ route('admin.dashboard') }}">
                            Trang Quản Trị Admin 👮
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content container my-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="main-footer pt-5 pb-3 border-top border-secondary mt-auto">
        <div class="container">
            <div class="row g-4">
                
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white fw-bold mb-3">✈️ HỆ THỐNG DULỊCHNHÓM11</h5>
                    <p class="text-secondary-50">Nền tảng đặt gói combo du lịch thông minh, kết nối tự động các dịch vụ lưu trú, lữ hành chất lượng cao nhằm đem lại trải nghiệm tối ưu cho du khách.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white fw-bold mb-3">ĐIỂM ĐẾN HOT</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Vịnh Hạ Long</a></li>
                        <li><a href="#" class="footer-link">Đảo Ngọc Phú Quốc</a></li>
                        <li><a href="#" class="footer-link">Thành phố Đà Nẵng</a></li>
                        <li><a href="#" class="footer-link">Cố đô Huế</a></li>
                        <li><a href="#" class="footer-link">Sapa mờ sương</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white fw-bold mb-3">HỖ TRỢ KHÁCH HÀNG</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Hướng dẫn đặt Combo</a></li>
                        <li><a href="#" class="footer-link">Chính sách hoàn tiền 24h</a></li>
                        <li><a href="#" class="footer-link">Điều khoản & Điều kiện</a></li>
                        <li><a href="#" class="footer-link">Bảo mật thông tin khách hàng</a></li>
                        <li><a href="#" class="footer-link">Trung tâm trợ giúp (FAQs)</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white fw-bold mb-3">THÔNG TIN LIÊN HỆ</h5>
                    <p class="mb-1"><i class="fa-solid fa-location-dot text-warning me-2"></i> Trường Đại học Phenikaa, Yên Nghĩa, Hà Đông, Hà Nội.</p>
                    <p class="mb-1"><i class="fa-solid fa-phone text-warning me-2"></i> Hotline: 1900 88xx (8h00 - 22h00)</p>
                    <p class="mb-3"><i class="fa-solid fa-envelope text-warning me-2"></i> support@dulichnhom11.com</p>
                    
                    <h6 class="text-white font-size-13 fw-bold mb-2">ĐỐI TÁC THANH TOÁN</h6>
                    <div>
                        <span class="payment-badge">Momo</span>
                        <span class="payment-badge">VNPAY</span>
                        <span class="payment-badge">Visa/MasterCard</span>
                    </div>
                </div>

            </div>

            <hr class="mt-4 mb-3 border-secondary" style="opacity: 0.2;">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted" style="font-size: 0.85rem;">&copy; Viettravel-Nâng tầm trải nghiệm Việt.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <small class="text-muted"><i class="fa-solid fa-shield-halved text-success me-1"></i> Website phục vụ báo cáo bài tập lớn Laravel</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>