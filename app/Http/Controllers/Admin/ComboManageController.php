<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Combo;   // Model Combo
use App\Models\Service; // Đảm bảo đã chạy php artisan make:model Service
use Illuminate\Support\Facades\Storage;

class ComboManageController extends Controller
{
    /**
     * Hiển thị danh sách các gói combo du lịch
     */
    public function index()
    {
        $combos = Combo::latest()->get();
        return view('admin.combos.index', compact('combos'));
    }

    /**
     * Hiển thị form tạo mới combo
     */
    public function create()
    {
        $services = Service::all(); 
        return view('admin.combos.create', compact('services'));
    }

    /**
     * Lưu combo mới
     */
    public function store(Request $request)
    {
        // 1. Validation dữ liệu (Sửa tên field cho khớp với form của em)
        $request->validate([
            'ten_combo' => 'required|string|max:255',
            'mo_ta' => 'required',
            'hinh_anh' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'services' => 'required|array' 
        ]);

        // 2. Xử lý upload hình ảnh
        $hinh_anh_path = null;
        if ($request->hasFile('hinh_anh')) {
            $hinh_anh_path = $request->file('hinh_anh')->store('combos', 'public');
        }

        // 3. Logic tính giá combo tự động dựa trên giá của từng dịch vụ
        // Lưu ý: Cột giá trong bảng services của em phải là 'gia_tien' hoặc 'price' tùy em đặt
        $totalPrice = Service::whereIn('id', $request->services)->sum('gia_tien');

        // 4. Lưu vào Database (Sửa tên cột cho khớp với Migration)
        $combo = Combo::create([
            'ten_combo' => $request->ten_combo,
            'mo_ta' => $request->mo_ta,
            'hinh_anh' => $hinh_anh_path,
            'gia_tien' => $totalPrice,
        ]);

        // 5. Lưu vào bảng trung gian
        $combo->services()->attach($request->services);

        return redirect()->route('admin.combos.index')->with('success', 'Tạo combo du lịch thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa
     */
    public function edit($id)
    {
        $combo = Combo::with('services')->findOrFail($id);
        $services = Service::all();
        return view('admin.combos.edit', compact('combo', 'services'));
    }

    /**
     * Cập nhật combo
     */
    public function update(Request $request, $id)
    {
        $combo = Combo::findOrFail($id);

        $request->validate([
            'ten_combo' => 'required|string|max:255',
            'mo_ta' => 'required',
            'services' => 'required|array'
        ]);

        $data = [
            'ten_combo' => $request->ten_combo,
            'mo_ta' => $request->mo_ta,
        ];

        if ($request->hasFile('hinh_anh')) {
            if ($combo->hinh_anh) {
                Storage::disk('public')->delete($combo->hinh_anh);
            }
            $data['hinh_anh'] = $request->file('hinh_anh')->store('combos', 'public');
        }

        // Tính lại giá
        $totalPrice = Service::whereIn('id', $request->services)->sum('gia_tien');
        $data['gia_tien'] = $totalPrice;

        $combo->update($data);
        $combo->services()->sync($request->services);

        return redirect()->route('admin.combos.index')->with('success', 'Cập nhật combo thành công!');
    }

    /**
     * Xóa combo
     */
    public function destroy($id)
    {
        $combo = Combo::findOrFail($id);
        
        if ($combo->hinh_anh) {
            Storage::disk('public')->delete($combo->hinh_anh);
        }

        $combo->delete();

        return redirect()->route('admin.combos.index')->with('success', 'Đã xóa combo thành công!');
    }
}