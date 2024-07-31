<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::with('comments')->latest()->paginate(5);
        return view('frontend.post', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if (Auth::id()) {
            $request->validate([
                'title' => 'required',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'news_content' => 'required',
            ]);

            if (!empty($request->image)) {
                $filename = 'image-' . uniqid() . '.' . $request->image->extension();
                $request->image->move('uploads/posts', $filename);
            } else {
                $filename = '';
            }

            $post = new Post;
            $post->title = $request->title;
            $post->image = $filename;
            $post->news_content = $request->news_content;
            $post->user_id = Auth::user()->id;
            $post->save();
            return redirect()->back()->with('tabs_home', [
                'type' => 'posts'
            ]);
        } else {
            return redirect('login');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $p = Post::with(['user', 'comments.user'])->findOrFail($id);
        return view('frontend.detailpost', compact('p'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
        return view('frontend.edit_post', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'news_content' => 'required',
        ]);

        // Validasi apakah user memiliki izin untuk mengedit post
        if ($post->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $filename = $post->image;
        if ($request->hasFile('image')) {
            if (!empty($filename) && file_exists('uploads/posts/' . $filename)) {
                unlink('uploads/posts/' . $filename);
            }
            $filename = 'image-' . $post->id . '.' . $request->image->extension();
            $request->image->move('uploads/posts', $filename);
        }

        $post->title = $request->title;
        $post->image = $filename;
        $post->news_content = $request->news_content;
        $post->save();
        return redirect()->back()->with('tabs_home', [
            'type' => 'posts'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!empty($post->image) && file_exists('uploads/posts/' . $post->image)) {
            unlink('uploads/posts/' . $post->image);
        }

        $post->delete();
        return redirect()->back()->with('tabs_home', [
            'type' => 'posts'
        ]);
    }
}
