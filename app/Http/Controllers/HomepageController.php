<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Models\Pages;
use App\Models\Products;

class HomepageController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    ///////////////////////////
    public function getIndex() {
        ///////////////////////////////////////////////////////
        parent::$data['products'] = Cache::rememberForever('products', function () {
                    $products = new Products();
                    return $products->getActiceProducts();
                });
        parent::$data['about'] = Cache::rememberForever('about', function () {
                    $page = new Pages();
                    return $page->getPageByName('about');
                });
        parent::$data['new_products'] = Cache::rememberForever('new_products', function () {
                    $products = new Products();
                    return $products->getNewProducts();
                });
        /*parent::$data['dealofdays'] = Cache::rememberForever('dealofdays', function () {
            $products = new Products();
            return $products->getDealProducts();
        });*/
      /*  parent::$data['feature_products'] = Cache::rememberForever('feature_products', function () {
                    $products = new Products();
                    return $products->getFeatureProducts();
                });*/
        $products = new Products();
        parent::$data['feature_products'] = $products->getFeatureProducts();
//        $products = new Products();
//        parent::$data['rand_products'] = $products->getRandProducts(5);

        parent::$data['rated_products'] = Cache::rememberForever('rated_products', function () {
                    $products = new Products();
                    return $products->getRatedProducts(10);
                });
        parent::$data['stker_products'] = Cache::rememberForever('stker_products', function () {
                    $products = new Products();
                    return $products->getCategoryProducts(1, 20);
                });
//        $products = new Products();
//        $products = $products->getRatedProducts(10);
//        print_r($products);
//        exit;
        ///////////////////////////////////////////////////////
        return view('frontend.home.view', parent::$data);
    }

}
