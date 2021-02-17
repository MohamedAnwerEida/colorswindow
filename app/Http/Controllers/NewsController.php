<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Models\News;

class NewsController extends Controller {

    public function __construct() {
        parent::__construct();
        self::$data['home'] = 0;
    }

    ///////////////////////////
    public function getIndex() {
        $news = new News();
        parent::$data['home'] = 1;
        parent::$data['category_news'] = $news->getCategoryNews(1, 15);
        return view('frontend.news.index', parent::$data);
    }

    ///////////////////////////////////////
    public function getNews($cat_id = NULL, $id = 0) {
        $id = $id == 0 ? $cat_id : $id;
        $news = new News();
        $info = $news->getNews($id);
        if (!$info) {
            return response()->view('errors.404', parent::$data, 500);
        }
        parent::$data['post_news'] = $info;
        parent::$data['next'] = $news->getNewsNext($info->id, $info->category_id);
        parent::$data['previous'] = $news->getNewsPrev($info->id, $info->category_id);
        parent::$data['related'] = $news->getNewsByTags($info->tags, $info->id);
        parent::$data['westnews'] = Cache::rememberForever('westnews', function () {
                    $news = new News();
                    return $news->getSidebarNews();
                });


        parent::$data['vedio'] = 0;
        parent::$data['view'] = 0;
        return view('frontend.news.details', parent::$data);
    }

}
