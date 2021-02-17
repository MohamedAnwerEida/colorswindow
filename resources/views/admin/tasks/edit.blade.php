@extends('admin.layout.master')

@section('title')
تعديل مهمة
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
        <a href="{{ route('tasks.view') }}">إدارة المهام</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <a href="{{ route('tasks.edit',['id' => Crypt::encrypt($task->id)]) }}">تعديل مهمة</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <strong> {{ $task->name_ar }}</strong>
    </li>

</ul>
@stop

@section('page-title')
<h1 class="page-title"> إدارة المهام
    <small>تعديل مهمة</small>
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
                    <span class="caption-subject font-dark sbold uppercase"> رقم الطلب : {{ $task->id }}</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs nav-tabs-lg">
                        <li class="active">
                            <a href="#tab_1" data-toggle="tab"> تعديل المهمة </a>
                        </li>
                        <li>
                            <a href="#tab_2" data-toggle="tab"> تفاصيل الطلب </a>
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
                                        @if(count($task_log)>0)
                                        <?php $cuurent_task_log = $task_log->first() ?>
                                        @else
                                        <?php
                                        $cuurent_task_log = new stdClass();
                                        $cuurent_task_log->dep_id = 0;
                                        $cuurent_task_log->emp_id = 0;
                                        $cuurent_task_log->task_status = 0;
                                        $cuurent_task_log->job_status = 0;
                                        ?>
                                        @endif
                                        @if($user->user_type==0)
                                        <div class="form-group">
                                            <label class="control-label col-md-3">القسم</label>
                                            <div class="col-md-6">
                                                <select name="dep_id"  class="form-control">
                                                    <option value="0" {{ $cuurent_task_log->dep_id==0?'selected':'' }}>بدون قسم</option>
                                                    @foreach($roles as $item)
                                                    <option value="{{ $item->id}}" {{ $cuurent_task_log->dep_id==$item->id?'selected':'' }}>{{ $item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->user_type==0 || $user->user_type==1)
                                        <div class="form-group">
                                            <label class="control-label col-md-3">الموظف</label>
                                            <div class="col-md-6">
                                                <select name="emp_id"  class="form-control">
                                                    <option value="0" {{ $cuurent_task_log->emp_id==0?'selected':'' }}>بدون موظف</option>
                                                    @foreach($users as $item)
                                                    @if($user->user_type==0)
                                                    <option value="{{ $item->id}}" {{ $cuurent_task_log->emp_id==$item->id?'selected':'' }}>{{ $item->name}}</option>
                                                    @elseif($user->role==$item->role)
                                                    <option value="{{ $item->id}}" {{ $cuurent_task_log->emp_id==$item->id?'selected':'' }}>{{ $item->name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label class="control-label col-md-3">حالة الطلب</label>
                                            <div class="col-md-6">
                                                <select name="job_status" class="form-control">
                                                    @foreach($tasks_status as $item)
                                                    <option value="{{ $item->status_id}}" {{ $cuurent_task_log->job_status==$item->status_id?'selected':'' }}>{{ $item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">ملاحظات</label>
                                            <div class="col-md-6">
                                                <textarea name="notes_admin" id="notes_admin" class="form-control" rows="3">{{ $task->notes_admin }}</textarea>

                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="col-md-offset-3 col-md-6">
                                                <button type="submit" class="btn default {{ $btn_class }}">حفظ</button>
                                                <a href="{{ route('tasks.view') }}" type="button" class="btn default">إلغاء</a>
                                                {{ csrf_field() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="portlet yellow-crusta box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-cogs"></i>تفاصيل الطلب </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> رقم الطلب: </div>
                                                <div class="col-md-7 value"> {{$task->id}}
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> تاريخ وقت الطلب: </div>
                                                <div class="col-md-7 value"> {{$task->created_at}} </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> حالة الطلب: </div>
                                                <div class="col-md-7 value">
                                                    <span class="label label-success"> {{$task->mystatus->name1 }} </span>
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> طريقة الدفع: </div>
                                                <div class="col-md-7 value">
                                                    <span class="label label-success"> {{$task->mypay ? $task->mypay->name : 'كاش'}} </span>
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> المبلغ الكلي: </div>
                                                <div class="col-md-7 value"> {{$task->total}} ريال </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="portlet blue-hoki box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-user"></i>بيانات الزبون </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> الاسم: </div>
                                                <div class="col-md-7 value"> {{$task->name}} </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> البريد الالكتروني: </div>
                                                <div class="col-md-7 value"> {{$task->email}} </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> الهاتف: </div>
                                                <div class="col-md-7 value"> {{$task->telephone}} </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> ملاحظات: </div>
                                                <div class="col-md-7 value"> {{$task->notes}} </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="portlet green-meadow box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-map"></i>عنوان الشحن </div>
                                        </div>
                                        <div class="portlet-body">

                                            <div class="row static-info">
                                                <div class="col-md-5 name"> الحي: </div>
                                                <div class="col-md-7 value"> {{$task->neighborhood}} </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> الشارع: </div>
                                                <div class="col-md-7 value"> {{$task->street}} </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> المنزل: </div>
                                                <div class="col-md-7 value"> {{$task->building}} </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($task->ratings)
                                <div class="col-md-6 col-sm-12">
                                    <div class="portlet green-meadow box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-bar-chart"></i>تقييم الطلب </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row">
                                                <div class="col-md-5 name"> التقييم</div>
                                                <div class="col-md-7 value">
                                                    <?PHP if ($task->ratings == 1) { ?>
                                                        <img src="{{ url('assets/site/images/rate/bad.png')}}" style="width: 50px;">
                                                    <?PHP } elseif ($task->ratings == 2) { ?>
                                                        <img src="{{ url('assets/site/images/rate/mid.png')}}" style="width: 50px;">
                                                    <?PHP } else { ?>
                                                        <img src="{{ url('assets/site/images/rate/good.png')}}" style="width: 50px;">
                                                    <?PHP } ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 name"> ملاحظة التقيم: </div>
                                                <div class="col-md-7 value"> {{ $task->rate_note }} </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="portlet grey-cascade box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-list-alt"></i>منتجات الطلبية </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered table-striped">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>المنتج</th>
                                                    <th>التفاصيل</th>
                                                    <th>السعر</th>
                                                    <th>الكمية</th>
                                                    <th>المجموع</th>

                                                    </thead>
                                                    <tbody
                                                    <?php $sub_total = 0; ?>
                                                        @foreach($task->items as $item)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td><?php
                                                                $product = get_product($item->name);
                                                                if ($product)
                                                                    echo $product->name_ar;
                                                                else
                                                                    echo 'تم حذف المنتج';
                                                                ?>
                                                            </td>
                                                            <td>
                                                                @if($item->meter_width>0)
                                                                <b>الطول</b>:<?= $item->meter_width ?> متر<br>
                                                                <b>العرض</b>:<?= $item->meter_height ?> متر<br>
                                                                @endif

                                                                <?php $item_specs = json_decode($item->spec) ?>
                                                                @if($item_specs)
                                                                @foreach($item_specs as $key=>$value)
                                                                <?php $specs = get_specs($key, $value) ?>
                                                                <?php if ($specs) { ?>
                                                                    <b><?= $specs->catspectype->name ?></b>:<?= $specs->name ?><br>
                                                                <?php } ?>
                                                                @endforeach
                                                                @endif
                                                                <b>تفاصيل التصميم</b>:<?= $item->design_data ?><br>
                                                            </td>
                                                            <td><?= round($item->price / $item->quantity, 1) ?> ريال</td>
                                                            <td><?= $item->quantity ?></td>
                                                            <td><?= $item->price ?> ريال</td>
                                                            <?php $sub_total += $item->price ?>
                                                        </tr>
                                                        @endforeach


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"> </div>
                                <div class="col-md-6">
                                    <div class="well">
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name"> المجموع: </div>
                                            <div class="col-md-3 value"> <?= $sub_total ?> ريال </div>
                                        </div>
                                        <?php if ($task->urgent != 0) { ?>
                                            <div class="row static-info align-reverse">
                                                <div class="col-md-8 name"> طلب مستعجل: </div>
                                                <div class="col-md-3 value"> <?= $sub_total * 0.5 ?> ريال </div>
                                            </div>
                                        <?php } ?>
                                        <?php if ($task->pay_value != 0) { ?>
                                            <div class="row static-info align-reverse">
                                                <div class="col-md-8 name"> رسوم الدفع عند الاستلام: </div>
                                                <div class="col-md-3 value"> <?= $task->pay_value ?> ريال </div>
                                            </div>
                                        <?php } ?>
                                        <?php if ($task->discount != 0) { ?>
                                            <div class="row static-info align-reverse">
                                                <div class="col-md-8 name"> خصم: </div>
                                                <div class="col-md-3 value"> <?= $task->discount ?> ريال </div>
                                            </div>
                                        <?php } ?>
                                        <?php if ($task->tax != 0) { ?>
                                            <div class="row static-info align-reverse">
                                                <div class="col-md-8 name"> الضريبة: </div>
                                                <div class="col-md-3 value"> <?= $task->tax ?> ريال </div>
                                            </div>
                                        <?php } ?>
                                        <div class="row static-info align-reverse">
                                            <div class="col-md-8 name">المجموع الكلي: </div>
                                            <div class="col-md-3 value"> <?= $task->total ?> ريال </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover" id="datatable_history">
                                    <thead>
                                        <tr role="row" class="heading">
                                            <th> تاريخ الحركة </th>
                                            <th> القسم المسئول </th>
                                            <th> رقم الطلب </th>
                                            <th> الموظف المسئول </th>
                                            <th> حالة الطلب </th>
                                            <th> حالة المهمة </th>
                                            <th> المستخدم </th>
                                            <th> الملاحظة </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($task_log)
                                        @foreach($task_log as $item)
                                        <tr>
                                            <td style="direction: ltr">{{ $item->created_at }}</td>
                                            <td>{{ $item->demp_name?$item->demp_name->name:'-' }}</td>
                                            <td>{{ $item->order_id }}</td>
                                            <td>{{ $item->emp_name?$item->emp_name->name:'-' }}</td>
                                            <td>{{ $item->mystatus?$item->mystatus->name:'-' }}</td>
                                            <td>{{ $item->job_status == 1 ? 'اكتملت' : 'مفتوحة' }}</td>
                                            <td>{{ $item->user ? $item->user->name: '-' }}</td>
                                            <td>{{ $item->notes_admin }}</td>
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