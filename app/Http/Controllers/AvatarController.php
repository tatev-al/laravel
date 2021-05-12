<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function index()
    {
        return view('profile')->with('detailF', Auth::user());
    }

    public function upload(Request $request)
    {
        $user = auth()->user();
        if(!$request->file('avatar'))
        {
            return back()->with('successAvatar', 'Please choose a picture first!');
        }
        $path = $request->file('avatar')->store('images/avatars');
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        if($user->avatar)
        {
            Storage::delete($user->avatar->path);
        }

        Avatar::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'original_name' => $request->file('avatar')->getClientOriginalName(),
                'path' => $path,
            ]
        );

        return back()->with('successAvatar', 'Avatar has been uploaded successfully!');
    }
}
