<?php

// Đây là địa chỉ nhà của file này: Nó nằm trong thư mục app/Http/Controllers/Admin
namespace App\Http\Controllers\Admin;

// Khai báo các công cụ sẽ dùng 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Combo;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ComboManageController extends Controller
{
    /**
     * Ý NGHĨA HÀM: "index" nghĩa là trang danh sách chính. 
     * Vào Database lấy tất cả Combo mới nhất, rồi đổ dữ liệu vào giao diện hiển thị lên màn hình Admin.
     */
    public function index()
    {
        $combos = Combo::latest()->get();
        return view('admin.combos.index', compact('combos'));
    }

    /**
     * Ý NGHĨA HÀM: "create" nghĩa là tạo mới. 
     */
    public function create()
    {
        // Lấy tất cả dịch vụ riêng lẻ trong máy ra để Admin tích chọn dịch vụ đi kèm cho Tour
        $services = Service::all();
        return view('admin.combos.create', compact('services'));
    }

    /**
     * Ý NGHĨA HÀM: "store" nghĩa là lưu trữ. 
     * Xử lý khi Admin thêm combo mới ở màn hình tạo mới và bấm nút "LƯU" để cất vào Database.
     */
    public function store(Request $request)
    {
        // 3.1 VÒNG BẢO VỆ: Kiểm tra xem Admin có điền thiếu gì không
        $request->validate([
            'ten_combo'    => 'required|string|max:255',
            'mo_ta'        => 'required',
            'services'     => 'required|array', 
            'hinh_anh'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
            'hinh_anh_url' => 'nullable|url'
        ]);

        // 3.2 XỬ LÝ ẢNH: Máy kiểm tra Admin tải file ảnh lên hay dán link ảnh từ mạng vào
        $hinh_anh_path = null;
        if ($request->hasFile('hinh_anh')) {
            $hinh_anh_path = $request->file('hinh_anh')->store('combos', 'public');
        } elseif ($request->filled('hinh_anh_url')) {
            $hinh_anh_path = $request->hinh_anh_url;
        }

        // 3.3 TÍNH TIỀN TỰ ĐỘNG: Duyệt qua từng dịch vụ Admin đã chọn để lấy giá tiền rồi cộng dồn lại
        $totalPrice = 0;
        if ($request->has('services')) {
            foreach ($request->services as $serviceId) {
                $service = Service::find($serviceId);
                if ($service) {
                    $totalPrice += $service->price ?? ($service->gia_tien ?? 0);
                }
            }
        }

        // 3.4 Lấy nội dung mô tả Admin nhập từ Form để chuẩn bị lưu vào Database
        $moTaGoc = $request->mo_ta;

        // Gom tất cả thông tin lại thành một gói dữ liệu sạch sẽ
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

        // 3.5 BỘ LỌC CHỐNG LỖI: Quét dọn các trường thừa không khớp cột Database thực tế
        $safeInsertData = array_filter($insertData, function ($key) {
            return Schema::hasColumn('combos', $key);
        }, ARRAY_FILTER_USE_KEY);

        // 3.6 CHẾ ĐỘ LƯU AN TOÀN: "Được ăn cả, ngã về không"
        DB::beginTransaction();
        try {
            // Bước A: Lưu thông tin cơ bản của Tour
            $combo = Combo::create($safeInsertData);
            
            // Bước B: Lưu các dịch vụ đi kèm của Tour đó vào bảng liên kết trung gian
            $combo->services()->attach($request->services);
            
            DB::commit();
            return redirect()->route('admin.combos.index')->with('success', 'Tạo combo thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Ý NGHĨA HÀM: "edit" nghĩa là chỉnh sửa. 
     */
    public function edit($id)
    {
        // Tìm cái Tour cần sửa theo ID, nạp sẵn các dịch vụ đi kèm cũ để hiển thị
        $combo = Combo::with('services')->findOrFail($id);
        $services = Service::all();
        
        return view('admin.combos.edit', compact('combo', 'services'));
    }

    /**
     * Ý NGHĨA HÀM: "update" nghĩa là cập nhật. 
     * Hàm này chạy khi Admin sửa xong xuôi ở giao diện và bấm nút "CẬP NHẬT CHỈNH SỬA".
     */
    public function update(Request $request, $id)
    {
        $combo = Combo::findOrFail($id);

        // Kiểm tra xem dữ liệu sửa có hợp lệ không
        $request->validate([
            'ten_combo'    => 'required|string|max:255',
            'mo_ta'        => 'required',
            'services'     => 'required|array',
            'hinh_anh'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'hinh_anh_url' => 'nullable|url'
        ]);

        // Tính toán lại tổng tiền mới
        $totalPrice = 0;
        if ($request->has('services')) {
            foreach ($request->services as $serviceId) {
                $service = Service::find($serviceId);
                if ($service) {
                    $totalPrice += $service->price ?? ($service->gia_tien ?? 0);
                }
            }
        }

        // ĐÃ SỬA: Bỏ hẳn đoạn lọc chữ cũ. Gán bằng nội dung mô tả Admin vừa sửa.
        $moTaGoc = $request->mo_ta;

        $updateData = [
            'name'         => $request->ten_combo,
            'ten_combo'    => $request->ten_combo,
            'description'  => $moTaGoc,
            'mo_ta'        => $moTaGoc,
            'price'        => $totalPrice,
            'gia_tien'     => $totalPrice,
        ];

        // Xử lý nạp file ảnh mới nếu có thay đổi
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

        // Lọc sạch trường thừa để bảo vệ database không bị ghi lỗi
        $safeUpdateData = array_filter($updateData, function ($key) {
            return Schema::hasColumn('combos', $key);
        }, ARRAY_FILTER_USE_KEY);

        DB::beginTransaction();
        try {
            $oldImage = $combo->image ?? $combo->hinh_anh;

            // Đè thông tin mới vừa sửa vào máy tính
            $combo->update($safeUpdateData);
            
            // Tự động cập nhật danh sách dịch vụ đi kèm ở bảng trung gian
            $combo->services()->sync($request->services);

            // THUẬT TOÁN TỰ ĐỘNG DỌN RÁC Ổ CỨNG:
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

    /**
     * Ý NGHĨA HÀM: "destroy" nghĩa là tiêu hủy/xóa sổ. 
     */
    public function destroy($id)
    {
        $combo = Combo::findOrFail($id);
        
        // Gỡ liên kết ở bảng trung gian trước để tránh lỗi hệ thống khóa ngoại của MySQL
        $combo->services()->detach();
        
        // Tiến hành xóa sổ hoàn toàn gói Tour Combo du lịch này
        $combo->delete();
        
        return redirect()->route('admin.combos.index')->with('success', 'Đã xóa!');
    }
}