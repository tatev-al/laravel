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
        $professions = Profession::select('id', 'name')->get();
        $users = Post::where('user_id', auth()->user()->id)->get();

        return view('post',[
            'posts' => DB::table('posts')->paginate(7)
            ])
            ->with('users', $users)
            ->with('professions', $professions)
            ->with('postImage', $users->load(['image'])->all());
    }

    public function show(Post $postId)
    {
        return view('showPost')
            ->with('postProfessions', Profession::all())
            ->with('post', $postId)
            ->with('user', auth()->user()->where('id', $postId->user_id)->first())
            ->with('userId', auth()->id());
    }

    public function transfer()
    {
        return view('createPost')
            ->with('postProfessions', Profession::all());
    }

    public function create(Request $request)
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

        PostImage::create(
            [
                'post_id' => $newPost->id,
                'user_id' => $user->id,
                'original_name' => $request->file('postImage')->getClientOriginalName(),
                'path' => $path,
            ]
        );

        $newPost->postProfessions()->sync($request->profession);

        return redirect()->route('posts.index');
    }

    public function edit(Post $postId)
    {
        abort_if($postId->user_id !== auth()->id(), 403, 'Unauthorized action.');

        return view('editPost')
            ->with('postProfessions', Profession::all())
            ->with('post', $postId);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'description' => 'required|string',
            'postImage' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $postId = $request->postId;
        $post = Post::where('id', $postId);

        $post->update(
            [
                'title'       => $request->title,
                'description' => $request->description
            ]
        );

        $postImagePath = $request->file('postImage')->store('images/posts');

        if($post->first()->load(['image'])->image) {
            Storage::delete($post->first()->load(['image'])->image->path);
        }

        PostImage::where('post_id', $postId)->updateOrCreate(
            [
                'post_id' => $postId,
            ],
            [
                'original_name' => $request->file('postImage')->getClientOriginalName(),
                'path' => $postImagePath,
            ]
        );

        $post->where('user_id', auth()->user()->id)->first()->postProfessions()->sync($request->profession);

        return redirect()->route('posts.index');
    }

    public function delete(Request $request)
    {
        $postId = $request->postId;
        $post = Post::where('id', $postId);
        $post->where('user_id', auth()->user()->id)->first()->postProfessions()->detach($request->profession);
        PostImage::where('post_id', $postId)->delete();
        $post->delete();

        return redirect()->route('posts.index');
    }
}
