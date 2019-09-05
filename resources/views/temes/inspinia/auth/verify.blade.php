@extends('temes.inspinia.auth.layouts.VerifyRestart')

@section('content')

<div class="verifyBox animated fadeInDown">

        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('auth.A fresh verification link has been sent to your email address') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">{{ __('auth.VerifyYourEmailAddress') }}</h2><hr>

                    <div class="row">

                        <div class="col-lg-12">
                            <p>{{ __('auth.Before proceeding, please check your email for a verification link') }}</p>
                            <p>{{ __('auth.If you did not receive the email') }},

                                <a href="{{ route('verification.resend') }}"

                                onclick="event.preventDefault();
                                document.getElementById('resend').submit();">
        
                                {{ __('auth.ClickHere') }}
        
                                </a>
                            </p>

                            <form id="resend" action="{{ route('verification.resend') }}" method="POST" style="display: none;">
                                    @csrf
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
