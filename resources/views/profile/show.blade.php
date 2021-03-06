@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                        <div class="row-cols-lg-5">
                            <img src="{{ $profile->avatar ? asset('/storage/' . $profile->avatar->path) : 'https://randomuser.me/api/portraits/women/44.jpg' }}" class="img-fluid" alt="avatar">
                        </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name:') }}</label>

                                <div class="col-md-6">
                                    <p class="mt-2">{{ $profile->name }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address:') }}</label>

                                <div class="col-md-6">
                                    <p class="mt-2">{{ $profile->email }}</p>
                                </div>
                            </div>

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

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone:') }}</label>

                                <div class="col-md-6">
                                    <p class="mt-2">{{ optional($profile->detail)->phone }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address:') }}</label>

                                <div class="col-md-6">
                                    <p class="mt-2">{{ optional($profile->detail)->address }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City:') }}</label>

                                <div class="col-md-6">
                                    <p class="mt-2">{{ optional($profile->detail)->city }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country:') }}</label>

                                <div class="col-md-6">
                                    <p class="mt-2">{{ optional($profile->detail)->country }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="user_profession" class="col-md-4 col-form-label text-md-right">{{ __('Profession(s):') }}</label>

                                <div class="col-md-6">
                                    @foreach($profile->professions as $profession)
                                        <p class="mt-2">{{ $profession->name }}</p>
                                    @endforeach
                                </div>
                            </div>
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
                            @foreach($profile->galleries as $gallery)
                                <a href="{{ route('gallery.show', ['gallery'=> $gallery['id']]) }}">
                                    <div class="d-flex flex-column">
                                        <div class="text-center">
                                            <p class="card-text">{{ $gallery['title'] }}</p>
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
