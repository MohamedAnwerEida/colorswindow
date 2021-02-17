<?php

use App\Models\Files;
use App\Models\Order;
use App\Models\Products;
use App\Models\ProductsSubCatgorySpec;
use App\Models\Carts;
use Illuminate\Support\Facades\Auth;

function check_main_products($scat_id) {
    $file = new Files();
    $product = $file->getMainProduct($scat_id);
    return $product;
}

function CountCartItems() {
    $cart = new Carts();
    $mycart = $cart->getCustomerCarts(Auth::guard('web')->user()->id);
    if ($mycart) {
        if ($mycart->items) {
            return count($mycart->items);
        }
    }
    return 0;
}

function get_product($p_id) {
    $file = new Products();
    $product = $file->getProduct($p_id);
    return $product;
}

function get_specs($products_spec_types_id, $product_spec_id) {
    $file = new ProductsSubCatgorySpec();
    $product = $file->getCatType($product_spec_id);
    return $product;
}

function get_image($image, $width, $height) {
    if ($image) {
        $image_explode = explode('/', $image);
        $size = sizeof($image_explode);
        $image_name = $image_explode[$size - 1];
        $final_explode = explode($image_name, $image);
        $thumb = $final_explode[0] . 'thumbs/' . $width . '_' . $height . '_' . $image_name;
        $full = $final_explode[0] . $image_name;
        if (file_exists(public_path() . $thumb)) {
            return $thumb;
        } else {
            if (!file_exists(public_path() . '/' . $final_explode[0] . 'thumbs')) {
                mkdir(public_path() . '/' . $final_explode[0] . 'thumbs/', 0755, true);
            }
            $img = Image::make(public_path() . '/' . $full);
            $img->fit($width, $height)
                    ->save(public_path() . '/' . $thumb);

            return $thumb;
        }
    }
    return '/';
}

function getEmptyProducts() {
    $product = new Products();
    return $product->getEmptyProducts();
}

function getNewOrders() {
    $product = new Order();
    return $product->getNewOrders();
}
function getTotalOnlineByMonth() {
    $product = new Order();
    return $product->getTotalOnlineByMonth();
}
function getTotalNotPaidByMonth() {
    $product = new Order();
    return $product->getTotalNotPaidByMonth();
}
function getTotalPaidByToday() {
    $product = new Order();
    return $product->getTotalPaidByToday();
}
