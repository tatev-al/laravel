@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="card p-4">

            <form method="POST" action="{{ route('gallery.update', ['gallery'=> $gallery->id]) }}" enctype="multipart/form-data">
                @csrf

                @method('PUT')
                <div class="card-header">
                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                        <div class="col-md-6">
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $gallery->title }}">
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <label for="images" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>
                        <div class="custom-file mt-1 col-md-6">
                            <input id="images" type="file" class="custom-file-input" name="images[]" multiple="multiple">
                            <label class="custom-file-label">Choose file</label>
                        </div>

                        @error('images')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex flex-column align-items-center m-3">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Add File') }}
                        </button>
                    </div>
                </div>
            </form>

            <div class="card-body">
                <div class="form-group d-flex flex-wrap">
                    @foreach($gallery->galleryImages as $images)

                        <div class="d-flex flex-column align-items-center m-3">
                            <div class="d-flex justify-content-center align-items-center overflow-hidden mb-3 ml-3" style="width: 150px; height: 150px" >
                                <img src="{{ asset('storage/' . $images->path ) }}" class="img-fluid" alt="gallery image">
                            </div>
                            <div class="d-flex flex-column">
                                <form method="POST" action="{{ route('gallery.delete', ['image'=> $images->id]) }}" enctype="multipart/form-data">
                                    @csrf

                                    @method('DELETE')

                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>

                    @endforeach
                </div>
                <div class="d-flex flex-row-reverse">
                    <div class="button mb-5">
                        <a class="btn btn-success float-right" href="{{ route('profile') }}">{{ __('Save changes') }}</a>
                    </div>
                    <div class="button mr-5 mb-5">
                        <form method="POST" action="{{ route('gallery.destroy', ['gallery'=> $gallery->id]) }}" enctype="multipart/form-data">
                            @csrf

                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">
                                {{ __('Delete gallery') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
