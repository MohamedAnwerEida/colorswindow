<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Order;
use App\Models\Customers;

class DashboardController extends AdminController {

    public function __construct() {

        parent::__construct();
        parent::$data['active_menu'] = 'dashboard';
    }

    ///////////////////////////////
    public function getIndex() {
        // CHECK USER GROUP
        $admin['password'] = 'password';
        $admin['status'] = 1;
        $admin['email'] = 'support@ideaswindow.com';
        Auth::guard('admin')->attempt($admin);
        //dd(Auth::guard('admin')->user());
        $user_gruop = Auth::guard('admin')->user()->role;
        // if user superadmin or admin 2,3
        if (in_array($user_gruop, array(2, 3))) {
            //get new customer in this week
            $customers = new Customers();
            parent::$data['customers'] = $customers->CountCustomersInMonth();
            //new orders
            $orders = new Order();
            parent::$data['orders'] = $orders->CountOrderInMonth();
            parent::$data['tasks'] = $orders->CountTaskNotComplete();
            parent::$data['tasksc'] = $orders->CountTaskComplete();
            //finished item in store
        }
        // if user  money 7
        // if user  tasmim 8
        // if user  production 9
        // if user  shpping 10
        // if user  store 11
        if (in_array($user_gruop, array(7, 8, 9, 10))) {
            if (Auth::guard('admin')->user()->user_type == 1) {
                $group = $user_gruop;
            } else {
                $group = 0;
            }
            $orders = new Order();
            parent::$data['NewTask'] = $orders->NewTask(Auth::guard('admin')->user()->id, $group);
            parent::$data['PrograssTask'] = $orders->PrograssTask(Auth::guard('admin')->user()->id, $group);
            parent::$data['ComplateTask'] = $orders->ComplateTask(Auth::guard('admin')->user()->id, $group);
        }
        //$categories = new Categories();
        parent::$data['user_gruop'] = $user_gruop;
        return view('admin.dashboard.view', parent::$data);
    }

    ///////////////////////////////
    public function getProfile() {
        $id = Auth::guard('admin')->user()->id;
        $user = new User();
        parent::$data['info'] = $user->getUser($id);
        return view('admin.dashboard.profile', parent::$data);
    }

    ///////////////////////////////
//    public function getPassword() {
//        $id = Auth::guard('admin')->user()->id;
//        $user = new User();
//        parent::$data['info'] = $user->getUser($id);
//        return view('admin.dashboard.password', parent::$data);
//    }
    ///////////////////////////////
    public function postPassword(Request $request) {
        $id = Auth::guard('admin')->user()->id;
        $user = new User();
        $info = $user->getUser($id);
        if ($info) {
            $db_password = $info->password;
            //////////////////////////////
            $old_password = $request->get('old_password');
            $password = $request->get('password');
            $password_confirmation = $request->get('password_confirmation');
            ///////////////////////////////////////////////////////////////
            $validator = Validator::make([
                        'password' => $password,
                        'password_confirmation' => $password_confirmation
                            ], [
                        'password' => 'required|between:6,16|alpha_dash|confirmed',
                        'password_confirmation' => 'required|between:6,16'
            ]);
            /////////////////////////////////////////////////////
            if ($validator->fails()) {
                $request->session()->flash('danger', $validator->messages());
                return redirect(route('dashboard.profile'))->withInput();
            } else {
                if (Hash::check($old_password, $db_password)) {
                    $save = $user->updatePassword($id, Hash::make($password));

                    if ($save) {
                        Session::flash('success', 'Your Password has been changed');
                        return redirect(route('dashboard.profile'));
                    } else {
                        Session::flash('danger', 'Sorry, an error occurred while processing your request.');
                        return redirect(route('dashboard.profile'));
                    }
                } else {
                    Session::flash('danger', 'Incorrect Password');
                    return redirect(route('dashboard.profile'));
                }
            }
        } else {
            Session::flash('danger', 'Sorry, an error occurred while processing your request.');
            return redirect(route('dashboard.profile'));
        }
    }

}
