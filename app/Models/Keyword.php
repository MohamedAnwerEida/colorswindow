<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keyword extends Model {

    protected $table = 'keyword';
    protected $fillable = [
        'keyword', 'module_type', 'module_id',
    ];

    public function module()
    {
        return $this->morphTo();
    }

    public function Products()
    {
        return $this->belongsTo(Products::class, "module_id");
    }

    function getSearchKeyword($title, $limit = 60) {
        return $this->where('module_type',Files::class)->with('Products')->where(function($query) use ($title) {
            if ($title != "") {
                $query->where('keyword', 'LIKE', '%' . $title . '%');
            }
        })
            ->groupBy('module_id')
            ->orderBy('id', 'desc')
            ->paginate($limit)->pluck('products');
    }

}
