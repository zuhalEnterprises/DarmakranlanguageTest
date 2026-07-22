@if(count($modelCustomer)>0)
<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <p class="m-0">
            {{ l('لیست مشتریان') }}
        </p>

    </div>
</div>
<table class="table table-bordered table-striped table-hover">
    <thead class="table-primary">
        <tr>
            <th valign="middle" style="text-align:center" scope="col" class="sortable"
                کد
            </th>
            <th valign="middle" style="text-align:center" scope="col">{{l('نام خریدار')}}</th>
            <th valign="middle" style="text-align:center" scope="col">{{l('نام مشاور')}}</th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('نوع معامله') }}</th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('نوع ملک') }}</th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('محلات') }}</th>

        </tr>
    </thead>
    <tbody>

@foreach($modelCustomer as $item)

<tr>
    <td valign="middle" align="center" data-href="/customer/{{$item->id}}" >
        <a class="text-decoration-none" href="/customer/{{$item->id}}" target="_blank">
        <span class="rounded-circle d-block" style="padding:10px;color:#000">{{$item->id}}</span>
        </a>
    </td>
    <td valign="middle" align="center" data-href="/customer/{{$item->id}}" >
    <a href="/customer/{{$item->id}}" target="_blank" class="text-decoration-none">
        @if($currentUser->isAdmin() || $currentUser->id == $item->user_id )
            {{$item->name}} <br>
            {{$item->mobile}}
        @endif
    </a>
    </td>
    <td valign="middle" align="center" data-href="/customer/{{$item->id}}" >
    <a href="/customer/{{$item->id}}" target="_blank" class="text-decoration-none">
        {{$item->user && $item->user->fullname() ? $item->user->fullname() : ''}}
    </a>
    </td>
    <td valign="middle" align="center" data-href="/customer/{{$item->id}}" >
    <a href="/customer/{{$item->id}}" target="_blank" class="text-decoration-none">
        {{$item->{{ l('request_type == 1 ? l(\'خرید\') : l(\'اجاره\')}}') }}
    </a>
    </td>
    <td valign="middle" align="center" data-href="/customer/{{$item->id}}" >
    <a href="/customer/{{$item->id}}" target="_blank" class="text-decoration-none">
        {{estateTypes($item->estate_type)}}
    </a>
    </td>
    <td valign="middle" align="center" data-href="/customer/{{$item->id}}"  style="padding: 0px">
        <div style="width: 150px;height:50px;overflow:auto">
        @php
        $_districtList = array();
        @endphp
        @foreach($item->districts as $district)
        @php
        $_districtList[] = $district->name
        @endphp
        @endforeach
        {{implode(' , ',$_districtList)}}
        </div>
    </td>

</tr>
@endforeach
</tbody>
</table>
<hr>
@endif
