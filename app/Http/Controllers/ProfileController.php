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
        // UploadedFile
        $file = $request->file('avatar');

//        Storage::put('example.txt', 'Hello World');
//        Storage::append('example.txt', 'Hello World2');
//        Storage::prepend('example.txt', 'Hello World2');

//        Storage::move('example.txt', '/public/example.txt');
//        if (Storage::exists('/public/example.txt')) {
//            $content = Storage::get('/public/example.txt');
//        } else {
//            $content = 'Not found';
//        }

//        dd($content);

//        exit;
        //dd(auth()->user()->avatar->path);
        $professions = Profession::select('id', 'name')->get();
        $user = auth()->user()->load(['detail', 'profession', 'avatar']);
        if(!Storage::exists($user->avatar->path))
        {
            $user->avatar->path = 'images/avatars/avatar.jpg';
        }
        //dd($user->avatar->path);
        return view('profile')
            ->with('user', $user)
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
