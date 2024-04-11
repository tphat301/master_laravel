<?php

namespace App\Http\Controllers;

use App\Models\Admin\Product;
use App\Utils\BreadCrumbs;
use App\Utils\Seo;
use Illuminate\Http\Request;

class SearchController extends Controller
{
  public $seo;
  public $type;
  public $breadcrumbs;
  public function __construct()
  {
    $this->seo = new Seo();
    $this->type =  config('admin.san-pham.type');
    $this->breadcrumbs = new BreadCrumbs();
  }
  public function index(Request $request)
  {
    /* SEO */
    $seo = $this->seo;
    $this->seo->set('h1', "Tìm kiếm");
    $this->seo->set('title', "Tìm kiếm");
    $this->seo->set('keywords', "Tìm kiếm");
    $this->seo->set('description', "Tìm kiếm");
    $this->seo->set('url', config('app.url') . $request->path());
    $this->seo->set('type', 'object');
    $this->seo->set('photo:type', "");
    $this->seo->set('photo', "");
    $this->seo->set('photo:width', "");
    $this->seo->set('photo:height', "");
    $titleMain = "Tìm kiếm";
    $keyword = htmlspecialchars($request->keyword);
    $rows = Product::where('type', $this->type)->where("title", "LIKE", "%{$keyword}%")->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate(20);
    // Breadcrumbs
    $this->breadcrumbs->set('', "Tìm kiếm");
    $breadcrumbs = $this->breadcrumbs->get();
    return view('product.index', compact('rows', 'breadcrumbs', 'titleMain', 'seo'));
  }
}
