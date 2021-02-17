<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pages extends Model {

    use SoftDeletes;

    protected $table = 'pages';
    protected $fillable = [
        'title', 'details', 'image', 'tags', 'status',
    ];

    //////////////////////////////////
    function updatePage($obj, $title, $details, $image, $tags, $status) {
        $obj->title = $title;
        $obj->details = $details;
        $obj->image = $image;
        $obj->tags = $tags;
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

    //////////////////////////////////
    function getPage($id) {
        return $this->find($id);
    }

    //////////////////////////////////
    function getAllPages() {
        return $this->get();
    }

    //////////////////////////////////
    function getPageByName($name) {
        return $this->where('slug', '=', $name)->first();
    }

    //////////////////////////////////////////////
    function getPages($page = null) {
        return $this->where(function($query) use ($page) {
                    if ($page != "") {
                        $query->where('title', 'LIKE', '%' . $page . '%');
                    }
                })->get();
    }

}
