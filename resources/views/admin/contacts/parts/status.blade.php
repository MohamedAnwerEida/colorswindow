@if($status == 0)
    <a data-href="{{ Crypt::encrypt($id) }}" class="btn btn-sm red @can('admin.contact.status') status @endcan">
        <i class="fa fa-times"></i>  غير مقروءة
    </a>
@elseif($status == 1)
    <a data-href="{{ Crypt::encrypt($id) }}" class="btn btn-sm green-dark @can('admin.contact.status') status @endcan">
        <i class="fa fa-check"></i> مقروءة
    </a>
@endif