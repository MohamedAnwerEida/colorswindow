<?php

namespace App\Http\Controllers;

use Hash;
use Validator;
use Mail;
use Config;
//use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Customers;
use App\Models\UserRequest;
use Illuminate\Contracts\Encryption\DecryptException;

class UsersController extends Controller {

    use AuthenticatesUsers;

    public function __construct() {
        parent::__construct();
        parent::$data['active_menu'] = 'login';
    }

    //////////////////////////////////////////////
    //////////////////////////////////////////////
    public function getForgotPassword() {
        return view('frontend.login.forgot_password', parent::$data);
    }

    //////////////////////////////////////////////
    public function postForgotPassword(Request $request) {
        $email = $request->get('email');
        //////////////////////////////////////
        $customers = new Customers();
        $info = $customers->getCustomerByEmail($email);
        if ($info) {
            $token = Str::random(40);
            $customers->updateToken($info->id, $token);
            $this->send_mail('reset', $info->id);
            $request->session()->flash('success', 'تم ارسال بريد الكتروني لاستعادة كلمة المرور');
            return redirect('login');
        } else {
            $request->session()->flash('success', 'هذا البريد غير موجود');
            return redirect('login/forgotPassword');
        }
    }

    //////////////////////////////////////////////
    public function getResetPassword($email, $token) {

        /////////////////////////////
        $customers = new Customers();
        $info = $customers->getCustomerByToken($token);
        if ($info) {
            $data_token = $info->token;
            if ($data_token == $token) {
                return view('frontend.login.reset_password', parent::$data);
            } else {
                $request->session()->flash('success', 'هذا البريد غير موجود');
                return redirect('login/forgotPassword');
            }
        } else {
            $request->session()->flash('success', 'هذا البريد غير موجود');
            return redirect('login/forgotPassword');
        }
    }

    //////////////////////////////////////////////
    public function postResetPassword(Request $request, $email, $token) {
        $password = $request->get('password');
        $password_confirmation = $request->get('password_confirmation');

        $customers = new Customers();
        $info = $customers->getCustomerByEmail($email);

        if ($info) {
            $customer_id = $info->id;
            $data_token = $info->token;
            if ($data_token == $token) {
                $validator = Validator::make([
                            'password' => $password,
                            'password_confirmation' => $password_confirmation
                                ], [
                            'password' => 'required|between:6,16|confirmed',
                            'password_confirmation' => 'required|between:6,16'
                ]);
                //////////////////////////////////////////////////////////
                if ($validator->fails()) {
                    $request->session()->flash('success', 'كلمة المرور غير سليمة حاول مرة اخري..');
                    return redirect('login/resetPassword/' . $email . '/' . $token);
                } else {
                    $change = $customers->updatePassword($customer_id, Hash::make($password));
                    if ($change) {
                        $customers->updateToken($customer_id, null);
                        $request->session()->flash('success', 'تم تغير كلمة المرور بنجاح..');
                        return redirect('login');
                    } else {
                        $request->session()->flash('success', 'كلمة المرور غير سليمة حاول مرة اخري..');
                        return redirect('login/resetPassword/' . $email . '/' . $token);
                    }
                }
            } else {
                $request->session()->flash('success', 'لم يتم العثور علي البيانات المطلوبة');
                return redirect('login');
            }
        } else {
            $request->session()->flash('success', 'لم يتم العثور علي البيانات المطلوبة');
            return redirect('login');
        }
    }

//////////////////////////// used function//////////////////////////////
    public function getIndex() {
        return view('frontend.login.view', parent::$data);
    }

    //////////////////////////////////////////
    public function doLogin(Request $request) {

        $email = $request->get('email');
        $password = $request->get('password');

        $user['email'] = $email;
        $user['password'] = $password;
        $user['status'] = 1;
        $remember = $request->get('remember');
        if (Auth::guard('web')->attempt($user, $remember)) {
            return redirect()->intended('/');
        } else {
            $user = new Customers();
            $cuser = $user->getCustomerByGoogleEmail($email);
            if ($cuser) {
                $request->session()->flash('danger', 'لديك حساب باستخدام جوجل, الرجاء تسجيل الدخول بحساب جوجل.');
                return redirect('login')->withInput();
            } else {
                $request->session()->flash('danger', 'اسم المستخدم او كلمة المرور غير صحيحة او ان الحساب غير مفعل');
                return redirect('login')->withInput();
            }
        }
    }

    public function postSignIndex(Request $request) {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $password_confirmation = $request->get('password_confirmation');
        $phone = $request->get('phone');
        $sex = $request->get('sex');
        $dob = $request->get('dob');
        $role = 0;
        $status = 0;
        $token = Str::random(40);
        $validator = Validator::make([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'password_confirmation' => $password_confirmation,
                    'phone' => $phone,
                    'dob' => $dob,
                    'sex' => $sex,
                        ], [
                    'email' => 'required|email|unique:customers,email',
                    'name' => 'required',
                    'phone' => 'required',
                    'dob' => 'required',
                    'sex' => 'required',
                    'password' => 'required|between:6,16|confirmed',
                    'password_confirmation' => 'required|between:6,16',
        ]);
        //////////////////////////////////////////////////////////
        if ($validator->fails()) {
            $request->session()->flash('danger', $validator->messages());
            return redirect('login')->withInput();
        } else {
            $user = new Customers();
            $add = $user->addCustomer($name, $email, $phone, $sex, $dob, $role, Hash::make($password), $status, $token);
            if ($add) {

                $this->send_mail('verify', $add->id);
                $request->session()->flash('success', 'تم التسجيل بنجاح يرجي فحص البريد الالكتروني لتفعيل الحساب الخاص بك..');
                return redirect(url('login'));
            } else {
                $request->session()->flash('danger', self::EXECUTION_ERROR);
                return redirect('login')->withInput();
            }
        }
    }

