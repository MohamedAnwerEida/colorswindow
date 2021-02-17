<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fav extends Model {

    protected $table = 'items_fav';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('fav_id', ' product_id ', 'user_id');

    function product() {
        return $this->belongsTo('App\Models\Products', 'product_id', 'id');
    }

    function getMyFav($user_id) {
        return $this
                        ->where('user_id', '=', $user_id)
                        ->paginate(20);
    }

    function getFav($item_id, $user_id) {
        return $this
                        ->where('user_id', '=', $user_id)
                        ->where('product_id', '=', $item_id)
                        ->first();
    }

    function addFav($item_id, $user_id) {
        $this->product_id = $item_id;
        $this->user_id = $user_id;
        $this->save();
        return $this;
    }

    function deleteFav($obj) {
        return $obj->delete();
    }

}
