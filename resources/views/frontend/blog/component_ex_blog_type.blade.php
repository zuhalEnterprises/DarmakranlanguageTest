<table class="table table-bordered table-striped table-hover shadow-sm">
    <thead class="table-primary">
        <tr>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('شناسه')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('تصویر')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('دسته بندی')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('عنوان')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('تاریخ انتشار')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('آشکار')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col"> {{l('ابزار')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($model as $item)
        <tr>

            <td valign="middle" align="center">{{$item->id}}</td>
            <th valign="middle" scope="row" style="width:100px">
                @if($item->image)
                <img class="w-100 object-cover rounded-1 table-pic" src="{{crop($item->img() , 150,150)}}" alt="{{$item->title}}">
                @endif
            </th>
            <td valign="middle" align="center">{{($item->category) ? $item->category->name : ''}}</td>
            <td valign="middle" align="center">{{$item->title}}</td>
            <td valign="middle" align="center">
                {{toPersianDate($item->created_at)}}
            </td>
            <td valign="middle" align="center">
                @if($item->active == 1)
                <i class="fi-check me-2 text-success"></i>
                @endif
            </td>

            <td valign="middle" align="center">
                <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fi-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                    @if($item->category_id > 1 || 1)
                    <li>
                        <a class="dropdown-item" target="_blank" style="cursor: pointer" onclick="setVisible({{$item->id}})">
                            <i class="fa-light fa-eye opacity-60 me-2"></i>{{$item->{{ l('active == 1 ? l(\'پنهان کردن\'):l(\'آشکار کردن\')}}') }}
                        </a>
                    </li>
                    @endif
                    <li>
                        <a class="dropdown-item" target="_blank" href="{{$item->url()}}">
                            <i class="fa-light fa-eye opacity-60 me-2"></i>{{l('مشاهده')}} </a>
                    </li>
                    <li>
                        <a class="dropdown-item" target="_blank" href="/profile/posts/edit/{{$item->id}}">
                            <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                            {{l('ویرایش')}}
                        </a>
                    </li>
                    @if($item->category_id > 1 || 1)
                    <li>
                        <a class="dropdown-item" style="cursor:pointer"  onclick="return confirm('{{l('آیا از حذف این مطلب مطمئن هستید؟')}}');" href="/profile/posts/destroy/{{$item->id}}">
                            <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                            {{l('حذف')}}
                        </a>
                    </li>
                    @endif
                </ul>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
