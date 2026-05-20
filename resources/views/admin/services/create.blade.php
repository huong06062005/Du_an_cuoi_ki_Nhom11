@extends('admin.layouts.admin') 

@section('title', 'THÊM DỊCH VỤ MỚI')

@section('admin_content')
<div class="max-w-4xl mx-auto" x-data="serviceForm()">
    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100 mb-8">
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
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tên dịch vụ cụ thể <span class="text-red-500">*</span></label>
                <input type="text" name="name" x-model="name" value="{{ old('name') }}" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-50 focus:border-blue-500 outline-none transition-all bg-slate-50/50 @error('name') border-red-500 @enderror" placeholder="VD: Khách sạn Mường Thanh Luxury">
                @error('name') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Phân loại dịch vụ <span class="text-red-500">*</span></label>
                <select name="type" x-model="type" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-50 focus:border-blue-500 outline-none bg-slate-50/50 font-medium @error('type') border-red-500 @enderror">
                    <option value="">-- Chọn loại dịch vụ --</option>
                    <option value="hotel" {{ old('type') == 'hotel' ? 'selected' : '' }}>Lưu trú (Khách sạn/Resort)</option>
                    <option value="flight" {{ old('type') == 'flight' ? 'selected' : '' }}>Vận chuyển (Máy bay/Tàu hỏa)</option>
                    <option value="attraction" {{ old('type') == 'attraction' ? 'selected' : '' }}>Tham quan (Vé vào cổng/Tour lẻ)</option>
                    <option value="transport" {{ old('type') == 'transport' ? 'selected' : '' }}>Di chuyển (Xe đưa đón)</option>
                </select>
                @error('type') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Giá nhập hệ thống (VNĐ) <span class="text-red-500">*</span></label>
                <input type="number" name="price" x-model="price" value="{{ old('price') }}" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-50 focus:border-blue-500 outline-none bg-slate-50/50 font-bold text-blue-600 @error('price') border-red-500 @enderror">
                @error('price') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Hình ảnh minh họa</label>
                <input type="file" name="image" @change="previewImage" class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-2xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @error('image') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Mô tả chi tiết / Ghi chú</label>
                <textarea name="mo_ta_chi_tiet" x-model="description" rows="4" placeholder="Nhập thông tin bổ sung (Hạng phòng, hãng bay, giờ đưa đón...)" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-50 focus:border-blue-500 outline-none bg-slate-50/50 text-sm">{{ old('mo_ta_chi_tiet') }}</textarea>
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

    <div class="space-y-4 mb-12">
        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest">
            <i class="fas fa-eye mr-1"></i> Khung hiển thị trực quan dữ liệu thành phần (Live Preview)
        </label>
        
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-6">
            <div class="border border-slate-200 rounded-2xl overflow-hidden bg-white">
                <div class="p-5 bg-slate-50/60 border-b border-slate-100 flex justify-between items-start">
                    <div>
                        <div class="flex items-center space-x-1 text-amber-400 text-xs mb-1">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span class="bg-blue-50 text-blue-700 text-[10px] px-1.5 py-0.5 rounded ml-2 font-bold uppercase tracking-wider">Đối tác chiến lược</span>
                        </div>
                        <h4 class="font-black text-slate-800 text-lg uppercase" x-text="name || 'Tên dịch vụ cụ thể hiển thị ở đây...'"></h4>
                        <p class="text-xs text-slate-400 mt-1">
                            <i class="fas fa-map-marker-alt mr-1 text-red-400"></i> 
                            <span x-text="type === 'hotel' ? 'Điểm lưu trú tiêu chuẩn — Vị trí trung tâm' : 'Tuyến điểm vận hành linh hoạt'"></span>
                        </p>
                    </div>
                    <div class="text-right flex items-center space-x-2">
                        <div>
                            <p class="text-xs font-bold text-blue-600">Tuyệt vời</p>
                            <p class="text-[10px] text-slate-400">1.875 đánh giá</p>
                        </div>
                        <span class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-md">9.2</span>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-4 p-5">
                    <div class="col-span-12 md:col-span-7 h-52 bg-slate-100 rounded-xl overflow-hidden shadow-inner border border-slate-100">
                        <img :src="imageSrc" class="w-full h-full object-cover transition-all duration-300" alt="Service Image Preview">
                    </div>
                    
                    <div class="col-span-12 md:col-span-5 flex flex-col justify-between space-y-3">
                        <div class="bg-blue-50/30 border border-blue-100/70 rounded-xl p-4 h-full">
                            <p class="text-xs font-bold text-blue-900 uppercase tracking-wider mb-2.5">Điểm nổi bật dịch vụ:</p>
                            <ul class="text-[11px] text-slate-600 space-y-2">
                                <li><i class="fas fa-check-circle text-emerald-500 mr-2"></i> Wifi miễn phí băng thông rộng</li>
                                <li><i class="fas fa-shield-alt text-emerald-500 mr-2"></i> Hỗ trợ hủy dịch vụ linh hoạt</li>
                                <li><i class="fas fa-user-shield text-emerald-500 mr-2"></i> Bảo hiểm hành trình đi kèm</li>
                            </ul>
                        </div>
                        
                        <div class="bg-slate-900 border border-slate-800 rounded-xl p-3 flex justify-between items-center px-4 shadow-lg shadow-slate-200">
                            <span class="text-xs text-slate-400 font-medium">Giá hệ thống:</span>
                            <span class="text-lg font-black text-emerald-400" x-text="formatPrice(price) + ' VNĐ'"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="border border-slate-100 rounded-xl p-3 text-center bg-slate-50/50 flex flex-col items-center justify-center">
                    <i class="fas fa-hotel text-lg text-blue-600 mb-1"></i>
                    <span class="text-[10px] font-bold text-slate-500 uppercase">Hệ thống phòng</span>
                </div>
                <div class="border border-slate-100 rounded-xl p-3 text-center bg-slate-50/50 flex flex-col items-center justify-center">
                    <i class="fas fa-plane text-lg text-blue-600 mb-1"></i>
                    <span class="text-[10px] font-bold text-slate-500 uppercase">Vé máy bay</span>
                </div>
                <div class="border border-slate-100 rounded-xl p-3 text-center bg-slate-50/50 flex flex-col items-center justify-center">
                    <i class="fas fa-route text-lg text-blue-600 mb-1"></i>
                    <span class="text-[10px] font-bold text-slate-500 uppercase">Lịch trình tour</span>
                </div>
                <div class="border border-slate-100 rounded-xl p-3 text-center bg-slate-50/50 flex flex-col items-center justify-center">
                    <i class="fas fa-car text-lg text-blue-600 mb-1"></i>
                    <span class="text-[10px] font-bold text-slate-500 uppercase">Xe đưa đón</span>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Chi tiết thông số mô tả</h5>
                <div class="bg-slate-50 text-slate-600 text-xs p-4 rounded-xl leading-relaxed whitespace-pre-line border border-slate-100 min-h-[70px]" 
                     x-text="description || 'Thông số chi tiết (Hạng phòng, hãng bay, giờ đưa đón...) sẽ hiển thị tự động tại đây khi em nhập dữ liệu...'">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    function serviceForm() {
        return {
            name: '{{ old('name', '') }}',
            type: '{{ old('type', 'hotel') }}',
            price: '{{ old('price', 800000) }}',
            description: '{{ old('mo_ta_chi_tiet', '') }}',
            imageSrc: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
            
            formatPrice(val) {
                if (!val) return '0';
                return parseInt(val).toLocaleString('vi-VN');
            },
            previewImage(e) {
                const file = e.target.files[0];
                if (file) {
                    this.imageSrc = URL.createObjectURL(file);
                }
            }
        }
    }
</script>
@endsection