<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Detail;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

    public function index()
    {
        return view('profile')->with('user', Auth::user());
    }

    public function update(Request $request)
    {
        if($request->get('form') == 1)
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

        if($request->get('form') == 2)
        {
            $request->validate([
                'phone' => [
                    'required',
                    Rule::unique('details')->ignore(Auth::id())
                ],
                'address' => 'required|string|max:191',
                'city' => 'required|string|max:191',
                'country' => 'required|string|max:191'
            ]);
            Detail::where('id', Auth::id())->update([
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country
            ]);

            return back()->with('successContact', 'Contact information has been updated successfully!');
        }
    }
}
