@extends('admin.layout.master')

@section('title')
    إدارة الصفحات الثابتة
@stop

@section('css')

@stop

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ route('dashboard.view') }}">الرئيسية</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('pages.view') }}">الصفحات الثابتة</a>
            <i class="fa fa-angle-right"></i>
            </i>
        </li>
        <li>
            <span>إدارة الصفحات الثابتة</span>
        </li>
    </ul>
@stop

@section('page-title')
    <h1 class="page-title"> الصفحات الثابتة
        <small>إدارة الصفحات الثابتة</small>
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
                        <label class="col-md-3 control-label">الإسم</label>
                        <div class="col-md-6">
                            <input type="text" name="title" id="title" class="form-control searchable" placeholder="الإسم">
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
                        <i class="icon-layers"></i>إدارة الصفحات الثابتة</div>
                </div>
                <div class="portlet-body">
                    @include('admin.layout.error')
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="pages_table">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> الإسم </th>
                            <th> الحالة </th>
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
            var oTable = $('#pages_table').DataTable({
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
                    url: "{{ route('pages.list') }}",
                    data: function (d) {
                        d.title = $('input[name="title"]').val();
                    }
                },
                "order": [[1, 'asc']],
                "columnDefs": [{
                    "targets": "_all",
                    "defaultContent": ""
                }],
                "columns": [
                    {"data": "", "title": "#", "orderable": false, "searchable": false},
                    {
                        "data": "title",
                        "title": "الإسم",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "data": "status",
                        "title": "الحالة",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "data": "actions",
                        "title": "تعديل",
                        "orderable": false,
                        "searchable": false
                    }
                ],
                "fnDrawCallback": function (oSettings) {
                    $('.tooltips').tooltip();

                    oTable.column(0).nodes().each(function (cell, i) {
                        cell.innerHTML = (parseInt(oTable.page.info().start)) + i + 1;
                    });
                }
            });

            $('.searchable').on('input',function (e) {
                e.preventDefault();
                oTable.draw();
            });

            $('button[type="reset"]').on('click', function (e) {
                e.preventDefault();
                $(this).closest('form').get(0).reset();
                oTable.draw();
            });

            $(document).on('click', ".status", function() {
                var id = $(this).data('href');
                var item = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('pages.status') }}",
                    data: {'id' : id}
                }).success(function (data) {
                    if(data.type == 'yes')
                    {
                        item.removeClass("red");
                        item.addClass("green-dark");
                        item.html('<i class="fa fa-check"></i> تفعيل');
                    }
                    else if(data.type == 'no')
                    {
                        item.removeClass("green-dark");
                        item.addClass("red");
                        item.html('<i class="fa fa-times"></i> تعطيل ');
                    }
                    toastr[data.status](data.message);
                });
            });
            ///////////////////////////////////////////////////
        });
    </script>
@stop

@section('modals')
    @include('admin.layout.ajax')
@stop
