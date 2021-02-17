@extends('admin.layout.master')

@section('title')
    إدارة السلايدر
@stop

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ route('dashboard.view') }}">الرئيسية</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('slider.view') }}">السلايدر</a>
            <i class="fa fa-angle-right"></i>
            </i>
        </li>
        <li>
            <span>إدارة السلايدر</span>
        </li>
    </ul>
@stop

@section('page-title')
    <h1 class="page-title">السلايدر
        <small>إدارة السلايدر</small>
    </h1>
@stop

@section('page-content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box {{ $form_class }}">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-grid"></i>إدارة السلايدر</div>
                        <div class="actions">
                            <a href="{{ route('slider.add') }}" class="btn btn-default btn-sm">
                                <i class="fa fa-plus"></i> إضافة </a>
                        </div>
                </div>
                <div class="portlet-body">
                    @include('admin.layout.error')
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="categories_table">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> الصورة </th>
                            <th> الرابط </th>
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
                    url: "{{ route('slider.list') }}",
                    data: function (d) {
                        d.title = $('input[name="name"]').val();
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
                        "data": "photo",
                        "title": "الصورة",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        "data": "url",
                        "title": "الرابط",
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

            $('.searchable').on('input', function (e) {
                e.preventDefault();
                oTable.draw();
            });

            $('button[type="reset"]').on('click', function (e) {
                e.preventDefault();
                $(this).closest('form').get(0).reset();
                oTable.draw();
            });

           
            ///////////////////////////////////////////////////
            $(document).on('click', ".delete", function () {
                var id = $("#delete_id").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('slider.delete') }}",
                    data: {'id': id}
                }).success(function (data) {
                    toastr[data.status](data.message);
                    oTable.draw();
                });
            });
        });
    </script>
@stop
