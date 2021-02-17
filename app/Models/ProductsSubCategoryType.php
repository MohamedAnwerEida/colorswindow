<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsSubCategoryType extends Model {

    use SoftDeletes;

    //////////////////////////////////////////////
    protected $table = 'products_spec_types';
    protected $fillable = [
        'name', 'sort', 'tags', 'color', 'status', 'in_menu'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    //////////////////////////////////////////////
    public function catspec() {
        return $this->hasMany('App\Models\ProductsSubCatgorySpec', 'cat', 'id');
    }

    //////////////////////////////////////////////
    function addCategories($name, $category_id, $sort, $tags, $color, $status, $in_menu) {
        $this->name = $name;
        $this->category_id = $category_id;
        $this->sort = $sort;
        $this->tags = $tags;
        $this->color = $color;
        $this->status = $status;
        $this->in_menu = $in_menu;


        $this->save();
        return $this;
    }

    //////////////////////////////////////////////
//    function updateCategories($obj, $name, $product_id, $spec_id, $price, $qty, $view_attr) {
//        $obj->product_id = $product_id;
//        $obj->spec_id = $spec_id;
//        $obj->name = $name;
//        $obj->price = $price;
//        $obj->qty = $qty;
//        $obj->perc = 0;
//        $obj->one_time = 1;
//        $obj->view_attr = $view_attr;
//
//        $obj->save();
//        return $obj;
//    }

    //////////////////////////////////////////////
    function updateStatus($id, $status) {
        return $this
                        ->where('id', '=', $id)
                        ->update([
                            'status' => $status
        ]);
    }

    //////////////////////////////////////////////
    function deleteCategories($obj) {
        return $obj->delete();
    }

    //////////////////////////////////////////////
    function getCategories($id) {
        return $this->find($id);
    }

    //////////////////////////////////////////////
    function getAllCategories() {
        return $this->get();
    }

    function getMenuActiveCategories() {
        $categories = $this->where('status', '=', 1)
                ->where('category_id', '=', 0)
                ->where('in_menu', '=', 1)
                ->orderBy('sort', 'asc')
                ->get();
        $back_data = array();
        foreach ($categories as $category) {
            $sub_categories = $this->where('status', '=', 1)
                    ->where('category_id', '=', $category->id)
                    ->where('in_menu', '=', 1)
                    ->orderBy('sort', 'asc')
                    ->get();
            $category->sub = $sub_categories;
            $back_data[] = $category;
        }
        return $back_data;
    }

    function getAricleActiveCategories() {
        $categories = $this->where('status', '=', 1)
                ->where('category_id', '=', 0)
                ->where('in_menu', '=', 1)
                ->orderBy('sort', 'asc')
                ->get();
        $back_data = array();
        foreach ($categories as $category) {
            $sub_categories = $this->where('status', '=', 1)
                    ->where('category_id', '=', $category->id)
                    ->where('in_menu', '=', 1)
                    ->orderBy('sort', 'asc')
                    ->get();
            if (sizeof($sub_categories) > 0) {
                foreach ($sub_categories as $subcategory) {
                    $cate = new \stdClass();
                    $cate->name = $category->name . ' - ' . $subcategory->name;
                    $cate->id = $subcategory->id;
                    $back_data[] = $cate;
                }
            } else {
                $back_data[] = $category;
            }
        }
        return $back_data;
    }

    //////////////////////////////////////////////
    function getActiveCategories($category_id) {
        return $this->where('status', '=', 1)->where('id', '=', $category_id)->first();
    }

    //////////////////////////////////////////////
    function getCategoriesWithNewsCount() {
        return $this->with('news')->where('status', '=', 1)->get();
    }

    //////////////////////////////////////////////
    function getSearchCategories($name = null) {
        return $this->where(function($query) use ($name) {
                    if ($name != "") {
                        $query->where('name', 'LIKE', '%' . $name . '%');
                    }
                })->get();
    }

}
