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
        // 1. Validation nghiêm ngặt dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:flight,hotel,attraction,transport', // Bắt buộc chọn đúng phân loại
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Tối đa 2MB
            'mo_ta_chi_tiet' => 'nullable|string'
        ]);

        // 2. Gom dữ liệu cơ bản
        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'mo_ta' => $request->mo_ta_chi_tiet, // Lưu thông tin bổ sung (Hãng bay, Số sao khách sạn...)
        ];

        // 3. Xử lý upload hình ảnh dịch vụ nếu có
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        // 4. Lưu dữ liệu vào bảng MySQL
        Service::create($data);

        // Chú ý sửa route thành admin.services.index cho đúng cấu trúc
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
            'type' => $request->type,
            'price' => $request->price,
            'mo_ta' => $request->mo_ta_chi_tiet,
        ];

        // Xử lý thay thế ảnh cũ nếu có upload ảnh mới
        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
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
        
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Đã xóa dịch vụ thành công!');
    }
}