<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
////////////////////////////////////
use App\Models\Customers;
use App\Models\Fav;

class CustomersController extends AdminController {

    const INSERT_SUCCESS_MESSAGE = "نجاح، تم الإضافة بتجاح";
    const UPDATE_SUCCESS = "نجاح، تم التعديل بنجاح";
    const DELETE_SUCCESS = "نجاح، تم الحذف بنجاح";
    const PASSWORD_SUCCESS = "نجاح، تم تغيير كلمة المرور بنجاح";
    const EXECUTION_ERROR = "عذراً، حدث خطأ أثناء تنفيذ العملية";
    const NOT_FOUND = "عذراً،لا يمكن العثور على البيانات";
    const ACTIVATION_SUCCESS = "نجاح، تم التفعيل بنجاح";
    const DISABLE_SUCCESS = "نجاح، تم التعطيل بنجاح";

    //////////////////////////////////////////////
    public function __construct() {
        parent::__construct();
        parent::$data['active_menu'] = 'customers';
    }

    //////////////////////////////////////////////
    public function getIndex() {
        return view('admin.customers.view', parent::$data);
    }

    //////////////////////////////////////////////
    public function getList(Request $request) {
        $customers = new Customers();
        $name = $request->get('name');
//        $status = $request->get('status');
//        $pay = $request->get('pay');
//        $order_date = $request->get('order_date');
//        $total = $request->get('total');
        $info = $customers->getCustomers($name);
        $datatable = Datatables::of($info);

        $datatable->escapeColumns(['*']);
//        $datatable->editColumn('status', function ($row) {
//            return $row->mystatus->name;
//        });
//        $datatable->editColumn('is_paid', function ($row) {
//            return ($row->is_paid ? 'تم الدفع' : 'غير مدفوع');
//        });
//        $datatable->editColumn('is_paid', function ($row) {
//            return ($row->mypay ? $row->mypay->name : 'غير مدفوع');
//        });
//        $datatable->editColumn('ratings', function ($row) {
//            if ($row->ratings) {
//                if ($row->ratings == 1) {
//                    $str = 'نجمة';
//                } elseif ($row->ratings == 2) {
//                    $str = 'نجمتين';
//                } else {
//                    $str = $row->ratings . ' ' . 'نجوم';
//                }
//            } else {
//                $str = '-';
//            }
//
//            return ($str);
//        });

        $datatable->addColumn('actions', function ($row) {
            $data['id'] = $row->id;
            $data['btn_class'] = parent::$data['btn_class'];

            return view('admin.customers.parts.actions', $data)->render();
        });
        return $datatable->make(true);
    }

