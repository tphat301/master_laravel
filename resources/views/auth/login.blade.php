@extends('welcome')
@section('title', 'Đăng nhập')
@section('content')
<div class="container auth-box">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h4 class="mb-2">Welcome to Login</h4>
          <p class="mb-4">
            Vui lòng đăng nhập vào tài khoản của bạn! Để nhận được các trải nghiệm tại website
          </p>
          <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label" for="username">Email or username</label>
              <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Email or username" autofocus/>
              @error('username')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">{{ __('Password') }}</label>
                <a href="{{ route('password.request') }}" title="{{ __('Forgot Your Password?') }}">
                  <small>{{ __('Forgot Your Password?') }}</small>
                </a>
              </div>
              <div class="input-group input-group-merge">
                <div class="d-flex w-100 position-relative">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password"  autocomplete="current-password"/>
                  <svg style="position: absolute; right: 10px; top:50%; transform: translateY(-50%); cursor: pointer;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                      <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                      <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                      <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
                    </svg>
                </div>
                @error('password')
                  <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember-me" {{ old('remember') ? 'checked' : '' }}/>
                <label class="form-check-label" for="remember-me"> {{ __('Remember Me') }} </label>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Login') }}</button>
            </div>
          </form>
          <p class="text-center">
            <span>Bạn đã có tài khoản chưa?</span>
            <a href="{{ route('register') }}">
              <span>Đăng ký ngay</span>
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
