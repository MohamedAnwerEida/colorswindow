<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderLog extends Model {

    use SoftDeletes;

    protected $table = 'order_log';
    protected $fillable = array('order_id', 'order_status', 'paid_status', 'note', 'user_id');

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function mystatus() {
        return $this->hasOne('App\Models\OrderStatus', 'id', 'order_status');
    }

}
