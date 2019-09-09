@extends('temes.inspinia.auth.layouts.login')

@section('content')

<div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <div class="descLogin">
                    <h2 class="font-bold">{{ __('auth.WelcomeTo') }}</h2>
                    <div class="col-md-9">
                        <img src="{{ asset('img/innove/logo.png') }}" class="logo-Login" alt="logo"> 
                    </div>
               </div>
            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <form method="POST" class="m-t" role="form" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('auth.E-MailAddress/Username') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                        <div class="form-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('auth.Password') }}" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">{{ __('auth.Login') }}</button>

                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                           <small> {{ __('auth.ForgotYourPassword') }}</small>
                        </a>
                       @endif

                    
                    </form>

                </div>
            </div>
        </div>
        <hr/>

        @include('temes.inspinia.includes.copyright')
        
    </div>

@endsection
