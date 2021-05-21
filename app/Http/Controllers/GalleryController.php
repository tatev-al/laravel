<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'title' => 'string|max:191',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $gallery = Gallery::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
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

    public function edit(Request $request, Gallery $galleryId)
    {
        $request->validate([
            'title' => 'string|max:191',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        Gallery::where('id', $galleryId->id)->update([
            'title' =>$request->title,
        ]);

        $files = $request->file('images');

        if($request->hasFile('images')) {
            foreach ($files as $file) {
                $path = $file->store('images/' . $request->title );
                GalleryImage::create([
                    'gallery_id' => $galleryId->id,
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path
                ]);
            }
        }

        return back();
    }

    public function show(Gallery $galleryId)
    {
        return view('gallery')
            ->with('gallery', Gallery::where('id', $galleryId->id)->first())
            ->with('galleryImages', GalleryImage::where('gallery_id', $galleryId->id)->get());
    }

    public function delete(GalleryImage $imageId)
    {
        Storage::delete($imageId->path);
        $imageId->delete();

        return back();
    }

    public function destroy(Gallery $galleryId)
    {
        $galleryImages = GalleryImage::where('gallery_id', $galleryId->id);
        Storage::delete($galleryImages->pluck('path')->all());
        $galleryImages->delete();
        $galleryId->delete();

        return redirect()->route('profile');
    }
}
