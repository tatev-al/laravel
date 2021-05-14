@extends('layouts.app')

@section('content')

<h1>
    hello
</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create New Post') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update')}}">

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{}}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{}}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="user_profession" class="col-md-4 col-form-label text-md-right">{{ __('Profession(s)') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="user_profession" name="profession[]" multiple="multiple">
                                        @foreach($professions as $pr)
                                            <option value="{{ $pr['id'] }}" @if(in_array($pr->id, $user->profession->pluck('id')->all())) selected @endif>{{ $pr['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="custom-file mt-1">
                                <input id="postImage" type="file" class="custom-file-input" name="postImage">
                                <label class="custom-file-label">Choose file</label>
                                <button class="btn btn-default" type="submit">Submit</button>
                            </div>

                            @error('postImage')
                            <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
