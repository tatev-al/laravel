<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Post;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user()->load(['detail', 'professions', 'avatar', 'galleries']);

        return view('profile')
            ->with('user', $user)
            ->with('professions', Profession::all());
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:191',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => 'nullable|string'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password
        ]);

        return back()->with('success', 'Profile has been updated successfully!');
    }

    public function show(Post $profile)
    {
        $profile = User::where('id', $profile->user_id)->get()->load(['detail', 'avatar', 'professions', 'galleries'])->first();
        $professions = Profession::select('id', 'name')->get();

        if($profile->avatar()->exists()) {
            $avatarPath = $profile->avatar->path;
        } else {
            $avatarPath = 'images/avatars/avatar.jpg';
        }

        $galleries = Gallery::where('user_id', $profile->id)->get();

        return view('showProfile')
            ->with('profile', $profile)
            ->with('professions', $professions)
            ->with('selected_professions', $profile->professions)
            ->with('galleries', $galleries);
    }
}
