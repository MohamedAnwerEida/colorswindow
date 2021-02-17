<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Products extends Model {

    use SoftDeletes;

    protected $table = 'products';
    protected $fillable = [
        'title', 'price', ' category_id', 'status', 'descs','offer'
    ];
    protected $hidden = [
        '',
    ];
     public function keyword(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany('App\Models\Keyword', 'module')->orderBy('created_at', 'desc');
    }
    public function category() {
        return $this->belongsTo('App\Models\Categories', 'cat', 'id');
    }

    public function subcats() {
        return $this->belongsTo('App\Models\ProductsSubCategory', 'scat', 'id')->with('spec');
    }

    public function images() {
        return $this->hasMany('App\Models\ProductsImages', 'product_id', 'id')->take(3);
    }

    public function rating() {
        return $this->hasMany('App\Models\ProductsRating');
    }

    public function comments() {
        return $this->hasMany('App\Models\ProductsComments', 'id_p', 'id');
    }

//    public function subcats() {
//        return $this->hasMany('App\Models\ProductsSubCategory', 'product_id', 'id');
//    }
    //////////////////////////////////////////////
    function addVideo($title, $url, $status, $user_id) {
        $this->title = $title;
        $this->url = $url;
        $this->status = $status;
        $this->user_id = $user_id;

        $this->save();
        return $this;
    }

    //////////////////////////////////////////////
    function updateVideo($obj, $title, $url, $status) {
        $obj->title = $title;
        $obj->url = $url;
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
//    function deleteVideo($obj) {
//        return $obj->delete();
//    }
    //////////////////////////////////////////////
    function getProduct($id) {
        return $this->with('category', 'subcats', 'rating', 'comments')->find($id);
    }

    function getCategoryProducts($category_id, $limit = 9) {
        return $this->with('images')
                        ->where('active', '=', 1)
                        ->where('cat', '=', $category_id)
                        ->orderBy('id', 'desc')
                        ->paginate($limit);
    }

    function getSubCategoryProducts($category_id, $limit = 9) {
        return $this->with('images')
                        ->where('active', '=', 1)
                        ->where('scat', '=', $category_id)
                        ->orderBy('id', 'desc')
                        ->paginate($limit);
    }

//    function getLastVideos($start, $limit) {
//        return $this
//                        ->where('status', '=', 1)
//                        ->orderBy('id', 'desc')
//                        ->skip($start)
//                        ->take($limit)
//                        ->get();
//    }
    //////////////////////////////////////////////
//    function getLastVideo() {
//        return $this
//                        ->where('status', '=', 1)
//                        ->orderBy('id', 'desc')
//                        ->first();
//    }
    //////////////////////////////////
//    function getAllVideos() {
//        return $this->get();
//    }

    function getNewProducts() {
        return $this->with('rating')->where('active', '=', 1)->orderBy('id', 'desc')->take(12)->get();
    }

    function getActiceProducts() {
        return $this->with('rating')->where('active', '=', 1)->orderBy('id', 'asc')->take(12)->get();
    }

    function getAllActiceProducts() {
        return $this->with('rating')->where('active', '=', 1)->orderBy('id', 'asc')->get();
    }

    function getFeatureProducts() {
        return $this->where('active', '=', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->take(6)->get();
    }

    function getProductsByCategory($cat_id, $limit) {
        return $this->where('active', '=', 1)->where('cat', '=', $cat_id)->orderBy('id', 'desc')->take($limit)->get();
    }

    function getDealProducts($limit = 20) {
        return $this->where('active', '=', 1)->where('dealofdays', '=', 1)->orderBy('id', 'desc')->paginate($limit);
    }
    function getLimitedDealProducts($limit) {
        return $this->where('active', '=', 1)->where('dealofdays', '=', 1)->orderBy('id', 'desc')->get()->take($limit);
    }
    function getRandProducts($limit = 5) {
        return $this->where('active', '=', 1)->inRandomOrder()->take($limit)->get();
    }
    function getOfferProducts($limit = 20) {
        return $this->where('active', '=', 1)->where('offer', '=', 1)->orderBy('id', 'desc')->paginate($limit);
    }
    function getRatedProducts($limit = 10) {
        return $this->where('active', '=', 1)
                        ->selectRaw('products.id,products.name_ar,products.image,products.price,old_price,AVG(products_rating.rate) AS rate')
                        ->join('products_rating', 'products_rating.products_id', '=', 'products.id', 'left')
                        ->orderByRaw('AVG(products_rating.rate)', 'desc')
                        ->groupBy('products.id')
                        ->take($limit)
                        ->get();
    }

//////////////////////////////////////////////
    function getSearchProducts($title, $limit = 60) {
        return $this->where('active', '=', 1)->where(function($query) use ($title) {
                            if ($title != "") {
                                $query->where('name_ar', 'LIKE', '%' . $title . '%');
                            }
                        })
                        ->orderBy('id', 'desc')
                        ->paginate($limit);
    }

    function getEmptyProducts() {
        return $this->where('active', '=', 1)->whereRaw('qty <= qty_stock_min ')->count();
    }

}
