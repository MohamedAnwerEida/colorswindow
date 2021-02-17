<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductLog extends Model {

    use SoftDeletes;

    protected $table = 'product_log';
    protected $fillable = array('order_id', 'product_id', 'qty', 'user_id');

    public function user() {
        return $this->hasOne('App\Models\Customers', 'id', 'user_id');
    }

}
