@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="button mb-5 d-flex flex-row-reverse">
            <a class="btn btn-light float-right" href="{{ route('posts.create') }}">{{ __('Create') }}</a>
        </div>
        @foreach($posts as $post)
            <div class="row justify-content-center mt-3">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body d-flex">
                            <div class="w-25 h-25">
                                <img src="{{ $post->image ? asset('/storage/' . $post->image->path) : 'https://randomuser.me/api/portraits/women/48.jpg' }}" class="img-fluid" alt="post image">
                            </div>
                            <div class="p-4 w-75">
                                <div class="d-flex justify-content-between"><h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text"><small class="text-muted">{{ $post->updated_at }}</small></p></div>
                                <div><p class="card-text">{{ Str::limit($post->description, 250) }}</p></div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="m-3">
                                    <a href="{{ route('posts.show', ['post'=> $post->id]) }}" class="btn btn-light">Show more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


@endsection
