@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <form method="POST" action="{{ route('gallery.transfer', ['galleryId'=> $gallery->id]) }}" enctype="multipart/form-data">
                        @csrf

                        @method('PUT')
                            <div class="card-header">
                                <p class="mt-2">{{ $gallery->title }}</p>
                            </div>

                            <div class="card-body">
                            <div class="form-group row">
                                @foreach($galleryImages as $images)
                                    <div class="d-flex justify-content-center w-25 h-25 m-1">
                                        <img src="{{ asset('storage/' . $images->path ) }}" class="img-fluid" alt="gallery image">
                                    </div>
                                @endforeach
                            </div>
                            </div>

                            <div class="form-group row mb-0 p-3">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Edit') }}
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
