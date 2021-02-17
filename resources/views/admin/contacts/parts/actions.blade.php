<div class="btn-group">
    <button class="btn btn-sm {{ $btn_class }} dropdown-toggle" type="button"
            data-toggle="dropdown" aria-expanded="false"> أداوات
        <i class="fa fa-angle-down"></i>
    </button>
    <ul class="dropdown-menu pull-left" role="menu">
        @can('admin.contact.reply')
        <li>
            <a href="{{ route('contacts.reply',[ 'id' => Crypt::encrypt($id)]) }}">
                <i class="fa fa-pencil"></i> عرض الرسالة </a>
        </li>
        @endcan
        @can('admin.contact.delete')
        <li>
            <a href="#confirm" data-href="{{ Crypt::encrypt($id) }}" data-toggle="modal">
                <i class="fa fa-trash-o"></i> حذف </a>
        </li>
        @endcan
    </ul>
</div>