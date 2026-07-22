@if(count($modelEstate)>0)

<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <p class="m-0">
           {{ l('مالکین') }}
        </p>

    </div>
</div>
<table class="table table-bordered table-striped table-hover">
    <thead class="table-primary">
        <tr>

            <th scope="col">#</th>
            <th class="text-center" scope="col"> {{l('کد ملک')}} </th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('مالک')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('مشاور')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('نوع ملک')}}</th>
            <th valign="middle" class="header" style="text-align:center" scope="col">{{l('آدرس')}}</th>


        </tr>
    </thead>
    <tbody>
        @foreach($modelEstate as $estate)
        <tr>
            <th valign="middle" scope="row"  >
                <a class="d-block " style="width:100px;height:80px" href="{{$estate->url()}}" target="_blank">
                    <img class="w-100 object-cover rounded-1 " src="{{$estate->coverImage()}}" alt="real estate" />
                </a>
            </th>
            <td valign="middle" align="center"  style="width: 50px" class="text-center">
                <a href="{{$estate->url()}}" target="_blank">
                    <span class="rounded-circle d-block" style="width: 50px;height:50px;padding-top:15px;color:#000">
                    {{$estate->id}}
                    </span>
                </a>
            </td>

            <td valign="middle" align="center">
                <a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">
                    @if($currentUser->isAdmin() ||
                    ($estate->expert_id>0 && $estate->expert && $estate->expert->isExpert() && ($estate->expiretime_expert == null || $estate->expiretime_expert > date('Y-m-d H:i:s')) && ($currentUser->id == $estate->expert_id  ||  (ss('SITE_ID') == 5 && $estate->percent_expert != 50 && $estate->percent_expert != 0))) ||
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
                    @if(ss('SITE_ID') == 3 || $estate->haveExpert())
                        {{$estate->expert->fullname()}}
                    @endif
                    @endif
                </a>
            </td>
            <td valign="middle" align="center">
                <a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">{{estateTypes($estate->estate_type)}}</a>
            </td>
            <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{$estate->url()}}" target="_blank">
                {{$estate->city->name??""}} - {{$estate->district->name??""}}
                {{!empty($estate->street)?" - ".$estate->street->name:""}}
                {{!empty($estate->address)?" - ".$estate->address:""}}
                {{$estate->buildingname != ''? l("- مجتمع:").$estate->buildingname:''}}

            </a> </td>
        </tr>
        @endforeach
    </tbody>
</table>
<hr>
@endif
