<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\City;
use App\Models\Admin\District;
use App\Utils\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
  protected $helper;
  protected $type;
  protected $numberPerPage;
  public function __construct()
  {
    $this->middleware('admin.auth');
    $this->helper = new Helpers();
  }

  /* Handle check request type namespace */
  public function checkRequestType($req)
  {
    if ($req == 'city') {
      $namespace = 'App\Models\Admin\City';
    } elseif ($req == 'district') {
      $namespace = 'App\Models\Admin\District';
    } else {
      $namespace = 'App\Models\Admin\Ward';
    }
    return $namespace;
  }

  /* Place index */
  public function index(Request $request)
  {
    $type = $request->type;
    session(['module_active' => $type . '_index']);
    $numberPerPage = config("admin.place." . $type . ".number_per_page");
    $namespace = $this->checkRequestType($request->type);
    $appendQueryString = ['code_city' => $request->code_city, 'code_district' => $request->code_district];
    if ($type == 'district') {
      $rowSelect = City::where('type_city', config('admin.place.city.type'))->get();
    } elseif ($type == 'ward') {
      $rowSelect = District::where('type_district', config('admin.place.district.type'))->get();
    } else {
      $rowSelect = [];
    }
    $keyword = htmlspecialchars($request->input('keyword'));
    if ($keyword) {
      $rows = $namespace::where('name_' . $type, "LIKE", "%{$keyword}%")->where('type_' . $type, $type)->orderBy('num', 'ASC')->orderBy('id_' . $type, 'ASC')->paginate($numberPerPage)->appends($appendQueryString);
    } else {
      if ($request->code_city) {
        $rows = $namespace::where('type_' . $type, $type)->where('code_city', $request->code_city)->orderBy('num', 'ASC')->orderBy('id_' . $type, 'ASC')->paginate($numberPerPage)->appends($appendQueryString);
      } elseif ($request->code_district) {
        $rows = $namespace::where('type_' . $type, $type)->where('code_district', $request->code_district)->orderBy('num', 'ASC')->orderBy('id_' . $type, 'ASC')->paginate($numberPerPage)->appends($appendQueryString);
      } else {
        $rows = $namespace::where('type_' . $type, $type)->orderBy('num', 'ASC')->orderBy('id_' . $type, 'ASC')->paginate($numberPerPage)->appends($appendQueryString);
      }
    }
    return view('admin.place.index', compact('rows', 'rowSelect', 'type'));
  }

  /* Place create */
  public function create(Request $request)
  {
    $type = $request->type;
    session(['module_active' => $type . '_create']);
    return view('admin.place.create', compact('type'));
  }

  /* Place detail */
  public function show(Request $request)
  {
    $type = $request->type;
    $fieldType = 'type_' . $type;
    $fieldId = 'id_' . $type;
    $id = $request->id;
    $namespace = $this->checkRequestType($type);
    $row = $namespace::where($fieldType, $type)->where($fieldId, $id)->first();
    return view('admin.place.show', compact('row', 'type'));
  }

  /* Place update number */
  public function updateNumber(Request $request)
  {
    $namespace = $this->checkRequestType($request->type);
    $namespace::where('id_' . $request->type, $request->id)->where('type_' . $request->type, $request->type)->update(['num' => $request->value]);
  }

  /* Place delete static */
  public function delete(Request $request)
  {
    $namespace = $this->checkRequestType($request->type);
    $direct = "admin.place." . $request->type . ".index";
    $id = "id_" . $request->type;
    $namespace::where('type_' . $request->type, $request->type)->where($id, $request->id)->delete();
    return $this->helper->transfer("Xóa dữ liệu", "success", route($direct, ['type' => $request->type]));
  }

  /* Place delete multiple */
  public function destroy(Request $request)
  {
    $namespace = $this->checkRequestType($request->type);
    $direct = "admin.place." . $request->type . ".index";
    $namespace::destroy($request->checkitem);
    return $this->helper->transfer("Xóa dữ liệu", "success", route($direct, ['type' => $request->type]));
  }

  /* Place save */
  public function save(Request $request)
  {
    $type = $request->type;
    $namespace = $this->checkRequestType($type);
    if ($type == 'ward') {
      $validator = Validator::make(
        $request->all(),
        [
          "name_ward" => ['required', "unique:ward"],
          "code_district" => ['required', "max:3", "regex:/^[0-9]+$/"],
        ],
        [
          'required' => ':attribute không được để trống',
          'unique' => ':attribute đã tồn tại.',
          'max' => ':attribute không vượt quá :max',
          'regex' => ':attribute chưa đúng định dạng'
        ],
        [
          "name_ward" => 'Tên phường xã',
          "code_district" => 'Mã quận huyện'
        ]
      );
    } elseif ($type == 'district') {
      $validator = Validator::make(
        $request->all(),
        [
          "name_district" => ['required', "unique:district"],
          "code_district" => ['required', "unique:district", "max:3", "regex:/^[0-9]+$/"],
          "code_city" => ['required', "max:3", "regex:/^[0-9]+$/"]
        ],
        [
          'required' => ':attribute không được để trống',
          'unique' => ':attribute đã tồn tại.',
          'max' => ':attribute không vượt quá :max',
          'regex' => ':attribute chưa đúng định dạng'
        ],
        [
          "name_district" => 'Tên quận huyện',
          "code_city" => 'Mã tỉnh thành',
          "code_district" => 'Mã quận huyện'
        ]
      );
    } else {
      $validator = Validator::make(
        $request->all(),
        [
          "name_city" => ['required', "unique:city"],
          "code_city" => ['required', "unique:city", "max:3", "regex:/^[0-9]+$/"]
        ],
        [
          'required' => ':attribute không được để trống',
          'unique' => ':attribute đã tồn tại.',
          'max' => ':attribute không vượt quá :max',
          'regex' => ':attribute chưa đúng định dạng'
        ],
        [
          "name_city" => 'Tên tỉnh thành',
          "code_city" => 'Mã tỉnh thành'
        ]
      );
    }
    if (!$validator->fails()) {
      if ($type == 'ward') {
        $data = [
          "name_ward" => htmlspecialchars($request->input("name_ward")),
          'type_ward' => $type,
          'num' => !empty($request->input('num')) ? $request->input('num') : 0,
          'code_district' => $request->input('code_district')
        ];
      } elseif ($type == 'district') {
        $data = [
          "name_district" => htmlspecialchars($request->input("name_district")),
          'type_district' => $type,
          'num' => !empty($request->input('num')) ? $request->input('num') : 0,
          'code_city' => $request->input('code_city'),
          'code_district' => $request->input('code_district')
        ];
      } else {
        $data = [
          "name_city" => htmlspecialchars($request->input("name_city")),
          'type_city' => $type,
          'code_city' => $request->input('code_city'),
          'num' => !empty($request->input('num')) ? $request->input('num') : 0,
        ];
      }
      $namespace::create($data);
      return $this->helper->transfer("Thêm dữ liệu", "success", route("admin.place." . $type . ".index", ['type' => $type]));
    } else {
      return redirect()->route("admin.place." . $type . ".create", ['type' => $type])->withErrors($validator)->withInput();
    }
  }

  /* Place update */
  public function update(Request $request)
  {
    $type = $request->type;
    $id = $request->id;
    $namespace = $this->checkRequestType($type);
    $fieldId = 'id_' . $type;
    $row = $namespace::where($fieldId, $id)->first();
    if ($type == 'ward') {
      $validator = Validator::make(
        $request->all(),
        [
          "name_ward" => ['required', "unique:ward"],
          "code_district" => ['required', "max:3", "regex:/^[0-9]+$/"],
        ],
        [
          'required' => ':attribute không được để trống',
          'unique' => ':attribute đã tồn tại.',
          'max' => ':attribute không vượt quá :max',
          'regex' => ':attribute chưa đúng định dạng'
        ],
        [
          "name_ward" => 'Tên phường xã',
          "code_district" => 'Mã quận huyện'
        ]
      );
    } elseif ($type == 'district') {
      $validator = Validator::make(
        $request->all(),
        [
          "name_district" => ['required', "unique:district"],
          "code_district" => ['required', "unique:district", "max:3", "regex:/^[0-9]+$/"],
          "code_city" => ['required', "max:3", "regex:/^[0-9]+$/"]
        ],
        [
          'required' => ':attribute không được để trống',
          'unique' => ':attribute đã tồn tại.',
          'max' => ':attribute không vượt quá :max',
          'regex' => ':attribute chưa đúng định dạng'
        ],
        [
          "name_district" => 'Tên quận huyện',
          "code_city" => 'Mã tỉnh thành',
          "code_district" => 'Mã quận huyện'
        ]
      );
    } else {
      $validator = Validator::make(
        $request->all(),
        [
          "name_city" => ['required', "unique:city"],
          "code_city" => ['required', "unique:city", "max:3", "regex:/^[0-9]+$/"]
        ],
        [
          'required' => ':attribute không được để trống',
          'unique' => ':attribute đã tồn tại.',
          'max' => ':attribute không vượt quá :max',
          'regex' => ':attribute chưa đúng định dạng'
        ],
        [
          "name_city" => 'Tên tỉnh thành',
          "code_city" => 'Mã tỉnh thành'
        ]
      );
    }
    if (!$validator->fails()) {
      if ($type == 'ward') {
        $data = [
          "name_ward" => htmlspecialchars($request->input("name_ward")),
          'num' => !empty($request->input('num')) ? $request->input('num') : 0,
          'code_district' => !empty($request->input('code_district')) ? $request->input('code_district') : ''
        ];
      } elseif ($type == 'district') {
        $data = [
          "name_district" => htmlspecialchars($request->input("name_district")),
          'num' => !empty($request->input('num')) ? $request->input('num') : 0,
          'code_city' => !empty($request->input('code_city')) ? $request->input('code_city') : '',
          'code_district' => !empty($request->input('code_district')) ? $request->input('code_district') : ''
        ];
      } else {
        $data = [
          "name_city" => htmlspecialchars($request->input("name_city")),
          'code_city' => !empty($request->input('code_city')) ? $request->input('code_city') : '',
          'num' => !empty($request->input('num')) ? $request->input('num') : 0
        ];
      }
      $row->update($data);
      return $this->helper->transfer("Cập nhật dữ liệu", "success", route("admin.place." . $type . ".show", ['id' => $id, 'type' => $type]));
    } else {
      return redirect()->route("admin.place." . $type . ".show", ['id' => $id, 'type' => $type])->withErrors($validator)->withInput();
    }
  }
}