    public function doLogout() {
        Auth::logout();
        return redirect('/');
    }

    public function getSpecial() {
        return view('frontend.special.index', parent::$data);
    }

    public function postSpecial(Request $request) {
        $srequest = $request->get('request');
        $validator = Validator::make([
                    'request' => $srequest,
                        ], [
                    'request' => 'required',
        ]);
        //////////////////////////////////////////////////////////
        if ($validator->fails()) {
            $request->session()->flash('danger', $validator->messages());
            return redirect('special')->withInput();
        } else {
            $user = new UserRequest();
            $user_id = Auth::guard('web')->user()->id;
            $add = $user->addNew($user_id, $srequest);
            if ($add) {
                Config::set('mail.driver', 'sendmail');
                Config::set('mail.host', 'ssl://smtp.gmail.com');
                Config::set('mail.port', 465);
                Config::set('mail.email', 'no-reply@colorswindow.com');
                Config::set('mail.encryption', 'ssl');
                Config::set('mail.password', '123');

                $user = new Customers();
                $mydata = $user->getCustomer($user_id);
                $email = $mydata->email;
                $name = $mydata->name;
                $data = [
                    'email' => $mydata->email,
                    'name' => $mydata->name,
                    'request' => $srequest,
                ];
                Mail::send('emails.request', $data, function ($message) use ($email, $name) {
                    $message->to('info@colorswindow.com', $name)->subject('طلب خاص')->from('no-reply@colorswindow.com', 'Colors Window');
                });
                $request->session()->flash('success', 'تم ارسال الطلب بنجاح');
                return redirect(route('special'));
            } else {
                $request->session()->flash('danger', self::EXECUTION_ERROR);
                return redirect('special')->withInput();
            }
        }
    }

    public function showProfile() {
        $user = new Customers();
        parent::$data['user'] = $user->getCustomer(Auth::guard('web')->user()->id);
        return view('frontend.login.profile', parent::$data);
    }

    public function postProfile(Request $request) {

        $name = $request->get('name');
        $phone = $request->get('phone');
        $dob = $request->get('dob');
        $sex = $request->get('sex');
        $validator = Validator::make([
                    'name' => $name,
                        ], [
                    'name' => 'required',
        ]);

        //////////////////////////////////////////////////////////
        if ($validator->fails()) {
            $request->session()->flash('danger', $validator->messages());
            return redirect('profile')->withInput();
        } else {
            $user = new Customers();
            $info = $user->getCustomer(Auth::guard('web')->user()->id);
            $add = $user->updateCustomer($info, $name, $phone, $dob, $sex);
            if ($add) {
                return redirect(route('profile'));
            } else {
                $request->session()->flash('danger', self::EXECUTION_ERROR);
                return redirect('profile')->withInput();
            }
        }
    }

    public function postShopping(Request $request) {
        $neighborhood = $request->get('neighborhood');
        $street = $request->get('street');
        $building = $request->get('building');
        $notes = $request->get('notes');
        //////////////////////////////////////////////////////////
        $user = new Customers();
        $info = $user->getCustomer(Auth::guard('web')->user()->id);
        $add = $user->updateCustomerShopping($info, $neighborhood, $street, $building, $notes);
        if ($add) {
            return redirect(route('profile'));
        } else {
            $request->session()->flash('danger', self::EXECUTION_ERROR);
            return redirect('profile')->withInput();
        }
    }

    public function verifyUser(Request $request, $token) {
        $verifyUser = new Customers();
        $user = $verifyUser->getCustomerByToken($token);
        if ($user) {
            if (!$user->status) {
                $verifyUser->updateStatus($user->id, 1);
                $verifyUser->updateToken($user->id, null);
                $request->session()->flash('success', 'تم تفعيل البريد الالكتروني يمكنك تسجيل الدخول الان');
            } else {
                $request->session()->flash('success', 'الحساب الخاص بك مفعل من قبل');
            }
        } else {
            $request->session()->flash('success', 'للاسف لم يمكن التعرف علي الايميل الخاص بك');
        }

        return redirect(url('login'));
    }

    public function send_mail($type, $user_id) {
        $user = new Customers();
        $mydata = $user->getCustomer($user_id);
        $email = $mydata->email;
        $name = $mydata->name;
        $data = array();
        $token = '';
        $title = '';
        $data = [
            'email' => $mydata->email,
            'name' => $mydata->name,
            'token' => ''
        ];
        if ($type == 'verify') {
            $data['token'] = $mydata->token;
            $token = $mydata->token;
            $view = 'emails.verify';
            $title = 'تاكيد البريد الالكتروني';
        }
        if ($type == 'reset') {
            $data['token'] = $mydata->token;
            $token = $mydata->token;
            $view = 'emails.reset';
            $title = 'استعادة كلمة المرور الخاصة بك';
        }
        Config::set('mail.driver', 'sendmail');
        Config::set('mail.host', 'ssl://smtp.gmail.com');
        Config::set('mail.port', 465);
        Config::set('mail.email', 'no-reply@colorswindow.com');
        Config::set('mail.encryption', 'ssl');
        Config::set('mail.password', '123');



        Mail::send($view, $data, function ($message) use ($email, $name, $token, $title) {
            $message->to($email, $name)->subject($title)->from('no-reply@colorswindow.com', 'Colors Window');
        });
        //  return view($view);
    }

}
