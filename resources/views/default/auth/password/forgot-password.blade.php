@extends('layouts.auth')

@section('metadata')
    <meta name="description" content="{{ __($metadata->login_description) }}">
    <meta name="keywords" content="{{ __($metadata->login_keywords) }}">
    <meta name="author" content="{{ __($metadata->login_author) }}">	    
    <link rel="canonical" href="{{ $metadata->login_url }}">
    <title>{{ __($metadata->register_title) }}</title>
@endsection

@section('content')
<div class="container-fluid justify-content-center">
    <div class="row h-100vh align-items-center login-background">

        <div class="col-md-6 col-sm-12 h-100" id="login-responsive">                
            <div class="card-body pr-10 pl-10 pt-10">

                <h3 class="text-center login-title mb-8">{{ __('Welcome to') }} <span class="text-info">{{ config('app.name') }}</span></h3>

                @if ($message = Session::get('success'))
                    <div class="alert alert-login alert-success"> 
                        <strong><i class="fa fa-check-circle"></i> {{ $message }}</strong>
                    </div>
                    @endif

                    @if ($message = Session::get('error'))
                    <div class="alert alert-login alert-danger">
                        <strong><i class="fa fa-exclamation-triangle"></i> {{ $message }}</strong>
                    </div>
                @endif

                <div class="mb-6 fs-14">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf       
                    
                    <div class="input-box mb-6">                             
                        <label for="email" class="fs-12 font-weight-bold text-md-right">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off"  placeholder="Email Address" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror                            
                    </div>
                    
                    <div class="form-group mb-0 text-center">                        
                        <button type="submit" class="btn btn-primary login-main-button">{{ __('Email Password Reset Link') }}</button>  
                        <p class="fs-10 text-muted mt-2">{{ __('or') }} <a class="text-info" href="{{ route('login') }}">{{ __('Sign In') }}</a></p>                                                    
                    </div>

                </form>
            </div>      
        </div>
        
        <div class="col-md-6 col-sm-12 text-center background-special h-100 align-middle p-0" id="login-background">
            <div class="login-bg">
                <img src="{{ URL::asset('img/frontend/backgrounds/login.webp') }}" alt="">
            </div>
        </div>
    </div>
</div>
@endsection
