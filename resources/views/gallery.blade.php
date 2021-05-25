@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <form method="POST" action="{{ route('gallery.edit', ['gallery'=> $gallery->id]) }}" enctype="multipart/form-data">
                        @csrf

                        @method('GET')
                            <div class="card-header">
                                <p class="mt-2">{{ $gallery->title }}</p>
                            </div>

                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    @foreach($gallery->galleryImages as $images)
                                        <div class="d-flex justify-content-center align-items-center overflow-hidden mb-3 ml-3"  style="width: 150px; height: 150px">
                                            <img src="{{ asset('storage/' . $images->path ) }}" class="img-fluid" alt="gallery image">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if(Auth::id() == $gallery->user_id)
                                <div class="d-flex flex-column">
                                    <button type="submit" class="btn btn-light">
                                        {{ __('Edit gallery') }}
                                    </button>
                                </div>
                            @endif

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
