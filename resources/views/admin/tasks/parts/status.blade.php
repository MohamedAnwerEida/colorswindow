@if($task_status == 0)
<a data-href="{{ Crypt::encrypt($id) }}" class="btn btn-sm red @can('admin.tasks.status') status @endcan">
    <i class="fa fa-times"></i>  مفتوحة
</a>
@elseif($task_status == 1)
<a data-href="{{ Crypt::encrypt($id) }}" class="btn btn-sm green-dark @can('admin.tasks.status') status @endcan">
    <i class="fa fa-check"></i> اكتملت
</a>
@endif