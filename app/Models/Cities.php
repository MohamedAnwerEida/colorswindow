<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model {

    protected $table = 'sa_cities';
    protected $fillable = array('nameAr', 'nameEn', 'provinceId');

}
