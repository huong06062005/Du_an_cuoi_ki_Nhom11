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

        $totalPrice = 0;
        if ($request->has('services')) {
            foreach ($request->services as $serviceId) {
                $service = Service::find($serviceId);
                if ($service) {
                    $totalPrice += $service->price ?? ($service->gia_tien ?? 0);
                }
            }
        }

        // MẸO THÔNG MINH: Gài từ khóa ẩn vào mô tả nếu Admin tích chọn phổ biến
        $moTaGoc = str_replace('[POPULAR]', '', $request->mo_ta);
        if ($request->has('is_featured')) {
            $moTaGoc = trim($moTaGoc) . ' [POPULAR]';
        }

        $insertData = [
            'name'         => $request->ten_combo,
            'ten_combo'    => $request->ten_combo,
            'description'  => $moTaGoc,
            'mo_ta'        => $moTaGoc,
            'price'        => $totalPrice,
            'gia_tien'     => $totalPrice,
            'status'       => 1,
            'trang_thai'   => 1,
        ];

        if ($hinh_anh_path) {
            $insertData['image']    = $hinh_anh_path;
            $insertData['hinh_anh'] = $hinh_anh_path;
        }

        $safeInsertData = array_filter($insertData, function ($key) {
            return Schema::hasColumn('combos', $key);
        }, ARRAY_FILTER_USE_KEY);

        DB::beginTransaction();
        try {
            $combo = Combo::create($safeInsertData);
            $combo->services()->attach($request->services);
            DB::commit();
            
            // Đồng bộ duy nhất một flash session success
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

        $totalPrice = 0;
        if ($request->has('services')) {
            foreach ($request->services as $serviceId) {
                $service = Service::find($serviceId);
                if ($service) {
                    $totalPrice += $service->price ?? ($service->gia_tien ?? 0);
                }
            }
        }

        // MẸO THÔNG MINH KHI UPDATE: Nếu tích chọn thì gài thêm chữ [POPULAR], nếu bỏ tích thì xóa sạch chữ đó đi
        $moTaGoc = str_replace('[POPULAR]', '', $request->mo_ta);
        if ($request->has('is_featured')) {
            $moTaGoc = trim($moTaGoc) . ' [POPULAR]';
        }

        $updateData = [
            'name'         => $request->ten_combo,
            'ten_combo'    => $request->ten_combo,
            'description'  => $moTaGoc,
            'mo_ta'        => $moTaGoc,
            'price'        => $totalPrice,
            'gia_tien'     => $totalPrice,
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