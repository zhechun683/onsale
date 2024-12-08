<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Shop;

// use App\Models\CartItem;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    /**
     * 显示用户的订单
     */
    public function index()
    {
        // 获取当前登录的用户
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', '请先登录');
        }

        // 获取用户的所有订单
        $orders = Order::where('user_id', $user->id)->get();

        return view('orders.index', compact('orders'));
    }
    public function store(Request $request)
    {
        // $cartItems = Cart::getItems();
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        $shopId = $cartItems[0]->product->shop_id;

        // Validate basic information from the user
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        // Create the order
        $order = Order::create([
            'user_id' => $user->id,
            'shop_id' => $shopId,
            'order_number' => "ORD-{$user->id}-{$shopId}-{now()->timestamp}",
            'total_price' => $this->calculateTotalPrice($cartItems),
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            // Reduce inventory in product
            $product = Product::find($item->product_id);
            $product->decrement('stock', $item->quantity);
        };

        // Clear the cart after checkout
        $user->cartItems()->delete();

        return redirect()->route('orders.show', $order->id);
    }
    

    public function shopindex()
    {
        // dd(Auth::user()->shop_id);
        
        $user = Auth::user();
        // dd($user);
        // 检查用户是否是商铺的拥有者
        if (!$user->shop->id) {

            // dd($user->shop->id,$shop->id);

            return redirect()->route('dashboard')->with('error', 'You are not the owner of the shop');
        }

        // 获取商铺的所有订单
        $orders = Order::where('shop_id', $user->shop->id)->get();
        // dd($user->shop_id);
        // dd($orders);
         // 打印所有订单

        return view('orders.shop', compact('orders'));
    }

    public function show($id)
    {
        // dd($id);
        // $user = Auth::user();

        $order = Order::where('id', $id)->get()->first();

        return view('orders.show', compact('order'));
    }
    public function checkout()
    {
        $user = Auth::user();
        
        // 获取用户的购物车商品
        $cartItems = $user->cartItems()->with('product')->get();
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            
            if ($product->stock < $item->quantity) {
                // If stock is insufficient, return with an error
                return redirect()->back()->with('error', "Insufficient stock for {$product->name}. Available stock: {$product->stock}");
            }
        }
        return view('orders.checkout', compact('cartItems'));
    }
    public function complete($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'pending' || $order->status !== 'hcompleted') {
            return redirect()->route('orders.show', $order->id)->with('error', 'This order cannot be completed.');
        }

        // Mark the order as completed
        if ($order->status === 'pending'){
            $order->update(['status' => 'hcompleted']);
        }
        if ($order->status === 'hcompleted'){
            $order->update(['status' => 'completed']);
        }
        

        // Notify the store owner
        // (This could be implemented via notifications or emails)
        return redirect()->route('orders.show', $order->id)->with('success', 'Order completed successfully!');
    }

    private function calculateTotalPrice($cartItems)
    {
        return collect($cartItems)->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}