<div class="btn-group">
    <button class="btn btn-sm {{ $btn_class }} dropdown-toggle" type="button"
            data-toggle="dropdown" aria-expanded="false"> أداوات
        <i class="fa fa-angle-down"></i>
    </button>
    <ul class="dropdown-menu pull-left" role="menu">
        @can('admin.orders.edit')
        <li>
            <a href="{{ route('orders.edit',[ 'id' => Crypt::encrypt($id)]) }}">
                <i class="fa fa-pencil"></i> عرض التفاصيل </a>
        </li>
        @endcan
        @can('admin.orders.invoice')
        <li>
            <a href="{{ route('orders.invoice',[ 'id' => Crypt::encrypt($id)]) }}" target="_blank">
                <i class="fa fa-newspaper-o"></i> عرض الفاتورة </a>
        </li>
        @endcan
        @can('admin.orders.delete')
        <li class="divider"></li>
        <li>
            <a href="#confirm" data-href="{{ Crypt::encrypt($id) }}" data-toggle="modal">
                <i class="fa fa-trash-o"></i> حذف </a>
        </li>
        @endcan
    </ul>
</div>