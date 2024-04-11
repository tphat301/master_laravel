@extends('admin.layouts.app')
@section('title', 'Đăng nhập admin')

@section('content')
    <div class="card login-admin" style="width: 414px;margin: 0 auto;">
        <div class="card-body"
            style="padding: 30px; display:flex; flex-direction: column;justify-content: center;word-wrap: break-word;">
            <h4 class="mb-2 text-center login-title">Đăng Nhập Hệ Thống</h4>
            <form id="formAuthentication" action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label login-admin__usernamelb" for="username">
                        Email or username
                    </label>
                    <input id="username" type="username"
                        class="form-control @error('username') is-invalid @enderror login-admin__username" name="username"
                        value="{{ old('username') }}" placeholder="Nhập email or username của bạn" autofocus />
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
                    <div class="d-flex justify-content-between flex-wrap">
                        <label class="form-label login-admin__forgotpass" for="password">{{ __('Password') }}</label>
                        <a href="{{ route('admin.password.request') }}" title="{{ __('Forgot Your Password?') }}">
                            <small>{{ __('Forgot Your Password?') }}</small>
                        </a>
                    </div>
                    <div class="d-flex col-md-12 position-relative">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror login-admin__password"
                            name="password" placeholder="Nhập mật khẩu của bạn" autocomplete="current-password" />
                        <svg class="eye-toggle-admin"
                            style="position: absolute; right: 10px; top:50%; transform: translateY(-50%); cursor: pointer;"
                            width="17" height="17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path
                                d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember-me"
                            {{ old('remember') ? 'checked' : '' }} />
                        <label class="form-check-label" for="remember-me"> {{ __('Remember Me') }} </label>
                    </div>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Login') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
