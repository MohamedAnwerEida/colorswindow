@extends('admin.layout.master')

@section('title')
إدارة المهام
@stop

@section('page-breadcrumb')
<ul class="page-breadcrumb">
    <li>
        <i class="icon-home"></i>
        <a href="{{ route('dashboard.view') }}">الرئيسية</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="{{ route('tasks.view') }}">المهام</a>
        <i class="fa fa-angle-right"></i>
        </i>
    </li>
    <li>
        <span>إدارة المهام</span>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title">المهام
    <small>إدارة المهام</small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-magnifier"></i>البحث  </div>
    </div>
    <div class="portlet-body">
        <form role="form" class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">حالة الطلب</label>
                    <div class="col-md-2">
                        <select id="order_status" name="order_status"  class="form-control searchable">
                            <option value="-1">الكل</option>
                            @foreach($order_staus as $item)
                            <option value="{{ $item->id}}">{{ $item->name1}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="col-md-2 control-label">حالة المهمة</label>
                    <div class="col-md-2">
                        <select id="task_status" name="task_status"  class="form-control searchable">
                            <option value="-1">الكل</option>
                            @foreach($tasks_status as $item)
                            <option value="{{ $item->status_id}}">{{ $item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="col-md-2 control-label">القسم</label>
                    <div class="col-md-2">
                        <select id="dep_id" name="dep_id"  class="form-control searchable">
                            <option value="-1">الكل</option>
                            @foreach($roles as $item)
                            <option value="{{ $item->id}}">{{ $item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box {{ $form_class }}">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-grid"></i>إدارة المهام</div>
            </div>
            <div class="portlet-body">
                @include('admin.layout.error')
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="categories_table">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> رقم الطلب </th>
                            <th> القسم المسئول </th>
                            <th> الموظف المسئول </th>
                            <th> حالة الطلب </th>
                            <th> حالة المهمة </th>
                            <th> تعديل </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@stop
@section('modal')
@include('admin.layout.ajax')
@stop
@section('css')
<style>
    .category-color {
        padding: 5px 15px;
        border-radius: 9px;
        color: #fff;
    }
    .category-color i {
        margin-left: 10px;
    }
</style>
@stop
@section('js')
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        ////////////////////////////////////////////////////
        $('#confirm').on('show.bs.modal', function (e) {
            $("#delete_id").val($(e.relatedTarget).data('href'));
        });
        var oTable = $('#categories_table').DataTable({
            "processing": true,
            "serverSide": true,
            "language": {
                "sProcessing": "Processing...",
                "sLengthMenu": "Show _MENU_ entries",
                "sZeroRecords": "No matching records found",
                "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
                "sInfoEmpty": "Showing 0 to 0 of 0 entries",
                "sInfoFiltered": "(filtered from _MAX_ total entries)",
                "sInfoPostFix": "",
                "sSearch": "Search=>:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "First",
                    "sPrevious": "Previous",
                    "sNext": "Next",
                    "sLast": "Last"
                }
            },
            "pageLength": 25,
            "bJQueryUI": false,
            "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"clearfix">>><"table-scrollable"t><"row"<"col-md-5 col-sm-12"i><"col-md-7 col-sm-12"p>>r',
            "ajax": {
                url: "{{ route('tasks.list') }}",
                data: function (d) {
                    d.order_status = $('#order_status').val();
                    d.task_status = $('#task_status').val();
                    d.dep_id = $('#dep_id').val();
                }
            },
            "order": [],
            "columnDefs": [{
                    "targets": "_all",
                    className: "good",
                    "defaultContent": ""
                }],
            "columns": [
                {"data": "", "title": "#", "orderable": false, "searchable": false},
                {
                    "data": "id",
                    "title": "رقم الطلب",
                    "orderable": false,
                    "searchable": false
                },
                {
                    "data": "tasklog",
                    "title": "القسم المسئول",
                    "orderable": false,
                    "searchable": false
                },
                {
                    "data": "emp_name",
                    "title": "الموظف المسئول",
                    "orderable": false,
                    "searchable": false
                },
                {
                    "data": "order_task_status",
                    "title": "حالة الطلب",
                    "orderable": true,
                    "searchable": false
                },
                {
                    "data": "task_status",
                    "title": "حالة المهمة",
                    "orderable": false,
                    "searchable": false
                },
                {
                    "data": "actions",
                    "title": "تعديل",
                    "orderable": false,
                    "searchable": false
                }
            ],
            "fnRowCallback": function (nRow, aData) {
                if (aData["urgent"] == 1) {
                    $('td.good', nRow).css('background-color', '#dbcece');
                }
            }, "fnDrawCallback": function (oSettings) {
                $('.tooltips').tooltip();

                oTable.column(0).nodes().each(function (cell, i) {
                    cell.innerHTML = (parseInt(oTable.page.info().start)) + i + 1;
                });
            }
        });

        $('.searchable').on('input', function (e) {
            e.preventDefault();
            oTable.draw();
        });

        $('button[type="reset"]').on('click', function (e) {
            e.preventDefault();
            $(this).closest('form').get(0).reset();
            oTable.draw();
        });
        $(document).on('click', ".status", function () {
            var id = $(this).data('href');
            var item = $(this);
            $.ajax({
                type: "POST",
                url: "{{ route('tasks.status') }}",
                data: {'id': id}
            }).success(function (data) {
                if (data.type == 1)
                {
                    item.removeClass("red");
                    item.addClass("green-dark");
                    item.html('<i class="fa fa-check"></i> اكتملت');
                } else if (data.type == 0)
                {
                    item.removeClass("green-dark");
                    item.addClass("red");
                    item.html('<i class="fa fa-times"></i> مفتوحة ');
                }
                toastr[data.status](data.message);
            });
        });
    });
</script>
@stop
