@extends('admin.layout.master')
@section('title')
لوحة التحكم - الصفحة الرئيسية
@stop

@section('page-title')
<h3 class="page-title"> الصفحة الرئيسية
    <small>إحصائيات</small>
</h3>
@stop

@section('page-breadcrumb')
<ul class="page-breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{ route('dashboard.view') }}"> الصفحة الرئيسية</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <span>إحصائيات</span>
    </li>
</ul>
@stop

@section('page-content')
<div class="row">
    <?php /*    <a href="{{route('push')}}" class="btn btn-outline-primary btn-block">Make a Push Notification!</a> */ ?>
    @if (in_array($user_gruop, array(2, 3)))
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
            <div class="visual">
                <i class="fa fa-line-chart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{ $customers }}">0</span>
                </div>
                <div class="desc"> New Customers This Month </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
            <div class="visual">
                <i class="fa fa-line-chart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{ $orders }}">0</span>
                </div>
                <div class="desc"> New Orders This Month </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
            <div class="visual">
                <i class="fa fa-line-chart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{ $tasks }}">0</span>
                </div>
                <div class="desc"> Open Tasks </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 yellow-gold" href="#">
            <div class="visual">
                <i class="fa fa-line-chart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{ $tasksc }}">0</span>
                </div>
                <div class="desc"> Delivered Tasks </div>
            </div>
        </a>
    </div>
    @endif
    @if(Auth::guard('admin')->user()->can('admin.stocks.view') ||  Auth::guard('admin')->user()->can('admin.stocks.edit'))
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{ getEmptyProducts() }}">0</span>
                </div>
                <div class="desc"> Empty Products in Stock </div>
            </div>
        </a>
    </div>
    @endif
    @if(Auth::guard('admin')->user()->can('admin.accounts.view') ||  Auth::guard('admin')->user()->can('admin.accounts.details'))
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{ getTotalOnlineByMonth() }}">0</span> SAR
                </div>
                <div class="desc"> Total From Online This Month </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{ getTotalNotPaidByMonth() }}">0</span> SAR
                </div>
                <div class="desc"> Total Not Paid This Month </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{ getTotalPaidByToday() }}">0</span>
                </div>
                <div class="desc"> Total Collected Today </div>
            </div>
        </a>
    </div>
    @endif
    @if (in_array($user_gruop, array(7, 8, 9, 10)))
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{ $NewTask }}">0</span>
                </div>
                <div class="desc"> New Tasks </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{ $PrograssTask }}">0</span>
                </div>
                <div class="desc"> In Progress Tasks </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="{{ $ComplateTask }}">0</span>
                </div>
                <div class="desc"> Completed Tasks </div>
            </div>
        </a>
    </div>
    @endif
</div>
@stop
@section('js')
<script src="assets/admin/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="assets/admin/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
@stop
