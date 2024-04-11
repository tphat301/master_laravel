<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterMail;
use App\Models\Admin\Newsletter;
use App\Models\Admin\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Utils\Helpers;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    private $type;
    private $helper;
    private $numberPerPage;
    public function __construct()
    {
        $this->middleware('admin.auth');
        $this->helper = new Helpers();
        $this->type = config('admin.message.newsletter.type');
        $this->numberPerPage = config('admin.message.newsletter.number_per_page');
    }

    /*Newsletter index*/
    public function index(Request $request)
    {
        session(['module_active' => 'newsletter_index']);
        $keyword = htmlspecialchars($request->input('keyword'));
        if ($keyword) {
            $rows = Newsletter::where("fullname", "LIKE", "%{$keyword}%")->where('type', $this->type)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($this->numberPerPage);
        } else {
            $rows = Newsletter::where('type', $this->type)->orderBy('num', 'ASC')->orderBy('id', 'ASC')->paginate($this->numberPerPage);
        }
        return view('admin.newsletter.index', compact('rows'));
    }

    /*Newsletter create*/
    public function create()
    {
        session(['module_active' => 'newsletter_create']);
        return view('admin.newsletter.create');
    }

    /*Newsletter detail*/
    public function show(Request $request)
    {
        $row = Newsletter::where('type', $this->type)->find($request->id);
        return view('admin.newsletter.show', compact('row'));
    }

    /*Newsletter delete static*/
    public function delete($id)
    {
        $uploadFile = "public/upload/newsletter_file_attach/";
        $row = Newsletter::where('type', $this->type)->find($id);
        $fileAttach = isset($row->file_attach) && !empty($row->file_attach) ? $row->file_attach : "";
        if (file_exists($uploadFile . $fileAttach) && !empty($fileAttach)) unlink($uploadFile . $fileAttach);
        $row->delete($id);
        return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.newsletter.index'));
    }

    /*Newsletter delete multiple*/
    public function destroy(Request $request)
    {
        $uploadFile = "public/upload/newsletter_file_attach/";
        $rows = Newsletter::where('type', $this->type)->find($request->checkitem);
        foreach ($rows as $v) {
            $file_attach = isset($v->file_attach) && !empty($v->file_attach) ? $v->file_attach : "";
            if (file_exists($uploadFile . $file_attach) && !empty($file_attach)) unlink($uploadFile . $file_attach);
        }
        Newsletter::destroy($request->checkitem);
        return $this->helper->transfer("Xóa dữ liệu", "success", route('admin.newsletter.index'));
    }

    /*Newsletter update number*/
    public function updateNumber(Request $request)
    {
        Newsletter::where('id', $request->id)->where('type', $this->type)->update(['num' => $request->value]);
    }

    /*Newsletter send mail*/
    public function sendmail(Request $request)
    {
        if (!file_exists("public/upload/file_attach")) {
            mkdir("public/upload/file_attach", 0777, true);
        }
        $row = Setting::where('type', config('admin.setting.type'))->first();
        $nameCompany = isset($row) ? $row->title : 'Name company';
        $hotline = isset($row) ? $row->hotline : '0987654321';
        if ($request->checkitem) {
            if ($request->hasFile('file')) {
                $fileAttach = $request->file->getClientOriginalName();
                $request->file->move('public/upload/file_attach', $fileAttach);
            }
            $rows = Newsletter::where('type', $this->type)->find($request->checkitem);
            if (count($rows) == 1) {
                $newsletter = Newsletter::where('type', $this->type)->where('id', $request->checkitem)->first();
                $data = [
                    'fullname' => $newsletter->fullname,
                    'phone' => $newsletter->phone,
                    'subject' => $request->subject,
                    'content' => htmlspecialchars_decode($request->content),
                    'name_company' => $nameCompany,
                    'hotline' => $hotline,
                    'file_attach' => $fileAttach
                ];
                Mail::to($newsletter->email)->send(new NewsletterMail($data));
            } elseif (count($rows) > 1) {
                $newsletter = Newsletter::where('type', $this->type)->whereIn('id', $request->checkitem)->get();
                foreach ($newsletter as $value) {
                    $data = [
                        'fullname' => $value->fullname,
                        'phone' => $value->phone,
                        'subject' => $request->subject,
                        'content' => htmlspecialchars_decode($request->content),
                        'name_company' => $nameCompany,
                        'hotline' => $hotline,
                        'file_attach' => $fileAttach
                    ];
                    Mail::to($value->email)->send(new NewsletterMail($data));
                }
            }
            return $this->helper->transfer("Gửi email", "success", route('admin.newsletter.index'));
        } else {
            return $this->helper->transfer("Gửi email", "danger", route('admin.newsletter.index'));
        }
    }

    public function save(Request $request)
    {
        if (!file_exists("public/upload/newsletter_file_attach")) {
            mkdir("public/upload/newsletter_file_attach", 0777, true);
        }
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'email'],
                'phone' => ['regex:/^[0-9]{3}[0-9]{4}[0-9]{3,4}$/'],
                'file_attach' => ['file', 'mimes:doc,docx,pdf,rar,zip,ppt,pptx,xls,xlsx', 'max:20971520']
            ],
            [
                'required' => ':attribute không được để trống',
                'mimes' => ':attribute chưa đúng định dạng',
                'max' => ':attribute chỉ cho upload tối đa là :max byte',
                'email' => ':attribute chưa đúng định dạng',
                'regex' => ':attribute chưa đúng định dạng'
            ],
            [
                'email' => 'Email',
                'file_attach' => 'Tập tin',
                'phone' => 'Số điện thoại'
            ]
        );
        if (!$validator->fails()) {
            if ($request->hasFile('file_attach')) {
                $fileAttach = $request->file_attach->getClientOriginalName();
                $request->file_attach->move('public/upload/newsletter_file_attach', $fileAttach);
            }
            $d = [
                'fullname' => !empty($request->input('fullname')) ? htmlspecialchars($request->input('fullname')) : null,
                'file_attach' => !empty($fileAttach) ? $fileAttach : null,
                'email' => htmlspecialchars($request->input('email')),
                'phone' => !empty($request->input('phone')) ? htmlspecialchars($request->input('phone')) : null,
                'subject' => !empty($request->input('subject')) ? htmlspecialchars($request->input('subject')) : null,
                'type' => $this->type,
                'address' => !empty($request->input('address')) ? htmlspecialchars($request->input('address')) : null,
                'confirm_status' => !empty($request->confirm_status) ? $request->confirm_status : 0,
                'content' => !empty($request->input('content')) ? htmlspecialchars($request->input('content')) : null,
                'notes' => !empty($request->input('notes')) ? htmlspecialchars($request->input('notes')) : null,
                'num' => !empty($request->input('num')) ? $request->input('num') : 0
            ];
            Newsletter::create($d);
            return $this->helper->transfer("Thêm dữ liệu", "success", route('admin.newsletter.index'));
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function update(Request $request)
    {
        $row = Newsletter::where('type', $this->type)->find($request->id);
        if (!file_exists("public/upload/newsletter_file_attach")) {
            mkdir("public/upload/newsletter_file_attach", 0777, true);
        }
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'email'],
                'phone' => ['regex:/^[0-9]{3}[0-9]{4}[0-9]{3,4}$/'],
                'file_attach' => ['file', 'mimes:doc,docx,pdf,rar,zip,ppt,pptx,xls,xlsx', 'max:20971520']
            ],
            [
                'required' => ':attribute không được để trống',
                'mimes' => ':attribute chưa đúng định dạng',
                'max' => ':attribute chỉ cho upload tối đa là :max byte',
                'email' => ':attribute chưa đúng định dạng',
                'regex' => ':attribute chưa đúng định dạng'
            ],
            [
                'email' => 'Email',
                'file_attach' => 'Tập tin',
                'phone' => 'Số điện thoại'
            ]
        );
        if (!$validator->fails()) {
            if ($request->hasFile('file_attach')) {
                $fileAttach = $request->file_attach->getClientOriginalName();
                $request->file_attach->move('public/upload/newsletter_file_attach', $fileAttach);
            } else {
                $fileAttach = isset($row->file_attach) ? $row->file_attach : null;
            }
            $d = [
                'fullname' => !empty($request->input('fullname')) ? htmlspecialchars($request->input('fullname')) : null,
                'file_attach' => !empty($fileAttach) ? $fileAttach : null,
                'email' => htmlspecialchars($request->input('email')),
                'phone' => !empty($request->input('phone')) ? htmlspecialchars($request->input('phone')) : null,
                'subject' => !empty($request->input('subject')) ? htmlspecialchars($request->input('subject')) : null,
                'address' => !empty($request->input('address')) ? htmlspecialchars($request->input('address')) : null,
                'confirm_status' => !empty($request->confirm_status) ? $request->confirm_status : 0,
                'content' => !empty($request->input('content')) ? htmlspecialchars($request->input('content')) : null,
                'notes' => !empty($request->input('notes')) ? htmlspecialchars($request->input('notes')) : null,
                'num' => !empty($request->input('num')) ? $request->input('num') : 0
            ];
            $row->update($d);
            return $this->helper->transfer("Cập nhật dữ liệu", "success", route('admin.newsletter.show', ['id' => $row->id]));
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        return $request->all();
    }
}
