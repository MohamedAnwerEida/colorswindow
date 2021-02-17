@if($sidebar == 0)
<a data-href="{{ Crypt::encrypt($id) }}" class="btn btn-sm red @can('admin.news.publish') sidebar @endcan">
    <i class="fa fa-times"></i> تثبيت
</a>
@elseif($sidebar == 1)
<a data-href="{{ Crypt::encrypt($id) }}" class="btn btn-sm green-dark @can('admin.news.publish') sidebar @endcan">
    <i class="fa fa-check"></i>  الغاء الثبيت
</a>
@endif