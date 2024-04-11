<?php

namespace App\Http\Controllers;

use App\Models\Admin\CategoryProduct;
use App\Models\Admin\News;
use App\Models\Admin\Photo;
use App\Models\Admin\Product;
use App\Models\Admin\Seopage;
use App\Utils\Seo;
use App\Utils\Watermark;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    private $watermark;
    private $seo;
    public function __construct()
    {
        $this->watermark = new Watermark();
        $this->watermark->watermarkProduct();
        /* SEO */
        $this->seo = new Seo();
        $seoPage = Seopage::where('type', config('admin.seopage.home.type'))->first();
        $this->seo->set('h1', !empty($seoPage->title) ? $seoPage->title : '');
        $this->seo->set('title', !empty($seoPage->title) ? $seoPage->title : '');
        $this->seo->set('keywords', !empty($seoPage->keywords) ? $seoPage->keywords : '');
        $this->seo->set('description', !empty($seoPage->description) ? $seoPage->description : '');
        $this->seo->set('url', config('app.url'));
        $this->seo->set('type', 'website');
        $this->seo->set('photo:type', "image/jpeg");
        if (!empty($seoPage->photo)) {
            $manager = new ImageManager(new Driver());
            $seoPagePhoto = $manager->read(public_path('upload/seopage/' . $seoPage->photo));
            $this->seo->set('photo', config('app.asset_url') . "upload/seopage/" . $seoPage->photo);
            $this->seo->set('photo:width', $seoPagePhoto->width());
            $this->seo->set('photo:height', $seoPagePhoto->height());
        } else {
            $this->seo->set('photo', config('app.url') . "resources/images/noimage.png");
            $this->seo->set('photo:width', config('admin.seopage.home.with'));
            $this->seo->set('photo:height', config('admin.seopage.home.height'));
        }
    }
    public function ajaxPaginate(Request $request)
    {
        if ($request->ajax()) {
            $prdHot = Product::where('type', config('admin.san-pham.type'))->whereRaw('find_in_set("noibat", status)')->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate(10, '*', 'prdh');
            return view('api.ajax_paginate', compact('prdHot'))->render();
        }
    }

    public function index(Request $request)
    {
        $seo = $this->seo;
        $prdBestSeller = Product::where('type', config('admin.san-pham.type'))->whereRaw('find_in_set("banchay", status)')->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
        $prdHot = Product::where('type', config('admin.san-pham.type'))->whereRaw('find_in_set("noibat", status)')->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate(10, '*', 'prdh');
        $news = News::where('type', config('admin.tin-tuc.type'))->whereRaw('find_in_set("noibat", status)')->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
        $videos = Photo::where('type', config('admin.video.video_multiple.type'))->where('action', config('admin.video.video_multiple.action'))->whereRaw('find_in_set("noibat", status)')->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
        $prdCategory1 = CategoryProduct::where('type', config('admin.san-pham.type'))->where('level', 1)->whereRaw('find_in_set("noibat", status)')->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
        $partner = Photo::where('type', config('admin.photo.partner.type'))->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
        return view('home.index', compact('seo', 'prdBestSeller', 'prdHot', 'news', 'videos', 'prdCategory1', 'partner'));
    }
}
