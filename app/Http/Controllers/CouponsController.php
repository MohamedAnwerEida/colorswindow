<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Carts;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\CouponUses;
use Illuminate\Http\Request;
use Auth;

class CouponsController extends Controller {

    public function store(Request $request) {
        $coupon = new Coupon();
        $discount = $coupon->findByCode($request->coupon_code);
        if (!$discount) {
            $request->session()->flash('danger', 'كود الخصم المستخدم غير سليم. الرجاء المحاولة مرة اخري');
            return back()->withInput();
        }
        $user_id = Auth::guard('students')->user()->id;
        $couopn_uses = new CouponUses();
        $used = $couopn_uses->getUsedCouponBefor($discount->id, $user_id);
        if ($used) {
            $request->session()->flash('danger', 'تم استخدام هذا الكوبون علي هذه السلة من قبل');
            return back()->withInput();
        } else {
//            $order = new Order();
//            $myorder = $order->getOrder($user_id, $id);
//            if ($myorder) {
//                $mydiscount = $coupon->discount($discount, $myorder->amount);
//            } else {
//                $request->session()->flash('danger', 'حدث خطا ولم يمكن التعرف علي الفاتورة المطلوبة');
//                return back()->withInput();
//            }
//            $myorder->updateDiscount($myorder->id, $mydiscount);

            $couopn_uses->addCoupon($discount->id, $user_id);
            $request->session()->flash('success', 'تم تطبيق كود الخصم بنجاح');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function CheckCoupon(Request $request, $code) {
        $coupon = new Coupon();
        $discount = $coupon->findByCode($code);
        if (!$discount) {
            $request->session()->flash('danger', 'كود الخصم المستخدم غير صحيح. الرجاء المحاولة مرة اخرى');
            return redirect('cart');
        } else {
            if ($discount->cat_type == 2) {
                //this discount is connected with product that you must have to get the coupon
                $products = new OrderProduct();
                $product_exist = $products->checkMyorderForProduct($discount->item_id, Auth::user()->id);

                //check if this product is exist in my order
                if ($product_exist) {
                    //if exist check if we use befor 
                    $order = new Order();
                    $coupon_used = $order->checkMyorderForCoupon($discount->id, Auth::user()->id);
                    if ($coupon_used) {
                        //---if used error
                        $request->session()->flash('danger', 'تم استخدام الكود من قبل');
                        return redirect('cart');
                    } else {
                        //---if not use it and marke it as used
                        $request->session()->flash('success', 'تم تطبيق كود الخصم بنجاح');
                        $cart = new Carts();
                        $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
                        $mycart->discount_id = $discount->id;
                        $mycart->discount_code = $discount->code;
                        $mycart->discount_value = $discount->value;
                        $mycart->discount_type = $discount->type;
                        $mycart->save();
                        $request->session()->push('coupon', $discount);
                        return redirect('cart');
                    }
                } else {
                    //if not exist error
                    $request->session()->flash('danger', 'كود الخصم المستخدم غير صحيح. الرجاء المحاولة مرة اخرى');
                    return redirect('cart');
                }
            } else {
                $request->session()->flash('success', 'تم تطبيق كود الخصم بنجاح');
                $cart = new Carts();
                $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
                $mycart->discount_id = $discount->id;
                $mycart->discount_code = $discount->code;
                $mycart->discount_value = $discount->value;
                $mycart->discount_type = $discount->type;
                $mycart->save();
                $request->session()->push('coupon', $discount);
                return redirect('cart');
            }
        }
    }

    public function RemoveCoupon(Request $request) {
        $cart = new Carts();
        $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
        $mycart->discount_id = 0;
        $mycart->discount_code = '';
        $mycart->discount_value = '';
        $mycart->discount_type = '';
        $mycart->save();
        $request->session()->flash('success', 'تمت ازالة كودالخصم');
        return redirect('cart');
    }

}
