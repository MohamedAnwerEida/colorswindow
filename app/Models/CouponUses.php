<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponUses extends Model {

    use SoftDeletes;

    protected $table = 'coupon_suses';

    public function invoice() {
        return $this->belongsTo('App\Models\Order', 'invoice_id');
    }

    function addCoupon($coupons_id, $user_id, $invoice_id) {
        $this->coupons_id = $coupons_id;
        $this->user_id = $user_id;
        $this->invoice_id = $invoice_id;
        $this->save();
        return $this;
    }

    function getUsedCouponBefor($coupons_id, $user_id, $invoice_id) {
        return $this
                        ->where('user_id', '=', $user_id)
                        ->where('coupons_id', '=', $coupons_id)
                        ->where('invoice_id', '=', $invoice_id)
                        ->first();
    }

    function getUsedCouponSearch($coupons_id, $from, $to) {
        return $this->with('invoice')
                        ->whereBetween('created_at', [$from, $to])
                        ->where('coupons_id', '=', $coupons_id)
                        ->get();
    }

}
