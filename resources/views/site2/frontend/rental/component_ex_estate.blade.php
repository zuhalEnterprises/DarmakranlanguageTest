<style>
    .help-table-color{
        display: block;
        width: 20px;
        height: 20px;
        background-color: red;
        border-radius: 100px;
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

@if($currentUser->isExpert() && ss('SITE_ID') == 3)
<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-1">
            <span class="help-table-color border lable-gold" ></span>
            <p  class="m-0">{{ l('اکتشافی 50 درصد') }}</p>
        </div>
        <div class="d-flex align-items-center gap-1">
            <span class="help-table-color border lable-silver" ></span>
            <p  class="m-0">اکتشافی {{(ss('SITE_ID') == 5)?10:20}} درصد</p>
        </div>
        @if(ss('SITE_ID') == 5)
        <div class="d-flex align-items-center gap-1">
            <span class="help-table-color border lable-bronze" ></span>
            <p  class="m-0">{{ l('اکتشافی 25 درصد') }}</p>
        </div>
        @endif
    </div>
</div>
@endif
<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <p class="m-0">
            <b>{{ l('تعداد نتایج:') }}</b>
        {{$totalCount}} ملک
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
                <th valign="middle" class="header" style="text-align:center" scope="col" class="sortable" onclick="sort('id')">
                    <div class="d-flex align-items-center gap-1">

                       <span class="d-flex flex-column">
                            <i class="fi fi-chevron-up fs-xxs"></i>
                            <i class="fi fi-chevron-down fs-xxs"></i>
                        </span>
                        <span>{{ l('کد') }}</span>
                    </div>
                </th>
                @if($currentUser && $currentUser->isExpert())
                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('مالک') }}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('مشاور') }}


                </th>
                @endif
                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('وضعیت') }}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('نوع') }}</th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('آدرس') }}</th>

                <th valign="middle" class="header" style="text-align:center" scope="col" class="sortable" onclick="sort('area')">
                    <div class="d-flex align-items-center gap-1">
                         <span class="d-flex flex-column">
                            <i class="fi fi-chevron-up fs-xxs"></i>
                            <i class="fi fi-chevron-down fs-xxs"></i>
                        </span>
                        <span>{{ l('مساحت') }}</span>
                    </div>
                </th>
                <th valign="middle" class="header" style="text-align:center" scope="col" class="sortable" onclick="sort('room_count')">
                    <div class="d-flex align-items-center gap-1">
                        <span class="d-flex flex-column">
                            <i class="fi fi-chevron-up fs-xxs"></i>
                            <i class="fi fi-chevron-down fs-xxs"></i>
                        </span>
                        <span>{{ l('اتاق') }}</span>
                    </div>
                </th>

                <th valign="middle" class="header" style="text-align:center" scope="col" id="price1" class="sortable" onclick="sort('price1')">
                    <div class="d-flex align-items-center gap-1">

                        <span class="d-flex flex-column gap-2">
                            <i class="fi fi-chevron-up fs-xxs"></i>
                            <i class="fi fi-chevron-down fs-xxs"></i>
                        </span>
                        <span>{{ l('قیمت / رهن') }}</span>
                    </div>

                </th>
                <th valign="middle" class="header" style="text-align:center" scope="col" id="price2" class="sortable" onclick="sort('price2')">
                    <div class="d-flex align-items-center gap-1">
                        <span class="d-flex flex-column">
                            <i class="fi fi-chevron-up fs-xxs"></i>
                            <i class="fi fi-chevron-down fs-xxs"></i>
                        </span>
                        <span>{{ l('متری / اجاره') }}</span>
                    </div>
                </th>


                <th valign="middle" class="header" style="text-align:center" scope="col" class="sortable" onclick="sort('showdate')">
                    <div class="d-flex align-items-center gap-1">

                        <span class="d-flex flex-column">
                            <i class="fi fi-chevron-up fs-xxs"></i>
                            <i class="fi fi-chevron-down fs-xxs"></i>
                        </span>
                        <span>{{ l('تاریخ') }}</span>
                    </div>

                </th>
                <th valign="middle" class="header" style="text-align:center" scope="col">{{ l('ابزار') }}</th>
            </tr>
        </thead>
        <tbody>

            @foreach($estates as $estate)
            <tr <?php echo $estate->urgent==1 && ss('SITE_ID') == 5 ?"style='background:#a9c5f2'":""?>>

                <th valign="middle" scope="row"  >
                    <a class="d-block " href="{{$estate->url()}}" target="_blank" style="width:100px;height:85px">
                         <img class="w-100 object-cover rounded-1 h-100 " src="{{$estate->coverImage()}}"
                            alt="real estate" />
                    </a>
                </th>

                <td valign="middle" align="center">
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
                        <span class="{{$classname}} rounded-circle d-block" style="width: 50px;height:50px;padding-top:15px;color:#000">
                        {{$estate->id}}
                        </span>
                    </a>
                </td>
                @if($currentUser && $currentUser->isExpert())
                <td valign="middle" align="center">
                    <a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">
                        @if($currentUser->isAdmin() ||
                        $estate->percent_expert == 0 ||
                        ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && ($currentUser->id == $estate->expert_id  ||  (ss('SITE_ID') == 5 && ($estate->percent_expert != 50 ||  $estate->created_at < date("Y-m-d", strtotime("-4 months"))) ))) ||
                        ($estate->expert_id == null || !$estate->expert || !$estate->expert->isExpert() || ($estate->expiretime_expert != null && $estate->expiretime_expert < date('Y-m-d H:i:s')))
                        )
                        {{$estate->owner_name}}
                        <br><br>
                        <a href="tel:{{$estate->phone}}">{{$estate->phone}}</a>
                        @endif

                    </a>
                </td>
                <td valign="middle" align="center">
                    <a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">
                        @if($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')))
                        @if($estate->haveExpert())
                            {{$estate->expert->fullname()}}

                            @if($estate->expiretime_expert != null)
                                <br> [{{toPersianDateYdm($estate->expiretime_expert)}}]
                            @endif
                        @endif
                        @endif
                    </a>
                </td>
                @endif
                <td valign="middle" align="center"><a class="{{$estate->confirmation}} text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">{{confirmStatuses($estate->confirmation)}}</a> </td>
                <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">{{estateTypes($estate->estate_type)}}</a> </td>
                <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">
                    {{$estate->city->name??""}} - {{$estate->district->name??""}}
                    {{!empty($estate->street)?" - ".$estate->street->name:""}}
                    {{!empty($estate->address)?" - ".$estate->address:""}}
                    {{$estate->buildingname != ''? l("- مجتمع:").$estate->buildingname:''}}

                </a> </td>
                <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">{{!empty($estate->area)?$estate->area:""}}</a></td>
                <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">{{!empty($estate->room_count)?($fieldList['room_count'][$estate->room_count] != l('بدون اتاق') ? $fieldList['room_count'][$estate->{{ l('room_count] : l(\'بدون اتاق\')):""}}') }}</a></td>

                @if ($estate->type == 2)
                    <td ><a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">{{ toPersianNumbers($estate->mortgage) }}</td>
                    <td ><a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">{{ toPersianNumbers($estate->rent) }}</td>
                @else
                    @if ($estate->price > 0)
                        <td valign="middle" align="center">
                            <a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">
                            {{ toPersianNumbers($estate->price) }}
                            </a>
                        </td>
                        <td valign="middle" align="center" >
                            <a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">
                            {{ toPersianNumbers($estate->price_per_meter) }}
                                </a>
                        </td>
                    @else
                        <td  valign="middle" align="center"> <a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">
                             {{ l('توافقی') }}
                        </a>
                        </td>
                        <td  valign="middle" align="center"></td>
                    @endif
                @endif
                <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">{{toPersianDate($estate->showdate)}}</a> </td>
                <td valign="middle" align="center">
                    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fi-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                        <li>
                            <a class="dropdown-item" target="_blank" href="{{$estate->url()}}">
                                <i class="fa-light fa-eye opacity-60 me-2"></i>{{ l('مشاهده جزئیات') }}
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
                                    {{ l('ویرایش ملک') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از آرشیو کردن این ملک مطمئن هستید؟')))archived({{$estate->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                    {{ l('آرشیو کردن ملک') }}
                                </a>
                            </li>
                            @else
                            <li>
                                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از جاری شدن این ملک مطمئن هستید؟')))verified({{$estate->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                    {{ l('جاری کردن ملک') }}
                                </a>
                            </li>
                            @endif
                        @endif
                        @if($currentUser->isAdmin())
                        <li>
                            <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از حذف این ملک مطمئن هستید؟')))destroy({{$estate->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                {{ l('حذف ملک') }}
                            </a>
                        </li>
                        @endif
                        @if($currentUser && $currentUser->isExpert() && $estate->confirmation == 'verified')
                        <li>
                            <a class="dropdown-item" style="cursor:pointer" onclick="ladder({{$estate->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                {{ l('نردبان') }}
                            </a>
                        </li>
                        @endif
                        @if($currentUser && $currentUser->isAdmin())
                        <li>
                            <a class="dropdown-item" style="cursor:pointer" target="_blank" href="/profile/editsEstate?estate_id={{$estate->id}}" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                {{ l('ویرایشهای گذشته') }}
                            </a>
                        </li>
                        @if($estate->visibility == 0)
                        <li>
                            <a class="dropdown-item" style="cursor:pointer" onclick="setVisible({{$estate->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                {{ l('تائید ملک') }}
                            </a>
                        </li>
                        @endif
                        @endif
                    </ul>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ l('نردبان') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>{{ l('قبل از نردبان کردن ملک مطمئن شوید هیچگونه تغییری نداشته است.') }}<br>
        {{ l('آیا با مالک در مورد تغییرات ملک هماهنگی کرده اید؟') }}
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ l('خیر') }}</button>
        <button type="button" class="btn btn-primary">{{ l('بله') }}</button>
      </div>
    </div>
  </div>
</div> -->

<script>

    @if (isset($estate) && $estate->type == 2)
    $('#price1').html('<div class="d-flex align-items-center gap-1">'+
        '<span class="d-flex flex-column">'+
            '<i class="fi fi-chevron-up fs-xxs"></i>'+
            '<i class="fi fi-chevron-down fs-xxs"></i>'+
        '</span>'+
        '<span>{{ l('قیمت رهن') }}</span>'+
    '</div>');
    $('#price2').html('<div class="d-flex align-items-center gap-1">'+
        '<span class="d-flex flex-column">'+
            '<i class="fi fi-chevron-up fs-xxs"></i>'+
            '<i class="fi fi-chevron-down fs-xxs"></i>'+
            '</span>'+
            '<span>{{ l('قیمت اجاره') }}</span>'+
            '</div>');
    @else
    $('#price1').html('<div class="d-flex align-items-center gap-1">'+
        '<span class="d-flex flex-column">'+
            '<i class="fi fi-chevron-up fs-xxs"></i>'+
            '<i class="fi fi-chevron-down fs-xxs"></i>'+
            '</span>'+
            '<span>{{ l('قیمت کل') }}</span>'+
            '</div>');
    $('#price2').html('<div class="d-flex align-items-center gap-1">'+
        '<span class="d-flex flex-column">'+
            '<i class="fi fi-chevron-up fs-xxs"></i>'+
            '<i class="fi fi-chevron-down fs-xxs"></i>'+
            '</span>'+
            '<span>{{ l('قیمت متری') }}</span>'+
            '</div>');
    @endif



    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
});
</script>
<style>
    .clickable-row{cursor: pointer}
    .table > :not(caption) > * > * {
        padding: 0.3rem

      }
</style>

