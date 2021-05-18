<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profession;
use Illuminate\Database\Eloquent\Builder;

class FeedController extends Controller
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
        $posts = Post::whereHas('post_professions', function (Builder $query) {
            $query->whereIn('profession_id', auth()->user()->user_professions->pluck('id'));
        })->where('user_id', '!=', auth()->id());

        return view('feed')
            ->with('users', $posts->get())
            ->with('posts', $posts->paginate(5))
            ->with('postImage', $posts->get()->load(['image']));
    }

    public function show()
    {
        return view('showPost')
            ->with('postProfessions', Profession::all());
    }
}
