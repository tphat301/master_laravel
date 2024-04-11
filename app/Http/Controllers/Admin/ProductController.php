<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CategoryProduct;
use App\Models\Admin\GalleryProduct;
use App\Models\Admin\Product;
use App\Models\Admin\Seo;
use App\Models\Admin\Setting;
use App\Models\Admin\TagProduct;
use App\Utils\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
  protected $helper;
  protected $type;
  protected $typeCategory1;
  protected $typeCategory2;
  protected $typeCategory3;
  protected $typeCategory4;
  protected $numberPerPage;
  protected $widthGallery;
  protected $width1;
  protected $width2;
  protected $width3;
  protected $width4;
  protected $heightGallery;
  protected $height1;
  protected $height2;
  protected $height3;
  protected $height4;
  protected $uploadProduct;
  public function __construct()
  {
    $this->middleware('admin.auth');
    $this->helper = new Helpers();
    $this->type = config("admin.san-pham.type");
    $this->typeCategory1 = config("admin." . $this->type . ".category.category1.type");
    $this->typeCategory2 = config("admin." . $this->type . ".category.category2.type");
    $this->typeCategory3 = config("admin." . $this->type . ".category.category3.type");
    $this->typeCategory4 = config("admin." . $this->type . ".category.category4.type");
    $this->numberPerPage = config("admin." . $this->type . ".number_per_page");
    $this->widthGallery = config("admin." . $this->type . ".gallery.width");
    $this->width1 = config("admin." . $this->type . ".width1");
    $this->width2 = config("admin." . $this->type . ".width2");
    $this->width3 = config("admin." . $this->type . ".width3");
    $this->width4 = config("admin." . $this->type . ".width4");
    $this->height1 = config("admin." . $this->type . ".height1");
    $this->height2 = config("admin." . $this->type . ".height2");
    $this->height3 = config("admin." . $this->type . ".height3");
    $this->height4 = config("admin." . $this->type . ".height4");
    $this->heightGallery = config("admin." . $this->type . ".gallery.height");
    $this->uploadProduct = "public/upload/product";
  }

  /* Select Category with level no pagging */
  public function getCategory($level)
  {
    switch ($level) {
      case 1:
        $type = $this->typeCategory1;
        break;
      case 2:
        $type = $this->typeCategory2;
        break;
      case 3:
        $type = $this->typeCategory3;
        break;
      case 4:
        $type = $this->typeCategory4;
        break;

      default:
        break;
    }
    $row = CategoryProduct::where('type', $type)->where('level', $level)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
    return $row;
  }

  /* Product list */
  public function index(Request $request)
  {
    $type = $this->type;
    session(['module_active' => $type]);
    $categoryAppendQueryString = ['category' => $request->category];
    $row1 = $this->getCategory(1);
    $row2 = $this->getCategory(2);
    $row3 = $this->getCategory(3);
    $row4 = $this->getCategory(4);
    $keyword = htmlspecialchars($request->input('keyword'));
    if ($keyword) {
      $rows = Product::where("title", "LIKE", "%{$keyword}%")->where('type', $type)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($this->numberPerPage)->appends($categoryAppendQueryString);
    } else {
      if ($request->category) {
        $rows = Product::where('type', $type)->where('id_parent1', $request->category)->orWhere('id_parent2', $request->category)->orWhere('id_parent3', $request->category)->orWhere('id_parent4', $request->category)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($this->numberPerPage)->appends($categoryAppendQueryString);
      } else {
        $rows = Product::where('type', $type)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($this->numberPerPage)->appends($categoryAppendQueryString);
      }
    }
    return view('admin.product.index', compact('rows', 'row1', 'row2', 'row3', 'row4', 'type'));
  }

  /* Product create */
  public function create()
  {
    $type = $this->type;
    $row1 = $this->getCategory(1);
    $row2 = $this->getCategory(2);
    $row3 = $this->getCategory(3);
    $row4 = $this->getCategory(4);
    session(['module_active' => $type]);
    return view('admin.product.create', compact('row1', 'row2', 'row3', 'row4', 'type'));
  }

  /* Product insert */
  public function save(Request $request)
  {
    $hashKey = Str::lower(Str::random(4));
    if (!file_exists($this->uploadProduct)) {
      mkdir($this->uploadProduct, 0777, true);
    }
    $validator = Validator::make(
      $request->all(),
      [
        'slug' => ['required', 'unique:products'],
        'title' => ['required', 'unique:products'],
        "photo1" => ['image', 'mimes:png,gif,jpg,jpeg,webp', 'max:20971520'],
        "photo2" => ['image', 'mimes:png,gif,jpg,jpeg,webp', 'max:20971520'],
        "photo3" => ['image', 'mimes:png,gif,jpg,jpeg,webp', 'max:20971520'],
        "photo4" => ['image', 'mimes:png,gif,jpg,jpeg,webp', 'max:20971520']
      ],
      [
        'required' => ':attribute không được để trống',
        'unique' => ':attribute đã tồn tại. :attribute truy cập mục này có thể bị trùng lặp.',
        'string' => ':attribute phải ở dạng chuỗi ký tự',
        'image' => ':attribute chỉ cho phép upload định dạng là hình ảnh.',
        'mimes' => ':attribute chỉ cho phép upload các định dạng :mimes',
        'max' => ':attribute chỉ cho upload tối đa là :max MB'
      ],
      [
        'slug' => 'Đường dẫn',
        'title' => 'Tiêu đề',
        'photo1' => 'Hình ảnh 1',
        'photo2' => 'Hình ảnh 2',
        'photo3' => 'Hình ảnh 3',
        'photo4' => 'Hình ảnh 4'
      ]
    );
    if (!$validator->fails()) {
      $manager = new ImageManager(new Driver());
      if ($request->hasFile('photo1')) {
        $image = $manager->read($request->photo1)->resize($this->width1, $this->height1);
        $photo1 = hexdec(uniqid()) . "." . $request->photo1->getClientOriginalName();
        $path = public_path('upload/product');
        $image->save($path . "/" . $photo1);
      }
      if ($request->hasFile('photo2')) {
        $image = $manager->read($request->photo2)->resize($this->width2, $this->height2);
        $photo2 = hexdec(uniqid()) . "." . $request->photo2->getClientOriginalName();
        $path = public_path('upload/product');
        $image->save($path . "/" . $photo2);
      }
      if ($request->hasFile('photo3')) {
        $image = $manager->read($request->photo3)->resize($this->width3, $this->height3);
        $photo3 = hexdec(uniqid()) . "." . $request->photo3->getClientOriginalName();
        $path = public_path('upload/product');
        $image->save($path . "/" . $photo3);
      }
      if ($request->hasFile('photo4')) {
        $image = $manager->read($request->photo4)->resize($this->width4, $this->height4);
        $photo4 = hexdec(uniqid()) . "." . $request->photo4->getClientOriginalName();
        $path = public_path('upload/product');
        $image->save($path . "/" . $photo4);
      }
      $data = [
        'slug' => htmlspecialchars($request->input('slug')),
        'title' => htmlspecialchars($request->input('title')),
        'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : 'hienthi',
        'code' => !empty($request->input('code')) ? htmlspecialchars($request->input('code')) : null,
        'quantity' => !empty($request->input('quantity')) ? htmlspecialchars($request->input('quantity')) : 1,
        'sale_price' => !empty($request->input('sale_price')) ? str_replace(',', '', $request->input('sale_price')) : 0,
        'regular_price' => !empty($request->input('regular_price')) ? str_replace(',', '', $request->input('regular_price')) : 0,
        'discount' => !empty($request->input('discount')) ? htmlspecialchars($request->input('discount')) : 0,
        'hash' => $hashKey,
        'type' => $this->type,
        'num' => !empty($request->input('num')) ? $request->input('num') : 0,
        'desc' => !empty($request->input('desc')) ? htmlspecialchars($request->input('desc')) : null,
        'content' => !empty($request->input('content')) ? htmlspecialchars($request->input('content')) : null,
        'photo1' => !empty($photo1) ? $photo1 : null,
        'photo2' => !empty($photo2) ? $photo2 : null,
        'photo3' => !empty($photo3) ? $photo3 : null,
        'photo4' => !empty($photo4) ? $photo4 : null,
        'id_parent1' => !empty($request->input('id_parent1')) ? $request->input('id_parent1') : 0,
        'id_parent2' => !empty($request->input('id_parent2')) ? $request->input('id_parent2') : 0,
        'id_parent3' => !empty($request->input('id_parent3')) ? $request->input('id_parent3') : 0,
        'id_parent4' => !empty($request->input('id_parent4')) ? $request->input('id_parent4') : 0
      ];
      Product::create($data);
      if ($request->input('title_seo')) {
        $dataSeo = [
          'title_seo' => htmlspecialchars($request->input('title_seo')),
          'hash_seo' => $hashKey,
          'type' => $this->type,
          'keywords' => !empty($request->input('keywords')) ? htmlspecialchars($request->input('keywords')) : null,
          'description_seo' => !empty($request->input('description_seo')) ? htmlspecialchars($request->input('description_seo')) : null
        ];
        Seo::create($dataSeo);
      }
      return $this->helper->transfer("Thêm dữ liệu", "success", route('admin.product'));
    } else {
      return redirect()->route('admin.product.create')->withErrors($validator)->withInput();
    }
  }

  /* Product detail */
  public function show(Request $request)
  {
    $type = $this->type;
    $row = Product::where('type', $type)->find($request->id);
    $tagProducts = TagProduct::where('type_tag_product', $type)->where('id_parent', $request->id)->get();
    $idTags = [];
    if ($tagProducts) {
      foreach ($tagProducts as $v) {
        $idTags[] = $v->id_tag;
      }
    }
    $tags = DB::table('tag')->where('type_tag', $type)->get();
    $row1 = $this->getCategory(1);
    $row2 = $this->getCategory(2);
    $row3 = $this->getCategory(3);
    $row4 = $this->getCategory(4);
    $rowSeo = Seo::where('type', $type)->where('hash_seo', $row->hash)->first();
    $rowGallery = GalleryProduct::where('type', $type)->where('id_parent', $request->id)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
    return view('admin.product.show', compact('row', 'tags', 'idTags', 'row1', 'row2', 'row3', 'row4', 'rowSeo', 'rowGallery', 'type'));
  }

  /* Product update */
  public function update(Request $request)
  {
    $product = Product::where('type', $this->type)->find($request->id);
    $tagRow = TagProduct::where('type_tag_product', $this->type)->where('id_parent', $product->id);
    if (!file_exists($this->uploadProduct)) {
      mkdir($this->uploadProduct, 0777, true);
    }
    $validator = Validator::make(
      $request->all(),
      [
        'slug' => ['required'],
        'title' => ['required'],
        "photo1" => ['image', 'mimes:png,gif,jpg,jpeg,webp', 'max:20971520'],
        "photo2" => ['image', 'mimes:png,gif,jpg,jpeg,webp', 'max:20971520'],
        "photo3" => ['image', 'mimes:png,gif,jpg,jpeg,webp', 'max:20971520'],
        "photo4" => ['image', 'mimes:png,gif,jpg,jpeg,webp', 'max:20971520']
      ],
      [
        'required' => ':attribute không được để trống',
        'unique' => ':attribute đã tồn tại. :attribute truy cập mục này có thể bị trùng lặp.',
        'string' => ':attribute phải ở dạng chuỗi ký tự',
        'image' => ':attribute chỉ cho phép upload định dạng là hình ảnh.',
        'mimes' => ':attribute chỉ cho phép upload các định dạng :mimes',
        'max' => ':attribute chỉ cho upload tối đa là :max MB'
      ],
      [
        'slug' => 'Đường dẫn',
        'title' => 'Tiêu đề',
        'photo1' => 'Hình ảnh 1',
        'photo2' => 'Hình ảnh 2',
        'photo3' => 'Hình ảnh 3',
        'photo4' => 'Hình ảnh 4'
      ]
    );
    if (!$validator->fails()) {
      $manager = new ImageManager(new Driver());
      if ($request->hasFile('photo1')) {
        $image = $manager->read($request->photo1)->resize($this->width1, $this->height1);
        $photo1 = hexdec(uniqid()) . "." . $request->photo1->getClientOriginalName();
        $path = public_path('upload/product');
        $image->save($path . "/" . $photo1);
      } else {
        $photo1 = isset($product->photo1) ? $product->photo1 : null;
      }
      if ($request->hasFile('photo2')) {
        $image = $manager->read($request->photo2)->resize($this->width2, $this->height2);
        $photo2 = hexdec(uniqid()) . "." . $request->photo2->getClientOriginalName();
        $path = public_path('upload/product');
        $image->save($path . "/" . $photo2);
      } else {
        $photo2 = isset($product->photo2) ? $product->photo2 : null;
      }
      if ($request->hasFile('photo3')) {
        $image = $manager->read($request->photo3)->resize($this->width3, $this->height3);
        $photo3 = hexdec(uniqid()) . "." . $request->photo3->getClientOriginalName();
        $path = public_path('upload/product');
        $image->save($path . "/" . $photo3);
      } else {
        $photo3 = isset($product->photo3) ? $product->photo3 : null;
      }
      if ($request->hasFile('photo4')) {
        $image = $manager->read($request->photo4)->resize($this->width4, $this->height4);
        $photo4 = hexdec(uniqid()) . "." . $request->photo4->getClientOriginalName();
        $path = public_path('upload/product');
        $image->save($path . "/" . $photo4);
      } else {
        $photo4 = isset($product->photo4) ? $product->photo4 : null;
      }
      $data = [
        'slug' => htmlspecialchars($request->input('slug')),
        'title' => htmlspecialchars($request->input('title')),
        'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : '',
        'code' => !empty($request->input('code')) ? htmlspecialchars($request->input('code')) : null,
        'quantity' => !empty($request->input('quantity')) ? htmlspecialchars($request->input('quantity')) : 1,
        'sale_price' => !empty($request->input('sale_price')) ? str_replace(',', '', $request->input('sale_price')) : 0,
        'regular_price' => !empty($request->input('regular_price')) ? str_replace(',', '', $request->input('regular_price')) : 0,
        'discount' => !empty($request->input('discount')) ? htmlspecialchars($request->input('discount')) : 0,
        'num' => !empty($request->input('num')) ? $request->input('num') : 0,
        'desc' => !empty($request->input('desc')) ? htmlspecialchars($request->input('desc')) : null,
        'content' => !empty($request->input('content')) ? htmlspecialchars($request->input('content')) : null,
        'photo1' => !empty($photo1) ? $photo1 : null,
        'photo2' => !empty($photo2) ? $photo2 : null,
        'photo3' => !empty($photo3) ? $photo3 : null,
        'photo4' => !empty($photo4) ? $photo4 : null,
        'id_parent1' => !empty($request->input('id_parent1')) ? $request->input('id_parent1') : 0,
        'id_parent2' => !empty($request->input('id_parent2')) ? $request->input('id_parent2') : 0,
        'id_parent3' => !empty($request->input('id_parent3')) ? $request->input('id_parent3') : 0,
        'id_parent4' => !empty($request->input('id_parent4')) ? $request->input('id_parent4') : 0
      ];
      $product->update($data);
      if ($request->input('title_seo')) {
        $dataSeo = [
          'title_seo' => htmlspecialchars($request->input('title_seo')),
          'keywords' => !empty($request->input('keywords')) ? htmlspecialchars($request->input('keywords')) : null,
          'description_seo' => !empty($request->input('description_seo')) ? htmlspecialchars($request->input('description_seo')) : null,
          'schema' => !empty($request->input('schema')) ? htmlspecialchars($request->input('schema')) : null,
          'hash_seo' => $product->hash,
          'type' => $this->type,
          'id_parent' => !empty($product->id) ? $product->id  : null
        ];
        $seo = Seo::where('hash_seo', $product->hash)->first();
        if ($seo) {
          Seo::where('hash_seo', $product->hash)->update($dataSeo);
        } else {
          Seo::create($dataSeo);
        }
      }
      $tags = $request->dataTags;
      if ($tags) {
        if ($tagRow->get()) $tagRow->delete();
        foreach ($tags as $tag) {
          TagProduct::create([
            'id_tag' => $tag,
            'id_parent' => $product->id,
            'type_tag_product' => $this->type
          ]);
        }
      }
      return $this->helper->transfer("Cập nhật dữ liệu", "success", route('admin.product.show', ['id' => $product->id]));
    } else {
      return redirect()->route('admin.product.show', ['id' => $product->id])->withErrors($validator)->withInput();
    }
  }

  /* Product duplicate */
  public function copy($id)
  {
    $row = Product::where('type', $this->type)->find($id);
    $titleCopy = $row->title . " copy " . str_repeat(Str::lower(Str::random(4)), 1);
    $slugCopy = $this->helper->changeTitle($titleCopy);
    Product::create(
      [
        'slug' => htmlspecialchars($slugCopy),
        'title' => htmlspecialchars($titleCopy),
        'code' => !empty($row->code) ? htmlspecialchars($row->code) : null,
        'desc' => !empty($row->desc) ? htmlspecialchars(htmlspecialchars_decode($row->desc)) : null,
        'content' => !empty($row->content) ? htmlspecialchars(htmlspecialchars_decode($row->content)) : null,
        'type' => $this->type,
        'num' => 0,
        'quantity' => 1,
        'hash' => Str::lower(Str::random(4)),
        'status' => 'hienthi',
        'id_parent1' => !empty($row->id_parent1) ? $row->id_parent1 : 0,
        'id_parent2' => !empty($row->id_parent2) ? $row->id_parent2 : 0,
        'id_parent3' => !empty($row->id_parent3) ? $row->id_parent3 : 0,
        'id_parent4' => !empty($row->id_parent4) ? $row->id_parent4 : 0,
      ]
    );
    return $this->helper->transfer("Sao chép dữ liệu", "success", route('admin.product'));
  }

  /* Product delete static */
  public function delete($id, $hash)
  {
    $uploadWatermarkProduct = "public/upload/wk_product/";
    $uploadProduct = "public/upload/product/";
    $uploadGallery = "public/upload/gallery/";
    $product = Product::where('type', $this->type)->where('hash', $hash)->find($id);
    $seo = SEO::where('type', $this->type)->where('hash_seo', $hash);
    $gallerys = GalleryProduct::where('type', $this->type)->where('id_parent', $id);
    $photo1 = isset($product->photo1) && !empty($product->photo1) ? $product->photo1 : "";
    $photo2 = isset($product->photo2) && !empty($product->photo2) ? $product->photo2 : "";
    $photo3 = isset($product->photo3) && !empty($product->photo3) ? $product->photo3 : "";
    $photo4 = isset($product->photo4) && !empty($product->photo4) ? $product->photo4 : "";
    if (file_exists($uploadProduct . $photo1) && !empty($photo1)) unlink($uploadProduct . $photo1);
    if (file_exists($uploadProduct . $photo2) && !empty($photo2)) unlink($uploadProduct . $photo2);
    if (file_exists($uploadProduct . $photo3) && !empty($photo3)) unlink($uploadProduct . $photo3);
    if (file_exists($uploadProduct . $photo4) && !empty($photo4)) unlink($uploadProduct . $photo4);
    if (file_exists($uploadWatermarkProduct . $photo1) && !empty($photo1)) unlink($uploadWatermarkProduct . $photo1);
    if (file_exists($uploadWatermarkProduct . $photo2) && !empty($photo2)) unlink($uploadWatermarkProduct . $photo2);
    if (file_exists($uploadWatermarkProduct . $photo3) && !empty($photo3)) unlink($uploadWatermarkProduct . $photo3);
    if (file_exists($uploadWatermarkProduct . $photo4) && !empty($photo4)) unlink($uploadWatermarkProduct . $photo4);
    if ($gallerys->get()) {
      foreach ($gallerys->get() as $gallery) {
        $galleryPhoto = isset($gallery->photo) && !empty($gallery->photo) ? $gallery->photo : "";
        if (file_exists($uploadGallery . $galleryPhoto) && !empty($galleryPhoto)) unlink($uploadGallery . $galleryPhoto);
      }
    }
    $product->delete();
    $seo->delete();
    $gallerys->delete();
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.product'));
  }

  /* Product delete mutiple */
  public function destroy(Request $request)
  {
    $uploadWatermarkProduct = "public/upload/wk_product/";
    $uploadProduct = "public/upload/product/";
    $uploadGallery = "public/upload/gallery/";
    $product = Product::where('type', $this->type)->find($request->checkitem);
    $idParent = [];
    foreach ($product as $v) {
      $photo1 = isset($v->photo1) && !empty($v->photo1) ? $v->photo1 : "";
      $photo2 = isset($v->photo2) && !empty($v->photo2) ? $v->photo2 : "";
      $photo3 = isset($v->photo3) && !empty($v->photo3) ? $v->photo3 : "";
      $photo4 = isset($v->photo4) && !empty($v->photo4) ? $v->photo4 : "";
      if (file_exists($uploadProduct . $photo1) && !empty($photo1)) unlink($uploadProduct . $photo1);
      if (file_exists($uploadProduct . $photo2) && !empty($photo2)) unlink($uploadProduct . $photo2);
      if (file_exists($uploadProduct . $photo3) && !empty($photo3)) unlink($uploadProduct . $photo3);
      if (file_exists($uploadProduct . $photo4) && !empty($photo4)) unlink($uploadProduct . $photo4);
      if (file_exists($uploadWatermarkProduct . $photo1) && !empty($photo1)) unlink($uploadWatermarkProduct . $photo1);
      if (file_exists($uploadWatermarkProduct . $photo2) && !empty($photo2)) unlink($uploadWatermarkProduct . $photo2);
      if (file_exists($uploadWatermarkProduct . $photo3) && !empty($photo3)) unlink($uploadWatermarkProduct . $photo3);
      if (file_exists($uploadWatermarkProduct . $photo4) && !empty($photo4)) unlink($uploadWatermarkProduct . $photo4);
      $idParent[] = $v->id;
    }
    if (count($idParent) > 0) {
      foreach ($idParent as $v) {
        $gallerys = GalleryProduct::where('type', $this->type)->where('id_parent', $v);
        if ($gallerys->get()) {
          foreach ($gallerys->get() as $gallery) {
            $galleryPhoto = isset($gallery->photo) && !empty($gallery->photo) ? $gallery->photo : "";
            if (file_exists($uploadGallery . $galleryPhoto) && !empty($galleryPhoto)) unlink($uploadGallery . $galleryPhoto);
          }
        }
        $gallerys->delete();
      }
    }
    Seo::where('type', $this->type)->whereIn('hash_seo', $request->hashes)->delete();
    Product::destroy($request->checkitem);
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.product'));
  }

  /* Product update number ajax */
  public function updateNumber(Request $request)
  {
    Product::where('id', $request->id)->where('type', $this->type)->update(['num' => $request->value]);
  }

  /* Product update status ajax */
  public function updateStatus(Request $request)
  {
    $status = Product::select('status')->where('type', $this->type)->find($request->id)->status;
    $status = !empty($status) ? explode(',', $status) : [];
    if (array_search($request->value, $status) !== false) {
      $key = array_search($request->value, $status);
      unset($status[$key]);
    } else {
      array_push($status, $request->value);
    }
    $statusStr = implode(',', $status);
    Product::where('id', $request->id)->where('type', $this->type)->update(['status' => $statusStr]);
  }

  /* Product delete photo */
  public function deletePhoto(Request $request)
  {
    $uploadProduct = "public/upload/product/";
    $action = $request->action;
    $photo = Product::where('type', $this->type)->find($request->id)->$action;
    $photo = isset($photo) && !empty($photo) ? $photo : "";
    if (file_exists($uploadProduct . $photo) && !empty($photo)) unlink($uploadProduct . $photo);
    Product::where('id', $request->id)->where('type', $this->type)->update([$action => null]);
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.product.show', ['id' => $request->id]));
  }

  /* Product schema JSON */
  public function schema(Request $request)
  {
    $row = Product::where('type', $this->type)->find($request->id);
    $seo = Seo::where('type', $this->type)->where('hash_seo', $row->hash)->first();
    if ($seo) {
      $photo = !empty($row->photo1 ? config('app.asset_url') . "upload/product/$row->photo1" : config('app.url') . "resources/images/noimage.png");
      $setting = Setting::where('type', config('admin.setting.type'))->first();
      $schemaJSON = $this->helper->buildSchemaProduct($row->id, $row->title, $photo, $row->code, !empty($setting->title) ? $setting->title : 'Name brand', htmlspecialchars_decode($row->desc), $row->sale_price, !empty($setting->title) ? $setting->title : 'Author', config('app.url') . "product/" . $row->slug);
      Seo::where('type', $this->type)->where('hash_seo', $row->hash)->update(['schema' => $schemaJSON]);
      return $this->helper->transfer("Tạo schema JSON", "success", route('admin.product.show', ['id' => $row->id]));
    } else {
      return $this->helper->transfer("Bạn cần có Data SEO để tạo Schema JSON Product. Thao tác tạo schema JSON", "danger", route('admin.product.show', ['id' => $row->id]));
    }
  }

  /* Product gallery */
  public function gallery(Request $request)
  {
    $uploadGallery = "public/upload/gallery/";
    if (!file_exists($uploadGallery)) {
      mkdir($uploadGallery, 0777, true);
    }
    $validator = Validator::make(
      $request->all(),
      [
        "file" => ['image', 'mimes:png,jpg,jpeg,webp', 'max:20971520'],
      ],
      [
        'image' => ':attribute chỉ cho phép upload định dạng là hình ảnh.',
        'mimes' => ':attribute chỉ cho phép upload các định dạng :mimes',
        'max' => ':attribute chỉ cho upload tối đa là :max MB',
      ],
      [
        "file" => 'Hình ảnh'
      ]
    );
    if (!$validator->fails()) {
      $manager = new ImageManager(new Driver());
      if ($request->hasFile('file')) {
        $image = $manager->read($request->file)->resize($this->widthGallery, $this->heightGallery);
        $photo = hexdec(uniqid()) . "." . $request->file->getClientOriginalName();
        $path = public_path('upload/gallery');
        $image->save($path . "/" . $photo);
        $dataGallery = [
          'photo' => $photo,
          'id_parent' => $request->id,
          'title' => pathinfo($photo, PATHINFO_FILENAME),
          'status' => "hienthi",
          'num' => 0,
          'type' => $this->type
        ];
        GalleryProduct::create($dataGallery);
      }
    } else {
      return $this->helper->transfer("Thêm dữ liệu", "danger", route('admin.product'));
    }
  }

  /* Product gallery delete */
  public function deleteGallery(Request $request)
  {
    $uploadGallery = "public/upload/gallery/";
    $galleryPhoto = GalleryProduct::where('type', $this->type)->find($request->id)->photo;
    $galleryPhoto = isset($galleryPhoto) && !empty($galleryPhoto) ? $galleryPhoto : "";
    if (file_exists($uploadGallery . $galleryPhoto) && !empty($galleryPhoto)) unlink($uploadGallery . $galleryPhoto);
    GalleryProduct::where('type', $this->type)->where('id', $request->id)->delete();
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.product'));
  }

  /* Product gallery update title */
  public function galleryTitle(Request $request)
  {
    @$id = $request->id;
    @$title = $request->value;
    GalleryProduct::where('type', $this->type)->where('id', $id)->update(['title' => $title]);
  }

  /* Product gallery update number */
  public function galleryNumber(Request $request)
  {
    @$id = $request->id;
    @$num = $request->value;
    GalleryProduct::where('type', $this->type)->where('id', $id)->update(['num' => $num]);
  }

  /* Product filter category */
  public function filterCategory(Request $request)
  {
    $id = $request->id;
    if ($id) {
      $row = CategoryProduct::where('type', $this->type)->where('id_parent', $id)->get();
      if (!empty($row)) {
        $output = '<option value="0">Chọn danh mục</option>';
        foreach ($row as $v) {
          $output .= '<option value="' . $v->id . '">' . $v->title . '</option>';
        }
      }
    } else {
      $output = '<option value="0">Chọn danh mục</option>';
    }
    echo $output;
  }
}
