<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function index()
    {
        return view('profile')->with('detail', Auth::user());
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'phone' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'city' => 'required|string|max:191',
            'country' => 'required|string|max:191'
        ]);

        $user->detail()->updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country
            ]
        );

        $user->user_professions()->sync($request->profession);
        return back()->with('successContact', 'Contact information has been updated successfully!');
    }
}
