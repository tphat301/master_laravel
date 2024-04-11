<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{

  use AuthenticatesUsers;
  use ThrottlesLogins;
  protected $maxAttempts = 5; // Số lần đăng nhập không thành công tối đa
  protected $decayMinutes = 1; // Thời gian đợi trước khi số lần đăng nhập lại được reset
  public function __construct()
  {
    $this->middleware('admin.guest')->except('logout');
  }

  protected function guard()
  {
    return Auth::guard('admin');
  }

  public function showLoginForm()
  {
    return view('admin.auth.login');
  }

  protected function redirectTo()
  {
    return route('admin.dashboard');
  }

  protected function loggedOut(Request $request)
  {
    return $request->wantsJson()
      ? new JsonResponse([], 204)
      : redirect()->route('admin.login');
  }
}
