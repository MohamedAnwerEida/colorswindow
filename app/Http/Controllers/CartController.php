<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\Customers;
use App\Models\Carts;
use App\Models\CartsItems;

class CartController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    ///////////////////////////
    public function getPdf(Request $request) {
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
        $user = new Customers();
        parent::$data['user'] = $user->getCustomer(Auth::guard('web')->user()->id);
        $cart = new Carts();
        $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
        $items_data = array();
        if (!empty($mycart->items)) {
            $items_data = $this->getitemdata($mycart->items);
        }
        parent::$data['items'] = $items_data;

        //return view('frontend.pdf.document', parent::$data);
        $html = view('frontend.pdf.document', parent::$data);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function getIndex(Request $request) {
        $user = new Customers();
        parent::$data['user'] = $user->getCustomer(Auth::guard('web')->user()->id);
        $cart = new Carts();
        $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
        $items_data = array();
        if (!empty($mycart->items)) {
            $items_data = $this->getitemdata($mycart->items);
        }
        parent::$data['cart'] = $mycart;
        parent::$data['cities'] = \App\Models\Cities::all();
        parent::$data['items'] = $items_data;
        return view('frontend.cart.cart', parent::$data);
    }

    public function getitemdata($items) {
        $product = new Products();
        $data_array = array();
        foreach ($items as $item) {
            $product = $product->getProduct($item['product_id']);
            $item_oj = new \stdClass();
            $item_oj->id = $item['id'];
            $item_oj->title = $product->name_ar;
            $item_oj->qty = $item['qty'];
            $ispec = json_decode($item['spec'], true);
            $spec_array = array();
            $stotal_price = $product->price;
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

                    $item_oj->quantity = isset($item['qty']) ? $item['qty'] : 1;
                    $cprice_obj = new \stdClass();
                    $cprice_obj->index = $index;
                    $cprice_obj->qty = $item_oj->quantity;
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
            $total_price = $this->getTotals($stotal_price, $install_unit_price, $custom_price, $custom_repeat, $cprice, $v_meter);

            $item_oj->total_price = $total_price;
            $item_oj->spec_data = $spec_array;
            $data_array[] = $item_oj;
        }
        return $data_array;
    }

    public function getTotals($total_price, $install_unit_price, $custom_price, $custom_repeat, $cprice, $v_meter) {
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
                            $ccprice = $custom_price;
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

    public function postAdd(Request $request, $product_id) {
        // check if he has order
        $cart = new Carts();
        $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
        $data_items['desgin_detail'] = $request->desgin_detail;
        $data_items['desgin_link'] = $request->desgin_link;
        $data_items['spec'] = json_encode($request->spec);
        $data_items['product_width'] = $request->product_width ? $request->product_width : 0;
        $data_items['product_height'] = $request->product_height ? $request->product_height : 0;
        $data_items['qty'] = $request->qty ? $request->qty : 1;
        $data_items['product_id'] = $product_id;

        if ($mycart) {
            //if yes add to order items
            $data_items['cart_id'] = $mycart->id;
        } else {
            //if no create then add to order items
            $data['customer_id'] = Auth::guard('web')->user()->id;
            $order_id = Carts::create($data)->id;
            $data_items['cart_id'] = $order_id;
        }
        $order_id = CartsItems::create($data_items);
        $request->session()->flash('success', 'تمت اضافة المنتج');
        return redirect('cart');
    }

    public function postPay(Request $request) {
        // check if he has order
        $cart = new Carts();
        $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
        $mycart->pay_type = $request->pay_type;
        $mycart->save();
        return response()->json([
                    'success' => '1',
                    'message' => 'Item save'
        ]);
    }

    public function postShipping(Request $request) {
        // check if he has order
        $cart = new Carts();
        $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
        $name = $request->fname;
        $mycart->$name = $request->fvalue;
        $mycart->save();
        return response()->json([
                    'success' => '1',
                    'message' => 'Item save'
        ]);
    }

    public function postShippingCity(Request $request) {
        // check if he has order
        $cart = new Carts();
        $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
        $mycart->city = $request->city;
        $mycart->save();
        return response()->json([
                    'success' => '1',
                    'message' => 'Item save'
        ]);
    }

    public function remove(Request $request) {
        $item = CartsItems::find($request->index);
        $item->delete();
        return response()->json([
                    'success' => '1',
                    'message' => 'Item Removed'
        ]);
    }

    public function urgent(Request $request) {
        $cart = new Carts();
        $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
        $mycart->urgent = $mycart->urgent == 1 ? 0 : 1;
        $mycart->save();
        return redirect('cart');
    }

}
