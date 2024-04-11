<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Seopage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Utils\Helpers;

class SeopageController extends Controller
{
  protected $helper;
  public function __construct()
  {
    $this->middleware('admin.auth');
    $this->helper = new Helpers();
  }

  /* Seopage Index */
  public function index(Request $request)
  {
    $type = $request->type;
    session(['module_active' => 'seopage' . $type]);
    $row = Seopage::where('type', $type)->first();
    return view('admin.seopage.index', compact('row', 'type'));
  }

  /* Seopage remake */
  public function remake(Request $request)
  {
    $upload = "public/upload/seopage/";
    $row = Seopage::where('type', $request->type)->where('hash', $request->hash)->find($request->id);
    $photo = isset($row->photo) && !empty($row->photo) ? $row->photo : "";
    if (file_exists($upload . $photo) && !empty($photo)) unlink($upload . $photo);
    Seopage::where('type', $request->type)->where('hash', $request->hash)->delete($request->id);
    return $this->helper->transfer("Làm mới dữ liệu", "success", route("admin.seopage", ['type' => $request->type]));
  }

  /* Seopage save */
  public function save(Request $request)
  {
    if (!file_exists("public/upload/seopage")) {
      mkdir("public/upload/seopage", 0777, true);
    }
    $hashKey = Str::lower(Str::random(4));
    $width = config("admin.seopage." . $request->type . ".with");
    $height = config("admin.seopage." . $request->type . ".height");
    $validator = Validator::make(
      $request->all(),
      [
        "title" => ['required'],
        "photo" => ['image', 'mimes:png,jpg,jpeg,webp', 'max:20971520']
      ],
      [
        'required' => ':attribute không được để trống',
        'image' => ':attribute chỉ cho phép upload định dạng là hình ảnh.',
        'mimes' => ':attribute chỉ cho phép upload các định dạng :mimes',
        'max' => ':attribute chỉ cho upload tối đa là :max MB',
      ],
      [
        "title" => 'Tiêu đề',
        "photo" => 'Hình ảnh'
      ]
    );
    if (isset($_POST['save'])) {
      if (!$validator->fails()) {
        $manager = new ImageManager(new Driver());
        if ($request->hasFile("photo")) {
          $image = $manager->read($request->photo)->resize($width, $height);
          $photo = hexdec(uniqid()) . "." . $request->photo->getClientOriginalName();
          $path = public_path('upload/seopage');
          $image->save($path . "/" . $photo);
        }
        $d = array(
          'title' => !empty($request->input('title')) ? htmlspecialchars($request->input('title')) : null,
          'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : 'hienthi',
          'description' => !empty($request->input('description')) ? htmlspecialchars($request->input('description')) : null,
          'keywords' => !empty($request->input('keywords')) ? htmlspecialchars($request->input('keywords')) : null,
          'type' => $request->type,
          'hash' => $hashKey,
          'photo' => !empty($photo) ? $photo : null
        );
        Seopage::create($d);
        return $this->helper->transfer("Thêm dữ liệu", "success", route("admin.seopage", ["type" => $request->type]));
      } else {
        return redirect()->route("admin.seopage", ["type" => $request->type])->withErrors($validator)->withInput();
      }
    } else {
      $row = Seopage::where('type', $request->type)->find($request->id);
      if (!$validator->fails()) {
        $manager = new ImageManager(new Driver());
        if ($request->hasFile("photo")) {
          $image = $manager->read($request->photo)->resize($width, $height);
          $photo = hexdec(uniqid()) . "." . $request->photo->getClientOriginalName();
          $path = public_path('upload/seopage');
          $image->save($path . "/" . $photo);
        } else {
          $photo = isset($row->photo) ? $row->photo : null;
        }
        $d = array(
          'title' => !empty($request->input('title')) ? htmlspecialchars($request->input('title')) : null,
          'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : '',
          'description' => !empty($request->input('description')) ? htmlspecialchars($request->input('description')) : null,
          'keywords' => !empty($request->input('keywords')) ? htmlspecialchars($request->input('keywords')) : null,
          'photo' => !empty($photo) ? $photo : null
        );
        $row->update($d);
        return $this->helper->transfer("Cập nhật dữ liệu", "success", route("admin.seopage", ["type" => $request->type]));
      } else {
        return redirect()->route("admin.seopage", ["type" => $request->type])->withErrors($validator)->withInput();
      }
    }
  }
}
