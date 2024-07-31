<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function home()
    {
        return view('frontend.geek');
    }
    public function category()
    {
        $categories = Category::all();
        $latestProducts = Product::latest()->take(8)->with('category')->get();
        return view('frontend.category', compact('categories', 'latestProducts'));
    }
    public function product($category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        $products = Product::where('category_id', $category->id)->get();
        return view('frontend.product', compact('products', 'category'));
    }

    public function detail_product($category_slug, $product_slug)
    {
        $products = Product::where('slug', $product_slug)->first();
        if (empty($products)) {
            return redirect('product');
        }
        return view('frontend.detailProduk', compact('products'));
    }

    public function cart()
    {
        $userId = Auth::id();
        $carts = Cart::where('user_id', $userId)->get();
        $address = Address::where('user_id', $userId)->get();
        return view('frontend.cart', compact('carts', 'address'));
    }
    public function contact()
    {
        return view('frontend.contact');
    }
    public function about()
    {
        return view('frontend.about');
    }
    public function post()
    {
        return view('frontend.post');
    }
}
