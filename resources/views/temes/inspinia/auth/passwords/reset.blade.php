@extends('temes.inspinia.auth.layouts.VerifyRestart')

@section('content')

<div class="passwordBox animated fadeInDown">

        @error('email')
            <div class="alert alert-danger" role="alert">
                    {{ $message }}
            </div>
        @enderror
    
        <div class="row">
    
            <div class="col-md-12">
                <div class="ibox-content">
    
                    <h2 class="font-bold">{{ __('auth.ResetPassword') }}</h2>
    
                    <div class="row">
    
                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="POST" action="{{ route('password.update') }}">
                                @csrf
                                
                                <input type="hidden" name="token" value="{{ $token }}">

                                @if($idUser)
        
                                    <?php $user = \Usuario::where('id',$idUser)->first();?>
        
                                     <input type="hidden" id="email" name="email" value="{{$user->email}}">
        
                                @endif

    
                                <div class="form-group">

                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('auth.Password') }}" required>
        
                                    @error('password')
                                         <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                               
                                </div>
        
                                <div class="form-group">
                                       
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('auth.ConfirmPassword') }}" required>
                                        
                                </div>
    
                                <button type="submit" class="btn btn-primary block full-width m-b">
                                        {{ __('auth.ResetPassword') }}
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
