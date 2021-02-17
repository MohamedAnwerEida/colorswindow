<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
////////////////////////////////////
use App\Models\Coupon;
use App\Models\CouponUses;
use App\Models\Subcategory;
use App\Models\Products;

class CouponsController extends AdminController {

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
        parent::$data['active_menu'] = 'coupons';
    }

    //////////////////////////////////////////////
    public function getIndex() {
        return view('admin.coupons.view', parent::$data);
    }

    //////////////////////////////////////////////
    public function getList(Request $request) {
        $title = $request->get('title', NULL);

        $coupons = new Coupon();
        $info = $coupons->getSearchCoupons($title);
        $datatable = Datatables::of($info);



        $datatable->editColumn('status', function ($row) {
            $data['id'] = $row->id;
            $data['status'] = $row->status;

            return view('admin.coupons.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row) {
            $data['id'] = $row->id;
            $data['btn_class'] = parent::$data['btn_class'];

            return view('admin.coupons.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }

    //////////////////////////////////////////////
    public function getAdd() {
        return view('admin.coupons.add', parent::$data);
    }

    //////////////////////////////////////////////
    public function postAdd(Request $request) {
        $code = $request->get('code');
        $value = $request->get('value');

        $type = $request->get('type');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $cat_type = $request->get('cat_type');
        $item_id = $request->get('item_id');
        $status = (int) $request->get('status');

        $validator = Validator::make([
                    'code' => $code,
                    'value' => $value
                        ], [
                    'code' => 'required|unique:coupons,code',
                    'value' => 'required'
        ]);
        //////////////////////////////////////////////////////////
        if ($validator->fails()) {
            $request->session()->flash('danger', $validator->messages());
            return redirect(route('coupons.add'))->withInput();
        } else {
            $coupons = new Coupon();
            $add = $coupons->addCoupon($code, $type, $value, $start_date, $end_date, $cat_type, $item_id, $status);
            if ($add) {
                $this->clearCache();
                ///////////////////////////////////////////////////////////////////
                $request->session()->flash('success', self::INSERT_SUCCESS_MESSAGE);
                return redirect(route('coupons.view'));
            } else {
                $request->session()->flash('danger', self::EXECUTION_ERROR);
                return redirect(route('coupons.add'))->withInput();
            }
        }
    }

    //////////////////////////////////////////////
    public function getEdit(Request $request, $id) {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('news.view'));
        }
        //////////////////////////////////////////////
        $coupons = new Coupon();
        $info = $coupons->getCoupon($id);
        if ($info) {
            parent::$data['info'] = $info;
            return view('admin.coupons.edit', parent::$data);
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('coupons.view'));
        }
    }

    ////////////////////////////////////////////////
    public function postEdit(Request $request, $id) {
        try {
            $encrypted_id = $id;
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('coupons.view'));
        }
        /////////////////////////////
        $coupons = new Coupon();
        $info = $coupons->getCoupon($id);
        if ($info) {


            $code = $request->get('code');
            $value = $request->get('value');

            $type = $request->get('type');
            $status = (int) $request->get('status');
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
            $cat_type = $request->get('cat_type');
            $item_id = $request->get('item_id');
            $validator = Validator::make([
                        'code' => $code,
                        'value' => $value
                            ], [
                        'code' => 'required|unique:coupons,id,' . $id,
                        'value' => 'required'
            ]);
            //////////////////////////////////////////////////////////
            if ($validator->fails()) {
                $request->session()->flash('danger', $validator->messages());
                return redirect(route('coupons.edit', ['id' => $encrypted_id]))->withInput();
            } else {
                $update = $coupons->updateCoupon($info, $code, $type, $value, $start_date, $end_date, $cat_type, $item_id, $status);
                if ($update) {
                    $request->session()->flash('success', self::UPDATE_SUCCESS);
                    return redirect(route('coupons.view'));
                } else {
                    $request->session()->flash('danger', self::EXECUTION_ERROR);
                    return redirect(route('coupons.edit', ['id' => $encrypted_id]))->withInput();
                }
            }
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('coupons.view'));
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
        $coupons = new Coupon();
        $info = $coupons->getCoupon($id);
        if ($info) {
            $delete = $coupons->deleteCoupon($info);
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
    public function postStatus(Request $request) {
        $id = $request->get('id');
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error Decode']);
        }
        /////////////////////////////////////
        $coupons = new Coupon();
        $info = $coupons->getCoupon($id);
        if ($info) {
            $status = $info->status;
            if ($status == 0) {
                $update = $coupons->updateStatus($id, 1);
                if ($update) {
                    return response()->json(['status' => 'success', 'message' => self::ACTIVATION_SUCCESS, 'type' => 'yes']);
                } else {
                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
                }
            } else {
                $update = $coupons->updateStatus($id, 0);
                if ($update) {
                    return response()->json(['status' => 'success', 'message' => self::DISABLE_SUCCESS, 'type' => 'no']);
                } else {
                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
                }
            }
        } else {
            return response()->json(['status' => 'error', 'message' => self::NOT_FOUND]);
        }
    }

    /////////////////////////////////////////
    public function clearCache() {
//        Cache::forget('vedio');
//        $video = new Coupons();
//        $info = $video->getLastCoupon();
//        Cache::forever('vedio', $info);
//
//        Cache::forget('vedio_other');
//        $info = $video->getLastCoupons(1, 2);
//        Cache::forever('vedio_other', $info);
    }

    public function getUses(Request $request, $id) {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('coupons.view'));
        }
        //////////////////////////////////////////////
        $coupons = new Coupon();
        $info = $coupons->getCoupon($id);
        if ($info) {
            parent::$data['info'] = $info;
            parent::$data['results'] = array();
            return view('admin.coupons.uses', parent::$data);
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('coupons.view'));
        }
    }

    ////////////////////////////////////////////////
    public function postUses(Request $request, $id) {
        try {
            $encrypted_id = $id;
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('coupons.view'));
        }
        /////////////////////////////
        $coupons = new Coupon();
        $info = $coupons->getCoupon($id);
        if ($info) {
            $coupon_from = $request->get('coupon_from');
            $coupon_to = $request->get('coupon_to');

            $validator = Validator::make([
                        'coupon_from' => $coupon_from,
                        'coupon_to' => $coupon_to
                            ], [
                        'coupon_from' => 'required',
                        'coupon_to' => 'required'
            ]);
            //////////////////////////////////////////////////////////
            if ($validator->fails()) {
                $request->session()->flash('danger', $validator->messages());
                return redirect(route('coupons.uses', ['id' => $encrypted_id]))->withInput();
            } else {
                $res = new CouponUses();
                parent::$data['info'] = $info;
                parent::$data['results'] = $res->getUsedCouponSearch($id, $coupon_from, $coupon_to);
                return view('admin.coupons.uses', parent::$data);
            }
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('coupons.view'));
        }
    }

    public function selectAjaxCategories(Request $request) {

        if ($request->ajax()) {
            $cat_type = $request->get('cat_type');
            $cat_item = $request->get('cat_item');

            if ($cat_type == 1) {//category
                $categories = new Subcategory();
                $states = $categories->getAllActiveCategories();
            } else if ($cat_type == 2) {//product
                $pro = new Products();
                $states = $pro->getAllActiceProducts();
            } else {
                $states = array();
            }
            $data = view('admin.coupons.ajax-select', compact('states', 'cat_item'))->render();
            return response()->json(['options' => $data]);
        }
    }

}
