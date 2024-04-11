<?php

namespace App\Http\Controllers;

use App\Models\Admin\Newsletter;
use App\Utils\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
  private $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }
  public function index(Request $request)
  {
    $validator = Validator::make(
      $request->get('dataNewsletter'),
      [
        'fullname' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'address' => ['required', 'string', 'max:255'],
        'phone' => ['numeric', 'regex:/^[0-9]{3}[0-9]{4}[0-9]{3,4}$/']
      ],
      [
        'fullname.required' => 'Họ và tên không được bỏ trống',
        'fullname.string' => 'Họ và tên phải là chuỗi ký tự',
        'fullname.max' => 'Họ và tên tối đa 255 ký tự',
        'email.required' => 'Email không được bỏ trống',
        'email.string' => 'Email phải là chuỗi ký tự',
        'email.max' => 'Email tối đa 255 ký tự',
        'email.email' => 'Email chưa đúng định dạng',
        'address.required' => 'Địa chỉ không được bỏ trống',
        'address.string' => 'Địa chỉ phải là chuỗi ký tự',
        'address.max' => 'Địa chỉ tối đa 255 ký tự',
        'phone.numeric' => 'Số điện thoại phải là dạng chữ số',
        'phone.regex' => 'Số điện thoại phải có ít nhất 10 số hoặc 11 số từ 0 đến 9'
      ]
    );

    $newsletter = $request->input('dataNewsletter');
    if (!$validator->fails()) {
      $data = [
        'fullname' => !empty($newsletter['fullname']) ? htmlspecialchars($newsletter['fullname']) : null,
        'email' => !empty($newsletter['email']) ? htmlspecialchars($newsletter['email']) : null,
        'address' => !empty($newsletter['address']) ? htmlspecialchars($newsletter['address']) : null,
        'phone' => !empty($newsletter['phone']) ? htmlspecialchars($newsletter['phone']) : null,
        'content' => !empty($newsletter['content']) ? htmlspecialchars($newsletter['content']) : null,
        'type' => config('admin.message.newsletter.type'),
        'confirm_status' => 0,
        'num' => 0
      ];
      Newsletter::create($data);
      return $this->helper->transfer("Đăng ký nhận tin", "success", route('home'));
    } else {
      session()->flash('fullname', $newsletter['fullname']);
      session()->flash('address', $newsletter['address']);
      session()->flash('email', $newsletter['email']);
      session()->flash('phone', $newsletter['phone']);
      session()->flash('content', $newsletter['content']);
      return redirect()->back()->withErrors($validator)->withInput();
    }
  }
}
