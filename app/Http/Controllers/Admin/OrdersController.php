<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
use Mail;
use Config;
////////////////////////////////////
use App\Models\Order;
use App\Models\Settings;
use App\Models\OrderPay;
use App\Models\OrderLog;
use App\Models\OrderStatus;

class OrdersController extends AdminController {

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
        parent::$data['active_menu'] = 'orders';
    }

    //////////////////////////////////////////////
    public function getIndex() {
        parent::$data['order_status'] = OrderStatus::all();
        parent::$data['order_pay'] = OrderPay::all();
        return view('admin.orders.view', parent::$data);
    }

    //////////////////////////////////////////////
    public function getList(Request $request) {
        $colors = array(
            1 => 'label-danger',
            2 => 'label-success',
            3 => 'label-info',
            4 => 'label-success',
            5 => 'label-info',
        );
        $orders = new Order();
        $name = $request->get('name');
        $status = $request->get('status');
        $pay = $request->get('pay');
        $order_date = $request->get('order_date');
        $total = $request->get('total');
        $info = $orders->getAllOrders($name, $status, $pay, $order_date, $total);
        $datatable = Datatables::of($info);

        $datatable->escapeColumns(['*']);
        $datatable->editColumn('status', function ($row)  {
            $colors = array(
                1 => 'label-danger',
                2 => 'label-success',
                3 => 'label-info',
                4 => 'label-success',
                5 => 'label-info',
            );
          //  dd($colors);
            return '<span class="label label-sm ">' . $row->mystatus->name1 . '</span>';
        });
        $datatable->editColumn('is_paid', function ($row) {
            return ($row->is_paid ? 'تم الدفع' : 'غير مدفوع');
        });
        $datatable->editColumn('paid_type', function ($row) {
            return ($row->mypay ? $row->mypay->name : 'كاش');
        });
        $datatable->editColumn('ratings', function ($row) {
            if ($row->ratings) {
                if ($row->ratings == 1) {
                    $str = 'سئ';
                } elseif ($row->ratings == 2) {
                    $str = 'متوسط';
                } else {
                    $str = 'ممتاز';
                }
            } else {
                $str = '-';
            }

            return ($str);
        });

        $datatable->addColumn('actions', function ($row) {
            $data['id'] = $row->id;
            $data['btn_class'] = parent::$data['btn_class'];

            return view('admin.orders.parts.actions', $data)->render();
        });
        return $datatable->make(true);
    }

    //////////////////////////////////////////////
