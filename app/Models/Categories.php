<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model {

    use SoftDeletes;

    //////////////////////////////////////////////
    protected $table = 'categories';
    protected $fillable = [
        'name', 'sort', 'tags', 'color', 'status', 'in_menu'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    //////////////////////////////////////////////
    public function subcategory() {
        return $this->hasMany('App\Models\Subcategory', 'cat', 'id')->where('active', '=', 1);
    }

    //////////////////////////////////////////////
    function addCategories($name, $sort, $color, $status) {
        $this->name_ar = $name;
        $this->sort = $sort;
        $this->color = $color;
        $this->status = $status;
        $this->save();
        return $this;
    }

    //////////////////////////////////////////////
    function updateCategories($obj, $name, $sort, $color, $status) {
        $obj->name_ar = $name;
        $obj->sort = $sort;
        $obj->color = $color;
        $obj->status = $status;
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
        return $this->where('status', '=', 1)->orderBy('sort', 'asc')->get();
    }

    function getMenuActiveCategories() {
        return $this->with('subcategory')->where('status', '=', 1)
                        ->orderBy('sort', 'asc')
                        ->get();
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
