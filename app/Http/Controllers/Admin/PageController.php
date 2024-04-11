<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Page;
use App\Models\Admin\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Utils\Helpers;

class PageController extends Controller
{
  protected $type;
  protected $helper;
  protected $uploadPage;

  public function __construct()
  {
    $this->middleware('admin.auth');
    $this->helper = new Helpers();
  }

  public function index(Request $request)
  {
    $type = $request->type;
    session(['module_active' => $type]);
    $row = Page::where('type', $type)->first();
    if ($row) {
      $rowSeo = Seo::where('type', $type)->where('hash_seo', $row->hash)->first();
    } else {
      $rowSeo = "";
    }
    return view('admin.page.index', compact('row', 'rowSeo', 'type'));
  }

  /*Page delete photo*/
  public function deletePhoto(Request $request)
  {
    $upload = "public/upload/page/";
    $action = $request->action;
    $photo = Page::where('type', $request->type)->find($request->id)->$action;
    $photo = isset($photo) && !empty($photo) ? $photo : "";
    if (file_exists($upload . $photo) && !empty($photo)) unlink($upload . $photo);
    Page::where('id', $request->id)->where('type', $request->type)->update([$action => null]);
    return $this->helper->transfer("Xóa dữ liệu", "success", route("admin.page", ['type' => $request->type]));
  }

  /*Page remake*/
  public function remake(Request $request)
  {
    $upload = "public/upload/page/";
    $row = Page::where('type', $request->type)->where('hash', $request->hash)->find($request->id);
    $photo1 = isset($row->photo1) && !empty($row->photo1) ? $row->photo1 : "";
    $photo2 = isset($row->photo2) && !empty($row->photo2) ? $row->photo2 : "";
    $photo3 = isset($row->photo3) && !empty($row->photo3) ? $row->photo3 : "";
    $photo4 = isset($row->photo4) && !empty($row->photo4) ? $row->photo4 : "";
    if (file_exists($upload . $photo1) && !empty($photo1)) unlink($upload . $photo1);
    if (file_exists($upload . $photo2) && !empty($photo2)) unlink($upload . $photo2);
    if (file_exists($upload . $photo3) && !empty($photo3)) unlink($upload . $photo3);
    if (file_exists($upload . $photo4) && !empty($photo4)) unlink($upload . $photo4);
    Seo::where('type', $request->type)->where('hash_seo', $request->hash)->where('id_parent', $request->id)->delete();
    Page::where('type', $request->type)->where('hash', $request->hash)->delete($request->id);
    return $this->helper->transfer("Làm mới dữ liệu", "success", route("admin.page", ['type' => $request->type]));
  }

