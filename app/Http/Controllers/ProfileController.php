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
//        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $professions = Profession::select('id', 'name')->get();
        $user = auth()->user()->load(['detail', 'userProfessions', 'avatar']);
        if($user->avatar()->exists()) {
            $avatarPath = $user->avatar->path;
        } else {
            $avatarPath = 'images/avatars/avatar.jpg';
        }

        $galleries = Gallery::where('user_id', auth()->id())->get();

        //dd(GalleryImage::where('gallery_id', [42,43])->get());
        //dd(Gallery::where('user_id', auth()->id())->get()->load(['galleryImages']));
        //dd(Gallery::where('user_id', auth()->id())->get()->load(['galleryImages'])->pluck('galleryImages')->all());
        //$test = Gallery::where('user_id', auth()->id())->get()->load(['galleryImages'])->pluck('galleryImages')->all();

//        dd(Gallery::whereHas('galleryImages', function (Builder $query) {
//            $query->whereIn('gallery_id', Gallery::where('user_id', auth()->id())->get()->pluck('id'));
//        }));

        return view('profile')
            ->with('user', $user)
            ->with('avatarPath', $avatarPath)
            ->with('professions', $professions)
            ->with('selected_professions', $user->userProfessions)
            ->with('galleries', $galleries);
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

    public function show(Post $profileId)
    {
        $profile = User::where('id', $profileId->user_id)->get()->load(['detail', 'avatar', 'userProfessions'])->first();
        $professions = Profession::select('id', 'name')->get();

        if($profile->avatar()->exists()) {
            $avatarPath = $profile->avatar->path;
        } else {
            $avatarPath = 'images/avatars/avatar.jpg';
        }

//        $galleries = Gallery::where('user_id', $profileId->user_id)->get();
//        dd($galleries->all());
//        dd(GalleryImage::all());
//        dd(Gallery::where('user_id', $profileId->user_id)->get()->load(['galleryImages'])->all()[0]->galleryImages);

        return view('showProfile')
            ->with('profile', $profile)
            ->with('avatarPath', $avatarPath)
            ->with('professions', $professions)
            ->with('selected_professions', $profile->userProfessions);

//            ->with('galleries', $galleries)
//            ->with('galleryImages', $galleries->load(['galleryImages']));
    }
}
