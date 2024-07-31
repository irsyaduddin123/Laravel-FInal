<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.page.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        if (count($categories) <= 0) {
            return redirect('admin/products')->with('message', 'Tambahkan Category Terlebih Dahulu');
        }
        return view('admin.page.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'deskripsi' => 'required|string',
            'stok' => 'required|numeric',
            'price' => 'required|numeric',
            'min_stok' => 'required|numeric',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            'category_id' => 'required|numeric',
        ]);
        $dataImage = [];
        $imageOrder = explode(',', $request->input('image_order'));
        $files = $request->file('image');
        if(!$files) {
            return redirect()->back()->withInput()->with('error_message', [
                'type' => 'danger',
                'message' => "Image Don't Empty",
            ]);
        }
        $sortedFiles = [];
        foreach ($imageOrder as $index) {
            $sortedFiles[] = $files[$index];
        }
        foreach ($sortedFiles as $image) {
            $uploadPath = 'uploads/products/';
            $file = $image;
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $validated['image.*'] = "$uploadPath$filename";
            $dataImage[] = [
                'id' => random_int(99, 9999),
                'name' => $uploadPath . $filename,
            ];
        }
        $validated['image'] = json_encode($dataImage);
        Product::create($validated);
        return redirect('admin/products')->with('message', 'Products Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products =  Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.page.products.edit', compact('products'), compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'deskripsi' => 'required|string',
            'stok' => 'required|numeric',
            'price' => 'required|numeric',
            'min_stok' => 'required|numeric',
            'category_id' => 'required|numeric',
        ]);
        $products = Product::findOrFail($id);
        $imgDecode = json_decode($products->image);
        $products->update($validated);
        return redirect('admin/products/' . $id . '/edit')->with('message', 'Product Updated Successfully');
    }

    public function updateImg(Request $request)
    {
        $validated = $request->validate([
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);
        $id_produk = $request->input('id_produk');
        $products = Product::findOrFail($id_produk);
        $imgDecode = json_decode($products->image);
        $dataImage = $imgDecode;
        $imageOrder = explode(',', $request->input('image_order'));
        $files = $request->file('image');
        $sortedFiles = [];
        foreach ($imageOrder as $index) {
            $sortedFiles[] = $files[$index];
        }
        foreach ($sortedFiles as $image) {
            $uploadPath = 'uploads/products/';
            $file = $image;
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $validated['image.*'] = "$uploadPath$filename";
            $dataImage[] = [
                'id' => random_int(99, 9999),
                'name' => $uploadPath . $filename,
            ];
        }
        $validated['image'] = json_encode($dataImage);
        $products->update($validated);
        return redirect('admin/products/' . $id_produk . '/edit')->with('message', 'Add Image Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products = Product::findOrFail($id);
        $imgDecode = json_decode($products->image);
        foreach ($imgDecode as $key => $value) {
            if (File::exists($value->name)) {
                File::delete($value->name);
            }
        }
        $products->delete();
        return redirect('admin/products')->with('message', 'Product Deleted Successfully');
    }

    public function destroyImg(int $id, $id_produk)
    {
        $products = Product::findOrFail($id_produk);
        $imgDecode = json_decode($products->image);
        $dataImage = [];
        foreach ($imgDecode as $key => $value) {
            if ($value->id == $id) {
                if (File::exists($value->name)) {
                    File::delete($value->name);
                }
            } else {
                $dataImage[] = $value;
            }
        };
        $products->image = json_encode($dataImage);
        $products->save();
        return redirect('admin/products/' . $id_produk . '/edit')->with('message', 'Image Product Deleted Successfully');
    }
}
