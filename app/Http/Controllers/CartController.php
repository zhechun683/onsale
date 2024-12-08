<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // 查看购物车
    public function viewCart()
    {
        $user = Auth::user();
        
        // 获取用户的购物车商品
        $cartItems = $user->cartItems()->with('product')->get();

        return view('cart.index', compact('cartItems'));
    }

    // 添加商品到购物车
    public function add(Product $product)
    {
        // 获取当前登录的用户
        $user = Auth::user();

        // 如果用户未登录，重定向到登录页面
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please Log in first');
        }

        // 检查购物车中是否已有此商品
        $existingCartItem = CartItem::where('user_id', $user->id)
                                     ->where('product_id', $product->id)
                                     ->first();

        if ($existingCartItem) {
            // 如果商品已经在购物车中，更新数量
            $existingCartItem->quantity += 1;
            $existingCartItem->save();
        } else {
            // 如果商品不在购物车中，创建新的购物车项
            CartItem::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        // 返回到购物车页面或商铺页面
        return redirect()->route('cart')->with('success', 'Product successfully added to cart');
    }

    // 更新购物车中的商品数量
    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Auth::user()->cartItems()->findOrFail($request->cart_item_id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index');
    }

    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please Log in first');
        }

        // 获取用户的购物车项
        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        return view('cart.index', compact('cartItems'));
    }
    public function remove($cartItemId)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please Log in first');
        }

        // 删除购物车项
        $cartItem = CartItem::where('user_id', $user->id)->findOrFail($cartItemId);
        $cartItem->delete();

        return redirect()->route('cart')->with('success', 'Item has been removed from shopping cart');
    }

}
