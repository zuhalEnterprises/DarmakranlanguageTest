@foreach($estates as $estate)
<!-- Item-->
    <div class="card card-hover card-horizontal border-0 shadow-lg mb-4">
        <a class="card-img-top" href="{{$estate->url()}}" style="background-image: url({{$estate->coverImage()}});">
            <div class="position-absolute start-0 top-0 pt-3 pe-3">
                <span class="d-table badge bg-success">
                    {{toPersianDate($estate->showdate)}}
                </span>
            </div>
            <div class="position-absolute start-0 bottom-0 pb-3 ps-3">

                @if($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')))
                @if($estate->haveExpert())
                    <img class="rounded-circle w-100 hadow-lg" style="width:50px;height:50px;border:1px solid #fff" src="http://localhost:8000/upload/images/profile/64e23fdbca5cb.png" alt=" mahmood vaezi">


                @endif
                @endif
            </div>
        </a>
        <div class="card-body position-relative pb-3">
            <div class="dropdown position-absolute zindex-5 top-0 end-0 mt-3 me-3">
                <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fi-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                    <li>
                        <a class="dropdown-item" target="_blank" href="{{$estate->url()}}">
                            <i class="fa-light fa-eye opacity-60 me-2"></i>{{l('مشاهده جزئیات')}}
                        </a>
                    </li>
                    @if(
                        $estate->user_id == Auth::user()->id ||
                        $estate->percent_expert == 0 ||
                        $currentUser->isAdmin() ||
                        ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && $currentUser->id == $estate->expert_id) ||
                        ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s')))
                        )
                        @if($estate->confirmation == 'verified')
                        <li>
                            <a class="dropdown-item"  target="_blank" href="/estates/{{$estate->id}}/edit" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                {{l('ویرایش ملک')}}
                            </a>
                        </li>
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
                    @if($currentUser && $currentUser->isExpert() && $estate->confirmation == 'verified')
                    <li>
                        <a class="dropdown-item" style="cursor:pointer" onclick="ladder({{$estate->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                            {{l('نردبان')}}
                        </a>
                    </li>
                    @endif
                    @if($currentUser && $currentUser->isAdmin())

                    @if($estate->visibility == 0)
                    <li>
                        <a class="dropdown-item" style="cursor:pointer" onclick="setVisible({{$estate->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                            <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                            {{l('تائید ملک')}}
                        </a>
                    </li>
                    @endif
                    @endif
                </ul>
            </div>
            <h6 class="mb-1 fw-normal  text-primary">

            </h6>
            <div class="row">
                <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-1">
                    <span class="">{{l('کد')}}:</span>
                    <h6 class="">
                        <a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">
                            @php
                                $classname = '';
                            @endphp
                            @if(ss('SITE_ID')==3 && $estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')))
                                @if($estate->percent_expert == 50)
                                    @php
                                        $classname = 'lable-gold';
                                    @endphp
                                @endif
                                @if($estate->percent_expert == ((ss('SITE_ID') == 5)?10:20))
                                    @php
                                        $classname = 'lable-silver';
                                    @endphp
                                @endif
                                @if($estate->percent_expert == 25 && ss('SITE_ID') == 5)
                                    @php
                                        $classname = 'lable-bronze';
                                    @endphp
                                @endif
                            @endif
                            <h6 class="">
                            {{$estate->id}}
                            </h6>
                        </a>
                    </h6>
                </div>
                <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-1">
                    <span class="">{{l('نوع معامله')}}:</span>
                    <h6 class="">
                        {{$estate->{{ l('type==1?l(\'فروش\'):l(\'رهن و اجاره\')}}') }}
                    </h6>
                </div>
                <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-1">
                    <span class="">{{l('نوع ملک')}}:</span>
                    <h6 class="">
                        {{estateTypes($estate->estate_type)}}
                    </h6>
                </div>
                <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-1">
                    <span class="">{{l('وضعیت')}}:</span>
                    <h6 class="">
                        {{l(confirmStatuses($estate->confirmation))}}
                    </h6>
                </div>

            </div>


            <div class="row">
                @if($estate->type == 1)
                <div class="col-6 col-md-6 col-lg-6 col-sm-6 mt-1">
                    <span class="">
                        <i class="fi-cash  me-1 mt-n1 fs-lg text-muted"></i>
                        {{l('قیمت')}}:</span>
                    <h6 class="">
                        {{toPersianNumbers($estate->price)}} {{l('تومان')}}
                    </h6>
                </div>

                @else
                @endif
                @if($estate->type == 2)
                <div class="col-6 col-md-6 col-lg-6 col-sm-6 mt-1">
                    <span class="">
                        <i class="fi-cash  me-1 mt-n1 fs-lg text-muted"></i>{{l('اجاره')}}:
                    </span>
                    <h6 class="">
                        {{toPersianNumbers($estate->rent)}} {{l('تومان')}}
                        @php
                        switch($estate->rentfrequency)
                        {
                            case "1": $rentfrequency = ' /Daily'; break;
                            case "7": $rentfrequency = ' /Weekly'; break;
                            case "30": $rentfrequency = ' /Montly'; break;
                            case "365": $rentfrequency = ' /Yearly'; break;
                            default: $rentfrequency = '';
                        }
                        echo $rentfrequency;
                        @endphp

                    </h6>
                </div>
                @else

                @endif
                <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-1">
                    <span class="">
                        <i class="fa-thin fa-ruler-horizontal me-1 mt-n1 fs-lg text-muted"></i> {{l('مساحت')}}:
                    </span>
                    <h6 class="">
                        {{$estate->area}} sqrt
                    </h6>
                </div>
                <div class="col-6 col-md-6 col-lg-3 col-sm-6 mt-1">
                    <span class="">
                        <i class="fa-thin fi-bed me-1 mt-n1 fs-lg text-muted"></i> {{l('اتاق')}}:
                    </span>
                    <h6 class="">
                        10
                    </h6>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-sm-12 mt-1">
                    <h6>
                        <span style="font-weight: normal">
                        Address:
                        </span>
                    {{$estate->city->name??""}} - {{$estate->district->name??""}}
                    {{!empty($estate->street)?" - ".$estate->street->name:""}}
                    {{!empty($estate->address)?" - ".$estate->address:""}}
                    {{$estate->buildingname != ''? l("- مجتمع:").$estate->buildingname:''}}
                    </h6>
                </div>
            </div>
            <div class="border-top pt-3 pb-2 mt-1 ">
                @if($currentUser && $currentUser->isExpert())
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-8 col-sm-12 mt-1">

                        <i class="fa-thin fi-user me-1 mt-n1 fs-lg text-muted"></i>
                        {{l('مالک')}}:
                        @if($currentUser->isAdmin() ||
                        $estate->percent_expert == 0 ||
                        ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert < date('Y-m-d H:i:s')) && ($currentUser->id == $estate->expert_id  ||  (ss('SITE_ID') == 5 && ($estate->percent_expert != 50 ||  $estate->created_at < date("Y-m-d", strtotime("-4 months")) ||  $estate->expiretime_expert <=  date("Y-m-d H:i:s", strtotime("+4 month", strtotime($estate->created_at)))   ) ))) ||
                        ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s')))
                        )
                        {{$estate->owner_name}}

                        @endif
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 col-sm-12 mt-1">

                        @if($currentUser->isAdmin() ||
                        $estate->percent_expert == 0 ||
                        ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert < date('Y-m-d H:i:s')) && ($currentUser->id == $estate->expert_id  ||  (ss('SITE_ID') == 5 && ($estate->percent_expert != 50 ||  $estate->created_at < date("Y-m-d", strtotime("-4 months")) ||  $estate->expiretime_expert <=  date("Y-m-d H:i:s", strtotime("+4 month", strtotime($estate->created_at)))   ) ))) ||
                        ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s')))
                        )

                        <i class="fa-thin fi-phone me-1 mt-n1 fs-lg text-muted"></i>{{$estate->phone}}
                        @endif

                    </div>
                </div>



                @endif

            </div>
        </div>
    </div>
@endforeach

