<?php

namespace App\Http\Controllers\Admin;

use App\Utils\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Admin\Newsletter;
use Illuminate\Http\Request;

class ContactController extends Controller
{
  public $helper;
  private $type;
  private $numberPerPage;
  public function __construct()
  {
    $this->helper = new Helpers();
    $this->type = 'lien-he';
    $this->numberPerPage = 10;
  }

  /* Contact list */
  public function index(Request $request)
  {
    $keyword = htmlspecialchars($request->input('keyword'));
    session(['module_active' => '']);
    if ($keyword) {
      $rows = Newsletter::where("fullname", "LIKE", "%{$keyword}%")->where('type', $this->type)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($this->numberPerPage);
    } else {
      $rows = Newsletter::where('type', $this->type)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($this->numberPerPage);
    }
    return view('admin.contact.index', compact('rows'));
  }

  /* Contact detail */
  public function show(Request $request)
  {
    $row = Newsletter::where('type', $this->type)->find($request->id);
    return view('admin.contact.show', compact('row'));
  }

  /* Contact update number */
  public function updateNumber(Request $request)
  {
    Newsletter::where('id', $request->id)->where('type', $this->type)->update(['num' => $request->value]);
  }

  /* Contact multiple delete */
  public function destroy(Request $request)
  {
    Newsletter::destroy($request->checkitem);
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.contact'));
  }

  /* Contact static delete */
  public function delete(Request $request)
  {
    Newsletter::where('type', $this->type)->where('id', $request->id)->delete();
    return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.contact'));
  }
}
