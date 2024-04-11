<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Seo;
use App\Models\Admin\Tag;
use Illuminate\Http\Request;
use App\Utils\Helpers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TagProductController extends Controller
{
  protected $type;
  protected $helper;
  protected $width;
  protected $height;
  protected $numberPerPage;
  protected $uploadTagProduct;
  public function __construct()
  {
    $this->middleware('admin.auth');
    $this->helper = new Helpers();
    $this->type = config('admin.product.tag.type');
    $this->numberPerPage = config('admin.product.tag.number_per_page');
    $this->width = config('admin.product.tag.width');
    $this->height = config('admin.product.tag.height');
    $this->uploadTagProduct = "public/upload/tag_product";
  }

  /* Tag product index */
  public function index(Request $request)
  {
    session(['module_active' => 'tag_product_index']);
    $keyword = htmlspecialchars($request->input('keyword'));
    if ($keyword) {
      $rows = Tag::where("title_tag", "LIKE", "%{$keyword}%")->where('type_tag', $this->type)->orderBy('num_tag', 'ASC')->orderBy('id_tag', 'ASC')->paginate($this->numberPerPage);
    } else {
      $rows = Tag::where('type_tag', $this->type)->orderBy('num_tag', 'ASC')->orderBy('id_tag', 'ASC')->paginate($this->numberPerPage);
    }
    return view('admin.tag.product_index', compact('rows'));
  }

  /* Tag product create */
  public function create()
  {
    session(['module_active' => 'tag_product_create']);
    return view('admin.tag.product_create');
  }

  /* Tag product show */
  public function show(Request $request)
  {
    $row = Tag::where('type_tag', $this->type)->find($request->id);
    $rowSeo = Seo::where('type', $this->type)->where('hash_seo', $row->hash_tag)->first();
    return view('admin.tag.product_show', compact('row', 'rowSeo'));
  }

  /* Tag product delete static */
  public function delete($id, $hash)
  {
    $upload = "public/upload/tag_product/";
    $tagProduct = Tag::where('type_tag', $this->type)->where('hash_tag', $hash)->find($id);
    $seo = SEO::where('type', $this->type)->where('hash_seo', $hash);
    $photo = isset($tagProduct->photo) && !empty($tagProduct->photo) ? $tagProduct->photo : "";
    if (file_exists($upload . $photo) && !empty($photo)) unlink($upload . $photo);
    $tagProduct->delete();
    $seo->delete();
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.tag_product'));
  }

  /* Tag product delete mutiple */
  public function destroy(Request $request)
  {
    $uploadNews = "public/upload/tag_product/";
    $tagProduct = Tag::where('type_tag', $this->type)->find($request->checkitem);
    foreach ($tagProduct as $v) {
      $photo = isset($v->photo) && !empty($v->photo) ? $v->photo : "";
      if (file_exists($uploadNews . $photo) && !empty($photo)) unlink($uploadNews . $photo);
    }
    Seo::where('type', $this->type)->whereIn('hash_seo', $request->hashes)->delete();
    Tag::destroy($request->checkitem);
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.tag_product'));
  }

  /* Tag product update number ajax */
  public function updateNumber(Request $request)
  {
    Tag::where('id_tag', $request->id)->where('type_tag', $this->type)->update(['num_tag' => $request->value]);
  }

  /* Tag product update status ajax */
  public function updateStatus(Request $request)
  {
    $status = Tag::select('status_tag')->where('type_tag', $this->type)->find($request->id)->status_tag;
    $status = !empty($status) ? explode(',', $status) : [];
    if (array_search($request->value, $status) !== false) {
      $key = array_search($request->value, $status);
      unset($status[$key]);
    } else {
      array_push($status, $request->value);
    }
    $statusStr = implode(',', $status);
    Tag::where('id_tag', $request->id)->where('type_tag', $this->type)->update(['status_tag' => $statusStr]);
  }

  /* Tag product delete photo */
  public function deletePhoto(Request $request)
  {
    $uploadNews = "public/upload/tag_product/";
    $action = $request->action;
    $photo = Tag::where('type_tag', $this->type)->find($request->id)->$action;
    $photo = isset($photo) && !empty($photo) ? $photo : "";
    if (file_exists($uploadNews . $photo) && !empty($photo)) unlink($uploadNews . $photo);
    Tag::where('id_tag', $request->id)->where('type_tag', $this->type)->update([$action => null]);
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.tag_product.show', ['id' => $request->id]));
  }

  /* Tag product save */
  public function save(Request $request)
  {
    $hashKey = Str::lower(Str::random(4));
    if (!file_exists($this->uploadTagProduct)) {
      mkdir($this->uploadTagProduct, 0777, true);
    }
    $validator = Validator::make(
      $request->all(),
      [
        "photo" => ['image', 'mimes:png,jpg,jpeg,webp', 'max:20971520']
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
        'photo' => 'Hình ảnh',
      ]
    );
    if (!$validator->fails()) {
      $manager = new ImageManager(new Driver());
      if ($request->hasFile('photo')) {
        $image = $manager->read($request->photo)->resize($this->width, $this->height);
        $photo = hexdec(uniqid()) . "." . $request->photo->getClientOriginalName();
        $path = public_path('upload/tag_product');
        $image->save($path . "/" . $photo);
      }
      $data = [
        'title_tag' => htmlspecialchars($request->input('title')),
        'status_tag' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : 'hienthi',
        'hash_tag' => $hashKey,
        'type_tag' => $this->type,
        'num_tag' => !empty($request->input('num')) ? $request->input('num') : 0,
        'photo' => !empty($photo) ? $photo : null
      ];
      if ($request->input('title_seo')) {
        $dataSeo = [
          'title_seo' => htmlspecialchars($request->input('title_seo')),
          'hash_seo' => $hashKey,
          'type' => $this->type,
          'keywords' => !empty($request->input('keywords')) ? htmlspecialchars($request->input('keywords')) : null,
          'description_seo' => !empty($request->input('description_seo')) ? htmlspecialchars($request->input('description_seo')) : null,
        ];
        Seo::create($dataSeo);
      }
      Tag::create($data);
      return $this->helper->transfer("Thêm dữ liệu", "success", route('admin.tag_product'));
    } else {
      return redirect()->back()->withErrors($validator)->withInput();
    }
  }

  /* Tag product update */
  public function update(Request $request)
  {
    $row = Tag::where('type_tag', $this->type)->find($request->id);
    if (!file_exists($this->uploadTagProduct)) {
      mkdir($this->uploadTagProduct, 0777, true);
    }
    $manager = new ImageManager(new Driver());
    if ($request->hasFile('photo')) {
      $image = $manager->read($request->photo)->resize($this->width, $this->height);
      $photo = hexdec(uniqid()) . "." . $request->photo->getClientOriginalName();
      $path = public_path('upload/tag_product');
      $image->save($path . "/" . $photo);
    } else {
      $photo = isset($row->photo) ? $row->photo : null;
    }
    $data = [
      'title_tag' => htmlspecialchars($request->input('title')),
      'status_tag' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : 'hienthi',
      'num_tag' => !empty($request->input('num')) ? $request->input('num') : 0,
      'photo' => !empty($photo) ? $photo : null
    ];
    if ($request->input('title_seo')) {
      $dataSeo = [
        'title_seo' => htmlspecialchars($request->input('title_seo')),
        'keywords' => !empty($request->input('keywords')) ? htmlspecialchars($request->input('keywords')) : null,
        'description_seo' => !empty($request->input('description_seo')) ? htmlspecialchars($request->input('description_seo')) : null,
        'schema' => !empty($request->input('schema')) ? htmlspecialchars($request->input('schema')) : null,
        'hash_seo' => $row->hash_tag,
        'type' => $this->type,
        'id_parent' => !empty($row->id_tag) ? $row->id_tag  : null
      ];
      $seo = Seo::where('hash_seo', $row->hash_tag)->first();
      if ($seo) {
        Seo::where('hash_seo', $row->hash_tag)->update($dataSeo);
      } else {
        Seo::create($dataSeo);
      }
    }
    $row->update($data);
    return $this->helper->transfer("Cập nhật dữ liệu", "success", route('admin.tag_product.show', ['id' => $row->id_tag]));
  }
}
