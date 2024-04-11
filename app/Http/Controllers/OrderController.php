<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Admin\City;
use App\Models\Admin\District;
use App\Models\Admin\News;
use App\Models\Admin\Order;
use App\Models\Admin\OrderDetail;
use App\Models\Admin\Product;
use App\Models\Admin\Setting;
use App\Models\Admin\Ward;
use Illuminate\Http\Request;
use App\Utils\BreadCrumbs;
use App\Utils\Helpers;
use App\Utils\Seo;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    private $type;
    private $seo;
    private $helper;
    private $breadcrumbs;
    public function __construct()
    {
        $this->type = 'gio-hang';
        $this->helper = new Helpers();
        $this->seo = new Seo();
        $this->breadcrumbs = new BreadCrumbs();
    }

    public function index()
    {
        $titleMain = "Giỏ hàng";
        /* Danh sách sản phẩm trong giỏ hàng */
        $carts = Cart::content();
        /* Tỉnh thành */
        $citys = City::where('type_city', config('admin.place.city.type'))->orderBy('num', 'ASC')->orderBy('id_city', 'ASC')->get();
        /* Quận huyện */
        $districts = District::where('type_district', config('admin.place.district.type'))->orderBy('num', 'ASC')->orderBy('id_district', 'ASC')->get();
        /* Phường xã */
        $wards = Ward::where('type_ward', config('admin.place.ward.type'))->orderBy('num', 'ASC')->orderBy('id_ward', 'ASC')->get();
        /* Hình thức thanh toán */
        $payments = News::where('type', config('admin.post.hinh-thuc-thanh-toan.type'))->whereRaw('find_in_set("hienthi", status)')->orderBy('num', 'ASC')->orderBy('id', 'ASC')->get();
        /* SEO */
        $seo = $this->seo;
        $this->seo->set('h1', $titleMain);
        $this->seo->set('title', $titleMain);
        $this->seo->set('keywords', "");
        $this->seo->set('description', "");
        $this->seo->set('url', config('app.url') . request()->path());
        $this->seo->set('type', 'object');
        $this->seo->set('photo', "");
        $this->seo->set('photo:width', "");
        $this->seo->set('photo:height', "");
        $this->seo->set('photo:type', "");
        /* Breadcrumbs */
        $this->breadcrumbs->set($this->type, "Giỏ hàng");
        $breadcrumbs = $this->breadcrumbs->get();
        return view('order.index', compact('carts', 'citys', 'districts', 'wards', 'seo', 'breadcrumbs', 'titleMain', 'payments'));
    }

    public function add(Request $request)
    {
        @$id = $request->id;
        $row = Product::where('type', config('admin.san-pham.type'))->where('id', $id)->first();
        Cart::add(
            [
                'id' => $row->id,
                'name' => $row->title,
                'qty' => !empty($request->quantity) ? $request->quantity : 1,
                'price' => $row->sale_price,
                'options' => [
                    'photo' => $row->photo1,
                    'code' => $row->code,
                    'regular_price' => $row->regular_price
                ]
            ]
        );
        return $this->helper->transfer("Thêm vào giỏ hàng", "success", route('order.index'));
    }

    public function updateCartAjax(Request $request)
    {
        $qty = $request->input('qty');
        $price = $request->input('price');
        $rowId = $request->input('rowId');
        $subTotal = $price * $qty;
        Cart::update($rowId, $qty);
        $data = array(
            'subTotal' => number_format($subTotal, 0, ",", ".") . "đ",
            'total' => number_format(Cart::total(), 0, ",", ".") . "đ",
        );
        echo  json_encode($data);
    }

    public function remove($rowId)
    {
        if ($rowId) {
            Cart::remove($rowId);
        }
    }

    public function destroy()
    {
        Cart::destroy();
        return $this->helper->transfer("Xóa giỏ hàng", "success", route('order.index'));
    }

    public function checkout(Request $request)
    {
        $setting = Setting::where('type', config('admin.setting.type'))->first();
        $options = $setting->options ? json_decode($setting->options) : [];
        $validator = Validator::make(
            $request->all(),
            [
                'fullname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'city' => ['required'],
                'district' => ['required'],
                'ward' => ['required'],
                'payments' => ['required'],
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
                'phone.regex' => 'Số điện thoại phải có ít nhất 10 số hoặc 11 số từ 0 đến 9',
                'city.required' => 'Tỉnh thành chưa được chọn',
                'ward.required' => 'Phường xã chưa được chọn',
                'district.required' => 'Quận huyện chưa được chọn',
                'payments.required' => 'Hình thức thanh toán chưa được chọn'
            ]
        );
        if (!$validator->fails()) {
            $code = Str::upper($this->helper->stringRandom(6));
            Order::create(
                [
                    'fullname' => htmlspecialchars($request->input('fullname')),
                    'phone' => htmlspecialchars($request->input('phone')),
                    'email' => htmlspecialchars($request->input('email')),
                    'city' => htmlspecialchars($request->input('city')),
                    'district' => htmlspecialchars($request->input('district')),
                    'ward' => htmlspecialchars($request->input('ward')),
                    'address' => htmlspecialchars($request->input('address')),
                    'payments' => htmlspecialchars($request->input('payments')),
                    'requirements' => !empty($request->input('requirements')) ? htmlspecialchars($request->input('requirements')) : null,
                    'order_status' => 1,
                    'num' => 0,
                    'type' => 'order',
                    'code' => $code,
                    'order_status' => 1,
                    'total_price' => Cart::total()
                ]
            );
            foreach (Cart::content() as &$cart) {
                OrderDetail::create(
                    [
                        'id_product' => $cart->id,
                        'title' => $cart->name,
                        'photo' => $cart->options->photo,
                        'sale_price' => $cart->price,
                        'regular_price' => $cart->options->regular_price,
                        'quantity' => $cart->qty,
                        'code' => $code
                    ]
                );
            }
            Mail::to($request->input('email'))->send(new OrderMail(
                [
                    'fullname' => $request->input('fullname'),
                    'email' => $request->input('email'),
                    'code' => $code,
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'time' => Carbon::createFromFormat('Y-m-d H:i:s', now('Asia/Ho_Chi_Minh'))->format('d/m/Y H:i:s A'),
                    'hotline' => $options->hotline
                ]
            ));
            Cart::destroy();
            return $this->helper->transfer("Đơn hàng đã được chờ xác nhận. Chúng tôi sẽ liên lạc với bạn sớm nhất. Xác nhận đơn hàng", "success", route('home'));
        } else {
            session()->flash('fullname', $request->fullname);
            session()->flash('address', $request->address);
            session()->flash('email', $request->email);
            session()->flash('phone', $request->phone);
            session()->flash('city', $request->city);
            session()->flash('district', $request->district);
            session()->flash('payments', $request->payments);
            session()->flash('ward', $request->ward);
            session()->flash('requirements', $request->requirements);
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
