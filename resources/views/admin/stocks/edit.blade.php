@extends('admin.layout.master')

@section('title')
تعديل منتج
@stop

@section('css')

@stop

@section('page-breadcrumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard.view') }}">الرئيسية</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <a href="{{ route('stocks.view') }}">إدارة المخزن</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <a href="{{ route('stocks.edit',['id' => Crypt::encrypt($info->id)]) }}">رصيد منتج</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <strong> {{ $info->name_ar }}</strong>
    </li>

</ul>
@stop

@section('page-title')
<h1 class="page-title"> المنتجات
    <small>رصيد منتج</small>
</h1>
@stop

@section('page-content')
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"> رصيد : {{ $info->name_ar }}</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs nav-tabs-lg">
                        <li class="active">
                            <a href="#tab_1" data-toggle="tab"> تعديل الرصيد </a>
                        </li>
                        <li>
                            <a href="#tab_2" data-toggle="tab"> ارشيف الرصيد </a>
                        </li>
                        <li>
                            <a href="#tab_3" data-toggle="tab"> ارشيف الطلبات </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            @include('admin.layout.error')
                            <form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">الكمية</label>
                                            <div class="col-md-6">
                                                <input type="text" value="{{ $info->qty }}" name="qty" id="qty" class="form-control" placeholder="الكمية">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">الحد الادني للكمية</label>
                                            <div class="col-md-6">
                                                <input type="text" value="{{ $info->qty_stock_min }}" name="qty_stock_min" id="qty_stock_min" class="form-control" placeholder="الحد الادني للكمية">
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="col-md-offset-3 col-md-6">
                                                <button type="submit" class="btn default {{ $btn_class }}">حفظ</button>
                                                <a href="{{ route('stocks.view') }}" type="button" class="btn default">إلغاء</a>
                                                {{ csrf_field() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover" id="datatable_history">
                                    <thead>
                                        <tr role="row" class="heading">
                                            <th> تاريخ الحركة </th>
                                            <th> المنتج </th>
                                            <th> الكمية </th>
                                            <th> الحد الادني </th>
                                            <th> المستخدم </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($product_stock_log)
                                        @foreach($product_stock_log as $item)
                                        <tr>
                                            <td style="direction: ltr">{{ $item->created_at }}</td>
                                            <td>{{ $info->name_ar }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->qty_stock_min }}</td>
                                            <td>{{ $item->user->name }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover" id="datatable_history">
                                    <thead>
                                        <tr role="row" class="heading">
                                            <th> تاريخ الحركة </th>
                                            <th> المنتج </th>
                                            <th> رقم الطلب </th>
                                            <th> الكمية </th>
                                            <th> المستخدم </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($product_log)
                                        @foreach($product_log as $item)
                                        <tr>
                                            <td style="direction: ltr">{{ $item->created_at }}</td>
                                            <td>{{ $info->name_ar }}</td>
                                            <td>{{ $item->order_id }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->user->name }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop