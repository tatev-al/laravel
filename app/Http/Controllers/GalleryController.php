<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function store(Request $request)
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
                $path = $file->store('images/' . Str::slug($request->title, '_') );

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('profile');
    }

    public function show(Gallery $gallery)
    {
        return view('gallery.gallery')
            ->with('gallery', Gallery::with('galleryImages')->where('id', $gallery->id)->first());
    }

    public function edit(Gallery $gallery)
    {
        abort_if($gallery->user_id !== auth()->id(), 403, 'Unauthorized action.');

        return view('gallery.edit')
            ->with('gallery', $gallery->load('galleryImages'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'string|max:191',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        Gallery::where('id', $gallery->id)->update([
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

        return back();
    }

    public function delete(GalleryImage $image)
    {
        if($image->path) {
            Storage::delete($image->path);
        }

        $image->delete();

        return back();
    }

    public function destroy(Gallery $gallery)
    {
        abort_if($gallery->user_id !== auth()->id(), 403, 'Unauthorized action.');

        Storage::delete($gallery->galleryImages->pluck('path')->all());
        $gallery->galleryImages()->delete();
        File::deleteDirectory(public_path('storage/images/' . Str::slug($gallery->title, '_')));
        $gallery->delete();

        return redirect()->route('profile');
    }
}
