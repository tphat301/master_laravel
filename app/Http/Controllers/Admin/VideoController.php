<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Photo;
use Illuminate\Support\Str;
use App\Utils\Helpers;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class VideoController extends Controller
{
  protected $helper;
  protected $videoMultipleType;
  protected $videoStaticType;
  protected $videoMultipleAction;
  protected $videoStaticAction;
  public function __construct()
  {
    $this->middleware('admin.auth');
    $this->helper = new Helpers();
    $this->videoMultipleType = config('admin.video.video_multiple.type');
    $this->videoStaticType = config('admin.video.video_static.type');
    $this->videoMultipleAction = config('admin.video.video_multiple.action');
    $this->videoStaticAction = config('admin.video.video_static.action');
  }

  /* Video static index */
  public function videoStaticIndex(Request $request)
  {
    session(['module_active' => 'video_static_index']);
    $type = $this->videoStaticType;
    $row = Photo::where('type', $type)->where('action', $this->videoStaticAction)->first();
    return view('admin.video.video_static', compact('row', 'type'));
  }

  /* Video static insert */
  public function videoStaticSave(Request $request)
  {
    if (!file_exists("public/upload/video")) {
      mkdir("public/upload/video", 0777, true);
    }
    $direct = "admin.video." . $request->type . ".index";
    $hashKey = Str::lower(Str::random(4));
    $action = config("admin.video." . $request->type . ".action");
    $with = config("admin.video." . $request->type . ".with");
    $height = config("admin.video." . $request->type . ".height");
    $validator = Validator::make(
      $request->all(),
      [
        "photo" => ['image', 'mimes:png,jpg,jpeg,webp', 'max:20971520'],
        "link" => ['required']
      ],
      [
        'image' => ':attribute chỉ cho phép upload định dạng là hình ảnh.',
        'mimes' => ':attribute chỉ cho phép upload các định dạng :mimes',
        'max' => ':attribute chỉ cho upload tối đa là :max MB',
        'required' => ':attribute không được bỏ trống.'
      ],
      [
        "photo" => 'Hình ảnh',
        "link" => "Link"
      ]
    );

    if (isset($_POST['save'])) {
      if (!$validator->fails()) {
        if ($request->hasFile("photo")) {
          $manager = new ImageManager(new Driver());
          $image = $manager->read($request->photo)->resize($with, $height);
          $photo = hexdec(uniqid()) . "." . $request->photo->getClientOriginalName();
          $path = public_path('upload/video');
          $image->save($path . "/" . $photo);
        }
        $d = array(
          'link' => htmlspecialchars($request->input('link')),
          'title' => !empty($request->input('title')) ? htmlspecialchars($request->input('title')) : null,
          'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : 'hienthi',
          'desc' => !empty($request->input('desc')) ? htmlspecialchars($request->input('desc')) : null,
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

  /* Video static remake */
  public function videoStaticRemake(Request $request)
  {
    $upload = "public/upload/video/";
    $direct = "admin.video." . $request->type . ".index";
    $row = Photo::where('type', $request->type)->where('hash', $request->hash)->find($request->id);
    $photo = isset($row->photo) && !empty($row->photo) ? $row->photo : "";
    if (file_exists($upload . $photo) && !empty($photo)) unlink($upload . $photo);
    Photo::where('type', $request->type)->where('hash', $request->hash)->delete($request->id);
    return $this->helper->transfer("Làm mới dữ liệu", "success", route($direct));
  }

  /* Video multiple index */
  public function videoMultipleIndex(Request $request)
  {
    $type = $this->videoMultipleType;
    $numberPerPage = config('admin.video.video_multiple.number_per_page');
    session(['module_active' => 'video_multiple_index']);
    $keyword = htmlspecialchars($request->input('keyword'));
    if ($keyword) {
      $rows = Photo::where("title", "LIKE", "%{$keyword}%")->where('type', $type)->where('action', $this->videoMultipleAction)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($numberPerPage);
    } else {
      $rows = Photo::where('type', $type)->where('action', $this->videoMultipleAction)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($numberPerPage);
    }
    return view('admin.video.index', compact('rows', 'type'));
  }

  /* Video multiple create */
  public function videoMultipleCreate()
  {
    session(['module_active' => 'video_multiple_create']);
    $type = $this->videoMultipleType;
    return view('admin.video.create', compact('type'));
  }

  /* Video multiple detail */
  public function show(Request $request)
  {
    $id = $request->id;
    $type = $request->type;
    $action = "admin.video." . $type . ".action";
    $row = Photo::where('type', $type)->where('action', config($action))->find($id);
    return view('admin.video.show', compact('row', 'type'));
  }

  /* Video multiple delete static */
  public function delete(Request $request)
  {
    $direct = "admin.video." . $request->type . ".index";
    $row = Photo::where('type', $request->type)->where('hash', $request->hash)->find($request->id);
    $row->delete();
    return $this->helper->transfer("Xóa dữ liệu", "success", route($direct));
  }

  /* Video multiple delete multiple */
  public function destroy(Request $request)
  {
    $direct = "admin.video." . $request->type . ".index";
    Photo::destroy($request->checkitem);
    return $this->helper->transfer("Xóa dữ liệu", "success", route($direct));
  }

  /* Video multiple update number */
  public function updateNumber(Request $request)
  {
    Photo::where('id', $request->id)->where('type', $request->type)->update(['num' => $request->value]);
  }

  /* Video multiple update status */
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

  /* Video multiple insert */
  public function save(Request $request)
  {
    $hashKey = Str::lower(Str::random(4));
    $type = $request->type;
    $action = config("admin.video." . $type . ".action");
    $directSuccess = "admin.video." . $type . ".index";
    $directDanger = "admin.video." . $type . ".create";
    $validator = Validator::make(
      $request->all(),
      [
        "link" => ['required']
      ],
      [
        'required' => ':attribute không được bỏ trống.'
      ],
      [
        "link" => 'Link'
      ]
    );
    if (!$validator->fails()) {
      $d = [
        'link' => htmlspecialchars($request->input('link')),
        'title' => !empty($request->input('title')) ? htmlspecialchars($request->input('title')) : null,
        'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : '',
        'hash' => $hashKey,
        'type' => $type,
        'action' => $action,
        'num' => !empty($request->input('num')) ? $request->input('num') : 0
      ];
      Photo::create($d);
      return $this->helper->transfer("Thêm dữ liệu", "success", route($directSuccess));
    } else {
      return redirect()->route($directDanger)->withErrors($validator)->withInput();
    }
  }

  /* Video multiple update */
  public function update(Request $request)
  {
    $row = Photo::where('type', $request->type)->find($request->id);
    $directDetail = "admin.video." . $request->type . ".show";
    $validator = Validator::make(
      $request->all(),
      [
        "link" => ['required']
      ],
      [
        'required' => ':attribute không được bỏ trống.'
      ],
      [
        "link" => 'Link'
      ]
    );
    if (!$validator->fails()) {
      $d = [
        'link' => htmlspecialchars($request->input('link')),
        'title' => !empty($request->input('title')) ? htmlspecialchars($request->input('title')) : null,
        'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : '',
        'num' => !empty($request->input('num')) ? $request->input('num') : 0
      ];
      $row->update($d);
      return $this->helper->transfer("Cập nhật dữ liệu", "success", route($directDetail, ['id' => $request->id, 'type' => $request->type]));
    } else {
      return redirect()->route($directDetail, ['id' => $request->id, 'type' => $request->type])->withErrors($validator)->withInput();
    }
  }
}
