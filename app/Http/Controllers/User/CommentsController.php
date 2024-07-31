<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Comments;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $post_id)
    {
        //
        if (Auth::check()) {
            $user = Auth::user();
            $user->comments()->create([
                'post_id' => $post_id,
                'comment' => $request->comment,
            ]);

            return redirect()->back()->with('tabs_home', [
                'type' => 'posts'
            ]);
        } else {
            return redirect('/login');
        }
    }
}
