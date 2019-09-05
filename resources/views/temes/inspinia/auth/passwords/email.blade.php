@extends('temes.inspinia.auth.layouts.VerifyRestart')

@section('content')

<div class="passwordBox animated fadeInDown">

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ __('auth.ResetPasswordAlertInfo')}}
        </div>
    @endif

    <div class="row">

        <div class="col-md-12">
            <div class="ibox-content">

                <h2 class="font-bold">{{ __('auth.ResetPassword') }}</h2>

                <p>
                    {{__('auth.InfoResetPassword')}}
                </p>

                <div class="row">

                    <div class="col-lg-12">
                        <form class="m-t" role="form" method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('auth.E-MailAddress') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <button type="submit" class="btn btn-primary block full-width m-b">
                                {{ __('auth.SendPasswordResetLink') }}
                            </button>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <hr/>

    @include('temes.inspinia.includes.copyright')

</div>

@endsection
