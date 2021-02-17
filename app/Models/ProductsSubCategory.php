<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsSubCategory extends Model {

    use SoftDeletes;

    //////////////////////////////////////////////
    protected $table = 'products_subcategories';
    protected $fillable = [
        'name', 'sort', 'tags', 'color', 'status', 'in_menu'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    //////////////////////////////////////////////
    public function spec() {
        return $this->hasMany('App\Models\ProductsSubCatgorySpec', 'product_id', 'id')->orderBy('spec_id')->orderBy('id')->with('catspectype');
    }

//    public function subcats() {
//        return $this->hasMany('App\Models\ProductsSubCategory', 'cat', 'id')->with('catspec');
//    }
    //////////////////////////////////////////////
    function addCategories($name, $category_id, $status) {
        $this->name_ar = $name;
        $this->cat = $category_id;
        $this->active = $status;
        $this->save();
        return $this;
    }

    //////////////////////////////////////////////
    function updateCategories($obj, $name, $category_id, $status) {
        $obj->name_ar = $name;
        $obj->cat = $category_id;        
        $obj->active = $status;


        $obj->save();
        return $obj;
    }

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
    function getAllActiveCategories() {
        return $this->where('active', '=', 1)->orderBy('dir', 'asc')->get();
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
        return $this->where('active', '=', 1)->where('id', '=', $category_id)->first();
    }

    //////////////////////////////////////////////
    function getCategoriesWithNewsCount() {
        return $this->with('news')->where('status', '=', 1)->get();
    }

    //////////////////////////////////////////////
    function getSearchCategories($name = null) {
        return $this->where(function($query) use ($name) {
                    if ($name != "") {
                        $query->where('name_ar', 'LIKE', '%' . $name . '%');
                    }
                })->get();
    }

}
