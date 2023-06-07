@extends('layouts.sbadmin.mainfront', ['title' => 'Verify Email'])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    @if (session('status'))
                                        <div class="text-center alert alert-success" role="alert">
                                            {{-- {{ session('status') }} --}}
                                            {{ __('A fresh verification link has been sent to your email address.') }}
                                        </div>
                                    @endif
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">{{ __('Verify Your Email Address') }}</h1>
                                        <p class="mb-4">
                                            {{ __('Before proceeding, please check your email for a verification link.') }}
                                            <br>
                                            {{ __('If you did not receive the email') }},
                                        </p>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('verification.send') }}">
                                        @csrf
                                        <button class="btn btn-primary btn-user btn-block">
                                            {{ __('Click here to request another !') }}
                                        </button>
                                    </form>
                                    <hr>
                                    @if (Route::has('logout'))
                                        <form class="user" method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-google btn-user btn-block">Click here to
                                                Create another Account !</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