  /*Page save*/
  public function save(Request $request)
  {
    if (!file_exists("public/upload/page")) {
      mkdir("public/upload/page", 0777, true);
    }
    $hashKey = Str::lower(Str::random(4));
    $width1 = config("admin.page." . $request->type . ".with1");
    $width2 = config("admin.page." . $request->type . ".with2");
    $width3 = config("admin.page." . $request->type . ".with3");
    $width4 = config("admin.page." . $request->type . ".with4");
    $height1 = config("admin.page." . $request->type . ".height1");
    $height2 = config("admin.page." . $request->type . ".height2");
    $height3 = config("admin.page." . $request->type . ".height3");
    $height4 = config("admin.page." . $request->type . ".height4");
    $validator = Validator::make(
      $request->all(),
      [
        "photo1" => ['image', 'mimes:png,gif,jpg,jpeg,webp', 'max:20971520'],
        "photo2" => ['image', 'mimes:png,gif,jpg,jpeg,webp', 'max:20971520'],
        "photo3" => ['image', 'mimes:png,gif,jpg,jpeg,webp', 'max:20971520'],
        "photo4" => ['image', 'mimes:png,gif,jpg,jpeg,webp', 'max:20971520'],
      ],
      [
        'required' => ':attribute không được để trống',
        'image' => ':attribute chỉ cho phép upload định dạng là hình ảnh.',
        'mimes' => ':attribute chỉ cho phép upload các định dạng :mimes',
        'max' => ':attribute chỉ cho upload tối đa là :max MB',
      ],
      [
        "photo1" => 'Hình ảnh 1',
        "photo2" => 'Hình ảnh 2',
        "photo3" => 'Hình ảnh 3',
        "photo4" => 'Hình ảnh 4'
      ]
    );
    if (isset($_POST['save'])) {
      if (!$validator->fails()) {
        $manager = new ImageManager(new Driver());
        if ($request->hasFile("photo1")) {
          $image = $manager->read($request->photo1)->resize($width1, $height1);
          $photo1 = hexdec(uniqid()) . "." . $request->photo1->getClientOriginalName();
          $path = public_path('upload/page');
          $image->save($path . "/" . $photo1);
        }
        if ($request->hasFile("photo2")) {
          $image = $manager->read($request->photo2)->resize($width2, $height2);
          $photo2 = hexdec(uniqid()) . "." . $request->photo2->getClientOriginalName();
          $path = public_path('upload/page');
          $image->save($path . "/" . $photo2);
        }
        if ($request->hasFile("photo3")) {
          $image = $manager->read($request->photo3)->resize($width3, $height3);
          $photo3 = hexdec(uniqid()) . "." . $request->photo3->getClientOriginalName();
          $path = public_path('upload/page');
          $image->save($path . "/" . $photo3);
        }
        if ($request->hasFile("photo4")) {
          $image = $manager->read($request->photo4)->resize($width4, $height4);
          $photo4 = hexdec(uniqid()) . "." . $request->photo4->getClientOriginalName();
          $path = public_path('upload/page');
          $image->save($path . "/" . $photo4);
        }
        $d = array(
          'slogan' => !empty($request->input('slogan')) ? htmlspecialchars($request->input('slogan')) : null,
          'slug' => !empty($request->input('slug')) ? htmlspecialchars($request->input('slug')) : null,
          'title' => !empty($request->input('title')) ? htmlspecialchars($request->input('title')) : null,
          'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : 'hienthi',
          'desc' => !empty($request->input('desc')) ? htmlspecialchars($request->input('desc')) : null,
          'content' => !empty($request->input('content')) ? htmlspecialchars($request->input('content')) : null,
          'type' => $request->type,
          'hash' => $hashKey,
          'photo1' => !empty($photo1) ? $photo1 : null,
          'photo2' => !empty($photo2) ? $photo2 : null,
          'photo3' => !empty($photo3) ? $photo3 : null,
          'photo4' => !empty($photo4) ? $photo4 : null
        );
        Page::create($d);
        if (!empty($request->input('title_seo'))) {
          $dataSeo = [
            'title_seo' => htmlspecialchars($request->input('title_seo')),
            'hash_seo' => $hashKey,
            'type' => $request->type,
            'keywords' => !empty($request->input('keywords')) ? htmlspecialchars($request->input('keywords')) : null,
            'description_seo' => !empty($request->input('description_seo')) ? htmlspecialchars($request->input('description_seo')) : null,
          ];
          Seo::create($dataSeo);
        }
        return $this->helper->transfer("Thêm dữ liệu", "success", route("admin.page", ['type' => $request->type]));
      } else {
        return redirect()->route("admin.page", ['type' => $request->type])->withErrors($validator)->withInput();
      }
    } else {
      $row = Page::where('type', $request->type)->find($request->id);
      if (!$validator->fails()) {
        $manager = new ImageManager(new Driver());
        if ($request->hasFile("photo1")) {
          $image = $manager->read($request->photo1)->resize($width1, $height1);
          $photo1 = hexdec(uniqid()) . "." . $request->photo1->getClientOriginalName();
          $path = public_path('upload/page');
          $image->save($path . "/" . $photo1);
        } else {
          $photo1 = isset($row->photo1) ? $row->photo1 : null;
        }
        if ($request->hasFile("photo2")) {
          $image = $manager->read($request->photo2)->resize($width2, $height2);
          $photo2 = hexdec(uniqid()) . "." . $request->photo2->getClientOriginalName();
          $path = public_path('upload/page');
          $image->save($path . "/" . $photo2);
        } else {
          $photo2 = isset($row->photo2) ? $row->photo2 : null;
        }
        if ($request->hasFile("photo3")) {
          $image = $manager->read($request->photo3)->resize($width3, $height3);
          $photo3 = hexdec(uniqid()) . "." . $request->photo3->getClientOriginalName();
          $path = public_path('upload/page');
          $image->save($path . "/" . $photo3);
        } else {
          $photo3 = isset($row->photo3) ? $row->photo3 : null;
        }
        if ($request->hasFile("photo4")) {
          $image = $manager->read($request->photo4)->resize($width4, $height4);
          $photo4 = hexdec(uniqid()) . "." . $request->photo4->getClientOriginalName();
          $path = public_path('upload/page');
          $image->save($path . "/" . $photo4);
        } else {
          $photo4 = isset($row->photo4) ? $row->photo4 : null;
        }
        $d = array(
          'slogan' => !empty($request->input('slogan')) ? htmlspecialchars($request->input('slogan')) : null,
          'slug' => !empty($request->input('slug')) ? htmlspecialchars($request->input('slug')) : null,
          'title' => !empty($request->input('title')) ? htmlspecialchars($request->input('title')) : null,
          'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : '',
          'desc' => !empty($request->input('desc')) ? htmlspecialchars($request->input('desc')) : null,
          'content' => !empty($request->input('content')) ? htmlspecialchars($request->input('content')) : null,
          'photo1' => !empty($photo1) ? $photo1 : null,
          'photo2' => !empty($photo2) ? $photo2 : null,
          'photo3' => !empty($photo3) ? $photo3 : null,
          'photo4' => !empty($photo4) ? $photo4 : null
        );
        $row->update($d);
        if ($request->input('title_seo')) {
          $dataSeo = [
            'title_seo' => htmlspecialchars($request->input('title_seo')),
            'keywords' => !empty($request->input('keywords')) ? htmlspecialchars($request->input('keywords')) : null,
            'description_seo' => !empty($request->input('description_seo')) ? htmlspecialchars($request->input('description_seo')) : null,
            'hash_seo' => $row->hash,
            'id_parent' => !empty($row->id) ? $row->id  : null
          ];
          $seo = Seo::where('hash_seo', $row->hash)->first();
          if ($seo) {
            Seo::where('hash_seo', $row->hash)->update($dataSeo);
          } else {
            Seo::create($dataSeo);
          }
        }
        return $this->helper->transfer("Cập nhật dữ liệu", "success", route("admin.page", ['type' => $request->type]));
      } else {
        return redirect()->route("admin.page", ['type' => $request->type])->withErrors($validator)->withInput();
      }
    }
  }
}
