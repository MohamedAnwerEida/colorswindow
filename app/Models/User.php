<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {

    use Notifiable,
        HasPushSubscriptions,
        SoftDeletes,
        HasRoles;

    //////////////////////////////////////////////
    protected $table = 'users';
    protected $fillable = [
        'username', 'name', 'email', 'role', 'created_by', 'password', 'status',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $guard_name = 'admin';

    //////////////////////////////////////////////
    public function myrole() {
        return $this->hasOne('App\Models\Roles', 'id', 'role');
    }

    //////////////////////////////////////////////
    public function user() {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    //////////////////////////////////////////////
    function addUser($username, $name, $email, $mobile, $role, $user_type, $created_by, $password, $status) {
        $this->username = $username;
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->role = $role;
        $this->user_type = $user_type;
        $this->created_by = $created_by;
        $this->password = $password;
        $this->status = $status;

        $this->save();
        return $this;
    }

    //////////////////////////////////////////////
    function updateUser($obj, $username, $name, $email, $mobile, $role, $user_type, $status) {
        $obj->username = $username;
        $obj->name = $name;
        $obj->email = $email;
        $obj->mobile = $mobile;
        $obj->role = $role;
        $obj->user_type = $user_type;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }

    //////////////////////////////////////////////
    function updatePassword($id, $password) {
        return $this
                        ->where('id', '=', $id)
                        ->update([
                            'password' => $password
        ]);
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
    function deleteUser($obj) {
        return $obj->delete();
    }

    //////////////////////////////////////////////
    function getUser($id) {
        return $this->find($id);
    }

    function getAllActiveUsers() {
        return $this->where('status', '=', 1)->get();
    }

    function getAllActiveStoreUsers() {
        return $this->whereHas('myrole', function($query) {
                            $query->where('id', 2);
                            $query->OrWhere('status_stock', 1);
                        })
                        ->where('status', '=', 1)
                        ->get();
    }

    function getAllActiveAdminUsers() {
        return $this->whereHas('myrole', function($query) {
                            $query->where('id', 2);
                        })
                        ->where('status', '=', 1)
                        ->where('user_type', '=', 0)
                        ->get();
    }

    //////////////////////////////////////////////
    function getUsers($username = null, $name = null, $email = null) {
        return $this->where(function($query) use ($username, $name, $email) {
                    if ($username != "") {
                        $query->where('username', 'LIKE', '%' . $username . '%');
                    }
                    if ($name != "") {
                        $query->where('name', 'LIKE', '%' . $name . '%');
                    }
                    if ($email != "") {
                        $query->where('email', '=', $email);
                    }
                })->get();
    }

    function updateUserAvatar($id, $avatar) {
        return $this
                        ->where('id', '=', $id)
                        ->update([
                            'avatar' => $avatar
        ]);
    }

}
