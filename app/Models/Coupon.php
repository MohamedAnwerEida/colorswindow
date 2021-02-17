<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model {

    use SoftDeletes;

    protected $table = 'coupons';

    function addCoupon($code, $type, $value, $start_date, $end_date, $cat_type, $item_id, $status) {
        $this->code = $code;
        $this->type = $type;
        $this->value = $value;
        $this->status = $status;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->cat_type = $cat_type;
        $this->item_id = $item_id;
        $this->save();
        return $this;
    }

    function updateCoupon($obj, $code, $type, $value, $start_date, $end_date, $cat_type, $item_id, $status) {
        $obj->code = $code;
        $obj->type = $type;
        $obj->value = $value;
        $obj->status = $status;
        $obj->start_date = $start_date;
        $obj->end_date = $end_date;
        $obj->cat_type = $cat_type;
        $obj->item_id = $item_id;
        $obj->save();
        return $obj;
    }

    //////////////////////////////////////////////
    function updateStatus($id, $status) {
        return $this
                        ->where('id', '=', $id)
                        ->update([
                            'status' => $status
        ]);
    }

    //////////////////////////////////////////////
    function deleteCoupon($obj) {
        return $obj->delete();
    }

    function getCoupon($id) {
        return $this->find($id);
    }

    function getSearchCoupons($title) {
        return $this->where(function($query) use ($title) {
                            if ($title != "") {
                                $query->where('code', 'LIKE', '%' . $title . '%');
                            }
                        })
                        ->orderBy('id', 'desc')
                        ->get();
    }

    function findByCode($code) {
        return $this
                        ->where('code', $code)
                        ->where('status', 1)
                        ->first();
    }

    public function discount($coupon, $total) {
        if ($coupon->type == 'fixed') {
            return $coupon->value;
        } elseif ($coupon->type == 'percent') {
            return round(($coupon->value / 100) * $total);
        } else {
            return 0;
        }
    }

}
