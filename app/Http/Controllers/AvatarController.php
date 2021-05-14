<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $user = auth()->user();
        $path = $request->file('avatar')->store('images/avatars');

        if($user->avatar) {
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
