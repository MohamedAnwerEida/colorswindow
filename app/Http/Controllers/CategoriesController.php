<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Support\Facades\Cache;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\ProductsSubCategory;
use App\Models\Products;

class CategoriesController extends Controller {

    public function __construct() {
        parent::__construct();
    }

///////////////////////////
    public function getIndex($category_id) {
        if (ctype_digit($category_id)) {
//////////////////////////////////////////////
            parent::$data['category_info'] = Cache::remember('category_info_' . $category_id, parent::$data['minutes'], function () use($category_id) {
                        $categories = new Categories();
                        return $categories->getActiveCategories($category_id);
                    });
            if (parent::$data['category_info']) {
                $products = new Products();
                parent::$data['products'] = $products->getCategoryProducts($category_id, 9);

                parent::$data['feature_products'] = Cache::rememberForever('feature_products', function () {
                            $products = new Products();
                            return $products->getFeatureProducts();
                        });
                parent::$data['rand_products'] = Cache::rememberForever('rand_products', function () {
                            $products = new Products();
                            return $products->getRandProducts(5);
                        });
                return view('frontend.categories.view', parent::$data);
            }
        }
        echo '<center><h1>';
        echo 'حدث خطا';
        echo '</h1>';
    }

    public function getsubcategoryIndex($category_id) {
        if (ctype_digit($category_id)) {
//////////////////////////////////////////////
            $subcat = new ProductsSubCategory();
            $scat = $subcat->getCategories($category_id);
            $products = new Products();
            parent::$data['products'] = $products->getSubCategoryProducts($category_id, 15);

            parent::$data['category_info'] = Cache::remember('category_info_' . $scat->cat, parent::$data['minutes'], function () use($category_id, $scat) {
                        $categories = new Categories();
                        return $categories->getActiveCategories($scat->cat);
                    });


            parent::$data['feature_products'] = Cache::rememberForever('feature_products', function () {
                        $products = new Products();
                        return $products->getFeatureProducts();
                    });
            parent::$data['rand_products'] = Cache::rememberForever('rand_products', function () {
                        $products = new Products();
                        return $products->getRandProducts(5);
                    });
            return view('frontend.categories.view', parent::$data);
        }
        echo '<center><h1>';
        echo 'حدث خطا';
        echo '</h1>';
    }

    public function getOffers() {
        $cat = new \stdClass();
        $cat->name_ar = 'عروضنا';
        parent::$data['category_info'] = $cat;
        $products = new Products();
        parent::$data['products'] = $products->getOfferProducts();
/*
        parent::$data['feature_products'] = Cache::rememberForever('feature_products', function () {
                    $products = new Products();
                    return $products->getFeatureProducts();
                });
        parent::$data['rand_products'] = Cache::rememberForever('rand_products', function () {
                    $products = new Products();
                    return $products->getRandProducts(5);
                });*/
        return view('frontend.categories.view', parent::$data);
    }

    public function getSearchIndex(Request $request) {
        $cat = new \stdClass();
        $cat->name_ar = 'البحث';
        parent::$data['category_info'] = $cat;

        $name = $request->get('name');
        $products = new Products();
        $keyword = new Keyword();
        parent::$data['products'] = $keyword->getSearchKeyword($name);

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
        return view('frontend.categories.view', parent::$data);
    }

}
