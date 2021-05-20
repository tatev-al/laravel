@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                        <div class="row-cols-lg-5">
                                <img src="{{ asset('/storage/'. $avatarPath ) }}" class="img-fluid" alt="avatar">
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
                                    @foreach($professions as $pr)
                                        @if(in_array($pr->id, $profile->userProfessions->pluck('id')->all()))
                                            <p class="mt-2">{{ $pr['name'] }}</p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Galleries') }}</div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between">
                        @foreach($galleries as $gallery)
                            <div class="">
                                <p class="card-text">{{ $gallery['title'] }}</p>
                                <img src="--}}{{--{{ asset('storage/' . $galleryImages['path'] ) }}--}}{{--" class="img-fluid" alt="gallery image">
                            </div>
                        @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>--}}

@endsection
