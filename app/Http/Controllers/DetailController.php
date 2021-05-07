<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        return back()->with('successContact', 'Contact information has been updated successfully!');
    }
}
