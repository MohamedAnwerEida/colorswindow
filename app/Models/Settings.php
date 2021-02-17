<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends Model {

    use SoftDeletes;

    protected $table = 'settings';
    protected $fillable = [
        'title', 'description', 'logo', 'tags', 'email', 'email_password', 'smtp_host', 'smtp_port', 'smtp_timeout', 'smtp_crypto', 'contact_email',
    ];

    //////////////////////////////////
    function updateSettings($obj, $title, $tax, $transfer, $description, $more_desc, $logo, $tags, $contact_email, $contact_phone) {
        $obj->title = $title;
        $obj->description = $description;
        $obj->more_desc = $more_desc;
        $obj->logo = $logo;
        $obj->tags = $tags;
        $obj->contact_email = $contact_email;
        $obj->contact_no = $contact_phone;
        $obj->transfer = $transfer;
        $obj->tax = $tax;
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
    function getSetting($id) {
        return $this->find($id);
    }

    //////////////////////////////////
    function getAllPages() {
        return $this->get();
    }

    //////////////////////////////////
    function getPageByName($name) {
        return $this->where('name', '=', $name)->first();
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
