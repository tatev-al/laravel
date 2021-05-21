@extends('layouts.app')

@section('content')


    <div class="container">

        <a class="card-header d-flex justify-content-center" href="{{ route('profile.show', ['profileId'=> $user->id]) }}">{{ $user->name }}</a>

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
                        @foreach($postProfessions as $pr)
                            @if(in_array($pr->id, $post->postProfessions->pluck('id')->all()))
                                <p class="mt-2">{{ $pr['name'] }}</p>
                            @endif
                        @endforeach
                </div>
            </div>

            <div class="form-group row">
                <label for="postImage" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>
                <div class="w-25 h-25">
                    @if(!$post->image)
                        <img src="{{ asset('storage/images/posts/post.jpg' ) }}" class="img-fluid" alt="{{ asset('storage/' . $user->image ) }}">
                    @else
                        <img src="{{ asset('storage/' . $post->image->path ) }}" class="img-fluid" alt="post image">
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-end">

                @if($userId == $user->id)
                    <form action="{{ route('posts.delete', ['postId'=> $post]) }}" method="GET" enctype="multipart/form-data" class="m-3">
                        @csrf
                        @method('GET')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                    <div class="m-3">
                        <a href="{{ route('posts.edit', ['postId'=> $post]) }}" class="btn btn-light">Edit</a>
                    </div>
                @endif

            </div>
        </div>

    </div>


@endsection
