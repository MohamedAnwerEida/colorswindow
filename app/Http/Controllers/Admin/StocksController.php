<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
////////////////////////////////////
use App\Models\Files;
use App\Models\Categories;
use App\Models\ProductLog;
use App\Models\ProductStockLog;
use App\Models\ProductsSubCategory;
use Illuminate\Support\Facades\Artisan;

class StocksController extends AdminController {

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
        parent::$data['active_menu'] = 'stocks';
    }

    //////////////////////////////////////////////
    public function getIndex() {
        return view('admin.stocks.view', parent::$data);
    }

    //////////////////////////////////////////////
    public function getList(Request $request) {
        $title = $request->get('title', NULL);

        $stocks = new Files();
        $info = $stocks->getSearchFiles($title);
        $datatable = Datatables::of($info);

        $datatable->editColumn('title', function ($row) {
            return (!empty($row->name_ar) ? $row->name_ar : 'N/A');
        });

        $datatable->editColumn('status', function ($row) {
            $data['id'] = $row->id;
            $data['status'] = $row->active;

            return view('admin.stocks.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row) {
            $data['id'] = $row->id;
            $data['cat_id'] = $row->cat;
            $data['btn_class'] = parent::$data['btn_class'];

            return view('admin.stocks.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }

    //////////////////////////////////////////////
    public function getEdit(Request $request, $id) {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('stocks.view'));
        }
        //////////////////////////////////////////////
        $stocks = new Files();
        $info = $stocks->getFile($id);
        $categories = new Categories();
        if ($info) {
            parent::$data['categories'] = $categories->getAllActiveCategories();
            $subcategories = new ProductsSubCategory();
            parent::$data['subcategories'] = $subcategories->getAllActiveCategories();
            parent::$data['info'] = $info;
            parent::$data['product_stock_log'] = ProductStockLog::where('product_id', $id)->orderBy('id', 'desc')->get();
            parent::$data['product_log'] = ProductLog::where('product_id', $id)->orderBy('id', 'desc')->get();

            return view('admin.stocks.edit', parent::$data);
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('stocks.view'));
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
        $stocks = new Files();
        $info = $stocks->getFile($id);
        if ($info) {
            $qty = (int) $request->get('qty');
            $qty_stock_min = (int) $request->get('qty_stock_min');
            $validator = Validator::make([
                        'qty' => $qty,
                        'qty_stock_min' => $qty_stock_min,
                            ], [
                        'qty' => 'required',
                        'qty_stock_min' => 'required',
            ]);
            //////////////////////////////////////////////////////////
            if ($validator->fails()) {
                $request->session()->flash('danger', $validator->messages());
                return redirect(route('stocks.edit', ['id' => $encrypted_id]))->withInput();
            } else {
                $update = $stocks->updateField($id, 'qty', $qty);
                $stocks->updateField($id, 'qty_stock_min', $qty_stock_min);
                if ($update) {
                    $save_data['product_id'] = $id;
                    $save_data['qty'] = $qty;
                    $save_data['qty_stock_min'] = $qty_stock_min;
                    $save_data['user_id'] = Auth::guard('admin')->user()->id;
                    ProductStockLog::create($save_data);
                    $this->clearCache();
                    $request->session()->flash('success', self::UPDATE_SUCCESS);
                    return redirect(route('stocks.view'));
                } else {
                    $request->session()->flash('danger', self::EXECUTION_ERROR);
                    return redirect(route('stocks.edit', ['id' => $encrypted_id]))->withInput();
                }
            }
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('stocks.view'));
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
        $stocks = new Files();
        $info = $stocks->getFile($id);
        if ($info) {
            $delete = $stocks->deleteFile($info);
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
        $stocks = new Files();
        $info = $stocks->getFile($id);
        if ($info) {
            $status = $info->active;
            if ($status == 0) {
                $update = $stocks->updateStatus($id, 1);
                if ($update) {
                    return response()->json(['status' => 'success', 'message' => self::ACTIVATION_SUCCESS, 'type' => 'yes']);
                } else {
                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
                }
            } else {
                $update = $stocks->updateStatus($id, 0);
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
        Artisan::call('cache:clear');
    }

}
