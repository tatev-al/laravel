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

        return view('createGallery')
            ->with('user', $user);
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $gallery = Gallery::create([
            'user_id' => auth()->id(),
            'title' =>$request->title,
        ]);

        $files = $request->file('images');

        if($request->hasFile('images')) {
            foreach ($files as $file) {
                $path = $file->store('images/' . $request->title );
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path
                ]);
            }
        }
        return redirect()->route('profile');
    }

    public function transfer(Gallery $galleryId)
    {
        return view('editGallery')
            ->with('gallery', Gallery::where('id', $galleryId->id)->first())
            ->with('galleryImages', GalleryImage::where('gallery_id', $galleryId->id)->get());
    }

    public function edit(Request $request)
    {

    }

    public function show(Gallery $galleryId)
    {
        return view('gallery')
            ->with('gallery', Gallery::where('id', $galleryId->id)->first())
            ->with('galleryImages', GalleryImage::where('gallery_id', $galleryId->id)->get());
    }

    public function delete(GalleryImage $imageId)
    {

    }
}
