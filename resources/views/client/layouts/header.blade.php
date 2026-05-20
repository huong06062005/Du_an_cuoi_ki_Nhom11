<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-10 h-20 flex justify-between items-center">
        <a href="/" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center text-white">
                <i class="fas fa-paper-plane text-sm"></i>
            </div>
            <span class="text-xl font-black text-slate-800 tracking-tighter uppercase">VietTravel</span>
        </a>

        <nav class="hidden md:flex space-x-8 font-bold text-[11px] uppercase tracking-widest text-slate-500">
            <a href="/" class="hover:text-blue-600 transition-colors">Trang chủ</a>
            <a href="{{ route('combos.index') }}" class="hover:text-blue-600 transition-colors">Gói Combo</a>
            <a href="#" class="hover:text-blue-600 transition-colors">Khách sạn</a>
            <a href="#" class="hover:text-blue-600 transition-colors">Tin tức</a>
        </nav>

        <div class="flex items-center space-x-6">
            @guest
                <a href="{{ route('login') }}" class="text-[11px] font-bold text-slate-600 uppercase hover:text-blue-600">Đăng nhập</a>
                <a href="{{ route('register') }}" class="bg-[#1a1a2e] text-white px-6 py-2.5 rounded text-[11px] font-black uppercase tracking-widest shadow-lg hover:bg-blue-600 transition-all">
                    Đăng ký ngay
                </a>
            @else
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-tight">Thành viên</span>
                        <span class="text-xs font-black text-blue-600 italic">Chào, {{ Auth::user()->name }}</span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="border-2 border-slate-800 text-slate-800 px-4 py-2 rounded text-[10px] font-black uppercase tracking-widest hover:bg-red-600 hover:border-red-600 hover:text-white transition-all shadow-sm">
                            Đăng xuất
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</header>