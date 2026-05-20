@extends('admin.layouts.admin') 

@section('title', 'THÊM DỊCH VỤ MỚI')

@section('admin_content')
<div class="max-w-4xl mx-auto" x-data="serviceForm()">
    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100 mb-6">
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

            <div class="col-span-2 space-y-3">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest">Service Preview</label>
                
                <div class="border border-slate-200 rounded-2xl p-5 bg-white space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center space-x-1 text-amber-400 text-xs mb-1">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <span class="bg-amber-100 text-amber-800 text-[10px] px-1.5 py-0.5 rounded font-bold ml-2">Top đầu</span>
                            </div>
                            <h4 class="font-bold text-slate-800 text-base" x-text="name || 'Le House Boutique Hotel - 100m to the beach'"></h4>
                            <p class="text-xs text-slate-400 mt-1">
                                <i class="fas fa-map-marker-alt text-blue-500 mr-1"></i> 
                                <span x-text="type === 'hotel' ? '05 - 01 - 0 Tầng Đà Nẵng - Việt Nam' : 'Tuyến điểm vận hành hệ thống'"></span> 
                                <span class="text-blue-500 font-medium ml-1">· Tuyệt ngắn nũ · Thiết bị sàn đố</span>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-12 md:col-span-5 h-44 bg-slate-100 rounded-xl overflow-hidden shadow-inner border border-slate-100">
                            <img :src="imageSrc" class="w-full h-full object-cover" alt="Main Preview">
                        </div>
                        
                        <div class="col-span-12 md:col-span-3 grid grid-cols-2 gap-2 h-44">
                            <div class="bg-slate-100 rounded-lg overflow-hidden"><img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover"></div>
                            <div class="bg-slate-100 rounded-lg overflow-hidden"><img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover"></div>
                            <div class="bg-slate-100 rounded-lg overflow-hidden"><img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover"></div>
                            <div class="bg-slate-100 rounded-lg overflow-hidden relative">
                                <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-white text-xs font-bold">+12 ảnh</div>
                            </div>
                        </div>

                        <div class="col-span-12 md:col-span-4 border border-slate-100 rounded-xl p-3 bg-slate-50/50 flex flex-col justify-between">
                            <div class="space-y-1.5">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-black text-slate-700">Highlights</span>
                                    <span class="text-emerald-600 text-xs font-bold">Excellent, 7.7</span>
                                </div>
                                <ul class="text-[11px] text-slate-500 space-y-1 list-disc list-inside">
                                    <li>Free High-Speed Wi-Fi</li>
                                    <li>Chòng gmáy hân tụi ch oần hang</li>
                                </ul>
                            </div>
                            
                            <div class="border-t border-slate-200/60 pt-2 space-y-1.5">
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ratings</p>
                                <div class="flex justify-between items-center bg-white p-2 rounded-lg border border-slate-100 shadow-sm">
                                    <div class="flex items-center space-x-1.5">
                                        <div class="w-5 h-5 bg-slate-200 rounded-full overflow-hidden"><img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover"></div>
                                        <span class="text-[11px] font-bold text-slate-700">Excellent, 7.7</span>
                                    </div>
                                    <span class="bg-blue-800 text-white font-bold text-[11px] px-1.5 py-0.5 rounded">7.7</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-2 space-y-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest">Service Highlights (Icon) ★</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="border border-slate-100 rounded-2xl p-4 bg-white flex items-center justify-between shadow-sm hover:border-blue-200 transition-all">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center"><i class="fas fa-wifi text-sm"></i></div>
                            <span class="text-xs font-bold text-slate-700 leading-tight">Free High-Speed<br>Wi-Fi</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
                    </div>
                    <div class="border border-slate-100 rounded-2xl p-4 bg-white flex items-center justify-between shadow-sm hover:border-blue-200 transition-all">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center"><i class="fas fa-bus text-sm"></i></div>
                            <span class="text-xs font-bold text-slate-700 leading-tight">Airport Shuttle</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
                    </div>
                    <div class="border border-slate-100 rounded-2xl p-4 bg-white flex items-center justify-between shadow-sm hover:border-blue-200 transition-all">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center"><i class="fas fa-spa text-sm"></i></div>
                            <span class="text-xs font-bold text-slate-700 leading-tight">Spa & Wellness<br>Center</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
                    </div>
                    <div class="border border-slate-100 rounded-2xl p-4 bg-white flex items-center justify-between shadow-sm hover:border-blue-200 transition-all">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center"><i class="fas fa-utensils text-sm"></i></div>
                            <span class="text-xs font-bold text-slate-700 leading-tight">Kitchen Facilities</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
                    </div>
                </div>
            </div>

            <div class="col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Hình ảnh minh họa</label>
                <input type="file" name="image" @change="previewImage" class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-2xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @error('image') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="col-span-2 space-y-3">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest">Service Description</label>
                <div class="w-full max-h-36 overflow-y-auto px-5 py-4 rounded-2xl border border-slate-200 bg-slate-50 text-xs text-slate-700 leading-relaxed font-medium whitespace-pre-line shadow-inner"
                     x-text="description || 'Nằm trên khu vực Bãi biển Mỹ Khê của thành phố Đà Nẵng, trong bán kính 2,4 km từ Cầu Rồng, Le House Boutique Hotel - 100m to the beach cung cấp các phòng máy lạnh...'">
                </div>
                <textarea name="mo_ta_chi_tiet" x-model="description" rows="4" placeholder="Nhập tóm tắt các dịch vụ hoặc lịch trình bao gồm trong combo..." class="w-full px-5 py-4 rounded-2xl border-2 border-slate-50 focus:border-blue-500 outline-none bg-slate-50/50 text-sm">{{ old('mo_ta_chi_tiet') }}</textarea>
            </div>
        </div>

        <div class="mt-12 flex space-x-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-100 hover:scale-[1.02] transition-all uppercase tracking-widest">
                Save to Repository
            </button>
            <a href="{{ route('admin.services.index') }}" class="px-8 py-4 bg-slate-100 text-slate-500 rounded-2xl font-bold hover:bg-slate-200 transition-all uppercase tracking-widest">
                Cancel
            </a>
        </div>
    </form>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    function serviceForm() {
        return {
            name: '{{ old('name', '') }}',
            type: '{{ old('type', 'hotel') }}',
            price: '{{ old('price', 800000) }}',
            description: '{{ old('mo_ta_chi_tiet', '') }}',
            // Ảnh mẫu mặc định khi chưa upload file mới
            imageSrc: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
            
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