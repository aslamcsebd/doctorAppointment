@extends('layouts.app2')

@section('content')
    <section class="vh-100 gradient-custom">
        <div class="row justify-content-center align-items-center h-100 m-0">
            <div class="col-md-6 col-xs-12">
                <div class="card bg-dark text-white py-4" style="border-radius: 1rem;">
                    @php
                        $hospitalInfo = App\Models\HospitalInfo::first();
                    @endphp
                    <div class="text-center pt-2">
                        <img src="{{ asset('') }}/{{ $hospitalInfo->photo ?? 'images/default.jpg' }}"
                            class="img-thumbnail" alt="No Image found" width="100">
                        <br>
                        <h4>{{ $hospitalInfo->name ?? 'Add hospital name' }}</h4>
                        <p>Sign in to your account</p>
                        <hr class="border border-light">
                    </div>
                    <div class="card-body py-0">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-sm-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <div class="col-md-6 col-sm-12 form-outline">

                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback text-light" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-sm-12 col-form-label text-md-right">{{ __('Password') }}</label>
                                <div class="col-md-6 col-sm-12 form-outline form-white">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="nvalid-feedback text-light" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-md-4 col-md-6 col-sm-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }} style="width: unset">
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-md-4 col-md-6 col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-block rounded-pill">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="form-group row">
                            <div class="offset-md-4 col-md-6 col-sm-12">
                                <a href="{{ url('/login/google') }}" class="btn btn-success btn-block rounded-pill">
                                    <i class="fab fa-google"></i> {{ __('Login with google') }}
                                </a>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <div class="offset-md-4 col-md-6 col-sm-12">
                                <a href="{{ route('register') }}" class="btn btn-secondary btn-block rounded-pill">
                                    {{ __('Register') }}
                                </a>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <div class="offset-md-4 col-md-8 col-sm-12">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link ml-4" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
