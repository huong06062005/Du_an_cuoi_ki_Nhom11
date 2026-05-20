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
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-800">
                        <i class="fas fa-external-link-alt w-5"></i>
                        <span class="font-bold text-sm">Xem trang chủ</span>
                    </a>

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

            {{-- Hiển thị thông báo thành công của hệ thống --}}
            @if(session('success'))
                <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl mb-6 border border-emerald-100 font-bold text-sm flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Hiển thị thông báo thông tin bổ sung --}}
            @if(session('info'))
                <div class="bg-blue-50 text-blue-600 p-4 rounded-xl mb-6 border border-blue-100 font-bold text-sm flex items-center">
                    <i class="fas fa-info-circle mr-2"></i> {{ session('info') }}
                </div>
            @endif

            @yield('admin_content')
        </main>
    </div>

</body>
</html>