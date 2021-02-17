<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminController extends BaseController {

    public static $data = [];

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public function __construct() {
        self::$data['component_style'] = 1;
        self::$data['color'] = "grey";
        self::$data['fixed_sidebar'] = 0;
        self::$data['form_class'] = "dark";
        self::$data['btn_class'] = "dark";
        self::$data['per_page'] = 20;
    }

}
