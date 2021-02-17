<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\Keyword;

class Files extends Model {

    use SoftDeletes;

    protected $table = 'products';
    protected $fillable = [
        'title', 'descs', 'image', 'status', 'user_id','offer'
    ];
    protected $hidden = [
        '',
    ];

    public function images() {
        return $this->hasMany('App\Models\ProductsImages', 'product_id', 'id')->take(5);
    }

    //////////////////////////////////////////////
    function addFile($name_ar, $text_ar, $cat, $scat, $image, $min_qty, $product_images, $price, $old_price, $active, $dealofdays, $featured, $main, $offer) {
        $this->name_ar = $name_ar;
        $this->text_ar = $text_ar;
        $this->cat = $cat;
        $this->scat = $scat;
        $this->image = $image;
        $this->min_qty = $min_qty;
        $this->extra_images = $product_images;
        $this->price = $price;
        $this->old_price = $old_price;
        // $this->qty = $qty;
        $this->active = $active;
        $this->dealofdays = $dealofdays;
        $this->featured = $featured;
        $this->main = $main;
        $this->offer = $offer;
        $this->save();
        return $this;
    }

    //////////////////////////////////////////////
    function updateFile($obj, $name_ar, $text_ar, $cat, $scat, $image, $min_qty, $product_images, $price, $old_price, $active, $dealofdays,$featured, $main, $offer) {
        $obj->name_ar = $name_ar;
        $obj->text_ar = $text_ar;
        $obj->cat = $cat;
        $obj->scat = $scat;
        $obj->image = $image;
        $obj->min_qty = $min_qty;
        $obj->extra_images = $product_images;
        $obj->price = $price;
        $obj->old_price = $old_price;
        // $obj->qty = $qty;
        $obj->active = $active;
        $obj->dealofdays = $dealofdays;
        $obj->featured = $featured;
        $obj->main = $main;
        $obj->offer = $offer;
        $obj->save();
        return $obj;
    }

    //////////////////////////////////////////////
    function updateStatus($id, $status) {
        return $this
                        ->where('id', '=', $id)
                        ->update([
                            'active' => $status
        ]);
    }

    function updateField($id, $name, $value) {
        return $this
                        ->where('id', '=', $id)
                        ->update([
                            $name => $value
        ]);
    }

    //////////////////////////////////////////////
    function deleteFile($obj) {
        return $obj->delete();
    }
    public function keyword(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Keyword::class, 'module')->orderBy('created_at', 'desc');
    }
    //////////////////////////////////////////////
    function getFile($id) {
        return $this->with(['images','keyword'])->find($id);
    }

    //////////////////////////////////////////////
    function getLastFile() {
        return $this
                        ->where('active', '=', 1)
                        ->orderBy('id', 'desc')
                        ->first();
    }

    function getMainProduct($scatid) {
        return $this
                        ->where('active', '=', 1)
                        ->where('scat', '=', $scatid)
                        ->where('main', '=', 1)
                        ->first();
    }

    function getFiles($start, $limit) {
        return $this
                        ->where('active', '=', 1)
                        ->orderBy('id', 'desc')
                        ->skip($start)
                        ->take($limit)
                        ->paginate($limit);
    }

    //////////////////////////////////
    function getAllFiles() {
        return $this->get();
    }

//////////////////////////////////////////////
    function getSearchFiles($title) {
        return $this->where(function($query) use ($title) {
                            if ($title != "") {
                                $query->where('name_ar', 'LIKE', '%' . $title . '%');
                            }
                        })
                        ->get();
    }

}
