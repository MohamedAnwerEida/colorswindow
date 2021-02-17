<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
////////////////////////////////////
use App\Models\User;
use App\Models\Order;
use App\Models\Roles;
use App\Models\OrderStatus;
use App\Models\TasksLog;
use App\Models\TasksStatus;

class TasksController extends AdminController {

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
        parent::$data['tasks_status'] = TasksStatus::all();
        parent::$data['active_menu'] = 'tasks';
    }

    //////////////////////////////////////////////
    public function getIndex() {
        $role = new Roles();
        parent::$data['roles'] = $role->getAllRolesActiveOrderd();
        parent::$data['order_staus'] = OrderStatus::all();

        return view('admin.tasks.view', parent::$data);
    }

    //////////////////////////////////////////////
    public function getList(Request $request) {
        $colors = array(
            1 => 'label-danger',
            2 => 'label-success',
            3 => 'label-info',
            4 => 'label-success',
            5 => 'label-info',
        );
        $tasks = new Order();
        $order_status = $request->get('order_status');
        $task_status = $request->get('task_status');
        $dep_id = $request->get('dep_id');
        $user = Auth::guard('admin')->user();
        $info = $tasks->getAllTasks($order_status, $task_status, $dep_id, $user);
        $data = array();
        if ($user->user_type == 2) {
            foreach ($info as $tasky) {
                if ($tasky->tasklog) {
                    $myrow = $tasky->tasklog->first();
                    if ($myrow->emp_id == $user->id) {
                        $data[] = $tasky;
                    }
                }
            }
        } else {
            $data = $info;
        }
        $datatable = Datatables::of($data);
        $role = new Roles();
        $roles = $role->getRole($user->role);
        $datatable->escapeColumns(['*']);
        $datatable->editColumn('status', function ($row) use($colors) {

            return '<span class="label label-sm  ">' . $row->mystatus->name . '</span>';
        });
        $datatable->editColumn('order_task_status', function ($row) {
            return ($row->mystatus ? $row->mystatus->name1 : '-');
        });
        $datatable->editColumn('tasklog', function ($row) {
            $str = '-';
            if ($row->tasklog) {
                if (count($row->tasklog) > 0) {
                    $data = $row->tasklog->first();
                    if ($data->dep_id != 0) {
                        $str = '<span class="category-color" style="background-color:' . $data->demp_name->role_color . '"><i class="fa ' . $data->demp_name->role_icon . '"></i>' . $data->demp_name->name . '</span>';
                    }
                }
            }

            return $str;
        });
        $datatable->editColumn('emp_name', function ($row) {
            $str = '-';
            if ($row->tasklog) {
                if (count($row->tasklog) > 0) {
                    $data = $row->tasklog->first();
                    if ($data->emp_id != 0) {
                        $str = $data->emp_name->name;
                    }
                }
            }

            return $str;
        });
        $datatable->editColumn('task_status', function ($row) {
            return $row->jobStatus ? $row->jobStatus->name : '-';
        });

        $datatable->addColumn('actions', function ($row) use($user, $roles) {
            $data['id'] = $row->id;
            $data['user'] = $user;
            $data['role'] = $roles;
            $data['order_task_dep'] = $row->order_task_dep;
            $data['btn_class'] = parent::$data['btn_class'];

            return view('admin.tasks.parts.actions', $data)->render();
        });
        return $datatable->make(true);
    }

    //////////////////////////////////////////////
    public function getEdit(Request $request, $id) {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('tasks.view'));
        }
        //////////////////////////////////////////////
        $tasks = new Order();
        $info = $tasks->getOrder($id);
        if ($info) {
            $role = new Roles();
            $users = new User();
            parent::$data['roles'] = $role->getAllRolesActiveOrderd();
            parent::$data['users'] = $users->getAllActiveUsers();
            parent::$data['task'] = $info;
            parent::$data['user'] = Auth::guard('admin')->user();
            parent::$data['task_log'] = TasksLog::where('order_id', $id)->orderBy('id', 'desc')->get();

            return view('admin.tasks.edit', parent::$data);
        } else {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('tasks.view'));
        }
    }

    ////////////////////////////////////////////////
    public function postEdit(Request $request, $id) {
        try {
            $encrypted_id = $id;
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('tasks.view'));
        }
        /////////////////////////////
        $tasks = new Order();
        $info = $tasks->getOrder($id);
        if ($info) {
            $user = Auth::guard('admin')->user();
            $mydata = new \stdClass();
            $mydata->order_id = $id;
            $mydata->dep_id = $request->get('dep_id') ? $request->get('dep_id') : $user->role;
            $mydata->emp_id = $request->get('emp_id') ? $request->get('emp_id') : $user->id;
            $mydata->notes_admin = $request->get('notes_admin');
            //$mydata->task_status = $request->get('task_status') ? $request->get('task_status') : $info->order_task_status;
            $role = Roles::find($mydata->dep_id);
            $mydata->task_status = $role->status_id;
            $mydata->job_status = (int) $request->get('job_status');
            $update = $tasks->updateField($info, 'status', $role->status_id);
            $update = $tasks->updateField($info, 'notes_admin', $mydata->notes_admin);
            $update = $tasks->updateField($info, 'order_task_dep', $mydata->dep_id);
            $update = $tasks->updateField($info, 'job_status', $mydata->job_status);
            $update = $tasks->updateField($info, 'emp_id', $mydata->emp_id);
            $save_data = $this->CreateTaskLogArray($mydata);
            TasksLog::create($save_data);
            if ($update) {
                $request->session()->flash('success', self::UPDATE_SUCCESS);
                return redirect(route('tasks.view'));
            } else {
                $request->session()->flash('danger', self::EXECUTION_ERROR);
                return redirect(route('tasks.edit', ['id' => $encrypted_id]))->withInput();
            }
        }
    }

