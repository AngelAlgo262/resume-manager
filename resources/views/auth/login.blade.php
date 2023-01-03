@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ 'Welcome!!!' }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="">
                                <label for="email" class=" d-flex justify-content-center">{{ 'E-Mail Address' }}</label>

                                <div class="">
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

                            <div class="">
                                <label for="password" class="d-flex justify-content-center">{{ 'Password' }}</label>

                                <div class="">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                           
                            <div class="">
                                <div class="">
                                    <div class="mt-3 btn-block">
                                        <button type="submit" class="btn btn-primary col-12">
                                            {{ 'Login' }}
                                        </button>
                                    </div>     
                                    <div>
                                        <div class="form-check float-right">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ 'Remember Me' }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
