@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="card p-4">


            <form method="POST" action="{{ route('posts.update', ['postId'=> $post->id])}}" enctype="multipart/form-data">
                @csrf

                @method('POST')
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                    <div class="col-md-6">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $post->title }}" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('description') }}</label>

                    <div class="col-md-6">
                        <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" required autofocus>{{ $post->description }}</textarea>

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user_profession" class="col-md-4 col-form-label text-md-right">{{ __('Profession(s)') }}</label>

                    <div class="col-md-6">
                        <select class="form-control" id="user_profession" name="profession[]" multiple="multiple">
                            @foreach($postProfessions as $pr)
                                <option value="{{ $pr['id'] }}" @if(in_array($pr->id, $post->post_professions->pluck('id')->all())) selected @endif>{{ $pr['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="postImage" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>
                    <div class="custom-file mt-1 col-md-6">
                        <input id="postImage" type="file" class="custom-file-input" name="postImage">
                        <label class="custom-file-label">Choose file</label>
                    </div>

                    @error('postImage')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save Changes') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>


@endsection
