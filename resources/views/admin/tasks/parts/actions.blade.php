<div class="btn-group">
    <button class="btn btn-sm {{ $btn_class }} dropdown-toggle" type="button"
            data-toggle="dropdown" aria-expanded="false"> أداوات
        <i class="fa fa-angle-down"></i>
    </button>
    <ul class="dropdown-menu pull-left" role="menu">
        @can('admin.tasks.edit')
        <li>
            <a href="{{ route('tasks.edit',[ 'id' => Crypt::encrypt($id)]) }}">
                <i class="fa fa-pencil"></i> تعديل المهمة  </a>
        </li>
        @endcan
        @can('admin.tasks.reopen')
        @if(($user->user_type==0 || $user->user_type==1) && $role->role_order!=1 && $order_task_dep>0)
        <li>
            <a href="{{ route('tasks.reopen',[ 'id' => Crypt::encrypt($id)]) }}">
                <i class="fa fa-pencil"></i> اعادة المهمة  
            </a>
        </li>
        @endif
        @endcan
        @can('admin.tasks.transfer')
        @if(($user->user_type==0 || $user->user_type==1) && $role->role_order!=4 && $order_task_dep>0)
        <li>
            <a href="{{ route('tasks.transfer',[ 'id' => Crypt::encrypt($id)]) }}">
                <i class="fa fa-pencil"></i> ترحيل المهمة  
            </a>
        </li>
        @endif
        @endcan
    </ul>
</div>