@extends('layouts.sbadmin.mainfront', ['title' => 'Confirm Password'])

@section('content')
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">{{ __('Confirm Password') }}</h1>
                                        <p class="mb-4">{{ __('Please confirm your password before continuing.') }}</p>
                                    </div>
                                    @if (session('status'))
                                        <div class="text-center alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <form class="user" method="POST" action="{{ route('password.confirm') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input id="password" type="password" placeholder="Your Password"
                                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block">
                                            Confirm Password
                                        </button>
                                        <hr>
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-google btn-user btn-block"
                                                href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
