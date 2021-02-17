<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('language','name');



}
