<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model {
    //protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('order_id', 'name', 'design', 'design_data', 'spec', 'quantity', 'price', 'total', 'meter_height', 'meter_width', 'page_no');

    function checkMyorderForProduct($product_id, $customer_id) {
        return $this
                        ->where('order_products.name', $product_id)
                        ->join('orders', function($join) use($customer_id) {
                            $join->on('orders.id', '=', 'order_products.order_id')
                            ->where('orders.customer_id', $customer_id);
                        })
                        ->first();
    }

}
