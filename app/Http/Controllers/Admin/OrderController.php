<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Order;
use App\Models\Admin\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Utils\Helpers;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    private $numberPerPage;
    public $helper;

    public function __construct()
    {
        $this->middleware('admin.auth');
        $this->helper = new Helpers();
        $this->numberPerPage = config('admin.order.number_per_page');
    }

    public function index(Request $request)
    {
        session(['module_active' => 'order_index']);
        $row1 = DB::table('order')->where('order_status', 1)->get();
        $row2 = DB::table('order')->where('order_status', 2)->get();
        $row3 = DB::table('order')->where('order_status', 3)->get();
        $row4 = DB::table('order')->where('order_status', 4)->get();
        $keyword = htmlspecialchars($request->input('keyword'));
        if ($keyword) {
            $rows = DB::table('order')->where("fullname", "LIKE", "%{$keyword}%")->join('news', 'order.payments', '=', 'news.id')->paginate($this->numberPerPage);
        } else {
            $rows = DB::table('order')->join('news', 'order.payments', '=', 'news.id')->paginate($this->numberPerPage);
        }
        return view('admin.order.index', compact('rows', 'row1', 'row2', 'row3', 'row4'));
    }

    public function show(Request $request)
    {
        $rowInfo = Order::where('code', $request->code)->join('news', 'order.payments', '=', 'news.id')->first();
        $rowDetail = DB::table('order_detail')->join('products', 'order_detail.id_product', '=', 'products.id')->select('products.*', 'order_detail.*')->where('order_detail.code', $request->code)->get();
        return view('admin.order.show', compact('rowInfo', 'rowDetail'));
    }

    /* Order multiple delete */
    public function destroy(Request $request)
    {
        Order::whereIn('code', $request->checkitem)->delete();
        OrderDetail::whereIn('code', $request->checkitem)->delete();
        return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.order'));
    }

    /* Order static delete */
    public function delete(Request $request)
    {
        Order::where('code', $request->code)->delete();
        OrderDetail::where('code', $request->code)->delete();
        return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.order'));
    }

    /* Order update */
    public function update(Request $request)
    {
        $row = Order::where('code',  $request->code)->first();
        $validator = Validator::make(
            $request->all(),
            [
                'order_status' => ['required']
            ],
            [
                'order_status.required' => 'Tình trạng đơn hàng không được để trống'
            ]
        );
        if (!$validator->fails()) {
            $d = [
                'order_status' => $request->order_status,
                'requirements' => !empty($request->requirements) ? $request->requirements : null,
                'notes' => !empty($request->notes) ? $request->notes : null
            ];
            // return $d;
            $row->update($d);
            return $this->helper->transfer("Cập nhật dữ liệu", "success", route('admin.order.show', ['code' => $request->code]));
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
