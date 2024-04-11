<?php

namespace App\Http\Controllers;

use App\Models\Admin\CategoryProduct;
use App\Models\Admin\GalleryProduct;
use App\Models\Admin\Product;
use App\Models\Admin\Seo as AdminSeo;
use App\Models\Admin\Seopage;
use App\Utils\BreadCrumbs;
use App\Utils\Helpers;
use App\Utils\Seo;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public $helper;
    public $type;
    public $seo;
    public $breadcrumbs;
    public function __construct()
    {
        $this->helper = new Helpers();
        $this->seo = new Seo();
        $this->type = config('admin.san-pham.type');
        $this->breadcrumbs = new BreadCrumbs();
    }

    public function index(Request $request)
    {
        @$id = $this->helper->getIdByNameId($request->slug);
        @$slug = $this->helper->getSlugByNameId($request->slug);
        if (!empty($id)) {
            $data = CategoryProduct::where('type', $this->type)->where('slug', $slug)->where('id', $id)->whereRaw('find_in_set("hienthi", status)')->first();
            if ($data) {
                if ($data->level == '1') {
                    /* SEO */
                    $seoOnePage = AdminSeo::where('type', $this->type)->where('hash_seo', $data->hash)->first();
                    $titleMain = !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $data->title;
                    $seo = $this->seo;
                    $this->seo->set('h1', !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $data->title);
                    $this->seo->set('title', !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $data->title);
                    $this->seo->set('keywords', !empty($seoOnePage->keywords) ? $seoOnePage->keywords : "");
                    $this->seo->set('description', !empty($seoOnePage->description_seo) ? $seoOnePage->description_seo : "");
                    $this->seo->set('url', config('app.url') . $request->path());
                    $this->seo->set('type', 'object');

                    if (!empty($data->photo1)) {
                        $manager = new ImageManager(new Driver());
                        $seoOnePagePhoto = $manager->read(public_path('upload/category_product1/' . $data->photo1));
                        $this->seo->set('photo', config('app.asset_url') . "upload/category_product1/" . $data->photo1);
                        $mime = strtolower(pathinfo('upload/category_product1/' . $data->photo1, PATHINFO_EXTENSION));
                        $this->seo->set('photo:width', $seoOnePagePhoto->width());
                        $this->seo->set('photo:height', $seoOnePagePhoto->height());
                        $this->seo->set('photo:type', "image/" . $mime);
                    } else {
                        $this->seo->set('photo', config('app.url') . "resources/images/noimage.png");
                        $this->seo->set('photo:width', config('admin.san-pham.category.category1.width1'));
                        $this->seo->set('photo:height', config('admin.san-pham.category.category1.height1'));
                        $this->seo->set('photo:type', "image/png");
                    }
                    /* Lấy sản phẩm */
                    $rows = Product::where('type', $this->type)->where('id_parent1', $id)->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate(20);
                    /* Breadcrumbs */
                    $this->breadcrumbs->set($this->type, "Sản phẩm");
                    $this->breadcrumbs->set($this->type . "/" . $data->slug . '-i-' . $id, $data->title);
                    $breadcrumbs = $this->breadcrumbs->get();
                    return view('product.index', compact('rows', 'breadcrumbs', 'seo', 'titleMain'));
                } elseif ($data->level == '2') {
                    /* SEO */
                    $seoOnePage = AdminSeo::where('type', $this->type)->where('hash_seo', $data->hash)->first();
                    $titleMain = !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $data->title;
                    $seo = $this->seo;
                    $this->seo->set('h1', !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $data->title);
                    $this->seo->set('title', !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $data->title);
                    $this->seo->set('keywords', !empty($seoOnePage->keywords) ? $seoOnePage->keywords : "");
                    $this->seo->set('description', !empty($seoOnePage->description_seo) ? $seoOnePage->description_seo : "");
                    $this->seo->set('url', config('app.url') . $request->path());
                    $this->seo->set('type', 'object');
                    if (!empty($data->photo1)) {
                        $manager = new ImageManager(new Driver());
                        $seoOnePagePhoto = $manager->read(public_path("upload/category_product2/" . $data->photo1));
                        $this->seo->set('photo', config('app.asset_url') . "upload/category_product2/" . $data->photo1);
                        $mime = strtolower(pathinfo('upload/category_product2/' . $data->photo1, PATHINFO_EXTENSION));
                        $this->seo->set('photo:width', $seoOnePagePhoto->width());
                        $this->seo->set('photo:height', $seoOnePagePhoto->height());
                        $this->seo->set('photo:type', "image/" . $mime);
                    } else {
                        $this->seo->set('photo', config('app.url') . "resources/images/noimage.png");
                        $this->seo->set('photo:width', config('admin.san-pham.category.category2.width1'));
                        $this->seo->set('photo:height', config('admin.san-pham.category.category2.height1'));
                        $this->seo->set('photo:type', "image/png");
                    }
                    /* Lấy sản phẩm cấp 2 */
                    $row2 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $id)->where('level', 2)->first();
                    /* Lấy sản phẩm cấp 1 */
                    $row1 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $row2->id_parent)->where('level', 1)->first();
                    /* Lấy sản phẩm */
                    $rows = Product::where('type', $this->type)->where('id_parent2', $id)->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate(20);
                    // Breadcrumbs
                    $this->breadcrumbs->set($this->type, "Sản phẩm");
                    if (!empty($row1->title)) {
                        $this->breadcrumbs->set($this->type . "/" . $row1->slug . '-i-' . $row1->id, $row1->title);
                    }
                    if (!empty($row2->title)) {
                        $this->breadcrumbs->set($this->type . "/" . $row2->slug . '-i-' . $row2->id, $row2->title);
                    }
                    $breadcrumbs = $this->breadcrumbs->get();
                    return view('product.index', compact('rows', 'breadcrumbs', 'seo', 'titleMain'));
                } elseif ($data->level == '3') {
                    /* SEO */
                    $seoOnePage = AdminSeo::where('type', $this->type)->where('hash_seo', $data->hash)->first();
                    $titleMain = !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $data->title;
                    $seo = $this->seo;
                    $this->seo->set('h1', !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $data->title);
                    $this->seo->set('title', !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $data->title);
                    $this->seo->set('keywords', !empty($seoOnePage->keywords) ? $seoOnePage->keywords : "");
                    $this->seo->set('description', !empty($seoOnePage->description_seo) ? $seoOnePage->description_seo : "");
                    $this->seo->set('url', config('app.url') . $request->path());
                    $this->seo->set('type', 'object');
                    if (!empty($data->photo1)) {
                        $manager = new ImageManager(new Driver());
                        $seoOnePagePhoto = $manager->read(public_path("upload/category_product3/" . $data->photo1));
                        $this->seo->set('photo', config('app.asset_url') . "upload/category_product3/" . $data->photo1);
                        $mime = strtolower(pathinfo('upload/category_product3/' . $data->photo1, PATHINFO_EXTENSION));
                        $this->seo->set('photo:width', $seoOnePagePhoto->width());
                        $this->seo->set('photo:height', $seoOnePagePhoto->height());
                        $this->seo->set('photo:type', "image/" . $mime);
                    } else {
                        $this->seo->set('photo', config('app.url') . "resources/images/noimage.png");
                        $this->seo->set('photo:width', config('admin.san-pham.category.category3.width1'));
                        $this->seo->set('photo:height', config('admin.san-pham.category.category3.height1'));
                        $this->seo->set('photo:type', "image/png");
                    }
                    /* Lấy sản phẩm cấp 3 */
                    $row3 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $id)->where('level', 3)->first();
                    /* Lấy sản phẩm cấp 2 */
                    $row2 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $row3->id_parent)->where('level', 2)->first();
                    /* Lấy sản phẩm cấp 1 */
                    $row1 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $row2->id_parent)->where('level', 1)->first();
                    /* Lấy sản phẩm */
                    $rows = Product::where('type', $this->type)->where('id_parent3', $id)->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate(20);
                    // Breadcrumbs
                    $this->breadcrumbs->set($this->type, "Sản phẩm");
                    if (!empty($row1->title)) {
                        $this->breadcrumbs->set($this->type . "/" . $row1->slug . "-i-" . $row1->id, $row1->title);
                    }
                    if (!empty($row2->title)) {
                        $this->breadcrumbs->set($this->type . "/" . $row2->slug . "-i-" . $row2->id, $row2->title);
                    }
                    if (!empty($row3->title)) {
                        $this->breadcrumbs->set($this->type . "/" . $row3->slug . "-i-" . $row3->id, $row3->title);
                    }
                    $breadcrumbs = $this->breadcrumbs->get();
                    return view('product.index', compact('rows', 'breadcrumbs', 'seo', 'titleMain'));
                } else {
                    /* SEO */
                    $seoOnePage = AdminSeo::where('type', $this->type)->where('hash_seo', $data->hash)->first();
                    $titleMain = !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $data->title;
                    $seo = $this->seo;
                    $this->seo->set('h1', !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $data->title);
                    $this->seo->set('title', !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $data->title);
                    $this->seo->set('keywords', !empty($seoOnePage->keywords) ? $seoOnePage->keywords : "");
                    $this->seo->set('description', !empty($seoOnePage->description_seo) ? $seoOnePage->description_seo : "");
                    $this->seo->set('url', config('app.url') . $request->path());
                    $this->seo->set('type', 'object');
                    if (!empty($data->photo1)) {
                        $manager = new ImageManager(new Driver());
                        $seoOnePagePhoto = $manager->read(public_path("upload/category_product4/" . $data->photo1));
                        $this->seo->set('photo', config('app.asset_url') . "upload/category_product4/" . $data->photo1);
                        $mime = strtolower(pathinfo('upload/category_product4/' . $data->photo1, PATHINFO_EXTENSION));
                        $this->seo->set('photo:type', "image/" . $mime);
                        $this->seo->set('photo:width', $seoOnePagePhoto->width());
                        $this->seo->set('photo:height', $seoOnePagePhoto->height());
                    } else {
                        $this->seo->set('photo', config('app.url') . "resources/images/noimage.png");
                        $this->seo->set('photo:width', config('admin.san-pham.category.category4.width1'));
                        $this->seo->set('photo:height', config('admin.san-pham.category.category4.height1'));
                        $this->seo->set('photo:type', "image/png");
                    }
                    /* Lấy sản phẩm cấp 4 */
                    $row4 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $id)->where('level', 4)->first();
                    /* Lấy sản phẩm cấp 3 */
                    $row3 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $row4->id_parent)->where('level', 3)->first();
                    /* Lấy sản phẩm cấp 2 */
                    $row2 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $row3->id_parent)->where('level', 2)->first();
                    /* Lấy sản phẩm cấp 1 */
                    $row1 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $row2->id_parent)->where('level', 1)->first();
                    /* Lấy sản phẩm */
                    $rows = Product::where('type', $this->type)->where('id_parent4', $id)->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate(20);
                    /* Breadcrumbs */
                    $this->breadcrumbs->set($this->type, "Sản phẩm");
                    if (!empty($row1->title)) {
                        $this->breadcrumbs->set($this->type . "/" . $row1->slug . "-i-" . $row1->id, $row1->title);
                    }
                    if (!empty($row2->title)) {
                        $this->breadcrumbs->set($this->type . "/" . $row2->slug . "-i-" . $row2->id, $row2->title);
                    }
                    if (!empty($row3->title)) {
                        $this->breadcrumbs->set($this->type . "/" . $row3->slug . "-i-" . $row3->id, $row3->title);
                    }
                    if (!empty($row4->title)) {
                        $this->breadcrumbs->set($this->type . "/" . $row4->slug . "-i-" . $row4->id, $row4->title);
                    }
                    $breadcrumbs = $this->breadcrumbs->get();
                    return view('product.index', compact('rows', 'breadcrumbs', 'seo', 'titleMain'));
                }
            } else {
                /* Lấy chi tiết sản phẩm */
                $row = Product::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->find($id);
                /* Lấy sản phẩm cấp 1 */
                $row1 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $row->id_parent1)->where('level', 1)->first();
                /* Lấy sản phẩm cấp 2 */
                $row2 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $row->id_parent2)->where('level', 2)->first();
                /* Lấy sản phẩm cấp 3 */
                $row3 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $row->id_parent3)->where('level', 3)->first();
                /* Lấy sản phẩm cấp 4 */
                $row4 = CategoryProduct::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->where('id', $row->id_parent4)->where('level', 4)->first();
                /* Lấy thư viện ảnh con */
                $rowGallery = GalleryProduct::where('type', $this->type)->where('id_parent', $row->id)->whereRaw('find_in_set("hienthi", status)')->get();
                /* Lấy sản phẩm cùng danh mục cấp 1  */
                $rowSame = Product::where('type', $this->type)->where('id', '<>', $row->id)->where('id_parent1', $row->id_parent1)->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate(20);
                /* Xử lý SEO */
                $seoOnePage = AdminSeo::where('type', $this->type)->where('hash_seo', $row->hash)->first();
                $titleMain = !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $row->title;
                $seo = $this->seo;
                $this->seo->set('h1', !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $row->title);
                $this->seo->set('title', !empty($seoOnePage->title_seo) ? $seoOnePage->title_seo : $row->title);
                $this->seo->set('keywords', !empty($seoOnePage->keywords) ? $seoOnePage->keywords : "");
                $this->seo->set('description', !empty($seoOnePage->description_seo) ? $seoOnePage->description_seo : "");
                $this->seo->set('schema', !empty($seoOnePage->schema) ? $seoOnePage->schema : "");
                $this->seo->set('url', config('app.url') . $request->path());
                $this->seo->set('type', 'article');
                if (!empty($row->photo1)) {
                    $manager = new ImageManager(new Driver());
                    $seoOnePagePhoto = $manager->read(public_path('upload/product/' . $row->photo1));
                    $this->seo->set('photo', config('app.asset_url') . "upload/product/" . $row->photo1);
                    $mime = strtolower(pathinfo('upload/product/' . $row->photo1, PATHINFO_EXTENSION));
                    $this->seo->set('photo:type', "image/" . $mime);
                    $this->seo->set('photo:width', $seoOnePagePhoto->width());
                    $this->seo->set('photo:height', $seoOnePagePhoto->height());
                } else {
                    $this->seo->set('photo', config('app.url') . "resources/images/noimage.png");
                    $this->seo->set('photo:width', config('admin.san-pham.width1'));
                    $this->seo->set('photo:height', config('admin.san-pham.height1'));
                    $this->seo->set('photo:type', "image/png");
                }
                /* Breadcrums */
                $this->breadcrumbs->set($this->type, "Sản phẩm");
                if (!empty($row1->title)) {
                    $this->breadcrumbs->set($this->type . "/" . $row1->slug . "-i-" . $row1->id, $row1->title);
                }
                if (!empty($row2->title)) {
                    $this->breadcrumbs->set($this->type . "/" . $row2->slug . "-i-" . $row2->id, $row2->title);
                }
                if (!empty($row3->title)) {
                    $this->breadcrumbs->set($this->type . "/" . $row3->slug . "-i-" . $row3->id, $row3->title);
                }
                if (!empty($row4->title)) {
                    $this->breadcrumbs->set($this->type . "/" . $row4->slug . "-i-" . $row4->id, $row4->title);
                }
                $this->breadcrumbs->set($this->type . "/" . $row->slug . "-i-" . $row->id, $row->title);
                $breadcrumbs = $this->breadcrumbs->get();
                return view('product.show', compact('row', 'rowGallery', 'rowSame', 'breadcrumbs', 'seo', 'titleMain'));
            }
        } else {
            /* Danh sách sản phẩm */
            $titleMain = "Sản phẩm";
            $seo = $this->seo;
            $seoPage = Seopage::where('type', config('admin.seopage.san-pham.type'))->first();
            $this->seo->set('h1', !empty($seoPage->title) ? $seoPage->title : "Sản phẩm");
            $this->seo->set('title', !empty($seoPage->title) ? $seoPage->title : "Sản phẩm");
            $this->seo->set('keywords', !empty($seoPage->keywords) ? $seoPage->keywords : "");
            $this->seo->set('description', !empty($seoPage->description) ? $seoPage->description : "");
            $this->seo->set('url', config('app.url') . $request->path());
            $this->seo->set('type', 'object');
            if (!empty($seoPage->photo)) {
                $manager = new ImageManager(new Driver());
                $seoPagePhoto = $manager->read(public_path('upload/seopage/' . $seoPage->photo));
                $this->seo->set('photo', config('app.asset_url') . "upload/seopage/" . $seoPage->photo);
                $mime = strtolower(pathinfo('upload/seopage/' . $seoPage->photo, PATHINFO_EXTENSION));
                $this->seo->set('photo:width', $seoPagePhoto->width());
                $this->seo->set('photo:height', $seoPagePhoto->height());
                $this->seo->set('photo:type', "image/" . $mime);
            } else {
                $this->seo->set('photo', config('app.url') . "resources/images/noimage.png");
                $this->seo->set('photo:width', config('admin.seopage.san-pham.with'));
                $this->seo->set('photo:height', config('admin.seopage.san-pham.height'));
                $this->seo->set('photo:type', "image/png");
            }
            /* Breadcrumbs */
            $this->breadcrumbs->set($this->type, "Sản phẩm");
            $rows = Product::where('type', $this->type)->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate(20);
            $breadcrumbs = $this->breadcrumbs->get();
            return view('product.index', compact('rows', 'breadcrumbs', 'titleMain', 'seo'));
        }
    }

    /* Product tab ajax */
    public function api(Request $request)
    {
        if ($request->ajax()) {
            @$id = $request->get('id');
            if ($id == 0) {
                $rows = Product::where('type', $this->type)->whereRaw('find_in_set("noibat", status)')->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->limit(10)->get();
            } else {
                $rows = Product::where('type', $this->type)->where('id_parent1', $id)->whereRaw('find_in_set("noibat", status)')->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->limit(10)->get();
            }
            return view('api.product', compact('rows'))->render();
        }
    }
}
