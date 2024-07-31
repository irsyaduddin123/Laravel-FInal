@extends('layouts.app')

@section('content')
    <div class="imgGame" style="background-image: url('{{ asset('assets/img/gamingLarge.jpg') }}');background-size: cover;">
    </div>
    <link rel="stylesheet" href="{{ asset('js/auth.css') }}">
    <div class="wrapper">
        <div class="title-text">
            <div class="title forget">{{ __('Reset Password') }}</div>
        </div>
        <div class="form-container">
            <div class="form-inner">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="field">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="{{ __('Masukkan Email Address') }}">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="field btn">
                        <div class="btn-layer"></div>
                        {{-- <button type="submit" class="btn" style="font-size: 1.2rem;">
                            {{ __('Send Password Reset Link') }}
                        </button> --}}
                        <input style="font-size: 1rem;" type="submit" value=" Send Password Reset Link">
                    </div>
                </form>
            </div>



        </div>
    </div>
@endsection
{{-- <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">{{ __('Reset Password') }}</div>
    
                                <div class="card-body">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
    
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
    
                                        <div class="row mb-3">
                                            <label for="email"
                                                class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
    
                                            <div class="col-md-6">
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
    
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
    
                                        <div class="row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Send Password Reset Link') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> --}}
