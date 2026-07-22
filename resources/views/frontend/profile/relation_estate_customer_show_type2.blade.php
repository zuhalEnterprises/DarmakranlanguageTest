
<style>
    .sortable{
        /* color:blue !important; */
        cursor: pointer
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
    .lable-gold{
        background-color: #ffdd05;
    }
    .lable-silver{
        background-color: #9d9d9d;
    }
    .lable-bronze{
        background-color: #f1b478;
    }
    @media (min-width:996px) {
        .table-pic {
        height: 75px;
        }
    }
    .table > :not(caption) > * > * {
        padding: 0.1rem;
    }
</style>

<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <p class="m-0">
            <b>{{l('نتایج جستجو')}}:  </b>
            {{$totalCount}}
        </p>
        @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2)
        |
        <p class="m-0">
            {{l('تعداد کل املاک متناسب')}}:
             <b>{{$reports['total']}}</b>
             &nbsp;|&nbsp;
             {{l('املاک تائید شده')}}:
            <b>{{$reports[2]}}</b>
            &nbsp;|&nbsp;
            {{l('املاک رد شده')}}:
            <b>{{$reports[1]}}</b>
            &nbsp;|&nbsp;
            {{l('املاک ارسال شده')}}:
            <b>{{$reports[3]}}</b>
            &nbsp;|&nbsp;
            {{l('املاک نامشخص')}}:
             <b>{{$reports[0]}}</b>
        </p>
        @endif
    </div>
