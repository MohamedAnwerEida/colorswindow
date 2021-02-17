<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model {

    use SoftDeletes;

    protected $table = 'test';
    protected $fillable = ['dara', 'status', 'cart_id'];

    function getByCartId($cart_id) {
        return $this->where('status', 'CAPTURED')->where('cart_id', '=', $cart_id)->first();
    }

}
