<?php

namespace App\Http\Controllers\Admin;

use App\Models\Keyword;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
////////////////////////////////////
use App\Models\Files;
use App\Models\Categories;
use App\Models\ProductsSubCategory;
use App\Models\ProductsImages;
use App\Models\ProductsSubCatgorySpec;
use Illuminate\Support\Facades\Artisan;

class FilesController extends AdminController {

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
        parent::$data['active_menu'] = 'files';
    }

    //////////////////////////////////////////////
    public function getIndex() {
        return view('admin.files.view', parent::$data);
    }

    //////////////////////////////////////////////
    public function getList(Request $request) {
        $title = $request->get('title', NULL);

        $files = new Files();
        $info = $files->getSearchFiles($title);
        $datatable = Datatables::of($info);

        $datatable->editColumn('title', function ($row) {
            return (!empty($row->name_ar) ? $row->name_ar : 'N/A');
        });

        $datatable->editColumn('status', function ($row) {
            $data['id'] = $row->id;
            $data['status'] = $row->active;

            return view('admin.files.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row) {
            $data['id'] = $row->id;
            $data['cat_id'] = $row->cat;
            $data['btn_class'] = parent::$data['btn_class'];

            return view('admin.files.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }

    //////////////////////////////////////////////
    public function getAdd() {
        $categories = new Categories();
        parent::$data['categories'] = $categories->getAllActiveCategories();
        $subcategories = new ProductsSubCategory();
        parent::$data['subcategories'] = $subcategories->getAllActiveCategories();
        return view('admin.files.add', parent::$data);
    }

    //////////////////////////////////////////////
    public function postAdd(Request $request) {
        $keywords = $request->get('keyword');
        $name_ar = $request->get('name_ar');
        $text_ar = $request->get('text_ar');
        $cat = $request->get('cat');
        $scat = $request->get('scat');
        $image = $request->get('image');
        $price = $request->get('price');
        $old_price = $request->get('old_price');
        $active = (int) $request->get('active');
        $dealofdays = (int) $request->get('dealofdays');
        $featured = (int) $request->get('featured');
        $main = (int) $request->get('main');
        $offer = (int) $request->get('offer');
        $min_qty = (int) $request->get('min_qty');

        $product_images = json_encode(array_filter($request->get('product_images')));

        $validator = Validator::make([
                    'name_ar' => $name_ar,
                    'text_ar' => $text_ar,
                    'min_qty' => $min_qty,
                        ], [
                    'name_ar' => 'required',
                    'text_ar' => 'required',
                    'min_qty' => 'required',
        ]);
        //////////////////////////////////////////////////////////
        if ($validator->fails()) {
            $request->session()->flash('danger', $validator->messages());
            return redirect(route('files.add'))->withInput();
        } else {
            $files = new Files();
            $add = $files->addFile($name_ar, $text_ar, $cat, $scat, $image, $min_qty, $product_images, $price, $old_price, $active, $dealofdays, $featured, $main,$offer);

            if ($add) {
              $this->updateKeyword($add->id,$keywords);
                $this->clearCache();
                ///////////////////////////////////////////////////////////////////
                $request->session()->flash('success', self::INSERT_SUCCESS_MESSAGE);
                return redirect(route('files.view'));
            } else {
                $request->session()->flash('danger', self::EXECUTION_ERROR);
                return redirect(route('files.add'))->withInput();
            }
        }
    }
    public function updateKeyword($id,$keywords){
        if($keywords){
            foreach ($keywords as $keyword){
                Keyword::updateOrCreate([
                    'module_type' => Files::class,
                    'module_id' => $id,
                    'keyword' => $keyword
                ]);
            }
        }
    }
    //////////////////////////////////////////////
    public function getEdit(Request $request, $id) {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('files.view'));
        }
        //////////////////////////////////////////////
        $files = new Files();
        $info = $files->getFile($id);
        //dd($info->toArray());
        $categories = new Categories();
        if ($info) {
            parent::$data['categories'] = $categories->getAllActiveCategories();
            $subcategories = new ProductsSubCategory();
            parent::$data['subcategories'] = $subcategories->getAllActiveCategories();
            parent::$data['info'] = $info;
            return view('admin.files.edit', parent::$data);
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('files.view'));
        }
    }

    ////////////////////////////////////////////////
    public function postEdit(Request $request, $id) {
        $keywords = $request->get('keyword');

        try {
            $encrypted_id = $id;
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('pages.view'));
        }
        /////////////////////////////
        $files = new Files();
        $info = $files->getFile($id);
        if ($info) {
            $db_img = $info->image;

            $name_ar = $request->get('name_ar');
            $text_ar = $request->get('text_ar');
            $cat = $request->get('cat');
            $scat = $request->get('scat');
            $image = $request->get('image');
            $price = $request->get('price');
            $old_price = $request->get('old_price');
            $active = (int) $request->get('active');
            $dealofdays = (int) $request->get('dealofdays');
            $featured = (int) $request->get('featured');
            $main = (int) $request->get('main');
            $offer = (int) $request->get('offer');
            $min_qty = (int) $request->get('min_qty');

            $product_images = json_encode(array_filter($request->get('product_images')));
            $validator = Validator::make([
                        'name_ar' => $name_ar,
                        'text_ar' => $text_ar,
                        'min_qty' => $min_qty,
                            ], [
                        'name_ar' => 'required',
                        'min_qty' => 'required',
            ]);
            //////////////////////////////////////////////////////////
            if ($validator->fails()) {
                $request->session()->flash('danger', $validator->messages());
                return redirect(route('files.edit', ['id' => $encrypted_id]))->withInput();
            } else {
                $update = $files->updateFile($info, $name_ar, $text_ar, $cat, $scat, $image, $min_qty, $product_images, $price, $old_price, $active, $dealofdays, $featured, $main, $offer);
                if ($update) {
//                    $delete_image = array();
//                    $pro_image = array();
//                    foreach ($info->images as $im) {
//                        $pro_image[] = $im->id;
//                    }
//                    print_r($ids);
//                    print_r($pro_image);
//                    $delete_image = array_diff($pro_image, $ids);
//                    print_r($delete_image);
//                    exit;
//                    if (sizeof($product_images) > 0) {
//
//                        foreach ($product_images as $product_image) {
//                            if (trim($product_image) != '') {
//                                $product_colors = new ProductsImages();
//                                $product_colors->addProductImage($id, 'Product Image', $product_image);
//                            }
//                        }
//                        exit;
//                    }
                    $this->updateKeyword($update->id,$keywords);

                    $this->clearCache();

                    $request->session()->flash('success', self::UPDATE_SUCCESS);
                    return redirect(route('files.view'));
                } else {
                    $request->session()->flash('danger', self::EXECUTION_ERROR);
                    return redirect(route('files.edit', ['id' => $encrypted_id]))->withInput();
                }
            }
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('files.view'));
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
        Keyword::where('module_key',Products::class)->where('module_id',$id)->delete();

        /////////////////////////////////////
        $files = new Files();
        $info = $files->getFile($id);
        if ($info) {
            $delete = $files->deleteFile($info);
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
        $files = new Files();
        $info = $files->getFile($id);
        if ($info) {
            $status = $info->active;
            if ($status == 0) {
                $update = $files->updateStatus($id, 1);
                if ($update) {
                    return response()->json(['status' => 'success', 'message' => self::ACTIVATION_SUCCESS, 'type' => 'yes']);
                } else {
                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
                }
            } else {
                $update = $files->updateStatus($id, 0);
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
