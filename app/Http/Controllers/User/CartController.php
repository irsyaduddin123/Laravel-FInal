<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function redeemCheck()
    {
    }
    public function addToCart(Request $request, $product_id)
    {
        $user_id = Auth::id();
        $product_qty = $request->jumlah;

        $productCheck = Product::where('id', $product_id)->first();
        if ($productCheck) {
            $cartItem = Cart::where('product_id', $product_id)->where('user_id', $user_id)->first();
            if ($cartItem) {
                // Check if the new quantity exceeds the stock
                if (($cartItem->product_qty + $product_qty) > $productCheck->stok) {
                    return redirect()->back()->with('error', [
                        'title' => 'Stok Tidak Cukup',
                        'text' => 'Quantity exceeds available stock',
                        'icon' => 'error',
                    ]);
                }

                // Produk sudah ada di keranjang, tambahkan kuantitas
                $cartItem->product_qty += $product_qty;
                $cartItem->save();

                return redirect()->back()->with('message', [
                    'title' => 'Produk Berhasil Di Perbarui',
                    'text' => $productCheck->name . ' Quantity Updated in Cart',
                    'icon' => 'warning',
                ]);
            } else {
                // Check if the requested quantity exceeds the stock
                if ($product_qty > $productCheck->stok) {
                    return redirect()->back()->with('message', [
                        'title' => 'Stok Tidak Cukup',
                        'text' => 'Quantity exceeds available stock',
                        'icon' => 'error',
                    ]);
                }

                // Produk belum ada di keranjang, tambahkan item baru
                $cartItem = new Cart;
                $cartItem->user_id = $user_id;
                $cartItem->product_id = $product_id;
                $cartItem->product_qty = $product_qty;
                $cartItem->save();

                return redirect()->back()->with('message', [
                    'title' => 'Produk Berhasil Di Tambah',
                    'text' => $productCheck->name . ' Successfully Added to Cart',
                    'icon' => 'success',
                ]);
            }
        }

        return redirect()->back();
    }

    public function getTotalCartItems()
    {
        $userId = auth()->id(); // Mengambil userID yang sedang login
        $totalItems = Cart::where('user_id', $userId)->get();
        $totalItemsCart = $totalItems->count();
        return response()->json(['carts' => $totalItemsCart], 200);
    }

    public function cartUpdate(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $product = Product::findOrFail($cart->product_id);

        // Periksa tindakan yang dilakukan (tambah atau kurang)
        if ($request->action === 'increment') {
            if (($cart->product_qty + 1) > $product->stok) {
                return redirect()->back()->with('error', 'Quantity exceeds available stock');
            }
            $cart->product_qty += 1; // Tambah satu
        } elseif ($request->action === 'decrement') {
            if ($cart->product_qty > 1) {
                $cart->product_qty -= 1; // Kurangi satu jika lebih dari satu
            }
        }

        $cart->save();

        // Redirect ke halaman keranjang belanja atau halaman lain yang sesuai
        return redirect()->back()->with('message', 'Cart item updated successfully');
    }

    public function cartDelete($id)
    {
        $cart = Cart::findOrFail($id);

        $cart->delete();

        return redirect()->back()->with('message', 'Cart item Deleted successfully');
    }
}
