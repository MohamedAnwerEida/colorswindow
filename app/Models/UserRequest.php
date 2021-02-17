<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model {

    protected $table = 'special';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    function addNew($user_id, $request) {
        $this->request = $request;
        $this->user_id = $user_id;
        $this->save();
        return $this;
    }

}
