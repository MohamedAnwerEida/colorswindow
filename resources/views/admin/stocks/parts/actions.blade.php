<div class="btn-group">
    <button class="btn btn-sm {{ $btn_class }} dropdown-toggle" type="button"
            data-toggle="dropdown" aria-expanded="false"> أداوات
        <i class="fa fa-angle-down"></i>
    </button>
    <ul class="dropdown-menu pull-left" role="menu">
        @can('admin.stocks.edit')
        <li>
            <a href="{{ route('stocks.edit',[ 'id' => Crypt::encrypt($id)]) }}">
                <i class="fa fa-pencil"></i> اضافة رصيد  </a>
        </li>
        @endcan
    </ul>
</div>