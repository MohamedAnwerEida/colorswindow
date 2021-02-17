<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTotal extends Model
{
	protected $table = 'order_total';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = array('order_id','code','title','value','sort_order');

	

}
