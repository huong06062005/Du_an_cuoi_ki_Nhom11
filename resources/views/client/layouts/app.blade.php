<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Đặt Combo Du Lịch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { display: flex; flex-direction: column; min-height: 100vh; } .main-content { flex: 1; }</style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">✈️ DuLịchNhóm11</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('booking.history') }}">Lịch sử đặt hàng</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="btn btn-warning btn-sm fw-bold me-2" href="{{ route('admin.orders.index') }}">Trang Admin Duyệt Đơn 👮</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content container my-4">
        @if(session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p class="mb-0">© 2026 Module Trải Nghiệm Khách Hàng - Thành Viên 3.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>