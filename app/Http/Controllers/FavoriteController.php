<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\Fav;
use App\Models\Customers;
use App\Models\Products;


class FavoriteController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function getIndex() {
        $fav = new Fav();
        parent::$data['favs'] = $fav->getMyFav(Auth::guard('web')->user()->id);
        parent::$data['deal_products'] = Cache::rememberForever('deal_products', function () {
                    $products = new Products();
                    return $products->getDealProducts();
                });
        parent::$data['feature_products'] = Cache::rememberForever('feature_products', function () {
                    $products = new Products();
                    return $products->getFeatureProducts();
                });
        parent::$data['rand_products'] = Cache::rememberForever('rand_products', function () {
                    $products = new Products();
                    return $products->getRandProducts(5);
                });
        return view('frontend.favorites.view', parent::$data);
    }

    public function addFav($id) {
        $user = Auth::guard('web')->user()->id;

        $fav = new Fav();
        $info = $fav->getFav($id, $user);
        if ($info) {//delete
            $fav->deleteFav($info);
        } else {//add
            $fav->addFav($id, $user);
        }

        return redirect('favorites');
    }

    public function getUnFav($item) {
        $user = new Customers();
        $user = $user->getCustomer(Auth::guard('web')->user()->id);
        $fav = new Fav();
        $info = $fav->getFav($item, $user->id);
        if ($info) {//delete
            $fav->deleteFav($info);
            return redirect('favorites');
        }
        return redirect('favorites');
    }

}
