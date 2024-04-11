<?php

namespace App\Http\Controllers;

use App\Models\Admin\Page;
use App\Utils\Seo;
use App\Models\Admin\Seo as AdminSeo;
use App\Utils\BreadCrumbs;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PageController extends Controller
{
    public $seo;
    public $breadcrumbs;
    public function __construct()
    {
        $this->seo = new Seo();
        $this->breadcrumbs = new BreadCrumbs();
    }
    public function about()
    {
        $type = config('admin.page.gioi-thieu.type');
        /* Lấy giới thiệu */
        $row = Page::where('type', $type)->whereRaw('find_in_set("hienthi", status)')->first();
        /* SEO */
        $seoOnePage = AdminSeo::where('type', $type)->where('hash_seo', $row->hash)->first();
        $titleMain = !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $row->title;
        $seo = $this->seo;
        $this->seo->set('h1', !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $row->title);
        $this->seo->set('title', !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $row->title);
        $this->seo->set('keywords', !empty($seoOnePage->keywords) ? $seoOnePage->keywords : "");
        $this->seo->set('description', !empty($seoOnePage->description_seo) ? $seoOnePage->description_seo : "");
        $this->seo->set('url', config('app.url') . request()->path());
        $this->seo->set('type', 'article');

        if (!empty($row->photo1)) {
            $manager = new ImageManager(new Driver());
            $seoOnePagePhoto = $manager->read(public_path('upload/page/' . $row->photo1));
            $this->seo->set('photo', config('app.asset_url') . "upload/page/" . $row->photo1);
            $mime = strtolower(pathinfo('upload/page/' . $row->photo1, PATHINFO_EXTENSION));
            $this->seo->set('photo:width', $seoOnePagePhoto->width());
            $this->seo->set('photo:height', $seoOnePagePhoto->height());
            $this->seo->set('photo:type', "image/" . $mime);
        } else {
            $this->seo->set('photo', config('app.url') . "resources/images/noimage.png");
            $this->seo->set('photo:width', config('admin.page.gioi-thieu.with1'));
            $this->seo->set('photo:height', config('admin.page.gioi-thieu.height1'));
            $this->seo->set('photo:type', "image/png");
        }
        /* Breadcrumbs */
        $this->breadcrumbs->set($type, !empty($row->title) ? $row->title : $seoOnePage->title);
        $breadcrumbs = $this->breadcrumbs->get();
        /* Schema */
        $templeat = 'page';
        return view('page.index', compact('row', 'seo', 'breadcrumbs', 'titleMain', 'templeat'));
    }
}
