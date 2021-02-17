<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model {

    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('customer_id', 'discount_code', 'urgent', 'discount_id', 'pay_type', 'discount_type', 'discount_value', 'total', 'neighborhood', 'street', 'building', 'notes', 'city');

    public function items() {
        return $this->hasMany('App\Models\CartsItems', 'cart_id');
    }

    function getCustomerCarts($customer_id) {
        return $this->where('customer_id', '=', $customer_id)->first();
    }

}
