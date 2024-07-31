<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ordersdetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::count();
        $categories = Category::count();
        $totalPrice = Order::where('status', 'Paid')->sum('total_price');
        $OrderPaid = Order::where('status', 'Paid')->count();
        $OrderUnpaid = Order::where('status', 'Unpaid')->count();
        $orderTotal = Order::count();
        $productCategories = Category::withCount('products')->get();
        $categoryNames = $productCategories->pluck('name');
        $categoryProductCounts = $productCategories->pluck('products_count');

        $ordersByMonth = Order::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as total_price'))
            ->where('status', 'Paid')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Mengambil produk yang sudah terjual
        $soldProducts = Ordersdetail::select('product_id', DB::raw('SUM(qty) as total_sold'))
            ->whereHas('order', function ($query) {
                $query->where('status', 'Paid');
            })
            ->groupBy('product_id')
            ->with('product')
            ->get();


        return view('admin.page.dashboard', compact(
            'products',
            'categories',
            'totalPrice',
            'categoryNames',
            'categoryProductCounts',
            'OrderPaid',
            'OrderUnpaid',
            'orderTotal',
            'soldProducts',
            'ordersByMonth',
        ));
    }
}
