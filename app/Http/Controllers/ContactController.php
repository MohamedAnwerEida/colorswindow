<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contacts;

class ContactController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    ///////////////////////////
    public function getIndex() {
        return view('frontend.contact.view', parent::$data);
    }

    public function postContact(Request $request) {
        ////////////////////////////////////////////
        $name = $request->get('name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $details = $request->get('message');

        $validator = Validator::make([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'details' => $details
                        ], [
                    'name' => 'required',
                    'email' => 'required|email',
                    'details' => 'required'
        ]);
        //////////////////////////////////////////////////////////
        if ($validator->fails()) {
            $request->session()->flash('danger', 'حدثت خطا');
            return redirect('contact')->withInput();
        } else {
            $contact = new Contacts();
            $add = $contact->addContact($name, $email, $details);
            if ($add) {
                $request->session()->flash('success', 'تم الارسال');
                return redirect('contact')->withInput();
            } else {
                $request->session()->flash('danger', 'حدثت مشكلة');
                return redirect('contact')->withInput();
            }
        }
    }

}
