<div class="btn-group">
    <button class="btn btn-sm {{ $btn_class }} dropdown-toggle" type="button"
            data-toggle="dropdown" aria-expanded="false"> أداوات
        <i class="fa fa-angle-down"></i>
    </button>
    <ul class="dropdown-menu pull-left" role="menu">
        @can('admin.coupons.edit')
        <li>
            <a href="{{ route('coupons.edit',[ 'id' => Crypt::encrypt($id)]) }}">
                <i class="fa fa-pencil"></i> تعديل </a>
        </li>
        @endcan
        @can('admin.coupons.uses')
        <li>
            <a href="{{ route('coupons.uses',[ 'id' => Crypt::encrypt($id)]) }}">
                <i class="fa fa-pencil"></i> تقرير الاستخدام </a>
        </li>
        @endcan
        @can('admin.coupons.delete')
        <li class="divider"></li>
        <li>
            <a href="#confirm" data-href="{{ Crypt::encrypt($id) }}" data-toggle="modal">
                <i class="fa fa-trash-o"></i> حذف </a>
        </li>
        @endcan
    </ul>
</div>