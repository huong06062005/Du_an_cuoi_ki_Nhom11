@extends('client.layouts.master')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl border border-gray-200">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 uppercase tracking-widest">
                Tạo Tài Khoản
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Trở thành thành viên của VietTravel
            </p>
        </div>
        <form class="mt-8 space-y-4" action="{{ route('register') }}" method="POST">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Họ và tên</label>
                <input name="name" type="text" required class="appearance-none rounded-xl relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Nguyễn Văn A">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                <input name="email" type="email" required class="appearance-none rounded-xl relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="example@gmail.com">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Mật khẩu</label>
                <input name="password" type="password" required class="appearance-none rounded-xl relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Tối thiểu 8 ký tự">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Xác nhận mật khẩu</label>
                <input name="password_confirmation" type="password" required class="appearance-none rounded-xl relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Nhập lại mật khẩu">
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 shadow-lg">
                    HOÀN TẤT ĐĂNG KÝ
                </button>
            </div>
            
            <div class="text-center text-sm">
                <a href="{{ route('login') }}" class="font-medium text-gray-500 hover:text-gray-700">
                    Đã có tài khoản? Quay lại đăng nhập
                </a>
            </div>
        </form>
    </div>
</div>
@endsection