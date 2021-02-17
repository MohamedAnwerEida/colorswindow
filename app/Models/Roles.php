<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model {

    use SoftDeletes;

    //////////////////////////////////////////////
    protected $table = 'roles';
    protected $fillable = ['name', 'status',];
    protected $hidden = [
        '',
    ];

    //////////////////////////////////////////////
    public function user() {
        return $this->hasMany('App\Models\User');
    }

    //////////////////////////////////////////////
    function addRole($name, $role_order, $status, $tasks_status, $role_color, $role_icon, $status_id, $status_stock) {
        $this->name = $name;
        $this->role_order = $role_order;
        $this->status = $status;
        $this->tasks_status = $tasks_status;
        $this->role_color = $role_color;
        $this->role_icon = $role_icon;
        $this->status_id = $status_id;
        $this->status_stock = $status_stock;

        $this->save();
        return $this;
    }

    //////////////////////////////////////////////
    function updateRole($obj, $name, $role_order, $status, $tasks_status, $role_color, $role_icon, $status_id, $status_stock) {
        $obj->name = $name;
        $obj->role_order = $role_order;
        $obj->status = $status;
        $obj->tasks_status = $tasks_status;
        $obj->role_color = $role_color;
        $obj->role_icon = $role_icon;
        $obj->status_id = $status_id;
        $obj->status_stock = $status_stock;


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

    //////////////////////////////////////////////
    function deleteRole($obj) {
        return $obj->delete();
    }

    //////////////////////////////////////////////
    function getRole($id) {
        return $this->find($id);
    }

    //////////////////////////////////////////////
    function getAllRolesActive() {
        return $this->where('status', '=', 1)->get();
    }

    function getRoleByorder($order) {
        return $this->where('role_order', '=', $order)->first();
    }

    function getAllRolesActiveOrderd() {
        return $this->where('status', '=', 1)->where('tasks_status', '=', 1)->orderBy('role_order', 'asc')->get();
    }

    //////////////////////////////////////////////
    function getRoles($name = null) {
        return $this->where(function($query) use ($name) {
                    if ($name != "") {
                        $query->where('name', 'LIKE', '%' . $name . '%');
                    }
                })->get();
    }

}
