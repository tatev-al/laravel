<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        $professions = Profession::select('id', 'name')->get();
        $user = auth()->user()->load(['detail', 'profession', 'avatar']);
        if(!$user->avatar)
        {
            $avatarPath = 'images/avatars/avatar.jpg';
        }
        else
        {
            $avatarPath = $user->avatar->path;
        }
        return view('profile')
            ->with('user', $user)
            ->with('avatarPath', $avatarPath)
            ->with('professions', $professions)
            ->with('selected_professions', $user->profession);
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
