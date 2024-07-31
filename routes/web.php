<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\Admin\ReedemController;
use App\Http\Controllers\User\CommentsController;
use App\Http\Controllers\User\FrontendController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use GuzzleHttp\Middleware;

Auth::routes();
// Auth::routes(['register' => false]);

// Route::get('/register', function () {
//     return redirect('home');
// });

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/users/uploadImage', [HomeController::class, 'uploadImage'])->name('users.uploadImage');
Route::post('/users/changePassword', [HomeController::class, 'changePassword'])->name('users.changePassword');

Route::get('/', [FrontendController::class, 'home']);
Route::get('/product', [FrontendController::class, 'category']);
Route::get('/product/{category_slug}', [FrontendController::class, 'product']);
Route::get('/product/{category_slug}/{product_slug}', [FrontendController::class, 'detail_product']);
Route::get('/cart', [FrontendController::class, 'cart']);
Route::get('/contact', [FrontendController::class, 'contact']);
Route::get('/about', [FrontendController::class, 'about']);
// post
Route::resource('post', PostController::class);

Route::post('comment/{post_id}', [CommentsController::class, 'store']);
// addresses
Route::post('tambahAlamat', [AddressController::class, 'store'])->middleware('auth');
Route::get('address', [AddressController::class, 'index'])->middleware('auth');
Route::get('addresses/create', [AddressController::class, 'create'])->middleware('auth');
Route::get('addresses/{id}/edit', [AddressController::class, 'edit'])->middleware('auth');
Route::put('addresses/{id}', [AddressController::class, 'update'])->middleware('auth');
Route::post('addresses/delete', [AddressController::class, 'destroy'])->middleware('auth');
// cart
Route::get('/cartTotal', [CartController::class, 'getTotalCartItems']);
Route::post('/addtocart/{product_id}', [CartController::class, 'addToCart'])->middleware('auth');
Route::put('/cart/update/{id}', [CartController::class, 'cartUpdate'])->middleware('auth');
Route::get('/cart/delete/{id}', [CartController::class, 'cartDelete'])->middleware('auth');
Route::post('/redeemCheck', [CartController::class, 'redeemCheck'])->middleware('auth');

Route::post('/payment/callback', [OrderController::class, 'callback']);

Route::post('/checkout', [OrderController::class, 'checkout'])->middleware('auth');
Route::get('/checkout/{order_id}', [OrderController::class, 'orderDetail'])->middleware('auth');
Route::put('/paymentreedem/{order_id}', [OrderController::class, 'paymentreedem'])->middleware('auth');
Route::get('/paymentreedem/{order_id}', [OrderController::class, 'removerPayment'])->middleware('auth');
Route::post('/payment/{order_id}', [OrderController::class, 'payment'])->middleware('auth');
Route::get('payment/checkout/{order_code}', [OrderController::class, 'settlement'])->middleware('auth');

// Contact us
Route::post('/massage', [MessageController::class, 'store'])->name('massage.store');


Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    // Route::get('dashboard', function () {
    //     return view('admin.page.dashboard');
    // });
    Route::get('/dashboard', [DashboardController::class, 'index']);


    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/create', [CategoryController::class, 'create']);
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::get('categories/{id}/delete', [CategoryController::class, 'destroy']);
    Route::post('categories/create', [CategoryController::class, 'store']);
    Route::get('products', [ProductsController::class, 'index']);
    Route::get('products/create', [ProductsController::class, 'create']);
    Route::get('products/{id}/delete', [ProductsController::class, 'destroy']);
    Route::post('/products/create', [ProductsController::class, 'store'])->name('tambah.products');
    Route::get('products/{id}/edit', [ProductsController::class, 'edit']);
    Route::post('/products/img', [ProductsController::class, 'updateImg']);
    Route::post('/products/{id}', [ProductsController::class, 'update']);
    Route::get('/products/delimg/{id}/{id_produk}', [ProductsController::class, 'destroyImg']);

    // Redeem code
    Route::get('/reedem', [ReedemController::class, 'index'])->name('admin.reedem.index');
    Route::post('reedem/store', [ReedemController::class, 'store']);
    Route::put('/reedem/update/{id}', [ReedemController::class, 'update'])->name('reedem.update');
    Route::post('/reedem/destroy/{id}', [ReedemController::class, 'destroy'])->name('reedem.destroy');

    Route::get('/massage', [MessageController::class, 'index']);

    Route::get('/orders', [OrderController::class, 'ordersCart']);
});
