<?php

namespace App\Providers;

use App\Models\Admin\CategoryNews;
use App\Models\Admin\CategoryProduct;
use App\Models\Admin\News;
use App\Models\Admin\Page;
use App\Models\Admin\Photo;
use App\Models\Admin\Setting;
use App\Utils\Helpers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        $helper = new Helpers();
        $currentPath = $request->path();

        // Static query
        $slogan = Page::where('type', config('admin.page.slogan.type'))->whereRaw('find_in_set("hienthi", status)')->first();
        $copyright = Page::where('type', config('admin.page.copyright.type'))->whereRaw('find_in_set("hienthi", status)')->first();
        $footer = Page::where('type', config('admin.page.footer.type'))->whereRaw('find_in_set("hienthi", status)')->first();

        // Multiple query
        $logo = Photo::where('type', config('admin.photo.logo.type'))->where('action', 'static')->whereRaw('find_in_set("hienthi", status)')->first();
        $favicon = Photo::where('type', config('admin.photo.favicon.type'))->where('action', 'static')->whereRaw('find_in_set("hienthi", status)')->first();
        $slideshow = Photo::where('type', config('admin.photo.slideshow.type'))->where('action', 'multiple')->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
        $socialFooter = Photo::where('type', config('admin.photo.social_footer.type'))->where('action', 'multiple')->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();

        $categoryProduct1 = CategoryProduct::where('type', config('admin.san-pham.type'))->where('level', 1)->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
        $categoryNews1 = CategoryNews::where('type', config('admin.tin-tuc.type'))->where('level', 1)->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
        $policy = News::where('type', config('admin.post.chinh-sach.type'))->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
        $setting = Setting::where('type', config('admin.setting.type'))->first();
        $options = isset($setting->options) ? json_decode($setting->options) : [];
        View::share(
            [
                'slideshow' => $slideshow,
                'logo' => $logo,
                'favicon' => $favicon,
                'slogan' => $slogan,
                'categoryProduct1' => $categoryProduct1,
                'categoryNews1' => $categoryNews1,
                'currentPath' => $currentPath,
                'setting' => $setting,
                'options' => $options,
                'helper' => $helper,
                'copyright' => $copyright,
                'footer' => $footer,
                'socialFooter' => $socialFooter,
                'policy' => $policy
            ]
        );
    }
}
