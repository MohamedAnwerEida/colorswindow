<?php

namespace App\Http\Controllers;

use App\Models\Products;

class ProductsController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function getIndex($id) {
        $product = new Products();
        $info = $product->getProduct($id);
        if ($info) {
            parent::$data['product'] = $info;
            $rProject = $product->getSubCategoryProducts(parent::$data['product']->scat,9);
            
            if($rProject->count() <= 1){
                $rProject = $product->getCategoryProducts(parent::$data['product']->cat,9);
            }
            parent::$data['related_product'] = $rProject;
            //dd(parent::$data['related_product']);
           // parent::$data['related_product'] = $info->subcats;
           // dd(parent::$data['related_product']->toArray());
            parent::$data['products'] = $product->getActiceProducts();
            return view('frontend.product.view', parent::$data);
        } else {
            return view('errors.404', parent::$data);
        }
    }

}
