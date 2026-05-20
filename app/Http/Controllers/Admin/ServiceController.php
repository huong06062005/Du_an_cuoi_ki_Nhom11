<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service; // Model quản lý dịch vụ thành phần
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema; // Khai báo thư viện để tự động kiểm tra cột database

class ServiceController extends Controller
{
    /**
     * Danh sách dịch vụ
     */
    public function index()
    {
        // Lấy danh sách dịch vụ mới nhất từ Database
        $services = Service::latest()->get();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Form thêm dịch vụ mới
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Lưu dịch vụ mới vào Database (Tự động lọc tên cột tránh lỗi MySQL)
     */
    public function store(Request $request)
    {
        // 1. Validation nghiêm ngặt dữ liệu đầu vào từ form
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:flight,hotel,attraction,transport', // Bắt buộc chọn đúng phân loại
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Bổ sung thêm đuôi webp phổ biến
            'mo_ta_chi_tiet' => 'nullable|string'
        ]);

        // 2. Gom dữ liệu cơ bản (Gồm cả phương án tiếng Anh và tiếng Việt dự phòng)
        $rawFormInputs = [
            'name'           => $request->name,
            'ten_dich_vu'    => $request->name,
            
            'type'           => $request->type,
            'loai_dich_vu'   => $request->type,
            
            'price'          => $request->price,
            'gia_tien'       => $request->price,
            
            'mo_ta'          => $request->mo_ta_chi_tiet, 
            'mo_ta_chi_tiet' => $request->mo_ta_chi_tiet, 
        ];

        // 3. Xử lý upload hình ảnh dịch vụ nếu có
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
            $rawFormInputs['image']     = $imagePath;
            $rawFormInputs['image_path']= $imagePath;
            $rawFormInputs['hinh_anh']  = $imagePath;
            $rawFormInputs['hinnh_anh'] = $imagePath; // Sửa lỗi viết sai chính tả tiêu đề phòng hờ
        }

        // 4. BỘ LỌC THÔNG MINH: Tự động giữ lại các trường có thật trong MySQL của em, loại bỏ trường thừa gây crash lỗi
        $safeData = array_filter($rawFormInputs, function ($key) {
            return Schema::hasColumn('services', $key);
        }, ARRAY_FILTER_USE_KEY);

        // 5. Tiến hành lưu vào bảng MySQL
        Service::create($safeData);

        return redirect()->route('admin.services.index')->with('success', 'Thêm dịch vụ thành công!');
    }

    /**
     * Form chỉnh sửa dịch vụ
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Cập nhật thông tin dịch vụ
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:flight,hotel,attraction,transport',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'mo_ta_chi_tiet' => 'nullable|string'
        ]);

        $rawFormInputs = [
            'name'           => $request->name,
            'ten_dich_vu'    => $request->name,
            
            'type'           => $request->type,
            'loai_dich_vu'   => $request->type,
            
            'price'          => $request->price,
            'gia_tien'       => $request->price,
            
            'mo_ta'          => $request->mo_ta_chi_tiet,
            'mo_ta_chi_tiet' => $request->mo_ta_chi_tiet,
        ];

        // Xử lý thay thế ảnh cũ nếu có upload ảnh mới
        if ($request->hasFile('image')) {
            // Danh sách các cột chứa ảnh có thể có trong model của em
            $imageFields = ['image', 'image_path', 'hinh_anh', 'hinnh_anh'];
            
            foreach ($imageFields as $field) {
                if (!empty($service->$field) && Storage::disk('public')->exists($service->$field)) {
                    Storage::disk('public')->delete($service->$field);
                }
            }

            $imagePath = $request->file('image')->store('services', 'public');
            $rawFormInputs['image']     = $imagePath;
            $rawFormInputs['image_path']= $imagePath;
            $rawFormInputs['hinh_anh']  = $imagePath;
            $rawFormInputs['hinnh_anh'] = $imagePath;
        }

        // Tự động lọc thông minh cho hành động Update
        $safeData = array_filter($rawFormInputs, function ($key) {
            return Schema::hasColumn('services', $key);
        }, ARRAY_FILTER_USE_KEY);

        $service->update($safeData);

        return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công!');
    }

    /**
     * Xóa dịch vụ
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        
        // Liệt kê xóa toàn bộ ảnh vật lý để sạch dung lượng disk máy
        $imageFields = ['image', 'image_path', 'hinh_anh', 'hinnh_anh'];
        foreach ($imageFields as $field) {
            if (!empty($service->$field) && Storage::disk('public')->exists($service->$field)) {
                Storage::disk('public')->delete($service->$field);
            }
        }
        
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Đã xóa dịch vụ thành công!');
    }
}