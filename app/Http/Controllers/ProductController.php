<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
    $this->middleware('admin');
}

    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Thêm quy tắc xác thực cho trường price
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0|max:999999.99', // Thay đổi giới hạn giá trị ở đây
            'category_id' => 'required|exists:categories,id',
        ], [
            'price.max' => 'The price cannot exceed 999,999.99.',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0|max:999999.99', // Thay đổi giới hạn giá trị ở đây
            'category_id' => 'required|exists:categories,id',
        ], [
            'price.max' => 'The price cannot exceed 999,999.99.',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}