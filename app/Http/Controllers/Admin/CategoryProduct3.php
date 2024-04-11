<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CategoryProduct;
use App\Models\Admin\Seo;
use App\Utils\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryProduct3 extends Controller
{
  protected $helper;
  protected $numberPerPage;
  protected $type;
  protected $typeCategory2;
  protected $typeCategory3;
  protected $uploadCategoryProduct;
  protected $width1;
  protected $width2;
  protected $width3;
  protected $width4;
  protected $height1;
  protected $height2;
  protected $height3;
  protected $height4;
  public function __construct()
  {
    $this->middleware('admin.auth');
    $this->helper = new Helpers();
    $this->type = config('admin.san-pham.type');
    $this->typeCategory2 = config('admin.' . $this->type . '.category.category2.type');
    $this->typeCategory3 = config('admin.' . $this->type . '.category.category3.type');
    $this->numberPerPage = config('admin.' . $this->type . '.category.category3.number_per_page');
    $this->uploadCategoryProduct = "public/upload/category_product3";
    $this->width1 = config('admin.' . $this->type . '.category.category3.width1');
    $this->width2 = config('admin.' . $this->type . '.category.category3.width2');
    $this->width3 = config('admin.' . $this->type . '.category.category3.width3');
    $this->width4 = config('admin.' . $this->type . '.category.category3.width4');
    $this->height1 = config('admin.' . $this->type . '.category.category3.height1');
    $this->height2 = config('admin.' . $this->type . '.category.category3.height2');
    $this->height3 = config('admin.' . $this->type . '.category.category3.height3');
    $this->height4 = config('admin.' . $this->type . '.category.category3.height4');
  }

  /* Category product list */
  public function index(Request $request)
  {
    $type = $this->type;
    $level = '3';
    session(['module_active' => $type . '-3']);
    $categoryAppendQueryString = ['category' => $request->category];
    $row2 = CategoryProduct::where('type', $type)->where('level', 2)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
    $keyword = htmlspecialchars($request->input('keyword'));
    if ($keyword) {
      $rows = CategoryProduct::where("title", "LIKE", "%{$keyword}%")->where('type', $this->typeCategory3)->where('level', 3)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($this->numberPerPage)->appends($categoryAppendQueryString);
    } else {
      if ($request->category) {
        $rows = CategoryProduct::where('type', $this->typeCategory3)->orWhere('id_parent', $request->category)->where('level', 3)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($this->numberPerPage)->appends($categoryAppendQueryString);
      } else {
        $rows = CategoryProduct::where('type', $this->typeCategory3)->where('level', 3)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($this->numberPerPage)->appends($categoryAppendQueryString);
      }
    }
    return view('admin.category_product_level3.index', compact('rows', 'row2', 'type', 'level'));
  }

  /* Category product create */
  public function create()
  {
    $type = $this->type;
    $level = '3';
    session(['module_active' => $type . '-3']);
    $rowCategory1 = CategoryProduct::where('type', $this->typeCategory3)->where('level', 2)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
    return view('admin.category_product_level3.create', compact('rowCategory1', 'type', 'level'));
  }

  /* Category product insert */
  public function save(Request $request)
  {
    $hashKey = Str::lower(Str::random(4));
    if (!file_exists($this->uploadCategoryProduct)) {
      mkdir($this->uploadCategoryProduct, 0777, true);
    }
    $validator = Validator::make(
      $request->all(),
      [
        'slug' => ['required', 'unique:category_products'],
        'title' => ['required', 'unique:category_products'],
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
        $path = public_path('upload/category_product3');
        $image->save($path . "/" . $photo1);
      }
      if ($request->hasFile('photo2')) {
        $image = $manager->read($request->photo2)->resize($this->width2, $this->height2);
        $photo2 = hexdec(uniqid()) . "." . $request->photo2->getClientOriginalName();
        $path = public_path('upload/category_product3');
        $image->save($path . "/" . $photo2);
      }
      if ($request->hasFile('photo3')) {
        $image = $manager->read($request->photo3)->resize($this->width3, $this->height3);
        $photo3 = hexdec(uniqid()) . "." . $request->photo3->getClientOriginalName();
        $path = public_path('upload/category_product3');
        $image->save($path . "/" . $photo3);
      }
      if ($request->hasFile('photo4')) {
        $image = $manager->read($request->photo4)->resize($this->width4, $this->height4);
        $photo4 = hexdec(uniqid()) . "." . $request->photo4->getClientOriginalName();
        $path = public_path('upload/category_product3');
        $image->save($path . "/" . $photo4);
      }
      $data = [
        'slug' => htmlspecialchars($request->input('slug')),
        'title' => htmlspecialchars($request->input('title')),
        'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : 'hienthi',
        'type' => $this->typeCategory3,
        'desc' => !empty($request->input('desc')) ? htmlspecialchars($request->input('desc')) : null,
        'content' => !empty($request->input('content')) ? htmlspecialchars($request->input('content')) : null,
        'photo1' => !empty($photo1) ? $photo1 : null,
        'photo2' => !empty($photo2) ? $photo2 : null,
        'photo3' => !empty($photo3) ? $photo3 : null,
        'photo4' => !empty($photo4) ? $photo4 : null,
        'level' => 3,
        'id_parent' => !empty($request->input('id_parent1')) ? htmlspecialchars($request->input('id_parent1')) : 0,
        'num' => !empty($request->input('num')) ? $request->input('num') : 0,
        'hash' => $hashKey
      ];
      CategoryProduct::create($data);
      if ($request->input('title_seo')) {
        $dataSeo = [
          'title_seo' => htmlspecialchars($request->input('title_seo')),
          'hash_seo' => $hashKey,
          'type' => $this->typeCategory3,
          'keywords' => !empty($request->input('keywords')) ? htmlspecialchars($request->input('keywords')) : null,
          'description_seo' => !empty($request->input('description_seo')) ? htmlspecialchars($request->input('description_seo')) : null,
        ];
        Seo::create($dataSeo);
      }
      return $this->helper->transfer("Thêm dữ liệu", "success", route('admin.category_product3'));
    } else {
      return redirect()->route('admin.category_product3.create')->withErrors($validator)->withInput();
    }
  }

  /* Category product detail */
  public function show(Request $request)
  {
    $type = $this->type;
    $level = '3';
    $row = CategoryProduct::where('type', $this->typeCategory3)->find($request->id);
    $rowSeo = Seo::where('type', $this->typeCategory3)->where('hash_seo', $row->hash)->first();
    $rowCategory1 = CategoryProduct::where('type', $this->typeCategory2)->where('level', 2)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
    return view('admin.category_product_level3.show', compact('row', 'rowSeo', 'rowCategory1', 'type', 'level'));
  }

  /* Category product update */
  public function update(Request $request)
  {
    $categoryProduct = CategoryProduct::where('type', $this->typeCategory3)->find($request->id);
    if (!file_exists($this->uploadCategoryProduct)) {
      mkdir($this->uploadCategoryProduct, 0777, true);
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
        $path = public_path('upload/category_product3');
        $image->save($path . "/" . $photo1);
      } else {
        $photo1 = isset($categoryProduct->photo1) ? $categoryProduct->photo1 : null;
      }
      if ($request->hasFile('photo2')) {
        $image = $manager->read($request->photo2)->resize($this->width2, $this->height2);
        $photo2 = hexdec(uniqid()) . "." . $request->photo2->getClientOriginalName();
        $path = public_path('upload/category_product3');
        $image->save($path . "/" . $photo2);
      } else {
        $photo2 = isset($categoryProduct->photo2) ? $categoryProduct->photo2 : null;
      }
      if ($request->hasFile('photo3')) {
        $image = $manager->read($request->photo3)->resize($this->width3, $this->height3);
        $photo3 = hexdec(uniqid()) . "." . $request->photo3->getClientOriginalName();
        $path = public_path('upload/category_product3');
        $image->save($path . "/" . $photo3);
      } else {
        $photo3 = isset($categoryProduct->photo3) ? $categoryProduct->photo3 : null;
      }
      if ($request->hasFile('photo4')) {
        $image = $manager->read($request->photo4)->resize($this->width4, $this->height4);
        $photo4 = hexdec(uniqid()) . "." . $request->photo4->getClientOriginalName();
        $path = public_path('upload/category_product3');
        $image->save($path . "/" . $photo4);
      } else {
        $photo4 = isset($categoryProduct->photo4) ? $categoryProduct->photo4 : null;
      }
      $data = [
        'slug' => htmlspecialchars($request->input('slug')),
        'title' => htmlspecialchars($request->input('title')),
        'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : '',
        'num' => !empty($request->input('num')) ? $request->input('num') : 0,
        'desc' => !empty($request->input('desc')) ? htmlspecialchars($request->input('desc')) : null,
        'content' => !empty($request->input('content')) ? htmlspecialchars($request->input('content')) : null,
        'photo1' => !empty($photo1) ? $photo1 : null,
        'photo2' => !empty($photo2) ? $photo2 : null,
        'photo3' => !empty($photo3) ? $photo3 : null,
        'photo4' => !empty($photo4) ? $photo4 : null,
        'id_parent' => !empty($request->input('id_parent1')) ? htmlspecialchars($request->input('id_parent1')) : 0,
      ];
      $categoryProduct->update($data);
      if ($request->input('title_seo')) {
        $dataSeo = [
          'title_seo' => htmlspecialchars($request->input('title_seo')),
          'keywords' => !empty($request->input('keywords')) ? htmlspecialchars($request->input('keywords')) : null,
          'description_seo' => !empty($request->input('description_seo')) ? htmlspecialchars($request->input('description_seo')) : null,
          'schema' => !empty($request->input('schema')) ? htmlspecialchars($request->input('schema')) : null,
          'hash_seo' => $categoryProduct->hash,
          'type' => $this->typeCategory3,
          'id_parent' => !empty($categoryProduct->id) ? $categoryProduct->id  : null
        ];
        $seo = Seo::where('hash_seo', $categoryProduct->hash)->first();
        if ($seo) {
          Seo::where('hash_seo', $categoryProduct->hash)->update($dataSeo);
        } else {
          Seo::create($dataSeo);
        }
      }
      return $this->helper->transfer("Cập nhật dữ liệu", "success", route('admin.category_product3.show', ['id' => $categoryProduct->id]));
    } else {
      return redirect()->route('admin.category_product3.show', ['id' => $categoryProduct->id])->withErrors($validator)->withInput();
    }
  }

  /* Category product duplicate */
  public function copy($id)
  {
    $row = CategoryProduct::where('type', $this->typeCategory3)->find($id);
    $titleCopy = $row->title . " copy " . str_repeat(Str::lower(Str::random(4)), 1);
    $slugCopy = $this->helper->changeTitle($titleCopy);
    CategoryProduct::create(
      [
        'slug' => htmlspecialchars($slugCopy),
        'title' => htmlspecialchars($titleCopy),
        'desc' => !empty($row->desc) ? htmlspecialchars(htmlspecialchars_decode($row->desc)) : null,
        'content' => !empty($row->content) ? htmlspecialchars(htmlspecialchars_decode($row->content)) : null,
        'type' => $this->typeCategory3,
        'num' => 0,
        'id_parent' => 0,
        'level' => 3,
        'hash' => Str::lower(Str::random(4)),
        'status' => 'hienthi'
      ]
    );
    return $this->helper->transfer("Thêm dữ liệu", "success", route('admin.category_product3'));
  }

  /* Category product delete static */
  public function delete($id, $hash)
  {
    $upload = "public/upload/category_product3/";
    $categoryProduct = CategoryProduct::where('type', $this->typeCategory3)->where('hash', $hash)->find($id);
    $seo = SEO::where('type', $this->typeCategory3)->where('hash_seo', $hash);
    $photo1 = isset($categoryProduct->photo1) && !empty($categoryProduct->photo1) ? $categoryProduct->photo1 : "";
    $photo2 = isset($categoryProduct->photo2) && !empty($categoryProduct->photo2) ? $categoryProduct->photo2 : "";
    $photo3 = isset($categoryProduct->photo3) && !empty($categoryProduct->photo3) ? $categoryProduct->photo3 : "";
    $photo4 = isset($categoryProduct->photo4) && !empty($categoryProduct->photo4) ? $categoryProduct->photo4 : "";
    if (file_exists($upload . $photo1) && !empty($photo1)) unlink($upload . $photo1);
    if (file_exists($upload . $photo2) && !empty($photo2)) unlink($upload . $photo2);
    if (file_exists($upload . $photo3) && !empty($photo3)) unlink($upload . $photo3);
    if (file_exists($upload . $photo4) && !empty($photo4)) unlink($upload . $photo4);
    $categoryProduct->delete();
    $seo->delete();
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.category_product3'));
  }

  /* Category product delete mutiple */
  public function destroy(Request $request)
  {
    $upload = "public/upload/category_product3/";
    $categoryProduct = CategoryProduct::where('type', $this->typeCategory3)->find($request->checkitem);
    foreach ($categoryProduct as $v) {
      $photo1 = isset($v->photo1) && !empty($v->photo1) ? $v->photo1 : "";
      $photo2 = isset($v->photo2) && !empty($v->photo2) ? $v->photo2 : "";
      $photo3 = isset($v->photo3) && !empty($v->photo3) ? $v->photo3 : "";
      $photo4 = isset($v->photo4) && !empty($v->photo4) ? $v->photo4 : "";
      if (file_exists($upload . $photo1) && !empty($photo1)) unlink($upload . $photo1);
      if (file_exists($upload . $photo2) && !empty($photo2)) unlink($upload . $photo2);
      if (file_exists($upload . $photo3) && !empty($photo3)) unlink($upload . $photo3);
      if (file_exists($upload . $photo4) && !empty($photo4)) unlink($upload . $photo4);
    }
    Seo::where('type', $this->typeCategory3)->whereIn('hash_seo', $request->hashes)->delete();
    CategoryProduct::destroy($request->checkitem);
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.category_product3'));
  }

  /* Product update number ajax */
  public function updateNumber(Request $request)
  {
    CategoryProduct::where('id', $request->id)->where('type', $this->typeCategory3)->update(['num' => $request->value]);
  }

  /* Category product update status ajax */
  public function updateStatus(Request $request)
  {
    $status = CategoryProduct::select('status')->where('type', $this->typeCategory3)->find($request->id)->status;
    $status = !empty($status) ? explode(',', $status) : [];
    if (array_search($request->value, $status) !== false) {
      $key = array_search($request->value, $status);
      unset($status[$key]);
    } else {
      array_push($status, $request->value);
    }
    $statusStr = implode(',', $status);
    CategoryProduct::where('id', $request->id)->where('type', $this->typeCategory3)->update(['status' => $statusStr]);
  }

  /* Category product delete photo */
  public function deletePhoto(Request $request)
  {
    $upload = "public/upload/category_product3/";
    $action = $request->action;
    $photo = CategoryProduct::where('type', $this->typeCategory3)->find($request->id)->$action;
    $photo = isset($photo) && !empty($photo) ? $photo : "";
    if (file_exists($upload . $photo) && !empty($photo)) unlink($upload . $photo);
    CategoryProduct::where('id', $request->id)->where('type', $this->typeCategory3)->update([$action => null]);
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.category_product3.show', ['id' => $request->id]));
  }
}