//    public function getAdd() {
//        return view('admin.orders.add', parent::$data);
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
//            return redirect(route('orders.add'))->withInput();
//        } else {
//            $destinationPath = 'File/Images/photo/';
//            $image_name = 'image_' . strtotime(date("Y-m-d H:i:s")) . '.' . $image->getClientOriginalExtension();
//            $image->move($destinationPath, $image_name);
//            Image::make($destinationPath . $image_name)->resize(200, 200)->save($destinationPath . 'thumb/' . $image_name);
//            ///////////////////
//            $orders = new Orders();
//            $add = $orders->addPhoto($title, $descs, $image_name, $status, Auth::guard('admin')->user()->id);
//            if ($add) {
//                $this->clearCache();
//                ///////////////////////////////////////////////////////////////////
//                $request->session()->flash('success', self::INSERT_SUCCESS_MESSAGE);
//                return redirect(route('orders.view'));
//            } else {
//                $request->session()->flash('danger', self::EXECUTION_ERROR);
//                return redirect(route('orders.add'))->withInput();
//            }
//        }
//    }
    //////////////////////////////////////////////
    public function getInvoice(Request $request, $id) {

        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('orders.view'));
        }
        //////////////////////////////////////////////
        $orders = new Order();
        $info = $orders->getOrder($id);
        if ($info) {
            $defaultConfig = new \Mpdf\Config\ConfigVariables;
            $dd = $defaultConfig->getDefaults();
            $fontDirs = $dd['fontDir'];

            $defaultFontConfig = new \Mpdf\Config\FontVariables();
            $ee = $defaultFontConfig->getDefaults();
            $fontData = $ee['fontdata'];
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 27,
                'margin_bottom' => 27,
                'margin_header' => 5,
                'margin_footer' => 5,
                'fontDir' => array_merge($fontDirs, [
                    realpath('assets/site/fonts'),
                ]),
                'fontdata' => $fontData + [
            'frutiger' => [
                'R' => 'TheSansArab-Light.ttf',
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ]
                ],
                'default_font' => 'frutiger'
            ]);
            $settings = new Settings();
            parent::$data['settings'] = $settings->getSetting(1);
            parent::$data['order'] = $info;
            parent::$data['statuss'] = OrderStatus::all();
            //return view('admin.orders.invoice', parent::$data);
            $html = view('admin.orders.invoice', parent::$data);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('orders.view'));
        }
    }

    //////////////////////////////////////////////
    public function getEdit(Request $request, $id) {
        /*$Orders = Order::all();

        foreach ($Orders as $order) {
            $sub_total = 0;
            $urgent = 0;
            $pay_value = 0;
            $discount = 0;
            $tax = 0;
            foreach ($order->items as $item) {
                $sub_total += $item->price;
            }
            if ($order->urgent != 0) {
                $urgent = number_format($sub_total * 0.5 , 2);
            }
            if ($order->pay_value != 0) {
                $pay_value = number_format($order->pay_value, 2);
            }
            if ($order->discount != 0) {

                $discount = $order->discount ;
            }
            if ($order->tax != 0) {
                $tax_persent = number_format(Settings::first()->tax/100, 2);
                $total_befor_tax = $sub_total + $pay_value + $urgent  ;
                $tax = number_format($total_befor_tax * $tax_persent, 2);
            }

            $total = $tax + $sub_total +  $pay_value + $urgent - $discount ;
            $order->tax = $tax;
            $order->total = $total;
            $order->save();
        }*/

        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('orders.view'));
        }
        //////////////////////////////////////////////
        $orders = new Order();
        $info = $orders->getOrder($id);
        //dd($info);
        if ($info) {
            parent::$data['statuss'] = OrderStatus::all();

            parent::$data['order'] = $info;
            return view('admin.orders.edit', parent::$data);
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('orders.view'));
        }
    }

    ////////////////////////////////////////////////
    public function postEdit(Request $request, $id) {
        try {
            $encrypted_id = $id;
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('pages.view'));
        }
        /////////////////////////////
        $orders = new Order();
        $info = $orders->getOrder($id);
        if ($info) {
            $status = $request->get('status');
            $is_paid = $request->get('is_paid');
            $notes_admin = $request->get('notes_admin');
            $update = $orders->updateOrder($info, $status, $is_paid, $notes_admin);
            $save_data['order_id'] = $id;
            $save_data['order_status'] = $status;
            $save_data['paid_status'] = $is_paid;
            $save_data['note'] = $notes_admin;
            $save_data['user_id'] = Auth::guard('admin')->user()->id;
            OrderLog::create($save_data);
            $this->send_mail($info, $status);
            // exit;
            if ($update) {
                $request->session()->flash('success', self::UPDATE_SUCCESS);
                return redirect(route('orders.view'));
            } else {
                $request->session()->flash('danger', self::EXECUTION_ERROR);
                return redirect(route('orders.edit', ['id' => $encrypted_id]))->withInput();
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
        $orders = new Order();
        $info = $orders->getOrder($id);
        if ($info) {
            $delete = $orders->deleteOrder($info);
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
        $orders = new Order();
        $info = $orders->getPhoto($id);
        if ($info) {
            $status = $info->status;
            if ($status == 0) {
                $update = $orders->updateStatus($id, 1);
                if ($update) {
                    return response()->json(['status' => 'success', 'message' => self::ACTIVATION_SUCCESS, 'type' => 'yes']);
                } else {
                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
                }
            } else {
                $update = $orders->updateStatus($id, 0);
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
        $photo = new Order();
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
        } elseif ($status == 3) {
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
