<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\User;
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
        $request->validate([
            'phone' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'city' => 'required|string|max:191',
            'country' => 'required|string|max:191'
        ]);

        Detail::updateOrCreate(
            [
                'user_id' => Auth::id()
            ],
            [
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country
            ]
        );
        $user = User::find(Auth::id());
        $user->profession()->sync($request->toArray()['profession']);
        return back()->with('successContact', 'Contact information has been updated successfully!');
    }
}
