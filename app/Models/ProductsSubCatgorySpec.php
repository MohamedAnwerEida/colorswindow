<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsSubCatgorySpec extends Model {

    use SoftDeletes;

    //////////////////////////////////////////////
    protected $table = 'product_spec';
    protected $fillable = [
        'name', 'sort', 'tags', 'color', 'status', 'in_menu'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    //////////////////////////////////////////////
    public function catspectype() {
        return $this->belongsTo('App\Models\ProductsSubCategoryType', 'spec_id', 'id');
    }

    //////////////////////////////////////////////
    function getCatType($id) {
        return $this->find($id);
    }

    function getSpecByProduct($id) {
        return $this->where('product_id', $id)->get();
    }

    //////////////////////////////////////////////
    function getCategories($id) {
        return $this->find($id);
    }

    function updateCategories($obj, $name, $product_id, $spec_id, $price, $price1, $view_attr, $view_meter, $view_repeat) {
        $obj->product_id = $product_id;
        $obj->spec_id = $spec_id;
        $obj->name = $name;
        $obj->price = $price;
        $obj->price1 = $price1;
        $obj->one_time = 1;
        $obj->view_attr = $view_attr;
        $obj->view_meter = $view_meter;
        $obj->view_repeat = $view_repeat;

        $obj->save();
        return $obj;
    }

}
