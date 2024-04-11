<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\CacheController;
use App\Http\Controllers\Admin\CategoryNews1;
use App\Http\Controllers\Admin\CategoryNews2;
use App\Http\Controllers\Admin\CategoryNews3;
use App\Http\Controllers\Admin\CategoryNews4;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryProduct1;
use App\Http\Controllers\Admin\CategoryProduct2;
use App\Http\Controllers\Admin\CategoryProduct3;
use App\Http\Controllers\Admin\CategoryProduct4;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SeopageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TagProductController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ContactController as ControllersContactController;
use App\Http\Controllers\NewsController as ControllersNewsController;
use App\Http\Controllers\NewsletterController as ControllersNewsletterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController as ControllersPageController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Auth::routes(['verify' => true]);
Route::get('refresh-csrf', function () {
    return csrf_token();
});
/* CLIENT */
Route::prefix('/')->group(function () {
    // Sitemap
    Route::get('sitemap', [SitemapController::class, 'index'])->name('sitemap');

    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // About
    Route::get('gioi-thieu', [ControllersPageController::class, 'about'])->name('about');

    // News
    Route::get('tin-tuc/{slug?}', [ControllersNewsController::class, 'index'])->name('news');

    // Policy
    Route::get('chinh-sach/{slug?}', [ControllersNewsController::class, 'policy'])->name('policy');

    // Product
    Route::get('san-pham/{slug?}', [ControllersProductController::class, 'index'])->name('product');
    Route::get("api_product", [ControllersProductController::class, 'api'])->name('api_product');

    // Contact
    Route::get('lien-he', [ControllersContactController::class, 'index'])->name('contact');
    Route::post('lien-he', [ControllersContactController::class, 'stored'])->name('contact.stored');

    // Search
    Route::get('tim-kiem', [SearchController::class, 'index'])->name('search');

    // Newsletter
    Route::post('newsletter', [ControllersNewsletterController::class, 'index'])->name('newsletter');

    // Pagging ajax
    Route::get('ajax_paginate', [HomeController::class, 'ajaxPaginate'])->name('ajax_paginate');

    // Order
    Route::prefix('gio-hang')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::get('add/{id}', [OrderController::class, 'add'])->name('order.add');
        Route::get('destroy', [OrderController::class, 'destroy'])->name('order.destroy');
        Route::delete('delete/{rowId}', [OrderController::class, 'remove'])->name('order.delete');
        Route::post('thanh-toan', [OrderController::class, 'checkout'])->name('order.checkout');
        Route::post('update_ajax', [OrderController::class, 'updateCartAjax'])->name('order.update_ajax');
    });
});