</div>
<div class="my-3 table-responsive table-p">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th class="text-center" scope="col"> {{l('ابزار')}}</th>
                <th scope="col">#</th>
                <th class="text-center" scope="col"> {{l('کد ملک')}} </th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('مالک')}}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('مشاور')}}

                </th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('نوع ملک')}}</th>
                @if(env('COUNTRY') != 'UAE')
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('آدرس')}}</th>
                @endif
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('مساحت')}}</th>

                @if($type==1)
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('قیمت')}}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('قیمت متری')}}</th>
                @endif
                @if($type==2)
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('رهن')}}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('اجاره')}}</th>
                @endif
                <th valign="middle" class="header" style="text-align:center" scope="col">{{l('وضعیت')}}</th>
                <th scope="col" class="sortable text-center"> {{l('اولویت')}} </th>

            </tr>
        </thead>
        <tbody>

            @foreach($relationEstateCustomer as $relEstateCustomer)

            @if($relEstateCustomer->estate != null)
            <tr id="tr{{$relEstateCustomer->id}}">
                <td valign="middle" class="text-center" style="width: 50px">

                    @if($relEstateCustomer->status != 3)
                    @if(ss('SITE_ID') == 5)

                        <div>
                            <a class="dropdown-item"  onclick="confirmm({{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                {{l('تائید')}}
                            </a>
                        </div>
                        <div>
                            <a class="dropdown-item"  onclick="reject({{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                {{l('رد')}}
                            </a>
                        </div>

                    @else
                    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fi-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                        <li>
                            <a class="dropdown-item"  onclick="confirmm({{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                {{l('تائید')}}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item"  onclick="reject({{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                {{l('رد')}}
                            </a>
                        </li>

                        <!--li>
                            <a class="dropdown-item"  onclick="priority(1 , {{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                {{l('انتقال به اولویت اول')}}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"  onclick="priority(2 , {{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                {{l('انتقال به اولویت دوم')}}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item"  onclick="priority(3 , {{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                {{l('انتقال به اولویت سوم')}}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item"  onclick="priority(4 , {{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                {{l('انتقال به اولویت چهارم')}}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item"  onclick="priority(5 , {{$relEstateCustomer->id}})" href="javascript:void(0)" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                {{l('انتقال به اولویت پنجم')}}
                            </a>
                        </li-->
                    </ul>
                    @endif
                    @endif
                </td>
                <th valign="middle" scope="row"  >

                    <a class="d-block " style="width:100px;height:80px;" href={{$relEstateCustomer->estate_id}}" target="_blank">
                         <img class="w-100 object-cover rounded-1 " src="{{$relEstateCustomer->estate != null  ? $relEstateCustomer->estate->coverImage() : ''}}"
                            alt="real estate" />
                    </a>
                </th>
                <td valign="middle" align="center"  style="width: 50px" class="text-center">
                    @if($relEstateCustomer->estate_id>0 && $relEstateCustomer->estate != null)
                    <a href={{$relEstateCustomer->estate->url()}}" target="_blank">

                        <span class="rounded-circle d-block" style="width: 50px;height:50px;padding-top:15px;color:#000">
                        {{$relEstateCustomer->estate_id}}
                        </span>
                    </a>
                    @else
                    -
                    @endif
                </td>

                <td valign="middle" align="center">
                    <a class="text-body text-decoration-none" href="{{$relEstateCustomer->estate->url()}}" target="_blank">
                        @if($currentUser->isAdmin() ||
                        ($relEstateCustomer->estate->expert_id>0 && $relEstateCustomer->estate->expert && $relEstateCustomer->estate->expert->isExpert() && ($relEstateCustomer->estate->expiretime_expert == null || $relEstateCustomer->estate->expiretime_expert > date('Y-m-d H:i:s')) && ($currentUser->id == $relEstateCustomer->estate->expert_id  ||  (ss('SITE_ID') == 5 && $relEstateCustomer->estate->percent_expert != 50 && $relEstateCustomer->estate->percent_expert != 0))) ||
                        ($relEstateCustomer->estate->expert_id == null || !$relEstateCustomer->estate->expert || !$relEstateCustomer->estate->expert->isExpert() || ($relEstateCustomer->estate->expiretime_expert != null && $relEstateCustomer->estate->expiretime_expert < date('Y-m-d H:i:s')))
                        )
                        {{$relEstateCustomer->estate->owner_name}}
                        <br><br>
                        <a href="tel:{{$relEstateCustomer->estate->phone}}">{{$relEstateCustomer->estate->phone}}</a>
                        @endif

                    </a>
                </td>
                <td valign="middle" align="center">
                    <a class="text-body text-decoration-none" href={{$relEstateCustomer->estate->url()}}" target="_blank">
                        @if($relEstateCustomer->estate->expert_id>0 && $relEstateCustomer->estate->expert && $relEstateCustomer->estate->expert->isExpert() && ($relEstateCustomer->estate->expiretime_expert == null || $relEstateCustomer->estate->expiretime_expert > date('Y-m-d H:i:s')))
                        @if(ss('SITE_ID') == 3 || $relEstateCustomer->estate->haveExpert())
                            {{$relEstateCustomer->estate->expert->fullname()}}
                        @endif
                        @endif
                    </a>
                </td>
                <td valign="middle" align="center"><a class="text-body text-decoration-none" href={{$relEstateCustomer->estate->url()}}" target="_blank">{{estateTypes($relEstateCustomer->estate->estate_type)}}</a> </td>
                @if(env('COUNTRY') != 'UAE')
                <td valign="middle" align="center"><a class="text-body text-decoration-none" href={{$relEstateCustomer->estate->url()}}" target="_blank">
                    {{$relEstateCustomer->estate->city->name??""}} - {{$relEstateCustomer->estate->district->name??""}}
                    {{!empty($relEstateCustomer->estate->street)?" - ".$relEstateCustomer->estate->street->name:""}}
                    {{!empty($relEstateCustomer->estate->address)?" - ".$relEstateCustomer->estate->address:""}}
                    {{$relEstateCustomer->estate->buildingname != ''? l("- مجتمع:").$relEstateCustomer->estate->buildingname:''}}

                </a> </td>
                @endif
                <td valign="middle" align="center"><a class="text-body text-decoration-none" href={{$relEstateCustomer->estate->url()}}" target="_blank">{{!empty($relEstateCustomer->estate->area)?$relEstateCustomer->estate->area:""}}</a></td>

                @if($type==1)
                <td valign="middle" align="center" style="width: 50px">
                    <a class="text-body text-decoration-none" href={{$relEstateCustomer->estate->url()}}" target="_blank">
                    {{ toPersianNumbers($relEstateCustomer->estate->price) }}
                    </a>
                </td>

                <td valign="middle" align="center" style="width: 50px">
                    <a class="text-body text-decoration-none" href={{$relEstateCustomer->estate->url()}}" target="_blank">
                    {{ toPersianNumbers($relEstateCustomer->estate->price_per_meter) }}
                    </a>
                </td>
                @endif
                @if($type==2)
                <td valign="middle" align="center" style="width: 50px">
                    <a class="text-body text-decoration-none" href={{$relEstateCustomer->estate->url()}}" target="_blank">
                    {{ toPersianNumbers($relEstateCustomer->estate->mortgage) }}
                    </a>
                </td>
                <td valign="middle" align="center" style="width: 50px">
                    <a class="text-body text-decoration-none" href={{$relEstateCustomer->estate->url()}}" target="_blank">
                    {{ toPersianNumbers($relEstateCustomer->estate->rent) }}
                    </a>
                </td>

                @endif
                <td valign="middle" class="text-center">
                    <span id="status{{$relEstateCustomer->id}}">
                    {{l($relEstateCustomer->strstatus())}}

                    @if($relEstateCustomer->status == 2)
                        @if($relEstateCustomer->creator_id>0)
                        ({{l('توسط مشاور')}})
                        @else
                        ({{l('توسط سیستم')}})
                        @endif
                    @endif
                    </span>
                </td>
                <td valign="middle" class="text-center" style="width: 50px">
                    <span id="priority{{$relEstateCustomer->id}}">
                    {{$relEstateCustomer->priority}}
                    </span
                </td>



            </tr>
            @endif
            @endforeach

        </tbody>

    </table>
</div>


