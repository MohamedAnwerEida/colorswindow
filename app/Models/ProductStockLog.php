<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStockLog extends Model {

    use SoftDeletes;

    protected $table = 'product_stock_log';
    protected $fillable = array('product_id', 'qty', 'qty_stock_min', 'user_id');

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}
