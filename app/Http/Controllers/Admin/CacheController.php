<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Utils\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CacheController extends Controller
{
  protected $helper;
  public function __construct()
  {
    $this->middleware('admin.auth');
    $this->helper = new Helpers();
  }

  public function index()
  {
    Artisan::call('cache:clear');
    return $this->helper->transfer("Xóa cache trình duyệt", "success", route('admin.dashboard'));
  }
}
