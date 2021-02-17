@extends('admin.layout.master')

@section('title')
إدارة العملاء
@stop

@section('page-breadcrumb')
<ul class="page-breadcrumb">
    <li>
        <i class="icon-home"></i>
        <a href="{{ route('dashboard.view') }}">الرئيسية</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <a href="{{ route('customers.view') }}">العملاء</a>
        <i class="fa fa-angle-left"></i>
        </i>
    </li>
    <li>
        <span>إدارة العملاء</span>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title">العملاء
    <small>إدارة العملاء</small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-magnifier"></i>البحث  </div>
    </div>
    <div class="portlet-body">
        <form role="form" method="post" id="add_user" class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-1 control-label">اسم الزبون</label>
                    <div class="col-md-2">
                        <input type="text" name="name" id="news" class="form-control searchable" placeholder="اسم الزبون">
                    </div>
                    <?php /*
                      <label class="col-md-1 control-label">تاريخ الطلب</label>
                      <div class="col-md-2">
                      <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                      <input type="text" class="form-control searchable" id="order_date" name="order_date" value="{{ old('first_installment_date') }}">
                      <span class="input-group-btn">
                      <button class="btn default" type="button">
                      <i class="fa fa-calendar"></i>
                      </button>
                      </span>
                      </div>
                      </div>
                      <label class="col-md-1 control-label">المجموع</label>
                      <div class="col-md-1">
                      <input type="text" name="total" id="total" class="form-control searchable" placeholder="المجموع">
                      </div>

                      <label class="col-md-1 control-label">الحالة</label>
                      <div class="col-md-1">
                      <select id="status" name="status"  class="form-control">
                      <option value="-1">الكل</option>
                      @foreach($order_status as $item)
                      <option value="{{ $item->id}}">{{ $item->name}}</option>
                      @endforeach
                      </select>
                      </div>
                      <label class="col-md-1 control-label">طريقة الدفع</label>
                      <div class="col-md-1">
                      <select id="pay" name="pay"  class="form-control searchable">
                      <option value="-1">الكل</option>
                      @foreach($order_pay as $item)
                      <option value="{{ $item->id}}">{{ $item->name}}</option>
                      @endforeach
                      </select>
                      </div> */ ?>
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
                    <i class="icon-grid"></i>إدارة العملاء</div>
            </div>
            <div class="portlet-body">
                @include('admin.layout.error')
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="categories_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم الزبون</th>
                            <th>الاوامر</th>
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
    .date-field {
        direction: ltr;
        text-align: center;
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
//        $('#confirm').on('show.bs.modal', function (e) {
//            $("#delete_id").val($(e.relatedTarget).data('href'));
//        });
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
                url: "{{ route('customers.list') }}",
                data: function (d) {
                    d.name = $('input[name="name"]').val();
                    d.status = $("#status").val();
                    d.pay = $("#pay").val();
                    d.order_date = $("#order_date").val();
                    d.total = $("#total").val();
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
                    "data": "name",
                    "title": "اسم الزبون",
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
//        $('#status').on('click', function (e) {
//            e.preventDefault();
//            oTable.draw();
//        });


        $("#add_user").submit(function (e) {
            e.preventDefault();
        });
<?php
/*
  $('.date-picker').datepicker();
  $(document).on('click', ".delete", function () {
  var id = $("#delete_id").val();
  $.ajax({
  type: "POST",
  url: "{{ route('customers.delete') }}",
  data: {'id': id}
  }).success(function (data) {
  toastr[data.status](data.message);
  oTable.draw();
  });
  });
 */
?>
    });
</script>
@stop
