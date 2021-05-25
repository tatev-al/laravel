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
        $posts = Post::with('image')->whereHas('professions', function (Builder $query) {
            $query->whereIn('profession_id', auth()->user()->professions->pluck('id'));
            })
            ->where('user_id', '!=', auth()->id())
            ->paginate(5);

        return view('feed')
            ->with('posts', $posts);
    }
}