//    public function postStatus(Request $request) {
//
//        $id = $request->get('id');
//        try {
//            $id = Crypt::decrypt($id);
//        } catch (DecryptException $e) {
//            return response()->json(['status' => 'error', 'message' => 'Error Decode']);
//        }
//        $tasks = new Order();
//        $info = $tasks->getOrder($id);
//        if ($info) {
//            $data_id = 0;
//            if ($info->tasklog) {
//                if (count($info->tasklog) > 0) {
//                    $data = $info->tasklog->first();
//                    $data_id = $data->id;
//                }
//            }
//            $info = TasksLog::findOrFail($data_id);
//            $save_data = $this->CreateTaskLogArray($info);
//            if ($info->job_status == 0) {
//                $save_data['job_status'] = 1;
//                $update = TasksLog::create($save_data);
//                if ($update) {
//                    return response()->json(['status' => 'success', 'message' => self::ACTIVATION_SUCCESS, 'type' => 1]);
//                } else {
//                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
//                }
//            } else {
//                $save_data['job_status'] = 0;
//                $update = TasksLog::create($save_data);
//                if ($update) {
//                    return response()->json(['status' => 'success', 'message' => self::DISABLE_SUCCESS, 'type' => 0]);
//                } else {
//                    return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR]);
//                }
//            }
//        } else {
//            return response()->json(['status' => 'error', 'message' => self::NOT_FOUND]);
//        }
//    }

    public function CreateTaskLogArray($data) {
        $save_data = array();
        $save_data['order_id'] = $data->order_id;
        $save_data['dep_id'] = $data->dep_id;
        $save_data['emp_id'] = $data->emp_id;
        $save_data['task_status'] = $data->task_status;
        $save_data['notes_admin'] = $data->notes_admin;
        $save_data['user_id'] = Auth::guard('admin')->user()->id;
        $save_data['job_status'] = $data->job_status;
        return $save_data;
    }

    public function postTransfer(Request $request, $id) {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('tasks.view'));
        }
        //////////////////////////////////////////////
        $tasks = new Order();
        $info = $tasks->getOrder($id);
        if ($info) {
            $role = new Roles();
            $roles = $role->getRole($info->order_task_dep);
            if ($roles->role_order != 4) {
                $new_level = $role->getRoleByorder($roles->role_order + 1);
                $mydata = new \stdClass();
                $mydata->order_id = $id;
                $mydata->dep_id = $new_level->id;
                $mydata->emp_id = Auth::guard('admin')->user()->id;
                $mydata->notes_admin = $info->notes_admin;
                $mydata->task_status = $info->order_task_status;
                $mydata->job_status = 0;
                $save_data = $this->CreateTaskLogArray($mydata);
                $update = TasksLog::create($save_data);
                $update = $tasks->updateField($info, 'order_task_dep', $new_level->id);
                $update = $tasks->updateField($info, 'job_status', 0);
                $update = $tasks->updateField($info, 'emp_id', NULL);
                return redirect(route('tasks.view'));
            }
        }
        $request->session()->flash('danger', self::NOT_FOUND);
        return redirect(route('tasks.view'));
    }

    public function postReopen(Request $request, $id) {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            $request->session()->flash('danger', self::NOT_FOUND);
            return redirect(route('tasks.view'));
        }
        //////////////////////////////////////////////
        $tasks = new Order();
        $info = $tasks->getOrder($id);
        if ($info) {
            $role = new Roles();
            $roles = $role->getRole($info->order_task_dep);
            if ($roles->role_order != 1) {
                $new_level = $role->getRoleByorder($roles->role_order - 1);
                $mydata = new \stdClass();
                $mydata->order_id = $id;
                $mydata->dep_id = $new_level->id;
                $mydata->emp_id = Auth::guard('admin')->user()->id;
                $mydata->notes_admin = $info->notes_admin;
                $mydata->task_status = $info->order_task_status;
                $mydata->job_status = 0;
                $save_data = $this->CreateTaskLogArray($mydata);
                $update = TasksLog::create($save_data);
                $update = $tasks->updateField($info, 'order_task_dep', $new_level->id);
                $update = $tasks->updateField($info, 'job_status', 0);
                $update = $tasks->updateField($info, 'emp_id', NULL);
                return redirect(route('tasks.view'));
            }
        }
        $request->session()->flash('danger', self::NOT_FOUND);
        return redirect(route('tasks.view'));
    }

}
