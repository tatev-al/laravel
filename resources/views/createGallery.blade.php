@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="card p-4">


            <form method="POST" action="{{ route('gallery.create') }}" enctype="multipart/form-data">
                @csrf

                @method('POST')
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                    <div class="col-md-6">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" required autofocus>
                    </div>
                </div>

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

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Add File') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>


@endsection
