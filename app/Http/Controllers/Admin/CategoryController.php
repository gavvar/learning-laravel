<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Kiểm tra xem người dùng đã đăng nhập chưa
        $this->middleware('admin'); // Kiểm tra xem người dùng có quyền admin không
    }

    // Hiển thị danh sách danh mục
    public function index()
    {
        $categories = Category::all(); // Lấy tất cả danh mục
        return view('categories.index', compact('categories')); // Trả về view danh sách danh mục
    }

    // Hiển thị form tạo danh mục mới
    public function create()
    {
        return view('categories.create'); // Trả về view tạo danh mục
    }

    // Lưu danh mục mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([ // Xác thực dữ liệu đầu vào
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all()); // Tạo danh mục mới

        return redirect()->route('categories.index')->with('success', 'Category created successfully.'); // Chuyển hướng về danh sách danh mục
    }

    // Hiển thị chi tiết danh mục
    public function show(Category $category)
    {
        return view('categories.show', compact('category')); // Trả về view chi tiết danh mục
    }

    // Hiển thị form chỉnh sửa danh mục
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category')); // Trả về view chỉnh sửa danh mục
    }

    // Cập nhật thông tin danh mục
    public function update(Request $request, Category $category)
    {
        $request->validate([ // Xác thực dữ liệu đầu vào
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all()); // Cập nhật danh mục

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.'); // Chuyển hướng về danh sách danh mục
    }

    // Xóa danh mục
    public function destroy(Category $category)
    {
        $category->delete(); // Xóa danh mục

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.'); // Chuyển hướng về danh sách danh mục
    }
}