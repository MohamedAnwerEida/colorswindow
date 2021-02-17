<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use App\Models\Pages;

class PageController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    ///////////////////////////
    public function getIndex() {
        
    }

    ///////////////////////////////////////
    public function getPage() {
        $id = Request::segment(count(Request::segments()));

        $page = new Pages();
        $info = $page->getPageByName($id);
        if (!$info) {
            return response()->view('errors.404', parent::$data, 500);
        }
        parent::$data['page'] = $info;
        return view('frontend.page.view', parent::$data);
    }

}
