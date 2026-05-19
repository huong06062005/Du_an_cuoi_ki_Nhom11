@extends('admin.layouts.admin')

@section('title', 'QUẢN LÝ TÀI KHOẢN')

@section('admin_content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Danh sách khách hàng</h2>
        <p class="text-sm text-slate-500">Quản lý thông tin và phân quyền người dùng hệ thống</p>
    </div>
    <div class="flex space-x-3">
        <div class="relative">
            <input type="text" placeholder="Tìm kiếm email/tên..." class="pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
            <i class="fas fa-search absolute left-3 top-3 text-slate-400 text-xs"></i>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200">
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Người dùng</th>
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Liên hệ</th>
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Vai trò</th>
                <th class="p-4 text-xs font-bold text-slate-500 uppercase">Ngày gia nhập</th>
                <th class="p-4 text-center text-xs font-bold text-slate-500 uppercase">Hành động</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($users as $user)
            <tr class="hover:bg-slate-50/50 transition-colors">
                <td class="p-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200 mr-3">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-800">{{ $user->name }}</div>
                            <div class="text-[10px] text-blue-600 font-bold uppercase tracking-widest">ID: #USR-{{ $user->id }}</div>
                        </div>
                    </div>
                </td>
                <td class="p-4">
                    <div class="text-sm text-slate-600">{{ $user->email }}</div>
                    <div class="text-xs text-slate-400 italic">Xác minh: <span class="text-green-500">Đã kích hoạt</span></div>
                </td>
                <td class="p-4">
                    @if($user->role == 'admin')
                        <span class="px-3 py-1 rounded-lg bg-purple-100 text-purple-700 text-[10px] font-black uppercase border border-purple-200">
                            <i class="fas fa-user-shield mr-1"></i> Quản trị viên
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-black uppercase border border-slate-200">
                            Khách hàng
                        </span>
                    @endif
                </td>
                <td class="p-4 text-sm text-slate-500 font-medium">
                    {{ $user->created_at->format('d/m/Y') }}
                </td>
                <td class="p-4 text-center">
                    <div class="flex justify-center space-x-2">
                        <button class="p-2 text-slate-400 hover:text-blue-600 transition-colors" title="Chỉnh sửa quyền">
                            <i class="fas fa-user-edit text-sm"></i>
                        </button>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors" title="Xóa tài khoản">
                                <i class="fas fa-user-minus text-sm"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6 flex justify-between items-center text-sm text-slate-500">
    <p>Hiển thị tài khoản khách hàng từ 1 đến 10</p>
    <div class="flex space-x-1">
        <button class="px-3 py-1 border rounded hover:bg-slate-50">1</button>
        <button class="px-3 py-1 border rounded hover:bg-slate-50">2</button>
        <button class="px-3 py-1 border rounded hover:bg-slate-50">Sau <i class="fas fa-chevron-right ml-1 text-[10px]"></i></button>
    </div>
</div>
@endsection