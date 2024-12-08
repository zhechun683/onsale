<?php
namespace App\Http\Controllers;
// app/Http/Controllers/ShopController.php

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    // 显示商铺注册页面
    public function showRegistrationForm()
    {
        // 如果用户已经拥有商铺，重定向到商铺管理页面
        if (Auth::user()->shop) {
            return redirect()->route('shop.dashboard');
        }

        return view('shop.register');
    }

    // 处理商铺注册
    public function register(Request $request)
    {
        // 验证商铺输入数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'contact_phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 处理商铺logo的上传（如果有）
        $logoPath = null;
        if ($request->hasFile('logo')) {
            // 输出上传的文件信息
            // dd($request->file('logo')->getClientOriginalName(), $request->file('logo')->getSize());
            
            $logoPath = $request->file('logo')->store('shop_logos', 'public');
        }
        

        // 创建商铺并与当前用户关联
        Shop::create([
            'name' => $request->name,
            'description' => $request->description,
            'contact_phone' => $request->contact_phone,
            'logo' => $logoPath,
            'user_id' => Auth::id(),  // 关联当前登录的用户
        ]);
        
        return redirect()->route('shop.dashboard')->with('success', 'Shop registration successful!');
    }
    public function dashboard()
    {
        $shop = Auth::user()->shop;  // Assuming the shop is associated with the logged-in user
        if (!$shop) {
            // If no shop is associated with the user, redirect to an error page or show a message
            return redirect()->route('shop.create')->with('error', 'You need to create a shop first.');
        }
        // Return the shop dashboard view with the shop data
        return view('shop.dashboard', compact('shop'));
    }
    public function edit()
    {
        $shop = Auth::user()->shop;
        // dd('stop?');
        return view('shop.edit', compact('shop'));
    }

    // Update the shop information
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $shop = Auth::user()->shop;
        $shop->name = $request->name;
        $shop->description = $request->description;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $shop->logo = $logoPath;
        }

        $shop->save();

        return redirect()->route('shop.dashboard')->with('success', 'Shop details updated successfully!');
    }
    public function destroy(Shop $shop)
    {

        $shop->delete();

        return redirect()->route('admin.shops.index')->with('success', 'Store deleted');
    }
    public function index()
    {
        // 获取所有商铺
        $shops = Shop::all();

        // 将商铺数据传递给视图
        return view('dashboard', compact('shops'));
    }
    public function show(Shop $shop)
    {
        $shop = Shop::with('products')->findOrFail($shop->id);
        return view('shop.show', compact('shop'));
    }
}
