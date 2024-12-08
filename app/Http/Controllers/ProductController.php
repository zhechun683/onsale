<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // List products for a specific shop
    public function index(Shop $shop)
    {
        // Ensure the user is the owner of the shop
        if ($shop->user_id != Auth::id()) {
            return redirect()->route('shop.dashboard')->with('error', 'You are not authorized to view this shop.');
        }

        $products = $shop->products; // Assuming a 'hasMany' relationship in the Shop model
        return view('shop.products.index', compact('shop', 'products'));
    }

    // Show form to upload a new product
    public function create(Shop $shop)
    {
        // Ensure the user is the owner of the shop
        if ($shop->user_id != Auth::id()) {
            return redirect()->route('shop.dashboard')->with('error', 'You are not authorized to add products to this shop.');
        }

        return view('shop.products.create', compact('shop'));
    }

    // Store a newly created product
    public function store(Request $request, Shop $shop)
    {
        // Validate the product details
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',  // 确保验证 stock 字段
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create the new product
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;  // 显式提供 stock 字段的值
        $product->shop_id = $shop->id;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('shop.products.index', $shop)->with('success', 'Product added successfully!');
    }

    // Show form to edit an existing product
    public function edit(Shop $shop, Product $product)
    {
        // Ensure the user is the owner of the shop
        if ($shop->user_id != Auth::id()) {
            return redirect()->route('shop.dashboard')->with('error', 'You are not authorized to edit this product.');
        }

        return view('shop.products.edit', compact('shop', 'product'));
    }

    // Update the product
    public function update(Request $request, Shop $shop, Product $product)
    {
        // Validate the updated product details
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the product details
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('shop.products.index', $shop)->with('success', 'Product updated successfully!');
    }

    // Delete a product
    public function destroy(Shop $shop, Product $product)
    {
        // Ensure the user is the owner of the shop
        if ($shop->user_id != Auth::id()) {
            return redirect()->route('shop.dashboard')->with('error', 'You are not authorized to delete this product.');
        }

        // Delete the product
        $product->delete();

        return redirect()->route('shop.products.index', $shop)->with('success', 'Product deleted successfully!');
    }
    public function show($id)
    {
        $product = Product::findOrFail($id); // 获取商品详情

        return view('product.show', compact('product'));
    }
}
