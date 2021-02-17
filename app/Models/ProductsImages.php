<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsImages extends Model {

    protected $table = 'products_images';
    protected $fillable = [
        'product_id', 'name', 'image', 'status'
    ];
    protected $hidden = [];

    ////////////////////////////////////
    public function product() {
        return $this->belongsTo('App\Models\Products', 'product_id');
    }

    ////////////////////////////////////
    function addProductImage($product_id, $name, $image) {
        $this->product_id = $product_id;
        $this->name = $name;
        $this->image = $image;
//        $this->status = $status;

        $this->save();
        return $this;
    }

    //////////////////////////////////
    function updateProductImage($obj, $product_id, $name, $image) {
        $obj->product_id = $product_id;
        $obj->name = $name;
        $obj->image = $image;
//        $obj->status = $status;
        $obj->save();

        return $obj;
    }

    //////////////////////////////////
    function updateStatus($id, $status) {
        return $this
                        ->where('id', '=', $id)
                        ->update([
                            'status' => $status
        ]);
    }

    //////////////////////////////////
    function deleteProductImage($obj) {
        return $obj->delete();
    }

    //////////////////////////////////
    function getProductImage($id) {
        return $this->find($id);
    }

    //////////////////////////////////
    function getActiveProductImage($id) {
        return $this->where('status', '=', 1)->where('id', '=', $id)->first();
    }

    //////////////////////////////////
    function getAllProductsImages() {
        return $this->get();
    }

    //////////////////////////////////
    function getAllActiveProductsImages() {
        return $this->where('status', '=', 1)->get();
    }

    //////////////////////////////////
    function getAllProductsImagesByProductId($product_id) {
        return $this->where('product_id', '=', $product_id)->get();
    }

    //////////////////////////////////
    function getAllActiveProductsImagesByProductId($product_id) {
        return $this->where('product_id', '=', $product_id)->where('status', '=', 1)->get();
    }

    //////////////////////////////////
    function deleteProductImageByProductId($product_id) {
        return $this->where('product_id', $product_id)->delete();
    }

    //////////////////////////////////
    function getProductsImages($name = "") {
        return $this->where(function($query) use ($name) {
                    if ($name != "") {
                        $query->where('name', '=', $name);
                    }
                })->get();
    }

}
