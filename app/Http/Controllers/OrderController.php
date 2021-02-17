<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Mail;
use Config;
use Notification;
use App\Models\Test;
use App\Models\User;
use App\Models\Files;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Settings;
use App\Models\Products;
use App\Models\Customers;
use App\Models\ProductLog;
use App\Models\CartsItems;
use App\Models\OrderStatus;
use App\Models\OrderProduct;
use App\Notifications\PushDemo;

class OrderController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $order = new Order();
        parent::$data['orders'] = $order->getAllOrdersByCustomer(Auth::user()->id);
        return view('frontend.orders.orders', parent::$data);
    }

    public function showInvoice($order_id) {
        $order = new Order();
        $info = $order->getOrderByCustomer($order_id, Auth::user()->id);
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
            parent::$data['order'] = $info;
            parent::$data['statuss'] = OrderStatus::all();
            //return view('admin.orders.invoice', parent::$data);
            $html = view('admin.orders.invoice', parent::$data);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }
    }

    public function getRate($order_id, $user_id) {
        if ($user_id == Auth::user()->id) {
            $order = new Order();
            $info = $order->getOrderByCustomer($order_id, Auth::user()->id);
            if ($info) {
                parent::$data['order'] = $info;
                return view('frontend.orders.rate', parent::$data);
            }
        }
        echo '<center><h1>';
        echo 'حدث خطا';
        echo '</h1>';
    }

    public function postRate(Request $request, $order_id, $user_id) {
        if ($user_id == Auth::user()->id) {
            $order = new Order();
            $info = $order->getOrderByCustomer($order_id, Auth::user()->id);
            if ($info) {
                $ratings = $request->get('ratings');
                $rate_note = $request->get('rate_note');
                $update = $order->updaterate($info, $ratings, $rate_note);
                return redirect('rate/' . $order_id . '/' . $user_id);
            }
        }
        echo '<center><h1>';
        echo 'حدث خطا';
        echo '</h1>';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AddPayOrder(Request $request) {
        $mycart = array();
        if ($request->exists('token')) {
            $request->session()->put('paid', 2);
            $cart = new Carts();
            $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
            if ($mycart) {
                $order = new Test();
                $data = $order->getByCartId('ord_' . $mycart->id);
                if ($data) {
                    if ($data->status == 'CAPTURED') {
                        $request->session()->put('paid', 1);
                        $this->store($request, 1);
                    } else {

                    }
                }
            }
        }
//        echo session('paid');
//        exit;
        parent::$data['cart'] = $mycart;
        return view('frontend.orders.cart', parent::$data);
    }

    public function SavePayOrder(Request $request) {
        $save_data = $request->all();
        $json = json_encode($save_data);
        $data['dara'] = $json;
        $data['status'] = $save_data['status'];
        $data['cart_id'] = $save_data['reference']["order"];
        Test::create($data);
    }

    public function store(Request $request, $is_paid = Null) {
        $pay = $request->get('pay');

        $pay_type = 0;
        if ($pay == 1) {
            $request->session()->flash('danger', 'حدث خلل في عملية الدفع حاول بعد قليل');
            return back()->withInput();
        } else {
            if ($is_paid == 1) {
                $pay_type = 3;
            } else {
                $pay_type = 1;
            }
$Orders = Order::all();

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
$total = number_format((float)$total, 2);
$order->tax = $tax;
$order->total = $total;
$order->save();
}
            $settings = new Settings();
            $set = $settings->getSetting(1);
            $user = new Customers();
            $user_info = $user->getCustomer(Auth::guard('web')->user()->id);
            $cart = new Carts();
            $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
            $items_data = array();
            if (!empty($mycart->items)) {
                $items_data = $this->getitemdata($mycart->items);
            }
            $total = $this->getFinalTotals($items_data);
            $extra = ($mycart->urgent == 1 ? $total * 0.5 : 0);
            $total = $total + $extra;
            $discount = $mycart->discount_type == 'fixed' ? $mycart->discount_value : $total * (($mycart->discount_value / 100));
            $total += $mycart->pay_type - $discount;
            $tax = $total * ($set->tax / 100);
            //    print_r($user_info);
            //print_r($items_data);
//            echo $is_paid;
            //      exit;

            if ($order = Order::create([
                        'customer_id' => $user_info->id,
                        'name' => $user_info->name,
                        'email' => $user_info->email,
                        'telephone' => $user_info->phone,
                        'neighborhood' => $mycart->neighborhood ? $mycart->neighborhood : $user_info->neighborhood,
                        'street' => $mycart->street ? $mycart->street : $user_info->street,
                        'building' => $mycart->building ? $mycart->building : $user_info->building,
                        'city' => $mycart->city,
                        'notes' => $mycart->notes,
                        'pay_value' => $mycart->pay_type,
                        'pay_type' => $pay_type,
                        'discount' => $discount,
                        'discount_id' => $mycart->discount_id,
                        'urgent' => $mycart->urgent,
                        'is_paid' => $is_paid,
                        'cart_id' => $mycart->id,
                        'tax' => $tax,
                        'total' => $total + $tax,
                        'status' => 1,
                    ])) {
                // add Order Products
                foreach ($items_data as $item) {
                    $qty = property_exists($item, "qty") ? $item->qty : 1;
                    $desgin = property_exists($item, "desgin") ? $item->desgin : '-';
                    $desgin_data = property_exists($item, "desgin_data") ? $item->desgin_data : '-';
                    OrderProduct::create([
                        'order_id' => $order->id,
                        'name' => $item->id,
                        'design' => $desgin,
                        'design_data' => $desgin_data,
                        'spec' => $item->spec,
                        'quantity' => $qty,
                        'price' => (double) $item->total_price,
                        'total' => $item->total_price,
                        'meter_height' => $item->meter_height,
                        'meter_width' => $item->meter_width
                    ]);
                    $stocks = new Files();
                    $current_product = $stocks->getFile($item->id);
                    $update = $stocks->updateField($current_product->id, 'qty', $current_product->qty - $qty);
                    //check min qty and make punsh for it if reached qty_stock_min
                    if (($current_product->qty - $qty) <= $current_product->qty_stock_min) {
                        // echo 'we must make push';
                        $users = New User();
                        Notification::send($users->getAllActiveStoreUsers(), new PushDemo('تبيه خاص بالكميات في المخزن', '/notification-icon.png', 'وجود منتج نفذ من المخزن', 'عرض المخزن'));
                    }
                    $save_data['order_id'] = $order->id;
                    $save_data['product_id'] = $current_product->id;
                    $save_data['qty'] = $qty;
                    $save_data['user_id'] = Auth::guard('web')->user()->id;
                    ProductLog::create($save_data);
                }
            }

            CartsItems::where("cart_id", $mycart->id)->delete();
            Carts::where("id", $mycart->id)->delete();
            $request->session()->put('order', $order->id);
            $users = New User();
            Notification::send($users->getAllActiveAdminUsers(), new PushDemo('تبيه خاص بطلب جديد', '/notification-icon.png', 'وجود طلب جديد', 'عرض الطلبات'));
            $this->send_mail($order->id);
            return redirect('orders')->withSuccess('Your Order Created Thank You!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        parent::$data['order'] = Order::findOrFail($id);
        return view('frontend.orders.order', parent::$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function getFinalTotals($items_obj) {
        $total_price = 0;
        foreach ($items_obj as $obj) {
            $total_price += $obj->total_price*$obj->qty;
        };
        return $total_price;
    }

    public function getTotals($stotal_price, $install_unit_price, $custom_price, $custom_repeat, $cprice, $v_meter) {
        $total_price = $stotal_price;
        if ($v_meter != 1) {
            foreach ($cprice as $value) {
                if ($value) {
                    $sqty = $value->qty;
                    if ($value->repeat == 1) {
                        $myprice = $value->price;
                    } else {
                        $myprice = (($value->price - $value->sprice) * $sqty) + $value->sprice;
                    }
                    $total_price = $total_price + $myprice;
                    if ($value->view == 1) {
                        //الغاء سعر المواصفات الخاصة في حالة اخفائها
                        if ($custom_repeat == 1) {
                            $ccprice = custom_price;
                        } else {
                            $ccprice = $custom_price * $sqty;
                        }
                        $total_price = $total_price - $ccprice;
                    }
                }
            }
        } else {
            foreach ($cprice as $index => $value) {
                $install = 0;
                if ($value) {
                    $sqty = $value->qty;
                    if ($value->meter == 1) {
                        $myprice = $value->meter_width * $value->meter_height * $value->price * $sqty;
                    } else {
                        if ($value->repeat == 1) {
                            $myprice = $value->price;
                        } else {
                            $myprice = $value->price * $sqty;
                        }
                    }
                    if ($index == 6) {
                        if ($value->sprice == 1) {
                            $install = $install_unit_price * $value->meter_width * $value->meter_height * $sqty;
                        }
                    }
                    $total_price = $total_price + $myprice + $install;
                }
            }
        }
        return $total_price;
    }

    public function getitemdata($items) {
        $product = new Products();
        $data_array = array();
        foreach ($items as $item) {
            $product = $product->getProduct($item['product_id']);
            $item_oj = new \stdClass();
            $item_oj->title = $product->name_ar;
            $item_oj->id = $product->id;
            $item_oj->qty = $item['qty'];
            $ispec = json_decode($item['spec'], true);
            $item_oj->spec = $item['spec'];

            $spec_array = array();
            $stotal_price = $product->price;
            $perc = 0;
            $v_meter = 0;
            $meter = 0;
            $price = 0;
            $custom_price = 0;
            $custom_repeat = 0;
            $install_unit_price = 0;
            $meter_width = array_key_exists('width', $item) ? $item['width'] : 0;
            $meter_height = array_key_exists('height', $item) ? $item['height'] : 0;
            $temp_price = array();
            $cprice = array();
            foreach ($product->subcats->spec as $spec) {
                $spec_oj = new \stdClass();
                if (array_key_exists($spec->catspectype->id, $ispec)) {
                    $spec_oj->cat_title = $spec->catspectype->name;
                    $index = $spec->catspectype->id;
                    if ($spec->catspectype->class_name == 'desgin') {
                        if (in_array($spec->id, $ispec)) {
                            $item_oj->desgin = $spec->name;
                            $item_oj->desgin_data = $item['desgin_detail'] . $item['desgin_link'];
                        }
                    }
                } else {
                    $spec_oj->cat_title = NUll;
                }
                if (in_array($spec->id, $ispec)) {
                    $spec_oj->spec_title = $spec->name;
                    $meter = $spec->view_meter;
                    $cc = $spec->catspectype->class_name;
                    if ($cc == 'custom') {
                        $custom_price = $spec->price;
                        $custom_repeat = $spec->view_repeat;
                    }

                    $cprice_obj = new \stdClass();
                    $cprice_obj->index = $index;
                    $cprice_obj->qty = $item_oj->qty;
                    $cprice_obj->view = $spec->view_attr;
                    $cprice_obj->one = $spec->one_time;
                    $cprice_obj->meter = $meter;
                    $cprice_obj->repeat = $spec->view_repeat;
                    $cprice_obj->price = $spec->price;
                    $cprice_obj->sprice = ($spec->price1 ? $spec->price1 : 0);
                    if ($meter == 1) {
                        $v_meter = 1;
                        $install_unit_price = ($spec->price1 ? $spec->price1 : 0);
                        $cprice_obj->meter_width = $meter_width;
                        $cprice_obj->meter_height = $meter_height;
                    }

                    $cprice[$index] = $cprice_obj;
                } else {
                    $spec_oj->spec_title = Null;
                }

                $spec_array[] = $spec_oj;
            }
            $item_oj->meter_width = $meter_width;
            $item_oj->meter_height = $meter_height;
            $total_price = $this->getTotals($stotal_price, $install_unit_price, $custom_price, $custom_repeat, $cprice, $v_meter);
            $item_oj->total_price = $total_price;
            $item_oj->spec_data = $spec_array;
            $data_array[] = $item_oj;
        }
        return $data_array;
    }

    public function send_mail($order_id) {
        $order = Order::findOrFail($order_id);
        $email = $order->email;
        $name = $order->name;
        $data = array();
        $token = '';
        $title = '';
        $data['order'] = $order;

        $view = 'emails.order';
        //$view = 'emails.cancel';
        $title = 'شكرا لتسوقك من نافذة الألوان';
        Config::set('mail.driver', 'sendmail');
        Config::set('mail.host', 'smtp.googlemail.com');
        Config::set('mail.port', 587);
        Config::set('mail.email', 'no-reply@colorswindow.com');
        //Config::set('mail.password', 'usgovvhhmlcmgsxo');
        Config::set('mail.password', 'No1234reply#');
        Config::set('mail.encryption', 'tls');
//        Mail::send($view, $data, function ($message) use ($email, $name, $token, $title) {
//
//            $message->to($users)->subject($title)->from('info@colorswindow.com', 'Colors Window');
//        });
        $pdf = $this->getpdfInvoice($order);
        Mail::send($view, $data, function($message) use ($email, $name, $token, $title, $pdf, $order_id) {
            $users[] = $email;
            $users[] = 'sales@colorswindow.com';
            $message
                    ->from('no-reply@colorswindow.com', 'Colors Window')
                    ->subject($title);
            $message->to($users);
            $message->attachData($pdf, 'order-' . $order_id . '.pdf');
        });
        //return view($view, $data);
    }

    public function getpdfInvoice($info) {
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
        parent::$data['order'] = $info;
        parent::$data['statuss'] = OrderStatus::all();
        //return view('admin.orders.invoice', parent::$data);
        $html = view('admin.orders.invoice', parent::$data);
        $mpdf->WriteHTML($html);
        return $mpdf->Output('', 'S');
    }

}
