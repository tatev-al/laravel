@extends('layouts.app')

@section('content')
    @if (session('success'))
        <span class="alert alert-success d-flex justify-content-center p-2">
            {{ session('success') }}
        </span>
    @endif
    @if (session('successContact'))
        <span class="alert alert-success d-flex justify-content-center p-2">
            {{ session('successContact') }}
        </span>
    @endif
    @if (session('successProfession'))
        <span class="alert alert-success d-flex justify-content-center p-2">
            {{ session('successProfession') }}
        </span>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update')}}">
                            @csrf

                            @method('POST')
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user['name'] }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('New E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user['email'] }}" required autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" required autofocus>
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
                        <form method="POST" action="{{ route('detail.update') }}">
                            @csrf

                            @method('POST')
                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                                <div class="col-md-6">
                                    @if($user['detail'] === null)
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="" required autofocus>
                                    @else
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user['detail']['phone'] }}" required autofocus>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                <div class="col-md-6">
                                    @if($user['detail'] === null)
                                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="" required autofocus>
                                    @else
                                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $user['detail']['address'] }}" required autofocus>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                                <div class="col-md-6">
                                    @if($user['detail'] === null)
                                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="" required autofocus>
                                    @else
                                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $user['detail']['city'] }}" required autofocus>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

                                <div class="col-md-6">
                                    @if($user['detail'] === null)
                                        <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="" required autofocus>
                                    @else
                                        <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ $user['detail']['country'] }}" required autofocus>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="user_profession" class="col-md-4 col-form-label text-md-right">{{ __('Profession(s)') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="user_profession" name="profession[]" multiple="multiple">
                                        @foreach($profession as $pr)
                                            @foreach($selected_professions as $sel_pr)
                                                @if($sel_pr['id'] == $pr['id'])
                                                    <option value="{{ $sel_pr['id'] }}" selected>{{ $sel_pr['name'] }}</option>
                                                    @break
                                                @endif
                                            @endforeach
                                                @if($sel_pr['id'] != $pr['id'])
                                                    <option value="{{ $pr['id'] }}" >{{ $pr['name'] }}</option>
                                                @endif
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

@endsection