/* ADMIN */
Route::prefix('admin')->group(function () {
    // Clear cache web
    Route::get('clear_cache', [CacheController::class, 'index'])->name('admin.clear_cache');

    // Info login admin
    Route::get('login_info', function () {
        return view('admin.layouts.login_info');
    })->name('login_info')->middleware('admin.auth');

    // Login
    Route::get('/', [LoginController::class, 'showLoginForm']);
    Route::post('/', [LoginController::class, 'login'])->name('admin.login');

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('logout', [LoginController::class, 'logout']);

    // Password reset
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');

    // Password sendmail
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');

    // Password reset token
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

    // Password update
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('admin.password.update');

    // Dashboard Admin
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    // Product Admin
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product');
        Route::get('show/{id}', [ProductController::class, 'show'])->name('admin.product.show');
        Route::get('copy/{id}', [ProductController::class, 'copy'])->name('admin.product.copy');
        Route::get('create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::get('update_number', [ProductController::class, 'updateNumber'])->name('admin.product.update_number');
        Route::get('update_status', [ProductController::class, 'updateStatus'])->name('admin.product.update_status');
        Route::get('destroy', [ProductController::class, 'destroy'])->name('admin.product.destroy');
        Route::get('delete_photo/{id}/{action}', [ProductController::class, 'deletePhoto'])->name('admin.product.delete_photo');
        Route::get('gallery/delete/{id}/{photo}', [ProductController::class, 'deleteGallery'])->name('admin.product.gallery.delete');
        Route::delete('delete/{id}/{hash}', [ProductController::class, 'delete'])->name('admin.product.delete');
        Route::post('save', [ProductController::class, 'save'])->name('admin.product.save');
        Route::post('schema/{id}', [ProductController::class, 'schema'])->name('admin.product.schema');
        Route::post('filter_category', [ProductController::class, 'filterCategory'])->name('admin.product.filter_category');
        Route::post('gallery/{id}', [ProductController::class, 'gallery'])->name('admin.product.gallery');
        Route::post('gallery/title/{id}', [ProductController::class, 'galleryTitle'])->name('admin.product.gallery.title');
        Route::post('gallery/number/{id}', [ProductController::class, 'galleryNumber'])->name('admin.product.gallery.number');
        Route::put('update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
    });

    // Tag Product Admin
    Route::prefix('tag_product')->group(function () {
        Route::get('/', [TagProductController::class, 'index'])->name('admin.tag_product');
        Route::get('show/{id}', [TagProductController::class, 'show'])->name('admin.tag_product.show');
        Route::get('create', [TagProductController::class, 'create'])->name('admin.tag_product.create');
        Route::get('update_number', [TagProductController::class, 'updateNumber'])->name('admin.tag_product.update_number');
        Route::get('update_status', [TagProductController::class, 'updateStatus'])->name('admin.tag_product.update_status');
        Route::get('destroy', [TagProductController::class, 'destroy'])->name('admin.tag_product.destroy');
        Route::get('delete_photo/{id}/{action}', [TagProductController::class, 'deletePhoto'])->name('admin.tag_product.delete_photo');
        Route::delete('delete/{id}/{hash}', [TagProductController::class, 'delete'])->name('admin.tag_product.delete');
        Route::post('save', [TagProductController::class, 'save'])->name('admin.tag_product.save');
        Route::put('update/{id}', [TagProductController::class, 'update'])->name('admin.tag_product.update');
    });

    // Category Product Level1 Admin
    Route::prefix('category_product1')->group(function () {
        Route::get('/', [CategoryProduct1::class, 'index'])->name('admin.category_product1');
        Route::get('show/{id}', [CategoryProduct1::class, 'show'])->name('admin.category_product1.show');
        Route::get('copy/{id}', [CategoryProduct1::class, 'copy'])->name('admin.category_product1.copy');
        Route::get('create', [CategoryProduct1::class, 'create'])->name('admin.category_product1.create');
        Route::get('update_number', [CategoryProduct1::class, 'updateNumber'])->name('admin.category_product1.update_number');
        Route::get('update_status', [CategoryProduct1::class, 'updateStatus'])->name('admin.category_product1.update_status');
        Route::get('destroy', [CategoryProduct1::class, 'destroy'])->name('admin.category_product1.destroy');
        Route::get('delete_photo/{id}/{action}', [CategoryProduct1::class, 'deletePhoto'])->name('admin.category_product1.delete_photo');
        Route::delete('delete/{id}/{hash}', [CategoryProduct1::class, 'delete'])->name('admin.category_product1.delete');
        Route::post('save', [CategoryProduct1::class, 'save'])->name('admin.category_product1.save');
        Route::put('update/{id}', [CategoryProduct1::class, 'update'])->name('admin.category_product1.update');
    });

    // Category Product Level2 Admin
    Route::prefix('category_product2')->group(function () {
        Route::get('/', [CategoryProduct2::class, 'index'])->name('admin.category_product2');
        Route::get('show/{id}', [CategoryProduct2::class, 'show'])->name('admin.category_product2.show');
        Route::get('copy/{id}', [CategoryProduct2::class, 'copy'])->name('admin.category_product2.copy');
        Route::get('create', [CategoryProduct2::class, 'create'])->name('admin.category_product2.create');
        Route::get('update_number', [CategoryProduct2::class, 'updateNumber'])->name('admin.category_product2.update_number');
        Route::get('update_status', [CategoryProduct2::class, 'updateStatus'])->name('admin.category_product2.update_status');
        Route::get('destroy', [CategoryProduct2::class, 'destroy'])->name('admin.category_product2.destroy');
        Route::get('delete_photo/{id}/{action}', [CategoryProduct2::class, 'deletePhoto'])->name('admin.category_product2.delete_photo');
        Route::delete('delete/{id}/{hash}', [CategoryProduct2::class, 'delete'])->name('admin.category_product2.delete');
        Route::post('save', [CategoryProduct2::class, 'save'])->name('admin.category_product2.save');
        Route::put('update/{id}', [CategoryProduct2::class, 'update'])->name('admin.category_product2.update');
    });

    // Category Product Level3 Admin
    Route::prefix('category_product3')->group(function () {
        Route::get('/', [CategoryProduct3::class, 'index'])->name('admin.category_product3');
        Route::get('show/{id}', [CategoryProduct3::class, 'show'])->name('admin.category_product3.show');
        Route::get('copy/{id}', [CategoryProduct3::class, 'copy'])->name('admin.category_product3.copy');
        Route::get('create', [CategoryProduct3::class, 'create'])->name('admin.category_product3.create');
        Route::get('update_number', [CategoryProduct3::class, 'updateNumber'])->name('admin.category_product3.update_number');
        Route::get('update_status', [CategoryProduct3::class, 'updateStatus'])->name('admin.category_product3.update_status');
        Route::get('destroy', [CategoryProduct3::class, 'destroy'])->name('admin.category_product3.destroy');
        Route::get('delete_photo/{id}/{action}', [CategoryProduct3::class, 'deletePhoto'])->name('admin.category_product3.delete_photo');
        Route::delete('delete/{id}/{hash}', [CategoryProduct3::class, 'delete'])->name('admin.category_product3.delete');
        Route::post('save', [CategoryProduct3::class, 'save'])->name('admin.category_product3.save');
        Route::put('update/{id}', [CategoryProduct3::class, 'update'])->name('admin.category_product3.update');
    });

    // Category level 4 product admin
    Route::prefix('category_product4')->group(function () {
        Route::get('/', [CategoryProduct4::class, 'index'])->name('admin.category_product4');
        Route::get('show/{id}', [CategoryProduct4::class, 'show'])->name('admin.category_product4.show');
        Route::get('copy/{id}', [CategoryProduct4::class, 'copy'])->name('admin.category_product4.copy');
        Route::get('create', [CategoryProduct4::class, 'create'])->name('admin.category_product4.create');
        Route::get('update_number', [CategoryProduct4::class, 'updateNumber'])->name('admin.category_product4.update_number');
        Route::get('update_status', [CategoryProduct4::class, 'updateStatus'])->name('admin.category_product4.update_status');
        Route::get('destroy', [CategoryProduct4::class, 'destroy'])->name('admin.category_product4.destroy');
        Route::get('delete_photo/{id}/{action}', [CategoryProduct4::class, 'deletePhoto'])->name('admin.category_product4.delete_photo');
        Route::delete('delete/{id}/{hash}', [CategoryProduct4::class, 'delete'])->name('admin.category_product4.delete');
        Route::post('save', [CategoryProduct4::class, 'save'])->name('admin.category_product4.save');
        Route::put('update/{id}', [CategoryProduct4::class, 'update'])->name('admin.category_product4.update');
    });

    // News Admin
    Route::prefix('news')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('admin.news');
        Route::get('show/{id}', [NewsController::class, 'show'])->name('admin.news.show');
        Route::get('copy/{id}', [NewsController::class, 'copy'])->name('admin.news.copy');
        Route::get('create', [NewsController::class, 'create'])->name('admin.news.create');
        Route::get('update_number', [NewsController::class, 'updateNumber'])->name('admin.news.update_number');
        Route::get('update_status', [NewsController::class, 'updateStatus'])->name('admin.news.update_status');
        Route::get('destroy', [NewsController::class, 'destroy'])->name('admin.news.destroy');
        Route::get('delete_photo/{id}/{action}', [NewsController::class, 'deletePhoto'])->name('admin.news.delete_photo');
        Route::get('gallery/delete/{id}/{photo}', [NewsController::class, 'deleteGallery'])->name('admin.news.gallery.delete');
        Route::delete('delete/{id}/{hash}', [NewsController::class, 'delete'])->name('admin.news.delete');
        Route::post('save', [NewsController::class, 'save'])->name('admin.news.save');
        Route::post('schema/{id}', [NewsController::class, 'schema'])->name('admin.news.schema');
        Route::post('filter_category', [NewsController::class, 'filterCategory'])->name('admin.news.filter_category');
        Route::post('gallery/{id}', [NewsController::class, 'gallery'])->name('admin.news.gallery');
        Route::post('gallery/title/{id}', [NewsController::class, 'galleryTitle'])->name('admin.news.gallery.title');
        Route::post('gallery/number/{id}', [NewsController::class, 'galleryNumber'])->name('admin.news.gallery.number');
        Route::put('update/{id}', [NewsController::class, 'update'])->name('admin.news.update');
    });

    // Category News Level1 Admin
    Route::prefix('category_news1')->group(function () {
        Route::get('/', [CategoryNews1::class, 'index'])->name('admin.category_news1');
        Route::get('show/{id}', [CategoryNews1::class, 'show'])->name('admin.category_news1.show');
        Route::get('copy/{id}', [CategoryNews1::class, 'copy'])->name('admin.category_news1.copy');
        Route::get('create', [CategoryNews1::class, 'create'])->name('admin.category_news1.create');
        Route::get('update_number', [CategoryNews1::class, 'updateNumber'])->name('admin.category_news1.update_number');
        Route::get('update_status', [CategoryNews1::class, 'updateStatus'])->name('admin.category_news1.update_status');
        Route::get('destroy', [CategoryNews1::class, 'destroy'])->name('admin.category_news1.destroy');
        Route::get('delete_photo/{id}/{action}', [CategoryNews1::class, 'deletePhoto'])->name('admin.category_news1.delete_photo');
        Route::delete('delete/{id}/{hash}', [CategoryNews1::class, 'delete'])->name('admin.category_news1.delete');
        Route::post('save', [CategoryNews1::class, 'save'])->name('admin.category_news1.save');
        Route::put('update/{id}', [CategoryNews1::class, 'update'])->name('admin.category_news1.update');
    });

    // Category News Level2 Admin
    Route::prefix('category_news2')->group(function () {
        Route::get('/', [CategoryNews2::class, 'index'])->name('admin.category_news2');
        Route::get('show/{id}', [CategoryNews2::class, 'show'])->name('admin.category_news2.show');
        Route::get('copy/{id}', [CategoryNews2::class, 'copy'])->name('admin.category_news2.copy');
        Route::get('create', [CategoryNews2::class, 'create'])->name('admin.category_news2.create');
        Route::get('update_number', [CategoryNews2::class, 'updateNumber'])->name('admin.category_news2.update_number');
        Route::get('update_status', [CategoryNews2::class, 'updateStatus'])->name('admin.category_news2.update_status');
        Route::get('destroy', [CategoryNews2::class, 'destroy'])->name('admin.category_news2.destroy');
        Route::get('delete_photo/{id}/{action}', [CategoryNews2::class, 'deletePhoto'])->name('admin.category_news2.delete_photo');
        Route::delete('delete/{id}/{hash}', [CategoryNews2::class, 'delete'])->name('admin.category_news2.delete');
        Route::post('save', [CategoryNews2::class, 'save'])->name('admin.category_news2.save');
        Route::put('update/{id}', [CategoryNews2::class, 'update'])->name('admin.category_news2.update');
    });

    // Category News Level3 Admin
    Route::prefix('category_news3')->group(function () {
        Route::get('/', [CategoryNews3::class, 'index'])->name('admin.category_news3');
        Route::get('show/{id}', [CategoryNews3::class, 'show'])->name('admin.category_news3.show');
        Route::get('copy/{id}', [CategoryNews3::class, 'copy'])->name('admin.category_news3.copy');
        Route::get('create', [CategoryNews3::class, 'create'])->name('admin.category_news3.create');
        Route::get('update_number', [CategoryNews3::class, 'updateNumber'])->name('admin.category_news3.update_number');
        Route::get('update_status', [CategoryNews3::class, 'updateStatus'])->name('admin.category_news3.update_status');
        Route::get('destroy', [CategoryNews3::class, 'destroy'])->name('admin.category_news3.destroy');
        Route::get('delete_photo/{id}/{action}', [CategoryNews3::class, 'deletePhoto'])->name('admin.category_news3.delete_photo');
        Route::delete('delete/{id}/{hash}', [CategoryNews3::class, 'delete'])->name('admin.category_news3.delete');
        Route::post('save', [CategoryNews3::class, 'save'])->name('admin.category_news3.save');
        Route::put('update/{id}', [CategoryNews3::class, 'update'])->name('admin.category_news3.update');
    });

    // Category News Level4 Admin
    Route::prefix('category_news4')->group(function () {
        Route::get('/', [CategoryNews4::class, 'index'])->name('admin.category_news4');
        Route::get('show/{id}', [CategoryNews4::class, 'show'])->name('admin.category_news4.show');
        Route::get('copy/{id}', [CategoryNews4::class, 'copy'])->name('admin.category_news4.copy');
        Route::get('create', [CategoryNews4::class, 'create'])->name('admin.category_news4.create');
        Route::get('update_number', [CategoryNews4::class, 'updateNumber'])->name('admin.category_news4.update_number');
        Route::get('update_status', [CategoryNews4::class, 'updateStatus'])->name('admin.category_news4.update_status');
        Route::get('destroy', [CategoryNews4::class, 'destroy'])->name('admin.category_news4.destroy');
        Route::get('delete_photo/{id}/{action}', [CategoryNews4::class, 'deletePhoto'])->name('admin.category_news4.delete_photo');
        Route::delete('delete/{id}/{hash}', [CategoryNews4::class, 'delete'])->name('admin.category_news4.delete');
        Route::post('save', [CategoryNews4::class, 'save'])->name('admin.category_news4.save');
        Route::put('update/{id}', [CategoryNews4::class, 'update'])->name('admin.category_news4.update');
    });

    // Post Admin
    Route::prefix('post')->group(function () {
        Route::get('{type}', [PostController::class, 'index'])->name('admin.post');
        Route::get('show/{type}/{id}', [PostController::class, 'show'])->name('admin.post.show');
        Route::get('copy/{type}/{id}', [PostController::class, 'copy'])->name('admin.post.copy');
        Route::get('create/{type}', [PostController::class, 'create'])->name('admin.post.create');
        Route::get('update_number/{type}', [PostController::class, 'updateNumber'])->name('admin.post.update_number');
        Route::get('update_status/{type}', [PostController::class, 'updateStatus'])->name('admin.post.update_status');
        Route::get('destroy/{type}', [PostController::class, 'destroy'])->name('admin.post.destroy');
        Route::get('delete_photo/{type}/{id}/{action}', [PostController::class, 'deletePhoto'])->name('admin.post.delete_photo');
        Route::get('delete/{type}/{id}/{hash}', [PostController::class, 'delete'])->name('admin.post.delete');
        Route::post('save/{type}', [PostController::class, 'save'])->name('admin.post.save');
        Route::put('update/{type}/{id}', [PostController::class, 'update'])->name('admin.post.update');
        Route::post('schema/{type}/{id}', [PostController::class, 'schema'])->name('admin.post.schema');
    });

    // Contact admin
    Route::prefix('contact')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('admin.contact');
        Route::get('{id}', [ContactController::class, 'show'])->name('admin.contact.show');
        Route::post('destroy', [ContactController::class, 'destroy'])->name('admin.contact.destroy');
        Route::get('delete/{id}', [ContactController::class, 'delete'])->name('admin.contact.delete');
        Route::post('update_number', [ContactController::class, 'updateNumber'])->name('admin.contact.update_number');
    });

    Route::prefix('order')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('admin.order');
        Route::get('{code}', [AdminOrderController::class, 'show'])->name('admin.order.show');
        Route::post('destroy', [AdminOrderController::class, 'destroy'])->name('admin.order.destroy');
        Route::get('delete/{code}', [AdminOrderController::class, 'delete'])->name('admin.order.delete');
        Route::post('update/{code}', [AdminOrderController::class, 'update'])->name('admin.order.update');
    });

    // Place Admin
    Route::prefix('place')->group(function () {
        // City
        Route::prefix('city')->group(function () {
            Route::get('index/{type}', [PlaceController::class, 'index'])->name('admin.place.city.index');
            Route::get('create/{type}', [PlaceController::class, 'create'])->name('admin.place.city.create');
            Route::get('show/{id}/{type}', [PlaceController::class, 'show'])->name('admin.place.city.show');
            Route::get('destroy/{type}', [PlaceController::class, 'destroy'])->name('admin.place.city.destroy');
            Route::get('update_number', [PlaceController::class, 'updateNumber'])->name('admin.place.city.update_number');
            Route::post('save/{type}', [PlaceController::class, 'save'])->name('admin.place.city.save');
            Route::put('update/{id}/{type}', [PlaceController::class, 'update'])->name('admin.place.city.update');
            Route::delete('delete/{id}/{type}', [PlaceController::class, 'delete'])->name('admin.place.city.delete');
        });

        // District
        Route::prefix('district')->group(function () {
            Route::get('index/{type}', [PlaceController::class, 'index'])->name('admin.place.district.index');
            Route::get('create/{type}', [PlaceController::class, 'create'])->name('admin.place.district.create');
            Route::get('show/{id}/{type}', [PlaceController::class, 'show'])->name('admin.place.district.show');
            Route::get('destroy/{type}', [PlaceController::class, 'destroy'])->name('admin.place.district.destroy');
            Route::get('update_number', [PlaceController::class, 'updateNumber'])->name('admin.place.district.update_number');
            Route::post('save/{type}', [PlaceController::class, 'save'])->name('admin.place.district.save');
            Route::put('update/{id}/{type}', [PlaceController::class, 'update'])->name('admin.place.district.update');
            Route::delete('delete/{id}/{type}', [PlaceController::class, 'delete'])->name('admin.place.district.delete');
        });

        // Ward
        Route::prefix('ward')->group(function () {
            Route::get('index/{type}', [PlaceController::class, 'index'])->name('admin.place.ward.index');
            Route::get('create/{type}', [PlaceController::class, 'create'])->name('admin.place.ward.create');
            Route::get('show/{id}/{type}', [PlaceController::class, 'show'])->name('admin.place.ward.show');
            Route::get('destroy/{type}', [PlaceController::class, 'destroy'])->name('admin.place.ward.destroy');
            Route::get('update_number', [PlaceController::class, 'updateNumber'])->name('admin.place.ward.update_number');
            Route::post('save/{type}', [PlaceController::class, 'save'])->name('admin.place.ward.save');
            Route::put('update/{id}/{type}', [PlaceController::class, 'update'])->name('admin.place.ward.update');
            Route::delete('delete/{id}/{type}', [PlaceController::class, 'delete'])->name('admin.place.ward.delete');
        });
    });

    // Photo Multiple Admin
    Route::prefix('photo')->group(function () {
        // Slideshow Admin
        Route::prefix('slideshow')->group(function () {
            Route::get('/', [PhotoController::class, 'slideshowIndex'])->name('admin.photo.slideshow.index');
            Route::get('create', [PhotoController::class, 'slideshowCreate'])->name('admin.photo.slideshow.create');
            Route::get('show/{id}/{type}', [PhotoController::class, 'show'])->name('admin.photo.slideshow.show');
            Route::get('destroy/{type}', [PhotoController::class, 'destroy'])->name('admin.photo.slideshow.destroy');
            Route::get('update_number', [PhotoController::class, 'updateNumber'])->name('admin.photo.slideshow.update_number');
            Route::get('update_status', [PhotoController::class, 'updateStatus'])->name('admin.photo.slideshow.update_status');
            Route::get('delete_photo/{id}/{action}/{type}', [PhotoController::class, 'deletePhoto'])->name('admin.photo.slideshow.delete_photo');
            Route::post('{type}', [PhotoController::class, 'save'])->name('admin.photo.slideshow.save');
            Route::put('update/{id}/{type}', [PhotoController::class, 'update'])->name('admin.photo.slideshow.update');
            Route::delete('delete/{id}/{hash}/{type}', [PhotoController::class, 'delete'])->name('admin.photo.slideshow.delete');
        });

        // Partner Admin
        Route::prefix('partner')->group(function () {
            Route::get('/', [PhotoController::class, 'partnerIndex'])->name('admin.photo.partner.index');
            Route::get('create', [PhotoController::class, 'partnerCreate'])->name('admin.photo.partner.create');
            Route::get('destroy/{type}', [PhotoController::class, 'destroy'])->name('admin.photo.partner.destroy');
            Route::get('show/{id}/{type}', [PhotoController::class, 'show'])->name('admin.photo.partner.show');
            Route::get('update_number', [PhotoController::class, 'updateNumber'])->name('admin.photo.partner.update_number');
            Route::get('update_status', [PhotoController::class, 'updateStatus'])->name('admin.photo.partner.update_status');
            Route::get('copy/{id}/{type}', [PhotoController::class, 'copy'])->name('admin.photo.partner.copy');
            Route::get('delete_photo/{id}/{action}/{type}', [PhotoController::class, 'deletePhoto'])->name('admin.photo.partner.delete_photo');
            Route::post('{type}', [PhotoController::class, 'save'])->name('admin.photo.partner.save');
            Route::put('update/{id}/{type}', [PhotoController::class, 'update'])->name('admin.photo.partner.update');
            Route::delete('delete/{id}/{hash}/{type}', [PhotoController::class, 'delete'])->name('admin.photo.partner.delete');
        });

        // Social Footer Admin
        Route::prefix('social_footer')->group(function () {
            Route::get('/', [PhotoController::class, 'socialFooterIndex'])->name('admin.photo.social_footer.index');
            Route::get('create', [PhotoController::class, 'socialFooterCreate'])->name('admin.photo.social_footer.create');
            Route::get('destroy/{type}', [PhotoController::class, 'destroy'])->name('admin.photo.social_footer.destroy');
            Route::get('show/{id}/{type}', [PhotoController::class, 'show'])->name('admin.photo.social_footer.show');
            Route::get('update_number', [PhotoController::class, 'updateNumber'])->name('admin.photo.social_footer.update_number');
            Route::get('update_status', [PhotoController::class, 'updateStatus'])->name('admin.photo.social_footer.update_status');
            Route::get('copy/{id}/{type}', [PhotoController::class, 'copy'])->name('admin.photo.social_footer.copy');
            Route::get('delete_photo/{id}/{action}/{type}', [PhotoController::class, 'deletePhoto'])->name('admin.photo.social_footer.delete_photo');
            Route::post('{type}', [PhotoController::class, 'save'])->name('admin.photo.social_footer.save');
            Route::put('update/{id}/{type}', [PhotoController::class, 'update'])->name('admin.photo.social_footer.update');
            Route::delete('delete/{id}/{hash}/{type}', [PhotoController::class, 'delete'])->name('admin.photo.social_footer.delete');
        });

        // Photo Static Admin
        Route::get('logo', [PhotoController::class, 'logo'])->name('admin.photo.logo');
        Route::get('favicon', [PhotoController::class, 'favicon'])->name('admin.photo.favicon');
        Route::get('watermark_product', [PhotoController::class, 'watermarkProduct'])->name('admin.photo.watermark_product');
        Route::get('watermark_news', [PhotoController::class, 'watermarkNews'])->name('admin.photo.watermark_news');
        Route::get('static/remake/{type}/{id}/{hash}', [PhotoController::class, 'staticRemake'])->name('admin.photo.static.remake');
        Route::post('static/save/{type}/{id?}', [PhotoController::class, 'staticSave'])->name('admin.photo.static.save');
    });

    // Video Admin
    Route::prefix('video')->group(function () {
        // Video Multiple Admin
        Route::prefix('video_multiple')->group(function () {
            Route::get('/', [VideoController::class, 'videoMultipleIndex'])->name('admin.video.video_multiple.index');
            Route::get('create', [VideoController::class, 'videoMultipleCreate'])->name('admin.video.video_multiple.create');
            Route::get('show/{id}/{type}', [VideoController::class, 'show'])->name('admin.video.video_multiple.show');
            Route::get('destroy/{type}', [VideoController::class, 'destroy'])->name('admin.video.video_multiple.destroy');
            Route::get('update_number', [VideoController::class, 'updateNumber'])->name('admin.video.video_multiple.update_number');
            Route::get('update_status', [VideoController::class, 'updateStatus'])->name('admin.video.video_multiple.update_status');
            Route::post('{type}', [VideoController::class, 'save'])->name('admin.video.video_multiple.save');
            Route::put('update/{id}/{type}', [VideoController::class, 'update'])->name('admin.video.video_multiple.update');
            Route::delete('delete/{id}/{hash}/{type}', [VideoController::class, 'delete'])->name('admin.video.video_multiple.delete');
        });

        // Video Static Admin
        Route::prefix('video_static')->group(function () {
            Route::get('/', [VideoController::class, 'videoStaticIndex'])->name('admin.video.video_static.index');
            Route::get('static/remake/{type}/{id}/{hash}', [VideoController::class, 'videoStaticRemake'])->name('admin.video.video_static.remake');
            Route::post('save/{type}/{id?}', [VideoController::class, 'videoStaticSave'])->name('admin.video.video_static.save');
        });
    });

    // Page Admin
    Route::prefix('page')->group(function () {
        Route::get('{type}', [PageController::class, 'index'])->name('admin.page');
        Route::get('delete_photo/{type}/{id}/{action}', [PageController::class, 'deletePhoto'])->name('admin.page.delete_photo');
        Route::get('remake/{type}/{id}/{hash}', [PageController::class, 'remake'])->name('admin.page.remake');
        Route::post('save/{type}/{id?}', [PageController::class, 'save'])->name('admin.page.save');
    });

    // Seopage Admin
    Route::prefix('seopage')->group(function () {
        Route::get('{type}', [SeopageController::class, 'index'])->name('admin.seopage');
        Route::get('remake/{type}/{id}/{hash}', [SeopageController::class, 'remake'])->name('admin.seopage.remake');
        Route::post('save/{type}/{id?}', [SeopageController::class, 'save'])->name('admin.seopage.save');
    });

    // Newsletter Admin
    Route::prefix('newsletter')->group(function () {
        Route::get('/', [NewsletterController::class, 'index'])->name('admin.newsletter.index');
        Route::get('create', [NewsletterController::class, 'create'])->name('admin.newsletter.create');
        Route::get('{id}', [NewsletterController::class, 'show'])->name('admin.newsletter.show');
        Route::post('update_number', [NewsletterController::class, 'updateNumber'])->name('admin.newsletter.update_number');
        Route::post('destroy', [NewsletterController::class, 'destroy'])->name('admin.newsletter.destroy');
        Route::post('/', [NewsletterController::class, 'save'])->name('admin.newsletter.save');
        Route::post('sendmail', [NewsletterController::class, 'sendmail'])->name('admin.newsletter.sendmail');
        Route::put('update/{id}', [NewsletterController::class, 'update'])->name('admin.newsletter.update');
        Route::delete('news/delete/{id}', [NewsletterController::class, 'delete'])->name('admin.newsletter.delete');
    });

    // Setting Admin
    Route::get('setting', [SettingController::class, 'index'])->name('admin.setting');
    Route::post('save/{id?}', [SettingController::class, 'save'])->name('admin.setting.save');
});
