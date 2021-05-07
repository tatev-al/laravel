<?php

namespace App\Http\Controllers;

use App\Models\UserProfession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserProfessionController extends Controller
{
    public function index()
    {
        $db = DB::table('professions')->get()->toArray();
        return view('profile')->with('user_profession', $db);
    }

    public function update(Request $request)
    {
        $request->validate([
        ]);

        UserProfession::updateOrCreate(
            [
                'user_id' => Auth::id()
            ],
            [
                //take profession id
                'profession' => $request->all()
            ]
        );
        return back()->with('successProfession', 'Profession(s) information has been updated successfully!');
    }
}
