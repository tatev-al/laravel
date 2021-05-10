<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

    public function index()
    {
        $profession = Profession::select('id', 'name')->get()->toArray();
        $selected_professions = User::with(['profession'])->find(Auth::id())->toArray()['profession'];
        $user = User::with(['detail'])->find(Auth::id())->toArray();
        return view('profile')
            ->with('user', $user)
            ->with('profession', $profession)
            ->with('selected_professions', $selected_professions);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => [
                'required',
                Rule::unique('users')->ignore(Auth::id())
            ],
            'password' => 'nullable|string'
        ]);

        User::where('id', Auth::id())->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : Auth::user()->password
        ]);

        return back()->with('success', 'Profile has been updated successfully!');
    }
}
