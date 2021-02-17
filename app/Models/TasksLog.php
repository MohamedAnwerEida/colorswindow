<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TasksLog extends Model {

    use SoftDeletes;

    protected $table = 'task_log';
    protected $fillable = array('order_id', 'dep_id', 'emp_id', 'task_status', 'job_status', 'notes_admin', 'user_id');

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function emp_name() {
        return $this->hasOne('App\Models\User', 'id', 'emp_id');
    }

    public function demp_name() {
        return $this->hasOne('App\Models\Roles', 'id', 'dep_id');
    }

    public function mystatus() {
        return $this->hasOne('App\Models\TasksStatus', 'status_id', 'task_status');
    }

}
