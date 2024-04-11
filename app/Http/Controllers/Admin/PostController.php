<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\News;
use App\Models\Admin\Photo;
use App\Models\Admin\Seo;
use App\Models\Admin\Setting;
use App\Utils\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostController extends Controller
{
  protected $helper;
  protected $uploadPost;
  public function __construct()
  {
    $this->middleware('admin.auth');
    $this->helper = new Helpers();
    $this->uploadPost = "public/upload/post";
  }

  // Post Index
  public function index(Request $request)
  {
    $type = $request->type;
    $numberPerPage = config('admin.post.' . $type . '.number_per_page');
    session(['module_active' => 'post-' . $type]);
    $keyword = htmlspecialchars($request->input('keyword'));
    if ($keyword) {
      $rows = News::where("title", "LIKE", "%{$keyword}%")->where('type', $type)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($numberPerPage);
    } else {
      $rows = News::where('type', $type)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($numberPerPage);
    }
    return view('admin.post.index', compact('rows', 'type'));
  }

  // Post Create
  public function create(Request $request)
  {
    $type = $request->type;
    session(['module_active' => 'post-' . $type]);
    return view('admin.post.create', compact('type'));
  }

  // Post Detail
  public function show(Request $request)
  {
    $type = $request->type;
    $row = News::where('type', $type)->find($request->id);
    $rowSeo = Seo::where('type', $type)->where('hash_seo', $row->hash)->first();
    return view('admin.post.show', compact('row', 'rowSeo', 'type'));
  }

  // Post Save
  public function save(Request $request)
  {
    $type = $request->type;
    $width1 = config('admin.post.' . $type . '.width1');
    $width2 = config('admin.post.' . $type . '.width2');
    $width3 = config('admin.post.' . $type . '.width3');
    $width4 = config('admin.post.' . $type . '.width4');
    $height1 = config('admin.post.' . $type . '.height1');
    $height2 = config('admin.post.' . $type . '.height2');
    $height3 = config('admin.post.' . $type . '.height3');
    $height4 = config('admin.post.' . $type . '.height4');
    $hashKey = Str::lower(Str::random(4));
    if (!file_exists($this->uploadPost)) {
      mkdir($this->uploadPost, 0777, true);
    }
    if (config('admin.post.' . $type . '.slug') === true) {
      $validator = Validator::make(
        $request->all(),
        [
          'slug' => ['required', 'unique:news'],
          'title' => ['required', 'unique:news'],
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
    } else {
      $validator = Validator::make(
        $request->all(),
        [
          'title' => ['required', 'unique:news'],
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
          'title' => 'Tiêu đề',
          'photo1' => 'Hình ảnh 1',
          'photo2' => 'Hình ảnh 2',
          'photo3' => 'Hình ảnh 3',
          'photo4' => 'Hình ảnh 4'
        ]
      );
    }

    if (!$validator->fails()) {
      $manager = new ImageManager(new Driver());
      if ($request->hasFile('photo1')) {
        $image = $manager->read($request->photo1)->resize($width1, $height1);
        $photo1 = hexdec(uniqid()) . "." . $request->photo1->getClientOriginalName();
        $path = public_path('upload/post');
        $image->save($path . "/" . $photo1);
      }
      if ($request->hasFile('photo2')) {
        $image = $manager->read($request->photo2)->resize($width2, $height2);
        $photo2 = hexdec(uniqid()) . "." . $request->photo2->getClientOriginalName();
        $path = public_path('upload/post');
        $image->save($path . "/" . $photo2);
      }
      if ($request->hasFile('photo3')) {
        $image = $manager->read($request->photo3)->resize($width3, $height3);
        $photo3 = hexdec(uniqid()) . "." . $request->photo3->getClientOriginalName();
        $path = public_path('upload/post');
        $image->save($path . "/" . $photo3);
      }
      if ($request->hasFile('photo4')) {
        $image = $manager->read($request->photo4)->resize($width4, $height4);
        $photo4 = hexdec(uniqid()) . "." . $request->photo4->getClientOriginalName();
        $path = public_path('upload/post');
        $image->save($path . "/" . $photo4);
      }
      $data = [
        'slug' => !empty($request->input('slug')) ? htmlspecialchars($request->input('slug')) : "",
        'title' => htmlspecialchars($request->input('title')),
        'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : 'hienthi',
        'hash' => $hashKey,
        'type' => $type,
        'num' => !empty($request->input('num')) ? $request->input('num') : 0,
        'desc' => !empty($request->input('desc')) ? htmlspecialchars($request->input('desc')) : null,
        'content' => !empty($request->input('content')) ? htmlspecialchars($request->input('content')) : null,
        'photo1' => !empty($photo1) ? $photo1 : null,
        'photo2' => !empty($photo2) ? $photo2 : null,
        'photo3' => !empty($photo3) ? $photo3 : null,
        'photo4' => !empty($photo4) ? $photo4 : null
      ];
      News::create($data);
      if ($request->input('title_seo')) {
        $dataSeo = [
          'title_seo' => htmlspecialchars($request->input('title_seo')),
          'hash_seo' => $hashKey,
          'type' => $type,
          'keywords' => !empty($request->input('keywords')) ? htmlspecialchars($request->input('keywords')) : null,
          'description_seo' => !empty($request->input('description_seo')) ? htmlspecialchars($request->input('description_seo')) : null,
        ];
        Seo::create($dataSeo);
      }
      return $this->helper->transfer("Thêm dữ liệu", "success", route('admin.post', ['type' => $type]));
    } else {
      return redirect()->route('admin.post.create', ['type' => $type])->withErrors($validator)->withInput();
    }
  }

  // Post Update
  public function update(Request $request)
  {
    $type = $request->type;
    $width1 = config('admin.post.' . $type . '.width1');
    $width2 = config('admin.post.' . $type . '.width2');
    $width3 = config('admin.post.' . $type . '.width3');
    $width4 = config('admin.post.' . $type . '.width4');
    $height1 = config('admin.post.' . $type . '.height1');
    $height2 = config('admin.post.' . $type . '.height2');
    $height3 = config('admin.post.' . $type . '.height3');
    $height4 = config('admin.post.' . $type . '.height4');
    $news = News::where('type', $type)->find($request->id);
    if (!file_exists($this->uploadPost)) {
      mkdir($this->uploadPost, 0777, true);
    }

    if (config('admin.post.' . $type . '.slug') === true) {
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
    } else {
      $validator = Validator::make(
        $request->all(),
        [
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
          'title' => 'Tiêu đề',
          'photo1' => 'Hình ảnh 1',
          'photo2' => 'Hình ảnh 2',
          'photo3' => 'Hình ảnh 3',
          'photo4' => 'Hình ảnh 4'
        ]
      );
    }

    if (!$validator->fails()) {
      $manager = new ImageManager(new Driver());
      if ($request->hasFile('photo1')) {
        $image = $manager->read($request->photo1)->resize($width1, $height1);
        $photo1 = hexdec(uniqid()) . "." . $request->photo1->getClientOriginalName();
        $path = public_path('upload/post');
        $image->save($path . "/" . $photo1);
      } else {
        $photo1 = isset($news->photo1) ? $news->photo1 : null;
      }
      if ($request->hasFile('photo2')) {
        $image = $manager->read($request->photo2)->resize($width2, $height2);
        $photo2 = hexdec(uniqid()) . "." . $request->photo2->getClientOriginalName();
        $path = public_path('upload/post');
        $image->save($path . "/" . $photo2);
      } else {
        $photo2 = isset($news->photo2) ? $news->photo2 : null;
      }
      if ($request->hasFile('photo3')) {
        $image = $manager->read($request->photo3)->resize($width3, $height3);
        $photo3 = hexdec(uniqid()) . "." . $request->photo3->getClientOriginalName();
        $path = public_path('upload/post');
        $image->save($path . "/" . $photo3);
      } else {
        $photo3 = isset($news->photo3) ? $news->photo3 : null;
      }
      if ($request->hasFile('photo4')) {
        $image = $manager->read($request->photo4)->resize($width4, $height4);
        $photo4 = hexdec(uniqid()) . "." . $request->photo4->getClientOriginalName();
        $path = public_path('upload/post');
        $image->save($path . "/" . $photo4);
      } else {
        $photo4 = isset($news->photo4) ? $news->photo4 : null;
      }
      $data = [
        'slug' => !empty($request->input('slug')) ? htmlspecialchars($request->input('slug')) : '',
        'title' => htmlspecialchars($request->input('title')),
        'status' => !empty($request->input('status')) ? htmlspecialchars(implode(',', $request->input('status'))) : 'hienthi',
        'num' => !empty($request->input('num')) ? $request->input('num') : 0,
        'desc' => !empty($request->input('desc')) ? htmlspecialchars($request->input('desc')) : null,
        'content' => !empty($request->input('content')) ? htmlspecialchars($request->input('content')) : null,
        'photo1' => !empty($photo1) ? $photo1 : null,
        'photo2' => !empty($photo2) ? $photo2 : null,
        'photo3' => !empty($photo3) ? $photo3 : null,
        'photo4' => !empty($photo4) ? $photo4 : null
      ];
      $news->update($data);
      if ($request->input('title_seo')) {
        $dataSeo = [
          'title_seo' => htmlspecialchars($request->input('title_seo')),
          'keywords' => !empty($request->input('keywords')) ? htmlspecialchars($request->input('keywords')) : null,
          'description_seo' => !empty($request->input('description_seo')) ? htmlspecialchars($request->input('description_seo')) : null,
          'schema' => !empty($request->input('schema')) ? htmlspecialchars($request->input('schema')) : null,
          'hash_seo' => $news->hash,
          'type' => $type,
          'id_parent' => !empty($news->id) ? $news->id  : null
        ];
        $seo = Seo::where('hash_seo', $news->hash)->first();
        if ($seo) {
          Seo::where('hash_seo', $news->hash)->update($dataSeo);
        } else {
          Seo::create($dataSeo);
        }
      }
      return $this->helper->transfer("Cập nhật dữ liệu", "success", route('admin.post.show', ['type' => $type, 'id' => $news->id]));
    } else {
      return redirect()->route('admin.post.show', ['type' => $type, 'id' => $news->id])->withErrors($validator)->withInput();
    }
  }

  /* Post duplicate */
  public function copy(Request $request)
  {
    $type = $request->type;
    $id = $request->id;
    $row = News::where('type', $type)->find($id);
    $titleCopy = $row->title . " copy " . str_repeat(Str::lower(Str::random(4)), 1);
    $slugCopy = $this->helper->changeTitle($titleCopy);
    News::create(
      [
        'slug' => htmlspecialchars($slugCopy),
        'title' => htmlspecialchars($titleCopy),
        'desc' => !empty($row->desc) ? htmlspecialchars(htmlspecialchars_decode($row->desc)) : null,
        'content' => !empty($row->content) ? htmlspecialchars(htmlspecialchars_decode($row->content)) : null,
        'type' => $type,
        'num' => 0,
        'hash' => Str::lower(Str::random(4)),
        'status' => 'hienthi'
      ]
    );
    return $this->helper->transfer("Sao chép dữ liệu", "success", route('admin.post', ['type' => $type]));
  }

  /* Post delete static */
  public function delete(Request $request)
  {
    $type = $request->type;
    $id = $request->id;
    $hash = $request->hash;
    $upload = "public/upload/post/";
    $post = News::where('type', $type)->where('hash', $hash)->find($id);
    $seo = SEO::where('type', $type)->where('hash_seo', $hash);
    $photo1 = isset($post->photo1) && !empty($post->photo1) ? $post->photo1 : "";
    $photo2 = isset($post->photo2) && !empty($post->photo2) ? $post->photo2 : "";
    $photo3 = isset($post->photo3) && !empty($post->photo3) ? $post->photo3 : "";
    $photo4 = isset($post->photo4) && !empty($post->photo4) ? $post->photo4 : "";
    if (file_exists($upload . $photo1) && !empty($photo1)) unlink($upload . $photo1);
    if (file_exists($upload . $photo2) && !empty($photo2)) unlink($upload . $photo2);
    if (file_exists($upload . $photo3) && !empty($photo3)) unlink($upload . $photo3);
    if (file_exists($upload . $photo4) && !empty($photo4)) unlink($upload . $photo4);
    $post->delete();
    $seo->delete();
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.post', ['type' => $type]));
  }

  /* Post delete mutiple */
  public function destroy(Request $request)
  {
    $type = $request->type;
    $upload = "public/upload/post/";
    $posts = News::where('type', $type)->find($request->checkitem);
    foreach ($posts as $v) {
      $photo1 = isset($v->photo1) && !empty($v->photo1) ? $v->photo1 : "";
      $photo2 = isset($v->photo2) && !empty($v->photo2) ? $v->photo2 : "";
      $photo3 = isset($v->photo3) && !empty($v->photo3) ? $v->photo3 : "";
      $photo4 = isset($v->photo4) && !empty($v->photo4) ? $v->photo4 : "";
      if (file_exists($upload . $photo1) && !empty($photo1)) unlink($upload . $photo1);
      if (file_exists($upload . $photo2) && !empty($photo2)) unlink($upload . $photo2);
      if (file_exists($upload . $photo3) && !empty($photo3)) unlink($upload . $photo3);
      if (file_exists($upload . $photo4) && !empty($photo4)) unlink($upload . $photo4);
    }
    News::destroy($request->checkitem);
    Seo::where('type', $type)->whereIn('hash_seo', $request->hashes)->delete();
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.post', ['type' => $type]));
  }

  /* Post update number ajax */
  public function updateNumber(Request $request)
  {
    $type = $request->type;
    $id = $request->id;
    $value = $request->value;
    News::where('id', $id)->where('type', $type)->update(['num' => $value]);
  }

  /* Post update status ajax */
  public function updateStatus(Request $request)
  {
    $type = $request->type;
    $status = News::select('status')->where('type', $type)->find($request->id)->status;
    $status = !empty($status) ? explode(',', $status) : [];
    if (array_search($request->value, $status) !== false) {
      $key = array_search($request->value, $status);
      unset($status[$key]);
    } else {
      array_push($status, $request->value);
    }
    $statusStr = implode(',', $status);
    News::where('id', $request->id)->where('type', $type)->update(['status' => $statusStr]);
  }

  /* Post delete photo */
  public function deletePhoto(Request $request)
  {
    $type = $request->type;
    $uploadNews = "public/upload/post/";
    $action = $request->action;
    $photo = News::where('type', $type)->find($request->id)->$action;
    $photo = isset($photo) && !empty($photo) ? $photo : "";
    if (file_exists($uploadNews . $photo) && !empty($photo)) unlink($uploadNews . $photo);
    News::where('id', $request->id)->where('type', $type)->update([$action => null]);
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.post.show', ['type' => $type, 'id' => $request->id]));
  }

  /* Post schema JSON */
  public function schema(Request $request)
  {
    $type = $request->type;
    $row = News::where('type', $type)->find($request->id);
    $seo = Seo::where('type', $type)->where('hash_seo', $row->hash)->first();
    if ($seo) {
      $setting = Setting::where('type', config('admin.setting.type'))->first();
      $photo = !empty($row->photo1 ? config('app.asset_url') . "upload/news/$row->photo1" : config('app.url') . "resources/images/noimage.png");
      $l = Photo::where('type', config('admin.photo.logo.type'))->where('action', 'static')->first();
      $logo = isset($l) && !empty($l->photo) ? $l->photo : 'Logo';
      $schemaJSON = $this->helper->buildSchemaArticle($row->id, $row->title, $photo, Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('d/m/Y H:i:s'), Carbon::createFromFormat('Y-m-d H:i:s', $row->updated_at)->format('d/m/Y H:i:s'), $setting->title, config('app.url') . $row->slug, $logo, config('app.url'));
      Seo::where('type', $type)->where('hash_seo', $row->hash)->update(['schema' => $schemaJSON]);
      return $this->helper->transfer("Tạo schema JSON Article", "success", route('admin.post.show', ['type' => $type, 'id' => $row->id]));
    } else {
      return $this->helper->transfer("Bạn cần có Data SEO để tạo Schema JSON Article .Thao tác tạo schema JSON Article", "danger", route('admin.post.show', ['type' => $type, 'id' => $row->id]));
    }
  }
}