    //////////////////////////////////////////////
//    public function getAdd() {
//        return view('admin.customers.add', parent::$data);
//    }
//    //////////////////////////////////////////////
//    public function postAdd(Request $request) {
//        $title = $request->get('title');
//        $descs = $request->get('descs');
//        $image = $request->file('image');
//        $status = (int) $request->get('status');
//
//        $validator = Validator::make([
//                    'title' => $title,
//                    'descs' => $descs,
//                    'image' => $image,
//                    'status' => $status
//                        ], [
//                    'title' => 'required',
//                    'descs' => 'required',
//                    'image' => 'required',
//                    'status' => 'required|numeric|in:0,1'
//        ]);
//        //////////////////////////////////////////////////////////
//        if ($validator->fails()) {
//            $request->session()->flash('danger', $validator->messages());
//            return redirect(route('customers.add'))->withInput();
//        } else {
//            $destinationPath = 'File/Images/photo/';
//            $image_name = 'image_' . strtotime(date("Y-m-d H:i:s")) . '.' . $image->getClientOriginalExtension();
//            $image->move($destinationPath, $image_name);
//            Image::make($destinationPath . $image_name)->resize(200, 200)->save($destinationPath . 'thumb/' . $image_name);
//            ///////////////////
//            $customers = new Customerss();
//            $add = $customers->addPhoto($title, $descs, $image_name, $status, Auth::guard('admin')->user()->id);
//            if ($add) {
//                $this->clearCache();
//                ///////////////////////////////////////////////////////////////////
//                $request->session()->flash('success', self::INSERT_SUCCESS_MESSAGE);
//                return redirect(route('customers.view'));
//            } else {
//                $request->session()->flash('danger', self::EXECUTION_ERROR);
//                return redirect(route('customers.add'))->withInput();
//            }
//        }
//    }
    //////////////////////////////////////////////
//    public function getInvoice(Request $request, $id) {
//
//        try {
//            $id = Crypt::decrypt($id);
//        } catch (DecryptException $e) {
//            $request->session()->flash('danger', self::NOT_FOUND);
//            return redirect(route('customers.view'));
//        }
//        //////////////////////////////////////////////
//        $customers = new Customers();
//        $info = $customers->getCustomers($id);
//        if ($info) {
//            $defaultConfig = new \Mpdf\Config\ConfigVariables;
//            $dd = $defaultConfig->getDefaults();
//            $fontDirs = $dd['fontDir'];
//
//            $defaultFontConfig = new \Mpdf\Config\FontVariables();
//            $ee = $defaultFontConfig->getDefaults();
//            $fontData = $ee['fontdata'];
//            $mpdf = new \Mpdf\Mpdf([
//                'margin_left' => 10,
//                'margin_right' => 10,
//                'margin_top' => 27,
//                'margin_bottom' => 27,
//                'margin_header' => 5,
//                'margin_footer' => 5,
//                'fontDir' => array_merge($fontDirs, [
//                    realpath('assets/site/fonts'),
//                ]),
//                'fontdata' => $fontData + [
//            'frutiger' => [
//                'R' => 'TheSansArab-Light.ttf',
//                'useOTL' => 0xFF,
//                'useKashida' => 75,
//            ]
//                ],
//                'default_font' => 'frutiger'
//            ]);
//            parent::$data['order'] = $info;
//            parent::$data['statuss'] = CustomersStatus::all();
//            //return view('admin.customers.invoice', parent::$data);
//            $html = view('admin.customers.invoice', parent::$data);
//            $mpdf->WriteHTML($html);
//            $mpdf->Output();
//        } else {
//            $request->session()->flash('danger', self::NOT_FOUND);
//            return redirect(route('customers.view'));
//        }
//    }
    //////////////////////////////////////////////
    public function getEdit(Request $request, $id) {
        $customers = new Customers();
        $info = $customers->getCustomer($id);
        if ($info) {
            $fav = new Fav();
            parent::$data['favs'] = $fav->getMyFav($id);
            parent::$data['customer'] = $info;
            return view('admin.customers.edit', parent::$data);
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('customers.view'));
        }
    }

    ////////////////////////////////////////////////
    public function postEdit(Request $request, $id) {
        $customers = new Customers();
        $info = $customers->getCustomer($id);
        if ($info) {
            $admin_notes = $request->get('admin_notes');
            $update = $customers->updateField($id, 'admin_notes', $admin_notes);
            if ($update) {
                $request->session()->flash('success', self::UPDATE_SUCCESS);
                return redirect(route('customers.view'));
            } else {
                $request->session()->flash('danger', self::EXECUTION_ERROR);
                return redirect(route('customers.viewdetails', ['id' => $id]))->withInput();
            }
        }
    }

    ////////////////////////////////////////////////
    public function postDelete(Request $request) {
        $id = $request->get('id');
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error Decode']);
        }
        /////////////////////////////////////
        $customers = new Customers();
        $info = $customers->getCustomers($id);
        if ($info) {
            $delete = $customers->deleteCustomers($info);
            if ($delete) {
                return response()->json(['status' => 'success', 'message' => self::DELETE_SUCCESS]);
            } else {
                return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => self::NOT_FOUND]);
        }
    }

    //////////////////////////////////////////////
    public function postStatus(Request $request) {
        $id = $request->get('id');
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error Decode']);
        }
        /////////////////////////////////////
        $customers = new Customers();
        $info = $customers->getPhoto($id);
        if ($info) {
            $status = $info->status;
            if ($status == 0) {
                $update = $customers->updateStatus($id, 1);
                if ($update) {
                    return response()->json(['status' => 'success', 'message' => self::ACTIVATION_SUCCESS, 'type' => 'yes']);
                } else {
                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
                }
            } else {
                $update = $customers->updateStatus($id, 0);
                if ($update) {
                    return response()->json(['status' => 'success', 'message' => self::DISABLE_SUCCESS, 'type' => 'no']);
                } else {
                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
                }
            }
        } else {
            return response()->json(['status' => 'error', 'message' => self::NOT_FOUND]);
        }
    }

    /////////////////////////////////////////
    public function clearCache() {
        Cache::forget('photo');
        $photo = new Customers();
        $info = $photo->getLastPhoto();
        Cache::forever('photo', $info);
    }

    public function send_mail($order, $status) {
        $email = $order->email;
        $name = $order->name;
        $data = array();
        $token = '';
        $title = '';
        $data['order'] = $order;
        if ($status == 5) {
            $view = 'emails.cancel';
            $title = 'تم الغاء طلبك';
        } elseif ($status == 2) {
            $title = 'لقد تم شحن السلعة! ';
            $view = 'emails.sent';
        } elseif ($status == 4) {
            $title = 'تقييم الخدمة!';
            $view = 'emails.rate';
        } else {
            return false;
        }
        Config::set('mail.driver', 'sendmail');
        Config::set('mail.host', 'smtp.googlemail.com');
        Config::set('mail.port', 587);
        Config::set('mail.email', 'no-reply@colorswindow.com');
        //Config::set('mail.password', 'usgovvhhmlcmgsxo');
        Config::set('mail.password', 'No1234reply#');
        Config::set('mail.encryption', 'tls');
        Mail::send($view, $data, function ($message) use ($email, $name, $token, $title) {
            $message->to($email, $name)->subject($title)->from('no-reply@colorswindow.com', 'Colors Window');
        });
        //      echo view($view, $data)->render();
    }

}
