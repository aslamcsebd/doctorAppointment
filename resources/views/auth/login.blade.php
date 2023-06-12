@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="text-center pt-2">
                    <img src="{{ asset('images/general/default.jpg') }}" class="img-thumbnail" alt="No Image found" width="100">
                    <br>
                    <h4>{{ $general->company_name ?? 'Add institution name' }}</h4>
                    <p>Sign in to your account</p>
                    <hr>
                </div>        
                {{-- <div class="card-header text-center bg-info">{{ __('Admin login') }}</div> --}}
                <div class="card-body py-0">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                @php
                                    $users = App\Models\User::all();
                                @endphp

                                <select class="form-control" name="email" required>
                                    @foreach($users as $user)
                                        <option value="{{$user->email}}">{{$user->email}}</option>
                                    @endforeach
                                </select>

                                {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> --}}

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="123" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-md-4 col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-md-4 col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="form-group row">
                        <div class="offset-md-4 col-md-6">
                            <a href="{{ url('/login/google') }}" class="btn btn-success btn-block">
                                <i class="fab fa-google"></i> {{ __('Login with google') }}
                            </a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-md-4 col-md-6">
                            <a href="{{ route('register') }}" class="btn btn-secondary btn-block">
                                {{ __('Register') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection