<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
////////////////////////////////////
use App\Models\Slider;
use Illuminate\Support\Facades\Artisan;

class SliderController extends AdminController {

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
        parent::$data['active_menu'] = 'slider';
    }

    //////////////////////////////////////////////
    public function getIndex() {
        return view('admin.sliders.view', parent::$data);
    }
    //////////////////////////////////////////////
    public function getAdd() {
        $slider = new Slider();
        return view('admin.sliders.add', parent::$data);
    }
    //////////////////////////////////////////////
    public function getList(Request $request) {

        $info = Slider::all();
        $datatable = Datatables::of($info);
        $datatable->addColumn('actions', function ($row) {
            $data['id'] = $row->id;
            $data['cat_id'] = $row->cat;
            $data['btn_class'] = parent::$data['btn_class'];

            return view('admin.sliders.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }

    //////////////////////////////////////////////
    public function postAdd(Request $request) {
        $photo = $request->get('photo');
        $url = $request->get('url');
        //////////////////////////////////////////////////////////
        $slider = new Slider();
        $slider->url = $url;
        $slider->photo = $photo;
        $slider->save();
        if ($slider) {
            $this->clearCache();
            ///////////////////////////////////////////////////////////////////
            $request->session()->flash('success', self::INSERT_SUCCESS_MESSAGE);
            return redirect(route('slider.view'));
        } else {
            $request->session()->flash('danger', self::EXECUTION_ERROR);
            return redirect(route('slider.add'))->withInput();
        }
    }

    //////////////////////////////////////////////
    public function getEdit(Request $request, $id) {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('slider.view'));
        }
        //////////////////////////////////////////////
        $slider =  Slider::find($id);
        //dd($info->toArray());
        if ($slider) {
            parent::$data['info'] = $slider;
            return view('admin.sliders.edit', parent::$data);
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('slider.view'));
        }
    }

    ////////////////////////////////////////////////
    public function postEdit(Request $request, $id) {
        try {
            $encrypted_id = $id;
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('pages.view'));
        }
        /////////////////////////////
        $slider = Slider::find($id);
        $slider->update([
            'url' => $request->get('url'),
            'photo' => $request->get('photo')
        ]);
        if ($slider) {
            $this->clearCache();
                $this->clearCache();
                $request->session()->flash('success', self::UPDATE_SUCCESS);
                return redirect(route('slider.view'));
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('slider.view'));
        }
    }

    ////////////////////////////////////////////////
    public function postDelete(Request $request) {
        $id = $request->get('id');
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error Decode']);
        }

        /////////////////////////////////////
        $slider = Slider::find($id);
        if ($slider) {
            $delete = $slider->delete();
            if ($delete) {
                return response()->json(['status' => 'success', 'message' => self::DELETE_SUCCESS]);
            } else {
                return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => self::NOT_FOUND]);
        }
    }

    //////////////////////////////////////////////

    /////////////////////////////////////////
    public function clearCache() {
        Artisan::call('cache:clear');
    }

}
