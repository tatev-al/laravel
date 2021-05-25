<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Post;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
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

    public function show(User $user)
    {
        return view('showProfile')
            ->with('profile', $user->load(['detail', 'avatar', 'professions', 'galleries']))
            ->with('professions', Profession::all());
    }
}
