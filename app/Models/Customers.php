<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class Customers extends Authenticatable {

    use Notifiable,
        SoftDeletes;

    protected $table = 'customers';
    protected $fillable = [
        'username', 'full_name', 'mobile', 'email', 'password', 'photo', 'device_token', 'device_type', 'status', 'activated_status', 'verification_code'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders() {
        return $this->hasMany('App\Models\Order', 'customer_id');
    }

    public function carts() {
        return $this->hasManyThrough('App\Models\CartsItems', 'App\Models\Carts', 'customer_id', 'cart_id');
    }

    function addCustomer($name, $email, $phone, $sex, $dob, $role, $password, $status, $token) {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->sex = $sex;
        $this->dob = $dob;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
        $this->status = $status;
        $this->token = $token;

        $this->save();
        return $this;
    }

    //////////////////////////////////////////////
    //function updateUser($obj, $name, $email, $country, $sex, $dop, $live_place, $phone, $role, $password, $status) {
    function updateCustomer($obj, $name, $phone, $dob, $sex, $email = NULL) {
        $obj->name = $name;
        if ($email) {
            $obj->email = $email;
        }
        $obj->phone = $phone;
        $obj->dob = $dob;
        $obj->sex = $sex;

//        $obj->email = $email;
//        $obj->role = $role;
//        $obj->password = $password;
//        $obj->status = $status;
        $obj->save();
        return $obj;
    }

    function updateCustomerShopping($obj, $neighborhood, $street, $building, $notes) {
        $obj->neighborhood = $neighborhood;
        $obj->street = $street;
        $obj->building = $building;
        $obj->notes = $notes;
        $obj->save();
        return $obj;
    }

    //////////////////////////////////////////////
    function updateDeviceCredentials($obj, $device_token, $device_type) {
        $obj->device_token = $device_token;
        $obj->device_type = $device_type;

        $obj->save();
        return $obj;
    }

    //////////////////////////////////////////////
    function updateCustomerForAdmin($obj, $username, $full_name, $mobile, $email, $activated_status, $status) {
        $obj->username = $username;
        $obj->full_name = $full_name;
        $obj->mobile = $mobile;
        $obj->email = $email;
        $obj->activated_status = $activated_status;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }

    //////////////////////////////////////////////
    function updatePassword($id, $password) {
        return $this->where('id', '=', $id)
                        ->update(['password' => $password
        ]);
    }

    //////////////////////////////////////////////
    function updateField($id, $field, $value) {
        return $this->where('id', '=', $id)
                        ->update([$field => $value]);
    }

    function updateStatus($id, $status) {
        return $this->where('id', '=', $id)
                        ->update(['status' => $status]);
    }

    //////////////////////////////////
    function changeVerificationCode($obj, $verification_code) {
        $obj->verification_code = $verification_code;
        $obj->save();

        return $obj;
    }

    //////////////////////////////////
    function updateActivatedStatus($obj, $activated_status, $verification_code) {
        $obj->activated_status = $activated_status;
        $obj->verification_code = $verification_code;
        $obj->save();

        return $obj;
    }

    //////////////////////////////////
    function updateCustomerCredit($obj, $type, $credit) {
        if ($type == 'plus') {
            $obj->increment('credit', $credit);
            $obj->save();
            return $obj;
        } elseif ($type == 'minus') {
            $obj->decrement('credit', $credit);
            $obj->save();
            return $obj;
        }
    }

    //////////////////////////////////
    function changePassword($obj, $password) {
        $obj->password = $password;
        $obj->save();

        return $obj;
    }

    //////////////////////////////////////////////
    function deleteCustomer($obj) {
        return $obj->delete();
    }

    //////////////////////////////////
    function getActiveCustomer($id) {
        return $this->where('status', '=', 1)->where('id', '=', $id)->first();
    }

    //////////////////////////////////////////////
    function getCustomer($id) {
        return $this->find($id);
    }

    //////////////////////////////////////////////
    function getCustomerByEmail($email) {
        return $this->where('email', '=', $email)->first();
    }

    function getCustomerByGoogleEmail($email) {
        return $this->where('email', '=', $email)->where('google_id', '!=', '')->first();
    }

    //////////////////////////////////////////////
    function getCustomerByMobile($mobile) {
        return $this->where('mobile', '=', $mobile)->first();
    }

    //////////////////////////////////////////////
    function getPreActiveCustomer($username) {
        return $this->where('username', '=', $username)->where('status', '=', 1)->where('activated_status', '=', 0)->first();
    }

    //////////////////////////////////////////////
    function getPreActiveCustomerForLogin($username) {
        return $this->where(function($query) use ($username) {
                    $query->where('username', '=', $username)->orWhere('email', '=', $username);
                })->where('status', '=', 1)->first();
    }

    function CountCustomersInMonth() {
//        echo Carbon::now()->subMonth()->month;
//        exit;
        return $this->whereMonth('created_at', '=', Carbon::now()->month)
                        //->where('status', '=', 1)
                        ->count();
    }

    //////////////////////////////////////////////
    function getCustomers($name = null, $full_name = null, $email = null, $mobile = null) {
        return $this->where(function($query) use ($name, $full_name, $email, $mobile) {
                    if ($name != "") {
                        $query->where('name', 'LIKE', '%' . $name . '%');
                    }
                    if ($full_name != "") {
                        $query->where('full_name', 'LIKE', '%' . $full_name . '%');
                    }
                    if ($email != "") {
                        $query->where('email', '=', $email);
                    }
                    if ($mobile != "") {
                        $query->where('mobile', '=', $mobile);
                    }
                })->get();
    }

    //////////////////////////////////
    function getAllActiveCustomers() {
        return $this->where('status', '=', 1)->get();
    }

    function getCustomerByToken($token) {
        return $this->where('token', $token)->first();
    }

    //////////////////////////////////
    function getCustomersHaveTokens() {
        return $this->where('status', '=', 1)
                        //->where('device_type', '=', $device_type)
                        ->where('device_token', '!=', null)
                        ->get();
    }

    //////////////////////////////////
    function countCustomers() {
        return $this->count('id');
    }

    function getSearchCustomers($name = null) {
        return $this->where(function($query) use ($name) {
                    if ($name != "") {
                        $query->where('full_name', 'LIKE', '%' . $name . '%');
                        $query->orWhere('mobile', 'LIKE', '%' . $name . '%');
                        $query->orWhere('email', 'LIKE', '%' . $name . '%');
                    }
                })->get();
    }

    function getSearchCustomer($name = null) {
        return $this->where(function($query) use ($name) {
                    if ($name != "") {
                        $query->where('full_name', 'LIKE', '%' . $name . '%');
                    }
                })->first();
    }

    function updateToken($id, $token) {
        return $this
                        ->where('id', '=', $id)
                        ->update([
                            'token' => $token
        ]);
    }

}
