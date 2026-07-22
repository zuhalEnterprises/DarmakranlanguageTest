<table class="table table-bordered table-striped table-hover">
    <thead class="table-primary">
        <tr>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('شناسه')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('نام')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('کد مقاله')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('سازنده')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col"> {{l('ابزار')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach( $model as $item)
        <tr id="{{$item->id}}">
            <td valign="middle" align="center">{{$item->id}}</td>
            <td valign="middle" align="center">
                {{$item->name}}
            </td>
            <td valign="middle" align="center">
                <span class="badge bg-danger">
                    {{$item->post_id}}
                </span>
            </td>
            <td valign="middle" align="center">
                {{$item->manufacturer ? $item->manufacturer->name : ''}}
            </td>

            <td valign="middle" align="center">
                <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fi-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                    <li>
                        <a class="dropdown-item"  href="/profile/project/edit/{{$item->id}}">
                            <i class="fa-light fa-edit opacity-60 me-2"></i> {{l('ویرایش')}}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item del" href="javascript:void(0)" onclick="deleteTodoItem({{$item->id}})">
                            <i class="fa-light fa-trash-can opacity-60 me-2"></i> {{l('حذف')}}
                        </a>
                    </li>
                </ul>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
