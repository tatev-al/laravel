@extends('layouts.app')

@section('content')
    @if (session('success'))
        <span class="alert alert-success d-flex justify-content-center p-2">
            {{ session('success') }}
        </span>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                        <div class="row-cols-lg-5">
                            <img src="{{ $user->avatar ? asset('/storage/' . $user->avatar->path) : 'https://randomuser.me/api/portraits/women/44.jpg' }}" class="img-fluid" alt="avatar">
                            <form method="POST" action="{{ route('profile.upload')}}" enctype="multipart/form-data">
                                @csrf

                                @method('PUT')
                                <div class="custom-file mt-1">
                                    <input id="avatar" type="file" class="custom-file-input" name="avatar">
                                    <label class="custom-file-label">Choose file</label>
                                    <button class="btn btn-default" type="submit">Submit</button>
                                </div>

                                @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </form>

                        </div>

                        <form method="POST" action="{{ route('profile.update')}}">
                            @csrf

                            @method('PUT')
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('New E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password">
                                </div>
                            </div>

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



    <div class="container p-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Contact Information') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.detail.update') }}">
                            @csrf

                            @method('PUT')
                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                                <div class="col-md-6">
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ optional($user->detail)->phone }}" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                <div class="col-md-6">
                                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ optional($user->detail)->address }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                                <div class="col-md-6">
                                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ optional($user->detail)->city }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

                                <div class="col-md-6">
                                        <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ optional($user->detail)->country }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="user_profession" class="col-md-4 col-form-label text-md-right">{{ __('Profession(s)') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="user_profession" name="professions[]" multiple="multiple">
                                        @foreach($professions as $profession)
                                            <option value="{{ $profession->id }}" @if($user->professions->contains($profession->id)) selected @endif>{{ $profession->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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

    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Galleries') }}</div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            @foreach($user->galleries as $gallery)
                                <a href="{{ route('gallery.show', ['gallery'=> $gallery->id]) }}">
                                    <div class="d-flex flex-column">
                                        <div class="text-center">
                                            <p class="card-text">{{ $gallery->title }}</p>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center overflow-hidden mb-3 ml-3" style="width: 150px; height: 150px">
                                            <img src="{{ !$gallery->galleryImages->isEmpty() ? asset('storage/' . $gallery->galleryImages[0]->path)
                                                    : 'https://images.pexels.com/photos/776336/pexels-photo-776336.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940' }}" class="img-fluid" alt="gallery image">
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
