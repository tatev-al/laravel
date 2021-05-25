<?php

namespace App\Http\Controllers;

use App\Models\PostImage;
use App\Models\Profession;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::with('image')->where('user_id', auth()->id())->get();

        return view('post')
            ->with('posts', $posts)
            ->with('professions', Profession::all());
    }

    public function create()
    {
        return view('createPost')
            ->with('professions', Profession::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'description' => 'required|string',
            'postImage' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $user = auth()->user();
        $path = $request->file('postImage')->store('images/posts');

        $newPost = Post::create(
            [
                'user_id' => $user->id,
                'title' => $request->title,
                'description' => $request->description,
            ]
        );

        $newPost->image()->create(
            [
                'user_id' => $user->id,
                'original_name' => $request->file('postImage')->getClientOriginalName(),
                'path' => $path,
            ]
        );

        $newPost->professions()->sync($request->professions);

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        return view('showPost')
            ->with('professions', Profession::all())
            ->with('post', $post->load('user'));
    }

    public function edit(Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403, 'Unauthorized action.');

        return view('editPost')
            ->with('professions', Profession::all())
            ->with('post', $post);
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'description' => 'required|string',
            'postImage' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $post->load('image');

        $post->update(
            [
                'title' => $request->title,
                'description' => $request->description
            ]
        );

        if($request->hasFile('postImage')) {
            $postImagePath = $request->file('postImage')->store('images/posts');

            if($post->image) {
                Storage::delete($post->image->path);
            }

            PostImage::where('post_id', $post->id)->updateOrCreate(
                [
                    'post_id' => $post->id,
                ],
                [
                    'original_name' => $request->file('postImage')->getClientOriginalName(),
                    'path' => $postImagePath,
                ]
            );
        }

        $post->professions()->sync($request->professions);

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403, 'Unauthorized action.');

        if($post->image) {
            Storage::delete($post->image->path);
        }

        $post->professions()->detach();
        $post->image()->delete();
        $post->delete();

        return redirect()->route('posts.index');
    }
}
