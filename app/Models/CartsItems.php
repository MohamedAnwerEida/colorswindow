<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartsItems extends Model {

    protected $table = 'carts_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('cart_id', 'product_id', 'desgin_detail', 'desgin_link', 'product_width', 'product_height', 'qty', 'spec', 'page_no');



}
