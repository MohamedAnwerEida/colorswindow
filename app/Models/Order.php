<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Order extends Model {

    use SoftDeletes;

    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('invoice_no', 'cart_id', 'customer_id', 'urgent', 'name', 'pay_value', 'discount', 'discount_id', 'tax', 'email', 'telephone', 'pay_type', 'payment_method', 'neighborhood', 'street', 'building', 'city', 'notes', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_city_id', 'shipping_method', 'shipping_code', 'comment', 'total', 'order_status_id', 'is_paid', 'tracking', 'currency_code', 'currency_value');

    public function items() {
        return $this->hasMany('App\Models\OrderProduct', 'order_id');
    }

    public function logs() {
        return $this->hasMany('App\Models\OrderLog', 'order_id');
    }

    public function totals() {
        return $this->hasMany('App\Models\OrderTotal', 'order_id');
    }

    public function mystatus() {
        return $this->hasOne('App\Models\OrderStatus', 'id', 'status');
    }

    public function tasksstatus() {
        return $this->hasOne('App\Models\TasksStatus', 'status_id', 'order_task_status');
    }

    public function jobStatus() {
        return $this->hasOne('App\Models\TasksStatus', 'status_id', 'job_status');
    }

    public function tasklog() {
        return $this->hasMany('App\Models\TasksLog', 'order_id', 'id')->orderBy('id', 'desc');
    }

    public function mypay() {
        return $this->hasOne('App\Models\OrderPay', 'id', 'pay_type');
    }

    function getAllOrdersByCustomer($customer_id) {
        return $this->with('mystatus')->where('customer_id', '=', $customer_id)->get();
    }

    function getOrderByCustomer($order_id, $customer_id) {
        return $this
                        ->where('id', '=', $order_id)
                        ->where('customer_id', '=', $customer_id)
                        ->first();
    }

    function getNewOrders() {
        return $this
                        ->where('status', '=', 1)
                        ->count();
    }

    function checkMyorderForCoupon($coupon_id, $customer_id) {
        return $this
                        ->where('discount_id', '=', $coupon_id)
                        ->where('customer_id', '=', $customer_id)
                        ->first();
    }

    function getAllOrders($name, $status, $pay, $order_date, $total) {
        return $this->where(function($query) use ($name, $status, $pay, $order_date, $total) {
                    if ($name != "") {
                        $query->where('name', 'LIKE', '%' . $name . '%')
                                ->Orwhere('id', '=', $name);
                    }
                    if ($status != -1) {
                        $query->where('status', '=', $status);
                    }
                    if ($pay != -1) {
                        $query->where('pay_type', '=', $pay);
                    }
                    if ($total != '') {
                        $query->where('total', '=', $total);
                    }
                    if ($order_date != '') {
                        $query->whereBetween('created_at', array($order_date . ' 00:00:00', $order_date . ' 23:23:59'));
                    }
                })->orderBy('id', 'desc')->get();
    }

    function getAllTasks($order_status = -1, $task_status = 0, $dep_id = -1, $user) {
        return $this->where(function($query) use ($order_status, $task_status, $dep_id, $user) {
                            //$query->where('order_task_status', $task_status);
                            if ($order_status != -1) {
                                $query->where('status', $order_status);
                            }
                            if ($task_status != -1) {
                                $query->where('job_status', $task_status);
                            }
                            if ($dep_id != -1) {
                                $query->where('order_task_dep', $dep_id);
                            }
                            if ($user->user_type != 0) {
                                $query->where('order_task_dep', $user->role);
                            }
                        })
                        ->orderByRaw("CASE WHEN ISNULL(urgent) THEN 0 ELSE 1 END" . ' DESC')
                        ->orderBy('id', 'asc')
                        ->get();
    }

    function getAllOrders1($name = NULL, $status = NULL, $pay = NULL, $order_date = NULL, $order_date1 = NULL, $paid = NULL) {
        return $this->where(function($query) use ($name, $status, $pay, $order_date, $order_date1, $paid) {
                    if ($name != "") {
                        $query->where('name', 'LIKE', '%' . $name . '%')
                                ->Orwhere('id', '=', $name);
                    }
                    if ($status != -1) {
                        $query->where('status', '=', $status);
                    }
                    if ($pay != -1) {
                        $query->where('pay_type', '=', $pay);
                    }
                    if ($paid != -1) {
                        $query->where('is_paid', '=', $paid);
                    }
                    if ($order_date != '') {
                        if ($order_date1 != '') {
                            $query->whereBetween('created_at', array($order_date . ' 00:00:00', $order_date1 . ' 23:23:59'));
                        } else {
                            $query->whereBetween('created_at', array($order_date . ' 00:00:00', $order_date . ' 23:23:59'));
                        }
                    }
                })->orderBy('id', 'desc')->get();
    }

    function getOrder($id) {
        return $this->with('mystatus')->where('id', '=', $id)->first();
    }

    function CountOrderInMonth() {
        return $this->whereMonth('created_at', '=', Carbon::now()->month)
                        ->where('status', '=', 1)
                        ->count();
    }

    function getTotalOnlineByMonth() {
        return $this->whereMonth('created_at', '=', Carbon::now()->month)
                        ->where('pay_type', '=', 3)
                        ->where('is_paid', '=', 1)
                        ->sum('total');
    }

    function getTotalPaidByToday() {
        return $this->whereDate('created_at', '=', Carbon::today())
                        ->where('is_paid', '=', 1)
                        ->sum('total');
    }

    function getTotalNotPaidByMonth() {
        return $this->whereMonth('created_at', '=', Carbon::now()->month)
                        ->where('pay_type', '=', 1)
                        ->where('is_paid', '=', NULL)
                        ->sum('total');
    }

    function NewTask($user_id, $group_id) {
        return $this->where(function($query) use ($user_id, $group_id) {
                            if ($group_id != 0) {
                                $query->where('order_task_dep', '=', $group_id);
                            } else {
                                $query->where('emp_id', '=', $user_id);
                            }
                        })->where('job_status', '=', NULL)
                        ->count();
    }

    function PrograssTask($user_id, $group_id) {
        return $this->where(function($query) use ($user_id, $group_id) {
                            if ($group_id != 0) {
                                $query->where('order_task_dep', '=', $group_id);
                                $query->whereNotNull('emp_id');
                            } else {
                                $query->where('emp_id', '=', $user_id);
                            }
                        })->where('job_status', '=', 0)
                        ->count();
    }

    function ComplateTask($user_id, $group_id) {
        return $this->where(function($query) use ($user_id, $group_id) {
                            if ($group_id != 0) {
                                $query->where('order_task_dep', '=', $group_id);
                                $query->whereNotNull('emp_id');
                            } else {
                                $query->where('emp_id', '=', $user_id);
                            }
                        })->where('job_status', '=', 2)
                        ->count();
    }

    function CountTaskNotComplete() {
        return $this->whereIN('status', array(2, 3, 4))
                        ->count();
    }

    function CountTaskComplete() {
        return $this->where('status', '=', 4)
                        ->where('job_status', '=', 1)
                        ->count();
    }

    function deleteOrder($obj) {
        return $obj->delete();
    }

    function updaterate($obj, $ratings, $rate_note) {
        $obj->ratings = $ratings;
        $obj->rate_note = $rate_note;
        $obj->save();
    }

    function updateField($obj, $field, $value) {
        $obj->$field = $value;
        $obj->save();
        return $obj;
    }

    function updateOrder($obj, $status, $is_paid, $notes_admin) {

        $obj->notes_admin = $notes_admin;
        $obj->is_paid = $is_paid;
        $obj->status = $status;
        if ($status == 2) {
            $obj->delivery_date = date('Y-m-d H:i:s');
        }
        if ($status == 3) {
            $obj->received_date = date('Y-m-d H:i:s');
        }
        if ($status == 4) {
            $obj->done_date = date('Y-m-d H:i:s');
        }
        if ($status == 5) {
            $obj->cancel_date = date('Y-m-d H:i:s');
        }
        $obj->save();
        return $obj;
    }

}
