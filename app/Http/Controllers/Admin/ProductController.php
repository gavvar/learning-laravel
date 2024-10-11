<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Kiểm tra xem người dùng đã đăng nhập chưa
        $this->middleware('admin'); // Kiểm tra xem người dùng có quyền admin không
    }

    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $products = Product::all(); // Lấy tất cả sản phẩm
        return view('admin.products.index', compact('products')); // Trả về view danh sách sản phẩm
    }

    // Hiển thị form tạo sản phẩm mới
    public function create()
    {
        $categories = Category::all(); // Lấy danh sách danh mục
        return view('admin.products.create', compact('categories')); // Trả về view tạo sản phẩm
    }

    // Lưu sản phẩm mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public'); // Lưu ảnh vào thư mục 'products'
        }

        // Tạo sản phẩm mới
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.'); // Chuyển hướng về danh sách sản phẩm
    }

    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::findOrFail($id); // Lấy sản phẩm theo ID
        return view('admin.products.show', compact('product')); // Trả về view chi tiết sản phẩm
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function edit(Product $product)
    {
        $categories = Category::all(); // Lấy danh sách danh mục
        return view('admin.products.edit', compact('product', 'categories')); // Trả về view chỉnh sửa sản phẩm
    }

    // Cập nhật thông tin sản phẩm
    public function update(Request $request, Product $product)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0|max:999999.99',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'price.max' => 'The price cannot exceed 999,999.99.',
        ]);

        $imagePath = $product->image; // Giữ lại đường dẫn hình ảnh hiện tại
        if ($request->hasFile('image')) {
            // Nếu có ảnh mới, xóa ảnh cũ nếu tồn tại
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public'); // Lưu ảnh mới
        }

        // Cập nhật thông tin sản phẩm
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.'); // Chuyển hướng về danh sách sản phẩm
    }

    // Xóa sản phẩm
    public function destroy(Product $product)
    {
        // Nếu sản phẩm có hình ảnh, xóa ảnh khỏi storage
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        $product->delete(); // Xóa sản phẩm khỏi cơ sở dữ liệu

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.'); // Chuyển hướng về danh sách sản phẩm
    }
}