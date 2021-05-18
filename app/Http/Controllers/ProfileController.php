<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
        $user = auth()->user()->load(['detail', 'user_professions', 'avatar']);
        if($user->avatar()->exists()) {
            $avatarPath = $user->avatar->path;
        } else {
            $avatarPath = 'images/avatars/avatar.jpg';
        }

        return view('profile')
            ->with('user', $user)
            ->with('avatarPath', $avatarPath)
            ->with('professions', $professions)
            ->with('selected_professions', $user->user_professions);
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
}
