<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Combo;   // Model Combo
use App\Models\Service; // Model Service
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
        // Lấy tất cả dịch vụ thành phần để admin chọn
        $services = Service::all(); 
        return view('admin.combos.create', compact('services'));
    }

    /**
     * Lưu combo mới vào cơ sở dữ liệu
     */
    public function store(Request $request)
    {
        // 1. Validation dữ liệu đầu vào chuẩn hóa tiếng Anh
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'services' => 'required|array' 
        ]);

        // 2. Xử lý upload hình ảnh combo du lịch
        $image_path = null;
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('combos', 'public');
        }

        // 3. Logic tính giá combo tự động: Cộng dồn cột 'price' của các dịch vụ được chọn
        $totalPrice = Service::whereIn('id', $request->services)->sum('price');

        // 4. Lưu dữ liệu combo mới vào bảng combos
        $combo = Combo::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image_path,
            'total_price' => $totalPrice, // Lưu tổng giá tự động tính được
        ]);

        // 5. Thêm mối quan hệ vào bảng trung gian combo_service
        $combo->services()->attach($request->services);

        return redirect()->route('admin.combos.index')->with('success', 'Tạo combo du lịch thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa gói combo
     */
    public function edit($id)
    {
        $combo = Combo::with('services')->findOrFail($id);
        $services = Service::all();
        return view('admin.combos.edit', compact('combo', 'services'));
    }

    /**
     * Cập nhật thông tin combo
     */
    public function update(Request $request, $id)
    {
        $combo = Combo::findOrFail($id);

        // 1. Validation dữ liệu khi cập nhật
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'services' => 'required|array'
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        // 2. Nếu có upload ảnh mới thì xóa ảnh cũ và cập nhật đường dẫn ảnh mới
        if ($request->hasFile('image')) {
            if ($combo->image) {
                Storage::disk('public')->delete($combo->image);
            }
            $data['image'] = $request->file('image')->store('combos', 'public');
        }

        // 3. Tính toán lại tổng tiền combo dựa trên các dịch vụ mới được tích chọn
        $totalPrice = Service::whereIn('id', $request->services)->sum('price');
        $data['total_price'] = $totalPrice;

        // 4. Cập nhật bảng combos và đồng bộ (sync) lại bảng trung gian
        $combo->update($data);
        $combo->services()->sync($request->services);

        return redirect()->route('admin.combos.index')->with('success', 'Cập nhật combo thành công!');
    }

    /**
     * Xóa hoàn toàn combo du lịch
     */
    public function destroy($id)
    {
        $combo = Combo::findOrFail($id);
        
        // Xóa file ảnh lưu trong thư mục Storage nếu có
        if ($combo->image) {
            Storage::disk('public')->delete($combo->image);
        }

        // Xóa dữ liệu combo (bảng trung gian sẽ tự động xóa theo nhờ cấu hình onDelete('cascade'))
        $combo->delete();

        return redirect()->route('admin.combos.index')->with('success', 'Đã xóa combo thành công!');
    }
}