<table class="table table-bordered table-striped table-hover">
    <thead class="table-primary">
        <tr>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('شناسه')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('نام محله')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('نام لاتین')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('شهر')}}</th>
            @if(env('COUNTRY') != 'UAE')
            <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('منطقه شهری') }}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('روستا') }}</th>
            @endif
            <th valign="middle" class="header" style="text-align:center" scope="col"> {{l('ابزار')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach( $model as $item)

            <td valign="middle" align="center">
                {{$item->id}}
            </td>
            <td valign="middle" align="center">
                {{$item->getOriginalName()}}
            </td>
            <td valign="middle" align="center">
                <span class="badge bg-danger">
                    {{$item->getOriginalNameEn()}}
                </span>
            </td>
            <td valign="middle" align="center">
                {{$item->city != null ? $item->city->name : ''}}
            </td>
            @if(env('COUNTRY') != 'UAE')
            <td valign="middle" align="center">
                {{$item->area}}
            </td>
            <td valign="middle" align="center">
                @if($item->village == 1)
                    <i class="fi-check text-success me-2"></i>
                @endif
            </td>
            @endif
            <td valign="middle" align="center">
                <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fi-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                    <li>
                        <a class="dropdown-item"  href="/profile/district/edit/{{$item->id}}">
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
