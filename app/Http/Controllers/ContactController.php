<?php

namespace App\Http\Controllers;

use App\Models\Admin\Newsletter;
use App\Models\Admin\Page;
use App\Models\Admin\Seopage;
use Illuminate\Http\Request;
use App\Utils\BreadCrumbs;
use App\Utils\Helpers;
use App\Utils\Seo;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
  public $seo;
  public $breadcrumbs;
  private $helper;

  public function __construct()
  {
    $this->breadcrumbs = new BreadCrumbs();
    $this->seo = new Seo();
    $this->helper = new Helpers();
  }
  public function index(Request $request)
  {
    $titleMain = "Liên hệ";
    $seo = $this->seo;
    $contact = Page::where('type', config('admin.page.contact.type'))->whereRaw('find_in_set("hienthi", status)')->first();
    /* SEO */
    $seoPage = Seopage::where('type', config('admin.seopage.lien-he.type'))->first();
    $this->seo->set('h1', !empty($seoPage->title) ? $seoPage->title : "Liên hệ");
    $this->seo->set('title', !empty($seoPage->title) ? $seoPage->title : "Liên hệ");
    $this->seo->set('keywords', !empty($seoPage->keywords) ? $seoPage->keywords : "");
    $this->seo->set('description', !empty($seoPage->description) ? $seoPage->description : "");
    $this->seo->set('url', config('app.url') . $request->path());
    $this->seo->set('type', 'object');
    if (!empty($seoPage->photo)) {
      $manager = new ImageManager(new Driver());
      $seoPagePhoto = $manager->read(public_path('upload/seopage/' . $seoPage->photo));
      $this->seo->set('photo', config('app.asset_url') . "upload/seopage/" . $seoPage->photo);
      $mime = strtolower(pathinfo('upload/seopage/' . $seoPage->photo, PATHINFO_EXTENSION));
      $this->seo->set('photo:width', $seoPagePhoto->width());
      $this->seo->set('photo:height', $seoPagePhoto->height());
      $this->seo->set('photo:type', "image/" . $mime);
    } else {
      $this->seo->set('photo', config('app.url') . "resources/images/noimage.png");
      $this->seo->set('photo:width', config('admin.seopage.lien-he.with'));
      $this->seo->set('photo:height', config('admin.seopage.lien-he.height'));
      $this->seo->set('photo:type', "image/png");
    }

    /* Breadcrumbs */
    $this->breadcrumbs->set('lien-he', 'Liên hệ');
    $breadcrumbs = $this->breadcrumbs->get();
    return view('contact.index', compact('contact', 'seo', 'breadcrumbs', 'titleMain'));
  }

  public function stored(Request $request)
  {
    $validator = Validator::make(
      $request->get('dataContact'),
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

    $contact = $request->input('dataContact');
    if (!$validator->fails()) {
      $data = [
        'fullname' => !empty($contact['fullname']) ? htmlspecialchars($contact['fullname']) : null,
        'email' => !empty($contact['email']) ? htmlspecialchars($contact['email']) : null,
        'address' => !empty($contact['address']) ? htmlspecialchars($contact['address']) : null,
        'phone' => !empty($contact['phone']) ? htmlspecialchars($contact['phone']) : null,
        'subject' => !empty($contact['subject']) ? htmlspecialchars($contact['subject']) : null,
        'content' => !empty($contact['content']) ? htmlspecialchars($contact['content']) : null,
        'type' => 'lien-he',
        'confirm_status' => 0,
        'num' => 0
      ];
      Newsletter::create($data);
      return $this->helper->transfer("Đăng ký liên hệ", "success", route('contact'));
    } else {
      session()->flash('fullname', $contact['fullname']);
      session()->flash('address', $contact['address']);
      session()->flash('email', $contact['email']);
      session()->flash('phone', $contact['phone']);
      session()->flash('subject', $contact['subject']);
      session()->flash('content', $contact['content']);
      return redirect()->back()->withErrors($validator)->withInput();
    }
  }
}
