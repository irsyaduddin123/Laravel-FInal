<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Post;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $orders = Order::where('user_id', $userId)->with('order_detail')->latest()->get();
        $carts =  Cart::where('user_id', $userId)->with('product')->get();
        $posts = Post::where('user_id', $userId)->latest()->get();
        $addresses = Address::where('user_id', $userId)->latest()->get();
        return view('home', compact('orders', 'carts', 'posts', 'addresses'));
    }

    public function uploadImage(Request $request)
    {
        // Validasi input
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Dapatkan user yang sedang login
        $user = Auth::user();

        // Cek apakah user sudah memiliki gambar sebelumnya
        if ($user->image) {
            // Hapus gambar lama jika ada
            $oldImagePath = 'uploads/users/' . $user->image;
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        // Simpan gambar baru
        $imageName = 'users' . time() . '.' . $request->image->extension();
        $request->image->move('uploads/users', $imageName);

        // Update kolom image di tabel users
        $user->image = $imageName;
        $user->save();

        return back()->with('status', 'Image uploaded successfully.');
    }

    public function changePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Dapatkan user yang sedang login
        $user = Auth::user();

        // Periksa apakah current_password sesuai dengan password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password does not match our records.'],
            ]);
        }

        // Update password user
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('status', 'Password changed successfully.');
    }

    // public function product()
    // {
    //     return view('frontend.product');
    // }
}
