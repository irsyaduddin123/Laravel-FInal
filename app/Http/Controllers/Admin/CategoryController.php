<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.page.categories.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.page.categories.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('image')) {
            $uploadPath = 'uploads/categories/';
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $validated['image'] = "$uploadPath$filename";
        }

        Category::create($validated);
        return redirect('admin/categories')->with('message', 'Categories Added Successfully');
    }

    public function edit($id)
    {
        $category =  Category::findOrFail($id);
        return view('admin.page.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $category = Category::findOrFail($id);

        if ($request->hasFile('image')) {
            $uploadPath = 'uploads/categories/';
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $validated['image'] = "$uploadPath$filename";

            // Delete old image if exists
            if (file_exists($category->image)) {
                unlink($category->image);
            }
        }

        $category->update($validated);
        return redirect('admin/categories')->with('message', 'Category Updated Successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if (File::exists($category->image)) {
            File::delete($category->image);
        }

        // if (file_exists($category->image)) {
        //     unlink($category->image);
        // }

        $category->delete();

        return redirect('admin/categories')->with('message', 'Category Deleted Successfully');
    }
}
