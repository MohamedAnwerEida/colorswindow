<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
//use Twitter;
use Illuminate\Support\Facades\Artisan;
use Intervention\Image\Facades\Image;

class NewsController extends AdminController {

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
        parent::$data['active_menu'] = 'news';
    }

//////////////////////////////////////////////
    public function getIndex() {
        return view('admin.news.view', parent::$data);
    }

//////////////////////////////////////////////
    public function getList(Request $request) {
        $length = $request->get('length');
        $start = $request->get('start');
        $title = $request->get('title');
        $publish = $request->get('publish');
        $sidebar = $request->get('sidebar');
        $category = 1;

        $news = new News();
        $info = $news->searchNews($title, $publish, $sidebar, $category, $start, $length);
        $count = $news->searchNewsCount($title, $publish, $sidebar, $category);
        $datatable = Datatables::of($info);
        $datatable = Datatables::of($info)->setTotalRecords($count);
        $datatable->editColumn('title', function ($row) {
            return (!empty($row->title) ? $row->title : 'N/A');
        });
        $datatable->editColumn('category_name', function ($row) {

            return (!empty($row->category->name) ? $row->category->name : 'N/A');
        });
        $datatable->editColumn('username', function ($row) {

            return (!empty($row->user) ? $row->user->username : 'N/A');
        });

        $datatable->editColumn('publish', function ($row) {
            $data['id'] = $row->id;
            $data['publish'] = $row->publish;

            return view('admin.news.parts.publish', $data)->render();
        });
        $datatable->editColumn('sidebar', function ($row) {
            $data['id'] = $row->id;
            $data['sidebar'] = $row->sidebar;

            return view('admin.news.parts.sidebar', $data)->render();
        });

        $datatable->addColumn('actions', function ($row) {
            $data['id'] = $row->id;
            $data['btn_class'] = parent::$data['btn_class'];

            return view('admin.news.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }

//////////////////////////////////////////////
    public function getAdd() {
        return view('admin.news.add', parent::$data);
    }

//////////////////////////////////////////////
    public function postAdd(Request $request) {
        $category_id = 1;
        $title = $request->get('title');
        $onwer = $request->get('onwer');
        $source = $request->get('source');
        $sub = $request->get('sub');
        $descs = $request->get('descs');
        $image = $request->get('image');
        $img_notes = $request->get('img_notes');
        $tags = $request->get('tags');
        $pub_date = $request->get('pub_date');
        $resort = $request->get('resort');
        $publish = (int) $request->get('publish');
        $sidebar = (int) $request->get('sidebar');


        $validator = Validator::make([
                    'category_id' => $category_id,
                    'title' => $title,
                    'sub' => $sub,
                    'descs' => $descs,
                    'image' => $image,
                        ], [
                    'category_id' => 'required',
                    'title' => 'required',
                    'sub' => 'required',
                    'descs' => 'required',
                    'image' => 'required',
        ]);
//////////////////////////////////////////////////////////
        if ($validator->fails()) {
            $request->session()->flash('danger', $validator->messages());
            return redirect(route('news.add'))->withInput();
        } else {
            $image_explode = explode('/', $image);
            $size = sizeof($image_explode);
            $image_name = $image_explode[$size - 1];
            $final_explode = explode($image_name, $image);
            $thumb = $final_explode[0] . 'thumbs/' . $image_name;
///////////////////
            $news = new News();

////////////////////////////////////////////
            $add = $news->addNews($title, $onwer, $source, $sub, $descs, $thumb, $image, $img_notes, $category_id, $tags, $resort, $pub_date, $publish, $sidebar, Auth::guard('admin')->user()->id);
            if ($add) {
                if ($publish == 1) {
                    $this->clearCache($category_id);
                }
///////////////////////////////////////////////////////////////////
                $request->session()->flash('success', self::INSERT_SUCCESS_MESSAGE);
                return redirect(route('news.view'));
            } else {
                $request->session()->flash('danger', self::EXECUTION_ERROR);
                return redirect(route('news.add'))->withInput();
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
        $news = new News();
        $info = $news->getNew($id);
        if ($info) {
            parent::$data['info'] = $info;
            return view('admin.news.edit', parent::$data);
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('news.view'));
        }
    }

//////////////////////////////////////////////
    public function postEdit(Request $request, $id) {
        try {
            $encrypted_id = $id;
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('news.view'));
        }
/////////////////////////////////////////
        $news = new News();
        $info = $news->getNew($id);
        if ($info) {
            $category_id = 1;
            $title = $request->get('title');
            $onwer = $request->get('onwer');
            $source = $request->get('source');
            $sub = $request->get('sub');
            $descs = $request->get('descs');
            $image = $request->get('image');
            $img_notes = $request->get('img_notes');
            $tags = $request->get('tags');
            $pub_date = $request->get('pub_date');
            $resort = $request->get('resort');
            $publish = (int) $request->get('publish');
            $sidebar = (int) $request->get('sidebar');


            $validator = Validator::make([
                        'category_id' => $category_id,
                        'title' => $title,
                        'sub' => $sub,
                        'descs' => $descs,
                            ], [
                        'category_id' => 'required',
                        'title' => 'required',
                        'sub' => 'required',
                        'descs' => 'required',
            ]);
//////////////////////////////////////////////////////////
            if ($validator->fails()) {
                $request->session()->flash('danger', $validator->messages());
                return redirect(route('news.edit', ['id' => $encrypted_id]))->withInput();
            } else {
                $image_explode = explode('/', $image);
                $size = sizeof($image_explode);
                $image_name = $image_explode[$size - 1];
                $final_explode = explode($image_name, $image);
                $thumb = $final_explode[0] . 'thumbs/' . $image_name;
                $old_category_id = $info->category_id;
////////////////////////////////////////////
                $update = $news->updateNews($info, $title, $onwer, $source, $sub, $descs, $thumb, $image, $img_notes, $category_id, $tags, $resort, $pub_date, $publish, $sidebar);
                if ($update) {
                    if ($info->publish == 1) {
                        if ($old_category_id != $category_id) {
                            $this->clearCache($old_category_id);
                        }
                        $this->clearCache($category_id);
                        //   $this->getMedium($title, $descs, $image);
                        //$this->getTwitter($update);
                    }
///////////////////////////////////////////////////////////
                    $request->session()->flash('success', self::UPDATE_SUCCESS);
                    return redirect(route('news.view'));
                } else {
                    $request->session()->flash('danger', self::EXECUTION_ERROR);
                    return redirect(route('news.edit', ['id' => $encrypted_id]))->withInput();
                }
            }
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('news.view'));
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
        $news = new News();
        $info = $news->getNew($id);
        if ($info) {
            $delete = $news->deleteNews($info);
            if ($delete) {
                $this->clearCache($info->category_id);
////////////////////////////////////
                return response()->json(['status' => 'success', 'message' => self::DELETE_SUCCESS]);
            } else {
                return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => self::NOT_FOUND]);
        }
    }

//////////////////////////////////////////////
    public function getMedium($title, $content, $image) {
//        $credentials = [
//            'client-id' => 'd2172702148',
//            'client-secret' => '442daeaf400a782004e94201ff21526ccdb1235e',
//            'redirect-url' => 'http://demo.uae71.com/public/admin/news/status',
//            'state' => 'somesecret',
//            'scopes' => 'scope1,scope2',
//        ];
//
//
//        $medium = new Medium();
//        $medium->connect($credentials);
//        $accessToken = '25ecd94df3fa5be8b07521507f5f622935d3a116ee34738a7aed592b98669706c';
//        $medium->setAccessToken($accessToken);
//        $user = $medium->getAuthenticatedUser();
//        $intro = '<p><img src="' . URL::to($image) . '" /</p><div style="direction:rtl;">' . $content . '</div>';
//
//        $data = [
//            'title' => $title,
//            'contentFormat' => 'html',
//            'content' => $intro,
//            'publishStatus' => 'public',
//        ];
//        $post = $medium->createPost($user->data->id, $data);
    }

    public function getTwitter($news) {//
//        try {
////            $new = new News();
////            $news = $new->getNew('53695');
//            $uploaded_media = Twitter::uploadMedia(['media' => file_get_contents(URL::to($news->image))]);
//            $status = ($news->category_id == 11 ? $news->onwer . ' يكتب "' : '') . $news->title . ($news->category_id == 11 ? '"' : '') . ' http://uae71.com/posts/' . $news->id . ' #الإمارات71';
//            return Twitter::postTweet(['status' => $status, 'media_ids' => $uploaded_media->media_id_string]);
//        } catch (\Exception $e) {
//            //   dd(Twitter::logs());
//            return false;
//        }
    }

    public function postPublish(Request $request) {

        $id = $request->get('id');
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error Decode']);
        }

        $news = new News();
        $info = $news->getNew($id);
        if ($info) {
            $publish = $info->publish;
            if ($publish == 0) {
                $update = $news->updatePublish($id, 1);
                if ($update) {
                    $this->clearCache($info->category_id);
////////////////////////////////////
                    return response()->json(['status' => 'success', 'message' => self::ACTIVATION_SUCCESS, 'type' => 'yes']);
                } else {
                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
                }
            } else {
                $update = $news->updatePublish($id, 0);
                if ($update) {

                    $this->clearCache($info->category_id);
////////////////////////////////////
                    return response()->json(['status' => 'success', 'message' => self::DISABLE_SUCCESS, 'type' => 'no']);
                } else {
                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
                }
            }
        } else {
            return response()->json(['status' => 'error', 'message' => self::NOT_FOUND]);
        }
    }

    public function postSidebar(Request $request) {

        $id = $request->get('id');
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error Decode']);
        }

        $news = new News();
        $info = $news->getNew($id);
        if ($info) {
            $publish = $info->sidebar;
            if ($publish == 0) {
                $update = $news->updateSidebar($id, 1);
                if ($update) {
                    $this->clearCache($info->category_id);
////////////////////////////////////
                    return response()->json(['status' => 'success', 'message' => self::ACTIVATION_SUCCESS, 'type' => 'yes']);
                } else {
                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
                }
            } else {
                $update = $news->updateSidebar($id, 0);
                if ($update) {

                    $this->clearCache($info->category_id);
////////////////////////////////////
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
    public function cleaAllCache() {

        Artisan::call('cache:clear');
        return redirect(route('news.view'));
    }

    public function clearCache($category_id) {
//        $news = new News();
/////////////// Inner Category Page///////////////
//        Cache::forget('category_news_' . $category_id);
//        $news_category = $news->getNewsByCategory($category_id, 0, 5);
//        Cache::forever('category_news_' . $category_id, $news_category);
//
/////////////// Home Page///////////////
//        $special_news = $news->getSpecialNews();
//        Cache::forget('main_news');
//        Cache::forever('main_news', $special_news);
//
//        $special_news = $news->getLastNews(9);
//        Cache::forget('last_news');
//        Cache::forever('last_news', $special_news);
//
//        $opinion_news = $news->getCategoryOneNews(12);
//        Cache::forget('opinion_news');
//        Cache::forever('opinion_news', $opinion_news);
//
//        $special_news = $news->getCategoryNews(9, 5);
//        Cache::forget('ask_news');
//        Cache::forever('ask_news', $special_news);
//
//
//        $special_news = $news->getNewsByMostView(6);
//        Cache::forget('most_news');
//        Cache::forever('most_news', $special_news);
    }

    public function getImage(Request $request) {
        // Allowed extentions.
        if ($request->hasFile('upload')) {

            $originName = $request->file('upload')->getClientOriginalName();

            $fileName = pathinfo($originName, PATHINFO_FILENAME);

            $extension = $request->file('upload')->getClientOriginalExtension();

            $fileName = $fileName . '_' . time() . '.' . $extension;



            $request->file('upload')->move(public_path('images'), $fileName);



            $CKEditorFuncNum = $request->input('CKEditorFuncNum');

            $url = asset('images/' . $fileName);

            $msg = 'Image uploaded successfully';

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";



            @header('Content-type: text/html; charset=utf-8');

            echo $response;
        }
    }

}
