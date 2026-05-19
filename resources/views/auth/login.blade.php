@extends('client.layouts.master')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl border border-gray-200">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 uppercase tracking-widest">
                Đăng Nhập
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Truy cập để đặt những Combo du lịch tốt nhất
            </p>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div class="mb-4">
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase mb-1">Địa chỉ Email</label>
                    <input id="email" name="email" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="email@example.com">
                </div>
                <div>
                    <label for="password" class="block text-xs font-bold text-gray-700 uppercase mb-1">Mật khẩu</label>
                    <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Chưa có tài khoản? Đăng ký ngay
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-zinc-900 hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500 transition duration-150">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-gray-400 group-hover:text-gray-300"></i>
                    </span>
                    XÁC NHẬN ĐĂNG NHẬP
                </button>
            </div>
        </form>
    </div>
</div>
@endsection