@extends('admin.layout.admin')

@section('title', 'THÊM DỊCH VỤ MỚI')

@section('admin_content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.services.store') }}" method="POST" class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100">
        @csrf
        <div class="flex items-center space-x-4 mb-10 border-b border-slate-50 pb-6">
            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                <i class="fas fa-plus text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-black text-slate-800 uppercase">Đăng ký dịch vụ mới</h3>
                <p class="text-xs text-slate-400">Thiết lập thông số cho dịch vụ thành phần</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tên dịch vụ cụ thể</label>
                <input type="text" name="ten_dich_vu" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-50 focus:border-blue-500 outline-none transition-all bg-slate-50/50" placeholder="VD: Khách sạn Mường Thanh Luxury">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Phân loại dịch vụ</label>
                <select name="type" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-50 focus:border-blue-500 outline-none bg-slate-50/50 font-medium">
                    <option value="hotel">Lưu trú (Khách sạn/Resort)</option>
                    <option value="flight">Vận chuyển (Máy bay/Tàu hỏa)</option>
                    <option value="tour">Tham quan (Vé vào cổng/Tour lẻ)</option>
                    <option value="car">Di chuyển (Xe đưa đón)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Giá nhập hệ thống (VNĐ)</label>
                <input type="number" name="gia_nhap" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-50 focus:border-blue-500 outline-none bg-slate-50/50 font-bold text-blue-600">
            </div>
        </div>

        <div class="mt-12 flex space-x-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-100 hover:scale-[1.02] transition-all uppercase tracking-widest">
                Lưu vào kho dữ liệu
            </button>
            <a href="{{ route('admin.services.index') }}" class="px-8 py-4 bg-slate-100 text-slate-500 rounded-2xl font-bold hover:bg-slate-200 transition-all uppercase tracking-widest">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection
