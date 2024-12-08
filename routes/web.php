<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Str;
// use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// /home/ubuntu/onsale/routes/web.php

Route::get('/', function () {
    return view('welcome');
});
 


Route::get('/dashboard', function () {
    // dd('here??');
    // dd('guest creation point reached'); // This will halt execution and show where it gets stuck

    return app(ShopController::class)->index();
})->name('dashboard');
// Route::get('/dashboard', [ShopController::class, 'index'])->name('dashboard');
Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/shop/register', [ShopController::class, 'showRegistrationForm'])->name('shop.register');
Route::post('/shop/register', [ShopController::class, 'register'])->name('shop.register.submit');
Route::get('/shop/dashboard', [ShopController::class, 'dashboard'])->name('shop.dashboard');
Route::get('/shop/edit', [ShopController::class, 'edit'])->name('shop.edit');
Route::post('/shop/update', [ShopController::class, 'update'])->name('shop.update');
Route::get('/shop/{shop}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/orders/shop', [OrderController::class, 'shopindex'])->name('orders.shop');
Route::get('/orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
Route::post('/orders/checkout', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');



Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

// routes/web.php



Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'viewUsers'])->name('admin.users');
    Route::get('/admin/shops', [AdminController::class, 'viewShops'])->name('admin.shops');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::delete('/admin/shops/{shop}', [AdminController::class, 'deleteShop'])->name('admin.deleteShop');
});


Route::middleware(['auth'])->group(function () {
    // User profile/dashboard route
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    
    // Route for editing user profile
    Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');

    // Shop-related routes (assuming you already have these)
    Route::get('/user/shops', [ShopController::class, 'index'])->name('user.shops');
    
    // Orders route (assuming you have an orders system in place)
});
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');


Route::middleware(['auth'])->group(function () {
    // Browsing products (viewing a shop's products)
    Route::get('/shop/{shop}/products', [ProductController::class, 'index'])->name('shop.products.index');

    // Upload a new product
    Route::get('/shop/{shop}/products/create', [ProductController::class, 'create'])->name('shop.products.create');
    Route::post('/shop/{shop}/products', [ProductController::class, 'store'])->name('shop.products.store');

    // Edit an existing product
    Route::get('/shop/{shop}/products/{product}/edit', [ProductController::class, 'edit'])->name('shop.products.edit');
    Route::post('/shop/{shop}/products/{product}', [ProductController::class, 'update'])->name('shop.products.update');

    // Delete a product
    Route::delete('/shop/{shop}/products/{product}', [ProductController::class, 'destroy'])->name('shop.products.destroy');
});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/logout', [Auth::class, 'logout'])->name('logout');

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

require __DIR__.'/auth.php';
