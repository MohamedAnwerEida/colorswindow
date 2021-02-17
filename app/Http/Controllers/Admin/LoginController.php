<?php namespace App\Http\Controllers\Admin;

use Hash;
use Session;
use Validator;
use App\Models\User;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends AdminController
{
    use AuthenticatesUsers;

    public function __construct()
    {
        parent::__construct();
    }
    ///////////////////////////////
    public function getIndex()
    {
        return view('admin.login.view');
    }
    ///////////////////////////////////////////
    public function postIndex(Request $request)
    {
        $field = filter_var($request->get('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $username = $request->get('username');
        $password = $request->get('password');

        $admin[$field] = $username;
        $admin['password'] = $password;
        $admin['status'] = 1;
        if (Auth::guard('admin')->attempt($admin))
        {
            
            return redirect()->intended('/admin');
        }
        else
        {
            return redirect('admin/login')->with(['danger' => 'ُError username or password']);
        }
    }
    //////////////////////////////////////////
    public function getLogout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
