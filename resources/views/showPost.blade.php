@extends('layouts.app')

@section('content')


    <div class="container">

        <a class="card-header d-flex justify-content-center" href="{{ route('profile.show', ['profile'=> $post->user->id]) }}">{{ $post->user->name }}</a>

        <div class="card-body">

            <div class="form-group row">
                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                <div class="col-md-6">
                    <p class="mt-2">{{ $post->title }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('description') }}</label>

                <div class="col-md-6">
                    <p class="mt-2">{{ $post->description }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label for="user_profession" class="col-md-4 col-form-label text-md-right">{{ __('Profession(s)') }}</label>

                <div class="col-md-6">
                        @foreach($professions as $profession)
                            @if(in_array($profession->id, $post->professions->pluck('id')->all()))
                                <p class="mt-2">{{ $profession->name }}</p>
                            @endif
                        @endforeach
                </div>
            </div>

            <div class="form-group row">
                <label for="postImage" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>
                <div class="w-25 h-25">
                    <img src="{{ $post->image ? asset('/storage/' . $post->image->path) : 'https://randomuser.me/api/portraits/women/48.jpg' }}" class="img-fluid" alt="post image">
                </div>
            </div>
            <div class="d-flex justify-content-end">

                @if($post->user->id == auth()->id())
                    <form action="{{ route('posts.destroy', ['post'=> $post]) }}" method="POST" enctype="multipart/form-data" class="m-3">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                    <div class="m-3">
                        <a href="{{ route('posts.edit', ['post'=> $post]) }}" class="btn btn-light">Edit</a>
                    </div>
                @endif

            </div>
        </div>

    </div>


@endsection
