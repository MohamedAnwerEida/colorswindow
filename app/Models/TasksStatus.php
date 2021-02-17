<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasksStatus extends Model
{
    protected $table = 'tasks_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name','status_id');



}
