<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Detail;

class ProfileController extends Controller
{

    public function index()
    {
        //$db = DB::table('professions')->get()->toArray()[5];
        $profession = Profession::select('id', 'name')->get()->toArray();
        //$db2 = User::with(['user_profession'])->get();
        //dd($user_profession);
        //dd(User::with(['detail'])->find(Auth::id())->relationsToArray()['detail']['phone']);
        $user = User::with(['detail'])->find(Auth::id())->toArray();
        //dd($user);
        return view('profile')->with('user', $user)->with('profession', $profession);
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
