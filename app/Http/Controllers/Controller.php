<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\Settings;
use App\Models\Categories;
use App\Models\Slider;
use App\Models\Socials;
use App\Models\Products;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController {

    public static $data = [];

    public function __construct() {

        self::$data['minutes'] = 60 * 24;
        //////////////////////////////////////
        self::$data['home'] = 1;
        self::$data['settings'] = Cache::rememberForever('settings', function () {
                    $settings = new Settings();
                    return $settings->getSetting(1);
                });
        self::$data['social'] = Cache::remember('social', self::$data['minutes'], function () {
                    $social = new Socials();
                    return $social->getAllSocialActive();
                });
        //////////////////////////////////////////////
        self::$data['categories'] = Cache::remember('categories', self::$data['minutes'], function () {
                    $categories = new Categories();
                    return $categories->getMenuActiveCategories();
                });
        self::$data['keywords'] = Cache::remember('keyword', self::$data['minutes'], function () {
            $keyword = new Keyword();
            return $keyword->get()->pluck('keyword')->toArray();
        });
        self::$data['sliders'] = Cache::remember('sliders', self::$data['minutes'], function () {
            $slider = new Slider();
            return $slider->get();
        });
       /* self::$data['gifts_products'] = Cache::rememberForever('gifts_products', function () {
                    $products = new Products();
                    return $products->getProductsByCategory(2, 6);
                });*/
        self::$data['dealofdays'] = Cache::rememberForever('gifts_products', function () {
            $products = new Products();
            return $products->getLimitedDealProducts(6);
        });
        //////////////////////////////////////
    }

}
