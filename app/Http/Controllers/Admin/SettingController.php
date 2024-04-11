<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\Helpers;

class SettingController extends Controller
{
  protected $type;
  protected $helper;
  public function __construct()
  {
    $this->middleware('admin.auth');
    $this->helper = new Helpers();
    $this->type = config('admin.setting.type');
  }

  /*Setting index*/
  public function index()
  {
    session(['module_active' => 'setting_index']);
    $row = Setting::where('type', $this->type)->first();
    $options = isset($row->options) ? json_decode($row->options) : [];
    return view('admin.setting.index', compact('row', 'options'));
  }

  /*Setting save*/
  public function save(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        "title" => ['required']
      ],
      [
        'required' => ':attribute không được để trống'
      ],
      [
        "title" => 'Tên công ty'
      ]
    );
    if (isset($_POST['save'])) {
      if (!$validator->fails()) {
        $d = array(
          'title' => !empty($request->input('title')) ? htmlspecialchars($request->input('title')) : null,
          'address' => !empty($request->input('address')) ? htmlspecialchars($request->input('address')) : null,
          'mastertool' => !empty($request->input('mastertool')) ? htmlspecialchars($request->input('mastertool')) : null,
          'analytics' => !empty($request->input('analytics')) ? htmlspecialchars($request->input('analytics')) : null,
          'headjs' => !empty($request->input('headjs')) ? htmlspecialchars($request->input('headjs')) : null,
          'bodyjs' => !empty($request->input('bodyjs')) ? htmlspecialchars($request->input('bodyjs')) : null,
          'options' => !empty($request->input('options')) ? json_encode($request->input('options')) : null,
          'type' => $this->type
        );
        Setting::create($d);
        return $this->helper->transfer("Thêm dữ liệu", "success", route('admin.setting'));
      } else {
        return redirect()->route('admin.setting')->withErrors($validator)->withInput();
      }
    } else {
      $row = Setting::where('type', $this->type)->find($request->id);
      if (!$validator->fails()) {
        $d = array(
          'title' => !empty($request->input('title')) ? htmlspecialchars($request->input('title')) : null,
          'mastertool' => !empty($request->input('mastertool')) ? htmlspecialchars($request->input('mastertool')) : null,
          'analytics' => !empty($request->input('analytics')) ? htmlspecialchars($request->input('analytics')) : null,
          'address' => !empty($request->input('address')) ? htmlspecialchars($request->input('address')) : null,
          'headjs' => !empty($request->input('headjs')) ? htmlspecialchars($request->input('headjs')) : null,
          'bodyjs' => !empty($request->input('bodyjs')) ? htmlspecialchars($request->input('bodyjs')) : null,
          'options' => !empty($request->input('options')) ? json_encode($request->input('options')) : null
        );
        $row->update($d);
        return $this->helper->transfer("Cập nhật dữ liệu", "success", route('admin.setting'));
      } else {
        return redirect()->route('admin.setting')->withErrors($validator)->withInput();
      }
    }
  }
}
