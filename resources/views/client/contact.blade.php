@extends('client.layouts.master') 

@section('content')
<div class="container mx-auto px-10 py-10">
    <h1 class="text-3xl font-black text-slate-800 uppercase mb-8">Thông tin liên hệ</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div>
            <div class="space-y-6 text-slate-600">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                    <p>Số 114, Nhân Hòa, Thanh Xuân, Hà Nội</p>
                </div>
                <div class="flex items-center space-x-4">
                    <i class="fas fa-phone-alt text-blue-600"></i>
                    <p>0966 832 024</p>
                </div>
                <div class="flex items-center space-x-4">
                    <i class="fas fa-envelope text-blue-600"></i>
                    <p>viettravel@gmail.com</p>
                </div>
            </div>
            <p class="mt-8 text-sm text-slate-500 leading-relaxed">
                CÔNG TY TNHH VIETTRAVEL<br>
                Mã số doanh nghiệp: 0105777656<br>
            </p>
        </div>

        <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="ho_ten" placeholder="Họ và tên*" class="w-full border border-slate-300 p-3 rounded focus:ring-2 focus:ring-blue-600 outline-none" required>
                <input type="email" name="email" placeholder="Email*" class="w-full border border-slate-300 p-3 rounded focus:ring-2 focus:ring-blue-600 outline-none" required>
            </div>
            <input type="text" name="dien_thoai" placeholder="Điện thoại*" class="w-full border border-slate-300 p-3 rounded focus:ring-2 focus:ring-blue-600 outline-none" required>
            <textarea name="noi_dung" placeholder="Nội dung liên hệ*" rows="5" class="w-full border border-slate-300 p-3 rounded focus:ring-2 focus:ring-blue-600 outline-none" required></textarea>
            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded font-bold hover:bg-blue-700 transition">GỬI TIN NHẮN</button>
        </form>
    </div>
</div>
@endsection