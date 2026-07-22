<style>
    .help-table-color{
        display: block;
        width: 20px;
        height: 20px;
        background-color: red;
        border-radius: 100px;
    }

    .table-p{
  max-height:600px;
  overflow:auto;
}
 thead tr:nth-child(1) th{
    position: sticky;
    top: 0;
    z-index: 10;
  }
  .table-pic {
    height: 45px;
}
@media (min-width:996px) {
    .table-pic {
    height: 75px;
}
}
</style>


<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <p class="m-0">
            <b> {{l('تعداد نتایج')}}:  </b>
        {{$totalCount}} {{l('ملک')}}
        </p>

    </div>
</div>
<div class="my-3 table-responsive table-p">

    <!--div class="Annonce" style="background-color:#B8B9AC"></div>
    <div class="AnnonceTitle">{{ l('در انتظار تایید') }}</div-->
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th valign="middle" class="header" style="text-align:center" scope="col">#</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('کد')}}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('مالک')}}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('وضعیت')}}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('نوع')}} </th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('آدرس')}}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('مساحت')}}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('اتاق')}}</th>

                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('ایام پیک') }}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('وسط هفته') }}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col"> {{l('ابزار')}}</th>
            </tr>
        </thead>
        <tbody>

            @foreach($estates as $estate)
            <tr>
                <th valign="middle" scope="row"  >
                    <a class="d-block " href="/room/{{$estate->id}}" target="_blank" style="width:100px;height:85px">
                         <img class="w-100 object-cover rounded-1 h-100 " src="{{$estate->coverImage()}}"
                            alt="real estate" />
                    </a>
                </th>

                <td valign="middle" align="center">
                    <a class="text-body text-decoration-none" href="/room/{{$estate->id}}" target="_blank">
                        {{$estate->id}}
                    </a>
                </td>
                <td valign="middle" align="center">
                    <a class="text-body text-decoration-none" href="/room/{{$estate->id}}" target="_blank">
                        @if($estate->expert !== null && $estate->expert->fullname() !== null)
                        {{$estate->expert->fullname()}}
                        <br><br>
                        <a href="tel:{{$estate->expert->username}}">{{$estate->expert->username}}</a>
                        @endif
                    </a>
                </td>

                <td valign="middle" align="center"><a class="{{$estate->confirmation}} text-body text-decoration-none" href="/room/{{$estate->id}}" target="_blank">{{confirmStatuses($estate->confirmation)}}</a> </td>
                <td valign="middle" align="center"><a class="text-body text-decoration-none" href="/room/{{$estate->id}}" target="_blank">{{estateTypes($estate->estate_type)}}</a> </td>
                <td valign="middle" align="center"><a class="text-body text-decoration-none" href="/room/{{$estate->id}}" target="_blank">
                    {{$estate->city->name??""}}
                    {{!empty($estate->address)?" - ".$estate->address:""}}
                </a> </td>
                <td valign="middle" align="center"><a class="text-body text-decoration-none" href="/room/{{$estate->id}}" target="_blank">{{!empty($estate->area)?$estate->area:""}}</a></td>
                <td valign="middle" align="center"><a class="text-body text-decoration-none" href="/room/{{$estate->id}}" target="_blank">{{!empty($estate->room_count)?($fieldList['room_count'][$estate->room_count] != l('بدون اتاق') ? $fieldList['room_count'][$estate->{{ l('room_count] : l(\'بدون اتاق\')):""}}') }}</a></td>

                <td valign="middle" align="center">
                    <a class="text-body text-decoration-none" href="/room/{{$estate->id}}" target="_blank">
                    {{ toPersianNumbers($estate->mortgage) }}
                    </a>
                </td>
                <td valign="middle" align="center">
                    <a class="text-body text-decoration-none" href="/room/{{$estate->id}}" target="_blank">
                        {{ toPersianNumbers($estate->rent) }}
                    </a>
                </td>

                <td valign="middle" align="center">
                    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fi-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                        <li>
                            <a class="dropdown-item" target="_blank" href="/room/{{$estate->id}}">
                                <i class="fa-light fa-eye opacity-60 me-2"></i>{{l('مشاهده جزئیات')}}
                            </a>
                        </li>
                            @if($currentUser->isAdmin() || ($estate->expert_id == Auth::user()->id))

                            <li>
                                <a class="dropdown-item"  target="_blank" href="/rental/estate/{{$estate->id}}/edit" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                    <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                    {{l('ویرایش ملک')}}
                                </a>
                            </li>
                            @if($estate->confirmation == 'verified')
                            <li>
                                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm('{{l('آیا از آرشیو کردن این ملک مطمئن هستید؟')}}'))archived({{$estate->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                    {{l('آرشیو کردن ملک')}}
                                </a>
                            </li>
                            @else
                            <li>
                                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm('{{l('آیا از جاری شدن این ملک مطمئن هستید؟')}}'))verified({{$estate->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                    {{l('جاری کردن ملک')}}
                                </a>
                            </li>
                            @endif
                        @endif
                        @if($currentUser->isAdmin())
                        <li>
                            <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm('{{l('آیا از حذف این ملک مطمئن هستید؟')}}'))destroy({{$estate->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                {{l('حذف ملک')}}
                            </a>
                        </li>
                        @endif

                        @if($currentUser && $currentUser->isAdmin() && $estate->visibility == 0)
                        <li>
                            <a class="dropdown-item" style="cursor:pointer" onclick="setVisible({{$estate->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                {{l('تائید ملک')}}
                            </a>
                        </li>
                        @endif
                    </ul>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>



<style>
    .clickable-row{cursor: pointer}
    .table > :not(caption) > * > * {
        padding: 0.4rem

      }
</style>

