<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Combo;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ComboManageController extends Controller
{
    public function index()
    {
        $combos = Combo::latest()->get();
        return view('admin.combos.index', compact('combos'));
    }

    public function create()
    {
        $services = Service::all();
        return view('admin.combos.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_combo'    => 'required|string|max:255',
            'mo_ta'        => 'required',
            'services'     => 'required|array',
            'hinh_anh'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'hinh_anh_url' => 'nullable|url'
        ]);

        $hinh_anh_path = null;
        if ($request->hasFile('hinh_anh')) {
            $hinh_anh_path = $request->file('hinh_anh')->store('combos', 'public');
        } elseif ($request->filled('hinh_anh_url')) {
            $hinh_anh_path = $request->hinh_anh_url;
        }

        $priceColumn = Schema::hasColumn('services', 'price') ? 'price' : 'gia_tien';
        $totalPrice = Service::whereIn('id', $request->services)->sum($priceColumn);

        $insertData = [
            'name'        => $request->ten_combo,
            'ten_combo'   => $request->ten_combo,
            'description' => $request->mo_ta,
            'mo_ta'       => $request->mo_ta,
            'image'       => $hinh_anh_path,
            'hinh_anh'    => $hinh_anh_path,
            'price'       => $totalPrice,
            'gia_tien'    => $totalPrice,
            'status'      => 1,
            'trang_thai'  => 1,
        ];

        DB::beginTransaction();
        try {
            $combo = Combo::create($insertData);
            $combo->services()->attach($request->services);
            DB::commit();
            return redirect()->route('admin.combos.index')->with('success', 'Tạo combo thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $combo = Combo::with('services')->findOrFail($id);
        $services = Service::all();
        return view('admin.combos.edit', compact('combo', 'services'));
    }

    public function update(Request $request, $id)
    {
        $combo = Combo::findOrFail($id);

        $request->validate([
            'ten_combo'    => 'required|string|max:255',
            'mo_ta'        => 'required',
            'services'     => 'required|array',
            'hinh_anh'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'hinh_anh_url' => 'nullable|url'
        ]);

        $priceColumn = Schema::hasColumn('services', 'price') ? 'price' : 'gia_tien';
        $totalPrice = Service::whereIn('id', $request->services)->sum($priceColumn);

        // Mảng cập nhật: Luôn lấy giá trị cũ trước
        $updateData = [
            'name'        => $request->ten_combo,
            'ten_combo'   => $request->ten_combo,
            'description' => $request->mo_ta,
            'mo_ta'       => $request->mo_ta,
            'price'       => $totalPrice,
            'gia_tien'    => $totalPrice,
        ];

        // Xử lý ảnh: Chỉ thay đổi nếu có upload hoặc link mới
        $newImagePath = null;
        if ($request->hasFile('hinh_anh')) {
            $newImagePath = $request->file('hinh_anh')->store('combos', 'public');
        } elseif ($request->filled('hinh_anh_url')) {
            $newImagePath = $request->hinh_anh_url;
        }

        if ($newImagePath) {
            $updateData['image']    = $newImagePath;
            $updateData['hinh_anh'] = $newImagePath;
        }

        DB::beginTransaction();
        try {
            // Lưu ảnh cũ để xóa sau nếu cần
            $oldImage = $combo->image ?? $combo->hinh_anh;

            $combo->update($updateData);
            $combo->services()->sync($request->services);

            // Chỉ xóa ảnh cũ nếu có ảnh mới và ảnh cũ là file local (không phải link)
            if ($newImagePath && $oldImage && !filter_var($oldImage, FILTER_VALIDATE_URL)) {
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            DB::commit();
            return redirect()->route('admin.combos.index')->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $combo = Combo::findOrFail($id);
        $combo->services()->detach();
        $combo->delete();
        return redirect()->route('admin.combos.index')->with('success', 'Đã xóa!');
    }
}