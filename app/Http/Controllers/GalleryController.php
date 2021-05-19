<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user()->load(['galleries']);

        return view('gallery')
            ->with('user', $user);
    }

    public function create(Request $request)
    {
//        $request->validate([
//            'title' => 'required|string|max:191',
//            'images' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
//        ]);
//
//        Gallery::create($request->all());
//        foreach ($request->images as $image) {
//            $path = $image->store('images/' . $request->title);
//            GalleryImage::create([
//                'gallery_id' => $image->id,
//                'original_name' => $image->getClientOriginalName(),
//                'path' => $path
//            ]);
//        }
    }
}
