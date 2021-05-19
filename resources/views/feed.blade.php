@extends('layouts.app')

@section('content')

    @if ($users->isEmpty())
        <span class="alert alert-success d-flex justify-content-center p-2">
            {{ 'No matching posts.' }}
        </span>
    @endif

    <div class="container">
        @foreach($users as $user)
            <div class="row justify-content-center mt-3">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body d-flex">
                            <div class="w-25 h-25">
                                @if(!$user->image)
                                    <img src="{{ asset('storage/images/posts/post.jpg' ) }}" class="img-fluid" alt="{{ asset('storage/' . $user->image ) }}">
                                @else
                                    <img src="{{ asset('storage/' . $user->image->path ) }}" class="img-fluid" alt="post image">
                                @endif
                            </div>
                            <div class="p-4 w-75">
                                <div class="d-flex justify-content-between"><h5 class="card-title">{{ $user['title'] }}</h5>
                                    <p class="card-text"><small class="text-muted">{{ $user['updated_at'] }}</small></p></div>
                                <div><p class="card-text">{{ Str::limit($user['description'], 250) }}</p></div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="m-3">
                                    <a href="{{ route('posts.show', ['postId'=> $user->id]) }}" class="btn btn-light">Show more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center p-4">
        {{ $posts->links() }}
    </div>

@endsection
