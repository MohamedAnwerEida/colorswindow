<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use App\Models\ProductsSubCategory;
use App\Models\ProductsSubCatgorySpec;
use App\Models\ProductsSubCategoryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Cache;
use DataTables;

class SubCategoriesController extends AdminController {

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
        parent::$data['active_menu'] = 'subcategories';
    }

    //////////////////////////////////////////////
    public function getIndex() {
        return view('admin.subcategories.view', parent::$data);
    }

    //////////////////////////////////////////////
    public function getList(Request $request) {
        $user = new ProductsSubCategory();

        $name = $request->get('name');

        $info = $user->getSearchCategories($name);

        $datatable = Datatables::of($info);

        $datatable->editColumn('name', function ($row) {
            return (!empty($row->name_ar) ? $row->name_ar : 'N/A');
        });

        $datatable->editColumn('status', function ($row) {
            $data['id'] = $row->id;
            $data['status'] = $row->active;

            return view('admin.subcategories.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row) {
            $data['id'] = $row->id;
            $data['btn_class'] = parent::$data['btn_class'];

            return view('admin.subcategories.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }

    //////////////////////////////////////////////
    public function getAdd() {
        $categories = new Categories();
        parent::$data['categories'] = $categories->getAllActiveCategories();
        return view('admin.subcategories.add', parent::$data);
    }

    //////////////////////////////////////////////
    public function postAdd(Request $request) {
        $name = $request->get('name');
        $category_id = $request->get('category_id');
        $status = (int) $request->get('status');

        $validator = Validator::make([
                    'name' => $name,
                    'status' => $status,
                        ], [
                    'name' => 'required',
                    'status' => 'required|numeric|in:0,1',
        ]);
        ////////////////////////////////////////
        if ($validator->fails()) {
            $request->session()->flash('danger', $validator->messages());
            return redirect(route('subcategories.add'))->withInput();
        } else {
            $subcategories = new ProductsSubCategory();
            $add = $subcategories->addCategories($name, $category_id, $status);
            if ($add) {
                $this->clearCache();
                //////////////////////////////////////////////////////////////////
                $request->session()->flash('success', self::INSERT_SUCCESS_MESSAGE);
                return redirect(route('subcategories.view'));
            } else {
                $request->session()->flash('danger', self::EXECUTION_ERROR);
                return redirect(route('subcategories.add'))->withInput();
            }
        }
    }

    //////////////////////////////////////////////
    public function getEdit(Request $request, $id) {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('subcategories.view'));
        }
        /////////////////////////////
        $categories = new Categories();
        $subcategories = new ProductsSubCategory();
        $info = $subcategories->getCategories($id);
        parent::$data['categories'] = $categories->getAllActiveCategories();
        if ($info) {
            parent::$data['info'] = $info;
            return view('admin.subcategories.edit', parent::$data);
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('subcategories.view'));
        }
    }

    //////////////////////////////////////////////
    public function postEdit(Request $request, $id) {
        try {
            $encrypted_id = $id;
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('subcategories.view'));
        }
        /////////////////////////////
        $subcategories = new ProductsSubCategory();
        $info = $subcategories->getCategories($id);
        if ($info) {
            $name = $request->get('name_ar');
            $category_id = $request->get('cat');
            $status = (int) $request->get('active');

            $validator = Validator::make([
                        'name' => $name,
                        'status' => $status,
                            ], [
                        'name' => 'required',
                        'status' => 'required|numeric|in:0,1',
            ]);

            if ($validator->fails()) {
                $request->session()->flash('danger', $validator->messages());
                return redirect(route('subcategories.edit', ['id' => $encrypted_id]))->withInput();
            } else {
                $update = $subcategories->updateCategories($info, $name, $category_id, $status);
                if ($update) {
                    $this->clearCache();
                    ///////////////////////////////////////////////////////////
                    $request->session()->flash('success', self::UPDATE_SUCCESS);
                    return redirect(route('subcategories.view'));
                } else {
                    $request->session()->flash('danger', self::EXECUTION_ERROR);
                    return redirect(route('subcategories.edit', ['id' => $encrypted_id]))->withInput();
                }
            }
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('subcategories.view'));
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
        /////////////////////////////
        $subcategories = new ProductsSubCategory();
        $info = $subcategories->getCategories($id);
        if ($info) {
            $status = $info->status;
            if ($status == 0) {
                $update = $subcategories->updateStatus($id, 1);
                if ($update) {
                    $this->clearCache();
                    ///////////////////////////////////////////////////////////
                    return response()->json(['status' => 'success', 'message' => self::ACTIVATION_SUCCESS, 'type' => 'yes']);
                } else {
                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
                }
            } else {
                $update = $subcategories->updateStatus($id, 0);
                if ($update) {
                    $this->clearCache();
                    ///////////////////////////////////////////////////////////
                    return response()->json(['status' => 'success', 'message' => self::DISABLE_SUCCESS, 'type' => 'no']);
                } else {
                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
                }
            }
        } else {
            return response()->json(['status' => 'error', 'message' => self::NOT_FOUND]);
        }
    }

    //////////////////////////////////////////////
    public function postDelete(Request $request) {
        $id = $request->get('id');
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error Decode']);
        }
        /////////////////////////////
        $subcategories = new ProductsSubCategory();
        $info = $subcategories->getCategories($id);
        if ($info) {
            $delete = $subcategories->deleteCategories($info);
            if ($delete) {
                $this->clearCache();
                ///////////////////////////////////////////////////////////
                return response()->json(['status' => 'success', 'message' => self::DELETE_SUCCESS]);
            } else {
                return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => self::NOT_FOUND]);
        }
    }

    public function getPrductSpec(Request $request, $id) {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('subcategories.view'));
        }
        $subcategories = new ProductsSubCategory();
        $subcategoriestypes = new ProductsSubCategoryType();
        $info = $subcategories->getCategories($id);
        parent::$data['subcategories'] = $subcategoriestypes->getAllCategories();
        if ($info) {
            $specs = new ProductsSubCatgorySpec();
            parent::$data['info'] = $info;
            parent::$data['specs'] = $specs->getSpecByProduct($id);
            return view('admin.subcategories.editspec', parent::$data);
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('subcategories.view'));
        }
    }

    public function postPrductSpec(Request $request, $id) {
        try {
            $encrypted_id = $id;
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('subcategories.view'));
        }
        $subcategories = new ProductsSubCategory();
        $info = $subcategories->getCategories($id);
        if ($info) {
            $name = $request->get('name');
            $ids = $request->get('id');
            $spec_id = $request->get('spec_id');
            $price = $request->get('price');
            $price1 = $request->get('price1');
            $view_attr = $request->get('view_attr');
            $view_meter = $request->get('view_meter');
            $view_repeat = $request->get('view_repeat');

            //   $status = (int) $request->get('status');
            //   $in_menu = (int) $request->get('in_menu');
            foreach ($ids as $key => $item) {
                $subcategoriestypes = new ProductsSubCatgorySpec();
                $obj = $subcategoriestypes->getCategories($item);
                $viewtt = NULL;
                $viewmtt = NULL;
                $viewrtt = NULL;
                if ($view_attr)
                    $viewtt = array_key_exists($item, $view_attr) ? 1 : 0;
                if ($view_meter)
                    $viewmtt = array_key_exists($item, $view_meter) ? 1 : 0;
                if ($view_repeat)
                    $viewrtt = array_key_exists($item, $view_repeat) ? 1 : 0;
                $update = $subcategoriestypes->updateCategories($obj, $name[$key], $id, $spec_id[$key], $price[$key], $price1[$key], $viewtt, $viewmtt, $viewrtt);
            }
            if ($update) {
                //  $this->clearCache();
                ///////////////////////////////////////////////////////////
                $request->session()->flash('success', self::UPDATE_SUCCESS);
                return redirect(route('subcategories.view'));
            } else {
                $request->session()->flash('danger', self::EXECUTION_ERROR);
                return redirect(route('subcategories.subcat', ['id' => $encrypted_id]))->withInput();
            }
        }
    }

    /////////////////////////////////////////
    public function clearCache() {
        Cache::forget('subcategories');
        $subcategories = new ProductsSubCategory();
        $info = $subcategories->getAllActiveCategories();
        Cache::forever('subcategories', $info);
        foreach ($info as $row) {
            Cache::forget('category_info_' . $row->id);
            ////////////////////////////////////////
            $category_info = $subcategories->getActiveCategories($row->id);
            Cache::forever('category_info_' . $row->id, $category_info);
        }
    }

}
