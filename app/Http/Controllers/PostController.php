<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $professions = Profession::select('id', 'name')->get();
        $user = auth()->user()->load(['profession', 'post']);
        return view('post')
            ->with('user', $user)
            ->with('posts', $user->post)
            ->with('professions', $professions)
            ->with('selected_professions', $user->profession);
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required|min:1|max:1000',
            'postImage' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $user = auth()->user();
        $path = $request->file('postImage')->store('images/posts');

        Post::create(
            [
                'original_name' => $request->file('avatar')->getClientOriginalName(),
                'path' => $path,
            ]
        );

        //return redirect();
    }
}
