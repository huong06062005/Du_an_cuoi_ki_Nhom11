<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | VietTravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 sticky top-0 h-screen">
            <div class="p-6 flex items-center space-x-3 text-white border-b border-slate-800">
                <i class="fas fa-shield-alt text-2xl text-blue-500"></i>
                <span class="font-black uppercase tracking-tighter text-lg">Admin Center</span>
            </div>

            <nav class="p-4 space-y-2 mt-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-800 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : '' }}">
                    <i class="fas fa-chart-line w-5"></i>
                    <span class="font-bold text-sm">Bảng điều khiển</span>
                </a>

                <a href="{{ route('admin.combos.index') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-800 transition-all {{ request()->routeIs('admin.combos.*') ? 'bg-blue-600 text-white' : '' }}">
                    <i class="fas fa-box w-5"></i>
                    <span class="font-bold text-sm">Quản lý Combo</span>
                </a>

                <a href="{{ Route::has('admin.services.index') ? route('admin.services.index') : '#' }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-800 transition-all {{ request()->routeIs('admin.services.*') ? 'bg-blue-600 text-white' : '' }}">
                    <i class="fas fa-concierge-bell w-5"></i>
                    <span class="font-bold text-sm">Quản lý dịch vụ</span>
                </a>

                <a href="{{ Route::has('admin.bookings.index') ? route('admin.bookings.index') : '#' }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-800 transition-all {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-600 text-white' : '' }}">
                    <i class="fas fa-calendar-check w-5"></i>
                    <span class="font-bold text-sm">Đơn đặt Tour</span>
                </a>

                <div class="pt-4 border-t border-slate-800 mt-4">
                    {{-- ĐÃ ẨN KHỐI "XEM TRANG CHỦ" THEO YÊU CẦU ĐỂ MENU ADMIN GỌN GÀNG --}}
                    {{-- 
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-800">
                        <i class="fas fa-external-link-alt w-5"></i>
                        <span class="font-bold text-sm">Xem trang chủ</span>
                    </a>
                    --}}

                    <a href="{{ route('logout') }}" class="w-full flex items-center space-x-3 p-3 rounded-xl hover:bg-red-500/10 text-red-400 mt-2">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span class="font-bold text-sm">Đăng xuất</span>
                    </a>
                </div>
            </nav>
        </aside>

        <main class="flex-grow p-10 overflow-y-auto">
            <header class="flex justify-between items-center mb-10">
                <h1 class="text-2xl font-black text-slate-800">@yield('title')</h1>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm font-bold text-slate-500">Chào, Admin {{ Auth::user()->name }}</span>
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endauth
                </div>
            </header>

            {{-- 🔥 ĐÃ CHÈN LẠI: Khối thông báo thành công viền dọc màu xanh lục phủ rộng toàn bộ các trang Admin --}}
            @if(session('success'))
                <div class="alert-box mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl shadow-sm text-sm text-emerald-800 flex items-center font-semibold transition-all duration-500">
                    <i class="fas fa-check-circle mr-2 text-emerald-500 text-base"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Hiển thị thông báo thông tin bổ sung - Đã cập nhật class alert-box và hiệu ứng transition --}}
            @if(session('info'))
                <div class="alert-box bg-blue-50 text-blue-600 p-4 rounded-xl mb-6 border border-blue-100 font-bold text-sm flex items-center transition-all duration-500">
                    <i class="fas fa-info-circle mr-2"></i> {{ session('info') }}
                </div>
            @endif

            @yield('admin_content')
        </main>
    </div>

    {{-- SCRIPT ẨN MƯỢT MÀ KHÔNG BỊ XUNG ĐỘT CLASS TAILWIND --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-box');
            
            alerts.forEach(function(alert) {
                // Thêm sẵn các thuộc tính transition bằng JS để đảm bảo chạy mượt
                alert.style.transition = "all 0.6s cubic-bezier(0.4, 0, 0.2, 1)";
                alert.style.opacity = "1";
                alert.style.overflow = "hidden";
                alert.style.maxHeight = alert.offsetHeight + "px";

                setTimeout(function() {
                    // Thực hiện hiệu ứng fade out và thu hẹp chiều cao cùng lúc
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-15px)';
                    alert.style.maxHeight = '0px';
                    alert.style.paddingTop = '0px';
                    alert.style.paddingBottom = '0px';
                    alert.style.marginTop = '0px';
                    alert.style.marginBottom = '0px';
                    alert.style.borderWidth = '0px';
                    
                    // Xóa hẳn khỏi cấu trúc trang sau khi ẩn xong hẳn
                    setTimeout(function() {
                        alert.remove();
                    }, 600);
                }, 3000); // 3000ms = 3 giây tự động ẩn
            });
        });
    </script>
</body>
</html>