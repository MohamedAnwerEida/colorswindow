<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacts extends Model {

//    use SoftDeletes;

    protected $table = 'contact_us';
    protected $fillable = [
        'name', 'email', 'details', 'status',
    ];
    protected $hidden = [
        '',
    ];

    ////////////////////////////////////
    function addContact($name, $email, $details) {
        $this->name = $name;
        $this->email = $email;
        $this->details = $details;

        $this->save();
        return $this;
    }

    //////////////////////////////////
    function updateStatus($id, $status) {
        return $this
                        ->where('id', '=', $id)
                        ->update([
                            'status' => $status
        ]);
    }

    //////////////////////////////////
    function deleteContact($obj) {
        return $obj->delete();
    }

    //////////////////////////////////
    function getContact($id) {
        return $this->find($id);
    }

    //////////////////////////////////
    function getActiveContact($id) {
        return $this->where('status', '=', 1)->where('id', '=', $id)->first();
    }

    //////////////////////////////////
    function getAllContact() {
        return $this->get();
    }

    //////////////////////////////////
    function getContacts($name = "", $email = "") {
        return $this->where(function($query) use ($name, $email) {
                    if ($name != "") {
                        $query->where('name', '=', $name);
                    } elseif ($email != "") {
                        $query->where('email', '=', $email);
                    }
                })->get();
    }

    //////////////////////////////////
    function getAllActiveContact() {
        return $this->where('status', '=', 1)->get();
    }
    function getAllContactUsForAdmin() {
        return $this->get();
    }

    //////////////////////////////////
    function countContact() {
        return $this->count('id');
    }

}
