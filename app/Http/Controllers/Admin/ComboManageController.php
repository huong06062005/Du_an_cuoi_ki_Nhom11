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

        $priceColumn = 'price';
        if (Schema::hasColumn('services', 'price')) $priceColumn = 'price';
        elseif (Schema::hasColumn('services', 'gia_tien')) $priceColumn = 'gia_tien';
        elseif (Schema::hasColumn('services', 'gia_nhap')) $priceColumn = 'gia_nhap';
        elseif (Schema::hasColumn('services', 'gia_goc')) $priceColumn = 'gia_goc';

        $totalPrice = Service::whereIn('id', $request->services)->sum($priceColumn);

        // ĐÃ CẬP NHẬT: Nhận giá trị trạng thái từ checkbox "is_featured" gửi lên
        $isFeaturedValue = $request->has('is_featured') ? 1 : 0;

        $insertData = [
            'name'         => $request->ten_combo,
            'ten_combo'    => $request->ten_combo,
            'description'  => $request->mo_ta,
            'mo_ta'        => $request->mo_ta,
            'image'        => $hinh_anh_path,
            'hinh_anh'     => $hinh_anh_path,
            'price'        => $totalPrice,
            'gia_tien'     => $totalPrice,
            'status'       => 1,
            'trang_thai'   => 1,
            'is_featured'  => $isFeaturedValue,
            'noi_bat'      => $isFeaturedValue,
        ];

        $safeInsertData = array_filter($insertData, function ($key) {
            return Schema::hasColumn('combos', $key);
        }, ARRAY_FILTER_USE_KEY);

        DB::beginTransaction();
        try {
            $combo = Combo::create($safeInsertData);
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

        $priceColumn = 'price';
        if (Schema::hasColumn('services', 'price')) $priceColumn = 'price';
        elseif (Schema::hasColumn('services', 'gia_tien')) $priceColumn = 'gia_tien';
        elseif (Schema::hasColumn('services', 'gia_nhap')) $priceColumn = 'gia_nhap';
        elseif (Schema::hasColumn('services', 'gia_goc')) $priceColumn = 'gia_goc';

        $totalPrice = Service::whereIn('id', $request->services)->sum($priceColumn);

        // ĐÃ CẬP NHẬT: Cập nhật trạng thái phổ biến khi Admin chỉnh sửa tích/bỏ tích
        $isFeaturedValue = $request->has('is_featured') ? 1 : 0;

        $updateData = [
            'name'         => $request->ten_combo,
            'ten_combo'    => $request->ten_combo,
            'description'  => $request->mo_ta,
            'mo_ta'        => $request->mo_ta,
            'price'        => $totalPrice,
            'gia_tien'     => $totalPrice,
            'is_featured'  => $isFeaturedValue,
            'noi_bat'      => $isFeaturedValue,
        ];

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

        $safeUpdateData = array_filter($updateData, function ($key) {
            return Schema::hasColumn('combos', $key);
        }, ARRAY_FILTER_USE_KEY);

        DB::beginTransaction();
        try {
            $oldImage = $combo->image ?? $combo->hinh_anh;

            $combo->update($safeUpdateData);
            $combo->services()->sync($request->services);

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