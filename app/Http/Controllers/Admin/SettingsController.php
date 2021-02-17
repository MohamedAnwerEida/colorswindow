<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Hash;
use Crypt;
use Session;
use Validator;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Settings;

//////////////////////////////////

class SettingsController extends AdminController {

    const INSERT_SUCCESS_MESSAGE = "نجاح، تم الإضافة بتجاح";
    const UPDATE_SUCCESS = "نجاح، تم التعديل بنجاح";
    const DELETE_SUCCESS = "نجاح، تم الحذف بنجاح";
    const PASSWORD_SUCCESS = "نجاح، تم تغيير كلمة المرور بنجاح";
    const EXECUTION_ERROR = "عذراً، حدث خطأ أثناء تنفيذ العملية";
    const NOT_FOUND = "عذراً،لا يمكن العثور على البيانات";
    const ACTIVATION_SUCCESS = "نجاح، تم التفعيل بنجاح";
    const DISABLE_SUCCESS = "نجاح، تم التعطيل بنجاح";

    //////////////////////////////////////////////
    public function __construct() {
        parent::__construct();
        parent::$data['active_menu'] = 'settings';
    }

    //////////////////////////////////////////
    public function getIndex(Request $request) {
        $settings = new Settings();
        $info = $settings->getSetting(1);
        if ($info) {
            parent::$data['info'] = $info;
            return view('admin.settings.view', parent::$data);
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('settings.view'));
        }
    }

    ////////////////////////////////////////////////
    public function postIndex(Request $request) {
        $settings = new Settings();
        $info = $settings->getSetting(1);
        if ($info) {
            $db_logo = $info->logo;
            ////////////////////////////////
            $title = $request->get('title');
            $description = $request->get('description');
            $more_desc = $request->get('more_desc');
            $logo = $request->file('logo');
            $tags = $request->get('tags');
            $contact_email = $request->get('contact_email');
            $contact_phone = $request->get('contact_phone');
            $transfer = $request->get('transfer');
            $tax = $request->get('tax');

            $validator = Validator::make([
                        'title' => $title,
                        'description' => $description,
                        'logo' => $logo,
                        'tags' => $tags,
                        'contact_email' => $contact_email,
                        'transfer' => $transfer,
                        'tax' => $tax,
                            ], [
                        'title' => 'required',
                        'description' => 'required',
                        'logo' => 'nullable|image',
                        'tags' => 'required',
                        'tax' => 'required|numeric',
                        'transfer' => 'required|numeric',
                        'contact_email' => 'nullable|email',
            ]);
            //////////////////////////////////////////////////////////
            if ($validator->fails()) {
                $request->session()->flash('danger', $validator->messages());
                return redirect(route('settings.view'))->withInput();
            } else {
                if ($request->hasFile('logo') && $logo->isValid()) {
                    $destinationPath = 'uploads/logos/';
                    $logo_name = 'logo_' . strtotime(date("Y-m-d H:i:s")) . '.' . $logo->getClientOriginalExtension();
                    $logo->move($destinationPath, $logo_name);
                } else {
                    $logo_name = $db_logo;
                }
                $update = $settings->updateSettings($info, $title, $tax, $transfer, $description, $more_desc, $logo_name, $tags, $contact_email, $contact_phone);
                if ($update) {
                    Cache::forget('settings');
                    $info = $settings->getSetting(1);
                    Cache::forever('settings', $info);
                    ////////////////////////////////////////////
                    $request->session()->flash('success', self::UPDATE_SUCCESS);
                    return redirect(route('settings.view'));
                } else {
                    $request->session()->flash('danger', self::EXECUTION_ERROR);
                    return redirect(route('settings.view'));
                }
            }
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('settings.view'));
        }
    }

}
