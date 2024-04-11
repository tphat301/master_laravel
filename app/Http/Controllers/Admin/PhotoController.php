<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\News;
use App\Models\Admin\Photo;
use App\Models\Admin\Product;
use App\Utils\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PhotoController extends Controller
{
  protected $helper;
  protected $slideshowType;
  protected $partnerType;
  protected $socialFooterType;
  public function __construct()
  {
    $this->middleware('admin.auth');
    $this->helper = new Helpers();
    $this->slideshowType = config('admin.photo.slideshow.type');
    $this->socialFooterType = config('admin.photo.social_footer.type');
    $this->partnerType = config('admin.photo.partner.type');
  }

  /* Slideshow list */
  public function slideshowIndex(Request $request)
  {
    $type = $this->slideshowType;
    $action = config('admin.photo.slideshow.action');
    $numberPerPage = config('admin.photo.slideshow.number_per_page');
    session(['module_active' => 'slideshow_index']);
    $keyword = htmlspecialchars($request->input('keyword'));
    if ($keyword) {
      $rows = Photo::where("title", "LIKE", "%{$keyword}%")->where('type', $type)->where('action', $action)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($numberPerPage);
    } else {
      $rows = Photo::where('type', $type)->where('action', $action)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($numberPerPage);
    }
    return view('admin.photo.index', compact('rows', 'type'));
  }

  /* Slideshow create */
  public function slideshowCreate()
  {
    session(['module_active' => 'slideshow_create']);
    $type = config('admin.photo.slideshow.type');
    return view('admin.photo.create', compact('type'));
  }

  /* Social footer list */
  public function socialFooterIndex(Request $request)
  {
    $type = $this->socialFooterType;
    $action = config('admin.photo.social_footer.action');
    $numberPerPage = config('admin.photo.social_footer.number_per_page');
    session(['module_active' => 'social_footer_index']);
    if ($request->input('keyword')) {
      $rows = Photo::where("title", "LIKE", "%{$request->input('keyword')}%")->where('type', $type)->where('action', $action)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($numberPerPage);
    } else {
      $rows = Photo::where('type', $type)->where('action', $action)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($numberPerPage);
    }
    return view('admin.photo.index', compact('rows', 'type'));
  }

  /* Social footer create */
  public function socialFooterCreate()
  {
    session(['module_active' => 'social_footer_create']);
    $type = config('admin.photo.social_footer.type');
    return view('admin.photo.create', compact('type'));
  }

  /* Partner list */
  public function partnerIndex(Request $request)
  {
    $type = $this->partnerType;
    $action = config('admin.photo.partner.action');
    $numberPerPage = config('admin.photo.partner.number_per_page');
    session(['module_active' => 'partner_index']);
    if ($request->input('keyword')) {
      $rows = Photo::where("title", "LIKE", "%{$request->input('keyword')}%")->where('type', $type)->where('action', $action)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($numberPerPage);
    } else {
      $rows = Photo::where('type', $type)->where('action', $action)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($numberPerPage);
    }
    return view('admin.photo.index', compact('rows', 'type'));
  }

  /* Partner create */
  public function partnerCreate()
  {
    session(['module_active' => 'partner_create']);
    $type = config('admin.photo.partner.type');
    return view('admin.photo.create', compact('type'));
  }

  /* Photo detail */
  public function show(Request $request)
  {
    $id = $request->id;
    $type = $request->type;
    $action = "admin.photo." . $type . ".action";
    $row = Photo::where('type', $type)->where('action', config($action))->find($id);
    return view('admin.photo.show', compact('row', 'type'));
  }

  /* Photo insert */
  public function save(Request $request)
  {
    $hashKey = Str::lower(Str::random(3));
    $type = $request->type;
    $data = $request->input('dataMultiple');
    $with = config("admin.photo." . $type . ".with");
    $height = config("admin.photo." . $type . ".height");
    $action = config("admin.photo." . $type . ".action");
    $directSuccess = "admin.photo." . $type . ".index";
    $directDanger = "admin.photo." . $type . ".create";
    $totalPost = count($data);
    if ($data) {
      for ($i = 1; $i <= $totalPost; $i++) {
        $file = "file" . $i;
        $validator = Validator::make(
          $request->all(),
          [
            "file" . $i => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:20971520'],
          ],
          [
            'required' => ':attribute upload không được để trống',
            'image' => ':attribute chỉ cho phép upload định dạng là hình ảnh.',
            'mimes' => ':attribute chỉ cho phép upload các định dạng :mimes',
            'max' => ':attribute chỉ cho upload tối đa là :max MB',
          ],
          [
            "file" . $i => 'Hình ảnh ' . $i
          ]
        );
        if (!$validator->fails()) {
          if ($request->hasFile($file)) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->$file)->resize($with, $height);
            $photo = hexdec(uniqid()) . "." . $request->$file->getClientOriginalName();
            if (!file_exists("public/upload/photo")) {
              mkdir("public/upload/photo", 0777, true);
            }
            $path = public_path('upload/photo');
            $image->save($path . "/" . $photo);
          }
          $d = [
            'title' => !empty($data[$i]['title']) ? htmlspecialchars($data[$i]['title']) : null,
            'status' => !empty($data[$i]['status']) ? htmlspecialchars(implode(',', $data[$i]['status'])) : 'hienthi',
            'link' => !empty($data[$i]['link']) ? htmlspecialchars($data[$i]['link']) : null,
            'hash' => $hashKey . $i,
            'type' => $type,
            'action' => $action,
            'num' => !empty($data[$i]['num']) ? $data[$i]['num'] : 0,
            'desc' => !empty($data[$i]['desc']) ? htmlspecialchars($data[$i]['desc']) : null,
            'content' => !empty($data[$i]['content']) ? htmlspecialchars($data[$i]['content']) : null,
            'photo' => !empty($photo) ? $photo : null
          ];
          Photo::create($d);
        }
      }
      return $this->helper->transfer("Thêm dữ liệu", "success", route($directSuccess));
    } else {
      return $this->helper->transfer("Thêm dữ liệu", "danger", route($directDanger));
    }
  }

  /* Photo update */
  public function update(Request $request)
  {
    $row = Photo::where('type', $request->type)->find($request->id);
    if (!file_exists("public/upload/photo")) {
      mkdir("public/upload/photo", 0777, true);
    }
    $with = config("admin.photo." . $request->type . ".with");
    $height = config("admin.photo." . $request->type . ".height");
    $directDetail = "admin.photo." . $request->type . ".show";
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
      if ($request->hasFile('file')) {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file)->resize($with, $height);
        $photo = hexdec(uniqid()) . "." . $request->file->getClientOriginalName();
        $path = public_path('upload/photo');
        $image->save($path . "/" . $photo);
      } else {
        $photo = isset($row->photo) ? $row->photo : null;
      }
      $d = [
        'title' => !empty($request->input('title')) ? htmlspecialchars($request->input('title')) : null,
        'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : 'hienthi',
        'link' => !empty($request->input('link')) ? htmlspecialchars($request->input('link')) : null,
        'num' => !empty($request->input('num')) ? $request->input('num') : 0,
        'desc' => !empty($request->input('desc')) ? htmlspecialchars($request->input('desc')) : null,
        'content' => !empty($request->input('content')) ? htmlspecialchars($request->input('content')) : null,
        'photo' => !empty($photo) ? $photo : null
      ];

      $row->update($d);
      return $this->helper->transfer("Cập nhật dữ liệu", "success", route($directDetail, ['id' => $request->id, 'type' => $request->type]));
    } else {
      return redirect()->route($directDetail, ['id' => $request->id, 'type' => $request->type])->withErrors($validator)->withInput();
    }
  }

  /* Photo update number */
  public function updateNumber(Request $request)
  {
    Photo::where('id', $request->id)->where('type', $request->type)->update(['num' => $request->value]);
  }

  /* Photo update status */
  public function updateStatus(Request $request)
  {
    $status = Photo::select('status')->where('type', $request->type)->find($request->id)->status;
    $status = !empty($status) ? explode(',', $status) : [];
    if (array_search($request->value, $status) !== false) {
      $key = array_search($request->value, $status);
      unset($status[$key]);
    } else {
      array_push($status, $request->value);
    }
    $statusStr = implode(',', $status);
    Photo::where('id', $request->id)->where('type', $request->type)->update(['status' => $statusStr]);
  }

  /* Photo delete multiple */
  public function destroy(Request $request)
  {
    $direct = "admin.photo." . $request->type . ".index";
    $uploadPhoto = "public/upload/photo/";
    $rows = Photo::where('type', $request->type)->find($request->checkitem);
    foreach ($rows as $v) {
      $photo = isset($v->photo) && !empty($v->photo) ? $v->photo : "";
      if (file_exists($uploadPhoto . $photo) && !empty($photo)) unlink($uploadPhoto . $photo);
    }
    Photo::destroy($request->checkitem);
    return $this->helper->transfer("Xóa dữ liệu", "success", route($direct));
  }

  /* Photo delete static */
  public function delete(Request $request)
  {
    $direct = "admin.photo." . $request->type . ".index";
    $uploadPhoto = "public/upload/photo/";
    $row = Photo::where('type', $request->type)->where('hash', $request->hash)->find($request->id);
    $photo = isset($row->photo) && !empty($row->photo) ? $row->photo : "";
    if (file_exists($uploadPhoto . $photo) && !empty($photo)) unlink($uploadPhoto . $photo);
    $row->delete();
    return $this->helper->transfer("Xóa dữ liệu", "success", route($direct));
  }

  /* Photo delete photo */
  public function deletePhoto(Request $request)
  {
    @$direct = "admin.photo." . $request->type . ".show";
    $uploadPhoto = "public/upload/photo/";
    $action = $request->action;
    $photo = Photo::where('type', $request->type)->find($request->id)->$action;
    $photo = isset($photo) && !empty($photo) ? $photo : "";
    if (file_exists($uploadPhoto . $photo) && !empty($photo)) unlink($uploadPhoto . $photo);
    Photo::where('id', $request->id)->where('type', $request->type)->update([$action => null]);
    return $this->helper->transfer("Xóa dữ liệu", "success", route($direct, ['id' => $request->id, 'type' => $request->type]));
  }

  /* Logo */
  public function logo()
  {
    session(['module_active' => 'logo_create']);
    $type = config('admin.photo.logo.type');
    $action = config('admin.photo.logo.action');
    $row = Photo::where('type', $type)->where('action', $action)->first();
    return view('admin.photo.photo_static', compact('row', 'type'));
  }

  /* Favicon */
  public function favicon()
  {
    session(['module_active' => 'favicon_create']);
    $type = config('admin.photo.favicon.type');
    $action = config('admin.photo.favicon.action');
    $row = Photo::where('type', $type)->where('action', $action)->first();
    return view('admin.photo.photo_static', compact('row', 'type'));
  }

  /* Watermark product */
  public function watermarkProduct()
  {
    session(['module_active' => 'watermark_product_create']);
    $type = config('admin.photo.watermark_product.type');
    $action = config('admin.photo.watermark_product.action');
    $row = Photo::where('type', $type)->where('action', $action)->first();
    return view('admin.photo.photo_static', compact('row', 'type'));
  }

  /* Watermark news */
  public function watermarkNews()
  {
    session(['module_active' => 'watermark_news_create']);
    $type = config('admin.photo.watermark_news.type');
    $action = config('admin.photo.watermark_news.action');
    $row = Photo::where('type', $type)->where('action', $action)->first();
    return view('admin.photo.photo_static', compact('row', 'type'));
  }

  /* Photo static remake */
  public function staticRemake(Request $request)
  {
    if ($request->type === 'watermark_product') {
      $upload = "public/upload/watermark_product/";
    } elseif ($request->type === 'watermark_news') {
      $upload = "public/upload/watermark_news/";
    } else {
      $upload = "public/upload/photo/";
    }

    $direct = "admin.photo." . $request->type;
    $row = Photo::where('type', $request->type)->where('hash', $request->hash)->find($request->id);
    $photo = isset($row->photo) && !empty($row->photo) ? $row->photo : "";
    if (file_exists($upload . $photo) && !empty($photo)) unlink($upload . $photo);
    Photo::where('type', $request->type)->where('hash', $request->hash)->delete($request->id);
    return $this->helper->transfer("Làm mới dữ liệu", "success", route($direct));
  }

  /* Photo static save */
  public function staticSave(Request $request)
  {
    if (!file_exists("public/upload/photo")) {
      mkdir("public/upload/photo", 0777, true);
    }
    if (!file_exists("public/upload/watermark_product")) {
      mkdir("public/upload/wk_product", 0777, true);
    }
    if (!file_exists("public/upload/watermark_product")) {
      mkdir("public/upload/wk_news", 0777, true);
    }
    if (!file_exists("public/upload/watermark_product")) {
      mkdir("public/upload/watermark_product", 0777, true);
    }
    if (!file_exists("public/upload/watermark_news")) {
      mkdir("public/upload/watermark_news", 0777, true);
    }
    $direct = "admin.photo." . $request->type;
    $hashKey = Str::lower(Str::random(4));
    $action = config("admin.photo." . $request->type . ".action");
    $with = config("admin.photo." . $request->type . ".with");
    $height = config("admin.photo." . $request->type . ".height");
    $validator = Validator::make(
      $request->all(),
      [
        "photo" => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:20971520'],
      ],
      [
        'image' => ':attribute chỉ cho phép upload định dạng là hình ảnh.',
        'mimes' => ':attribute chỉ cho phép upload các định dạng :mimes',
        'max' => ':attribute chỉ cho upload tối đa là :max MB',
        'required' => ':attribute không được bỏ trống'
      ],
      [
        "photo" => 'Hình ảnh'
      ]
    );

    if (isset($_POST['save'])) {
      if (!$validator->fails()) {
        if ($request->hasFile("photo")) {
          $manager = new ImageManager(new Driver());
          $image = $manager->read($request->photo)->resize($with, $height);
          $photo = hexdec(uniqid()) . "." . $request->photo->getClientOriginalName();
          if ($request->type == 'watermark_product') {
            $path = public_path('upload/watermark_product');
          } elseif ($request->type == 'watermark_news') {
            $path = public_path('upload/watermark_news');
          } else {
            $path = public_path('upload/photo');
          }
          $image->save($path . "/" . $photo);
        }
        $d = array(
          'title' => !empty($request->input('title')) ? htmlspecialchars($request->input('title')) : null,
          'position' => !empty($request->input('position')) ? htmlspecialchars($request->input('position')) : null,
          'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : 'hienthi',
          'desc' => !empty($request->input('desc')) ? htmlspecialchars($request->input('desc')) : null,
          'content' => !empty($request->input('content')) ? htmlspecialchars($request->input('content')) : null,
          'photo' => !empty($photo) ? $photo : null,
          'type' => $request->type,
          'action' => $action,
          'hash' => $hashKey
        );
        Photo::create($d);
        return $this->helper->transfer("Thêm dữ liệu", "success", route($direct));
      } else {
        return redirect()->route($direct)->withErrors($validator)->withInput();
      }
    }
  }
}
