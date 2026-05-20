<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service; // Model quản lý dịch vụ thành phần
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Danh sách dịch vụ
     * Phân loại trực quan: Vé máy bay, Khách sạn, Vé tham quan, Xe đưa đón...
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
     * Lưu dịch vụ mới vào Database (Vé máy bay, Khách sạn, Vé vui chơi...)
     */
    public function store(Request $request)
    {
        // 1. Validation nghiêm ngặt dữ liệu đầu vào từ form
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:flight,hotel,attraction,transport', // Bắt buộc chọn đúng phân loại
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Tối đa 2MB
            'mo_ta_chi_tiet' => 'nullable|string'
        ]);

        // 2. Gom dữ liệu cơ bản (Tự động bọc lót cả 2 phương án tiếng Anh và tiếng Việt cho an toàn database)
        $data = [
            'name' => $request->name,
            'ten_dich_vu' => $request->name,
            
            'type' => $request->type,
            'loai_dich_vu' => $request->type,
            
            'price' => $request->price,
            'gia_tien' => $request->price,
            
            'mo_ta' => $request->mo_ta_chi_tiet, 
            'mo_ta_chi_tiet' => $request->mo_ta_chi_tiet, 
        ];

        // 3. Xử lý upload hình ảnh dịch vụ nếu có
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
            $data['image'] = $imagePath;
            $data['hinnh_anh'] = $imagePath; // Dự phòng trường tên cột tiếng Việt
        }

        // 4. Lưu dữ liệu vào bảng MySQL
        Service::create($data);

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'mo_ta_chi_tiet' => 'nullable|string'
        ]);

        $data = [
            'name' => $request->name,
            'ten_dich_vu' => $request->name,
            
            'type' => $request->type,
            'loai_dich_vu' => $request->type,
            
            'price' => $request->price,
            'gia_tien' => $request->price,
            
            'mo_ta' => $request->mo_ta_chi_tiet,
            'mo_ta_chi_tiet' => $request->mo_ta_chi_tiet,
        ];

        // Xử lý thay thế ảnh cũ nếu có upload ảnh mới
        if ($request->hasFile('image')) {
            // Xóa file ảnh vật lý cũ trong thư mục Storage để tránh nặng bộ nhớ máy
            if (!empty($service->image) && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            if (!empty($service->hinh_anh) && Storage::disk('public')->exists($service->hinh_anh)) {
                Storage::disk('public')->delete($service->hinh_anh);
            }

            $imagePath = $request->file('image')->store('services', 'public');
            $data['image'] = $imagePath;
            $data['hinh_anh'] = $imagePath;
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công!');
    }

    /**
     * Xóa dịch vụ
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        
        // Xóa ảnh cũ trước khi xóa hàng trong database
        if (!empty($service->image) && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }
        if (!empty($service->hinh_anh) && Storage::disk('public')->exists($service->hinh_anh)) {
            Storage::disk('public')->delete($service->hinh_anh);
        }
        
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Đã xóa dịch vụ thành công!');
    }
}