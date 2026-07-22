<style>
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

</style>

<div class="border rounded p-3 mb-3 bg-secondary">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-1">
            <span class="help-table-color border" style="background-color:#ffdd05"></span>
            <p class="m-0">{{ l('لیبل طلایی') }}</p>
        </div>
        <div class="d-flex align-items-center gap-1">
            <span class="help-table-color border" style="background-color:#9d9d9d"></span>
            <p class="m-0">{{ l('لیبل نقره ای') }}</p>
        </div>
        <div class="d-flex align-items-center gap-1">
            <span class="help-table-color border" style="background-color:#f1b478"></span>
            <p class="m-0">{{ l('لیبل برنزی') }}</p>
        </div>

    </div>
</div>
<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <p class="m-0">
            <b>{{ l('تعداد نتایج:') }}</b>
            {{$totalCount}} مشتری

        </p>

    </div>
</div>
<div class="table-p">
<table class="table table-bordered table-striped table-hover">
    <thead class="table-primary">
        <tr>
            <th valign="middle" style="text-align:center" scope="col" class="sortable" onclick="sort('id')">
                <div class="d-flex align-items-center gap-1">
                    <span class="d-flex flex-column">
                        <i class="fi fi-chevron-up fs-xxs"></i>
                        <i class="fi fi-chevron-down fs-xxs"></i>
                    </span>
                    <span>{{ l('کد') }}</span>
                </div>
            </th>
            <th valign="middle" style="text-align:center" scope="col">{{l('نام خریدار')}}</th>
            <th valign="middle" style="text-align:center" scope="col">{{l('نام مشاور')}}</th>
            <th valign="middle" style="text-align:center" scope="col" class="sortable" onclick="sort('updated_at')">
                <div class="d-flex align-items-center gap-1">
                     <span class="d-flex flex-column">
                        <i class="fi fi-chevron-up fs-xxs"></i>
                        <i class="fi fi-chevron-down fs-xxs"></i>
                    </span>
                    <span>{{ l('تاریخ ویرایش') }}</span>
                </div>
            </th>
            @if($currentUser->isExpert() || $currentUser->isAdmin())
            <th valign="middle" style="text-align:center" scope="col">{{ l('ابزار') }}</th>
            @endif
        </tr>
    </thead>
    <tbody>

@foreach($model as $item)
<?php
    $bgcolor =  ($item->updated_at < date("Y-m-d 00:00:00", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-58 day" ) ))?'#d5ddff':'';
?>
<tr style="background-color:{{$bgcolor}}">
    @php
    $labelcolor = array(0 => '' , 1 => 'lable-gold' , 2 => 'lable-silver' , 3 => 'lable-bronze');
    @endphp
    <td valign="middle" align="center" data-href="/customer/{{$item->id}}" >
        <a class="text-decoration-none" href="/customer/{{$item->id}}" target="_blank">
        <span class="{{$labelcolor[(int)$item->label]}} rounded-circle d-block" style="padding:10px;color:#000">{{$item->id}}</span>
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

    <td valign="middle" align="center" data-href="/customer/{{$item->id}}">
        <a href="/customer/{{$item->id}}" target="_blank" class="text-decoration-none">
        {{ toPersianDate($item->updated_at) }}
        </a>
    </td>
    @if($currentUser->isExpert() || $currentUser->isAdmin())
    <td valign="middle" align="center">
        <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fi-dots-vertical"></i>
        </button>
        <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
            <li>
                <a class="dropdown-item" target="_blank" href="/customer/{{$item->id}}">
                    <i class="fa-light fa-eye opacity-60 me-2"></i>{{ l('مشاهده جزئیات') }}
                </a>
            </li>
            @if($item->user_id == $currentuserid || $currentUser->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch'))
            @if($item->status == 1)
            <li>
                <a class="dropdown-item"  target="_blank" href="/customer/{{$item->id}}/edit_v2" class="flex items-center gap-2 p-2 hover:text-blue-500">
                    <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                    {{ l('ویرایش') }}
                </a>
            </li>
            @endif
            <li>
                @if($item->status == 1)
                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از آرشیو کردن این تقاضا مطمئن هستید؟')))deleteclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                    {{ l('انتقال به آرشیو') }}
                </a>
                @else
                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از جاری کردن این تقاضا مطمئن هستید؟')))undeleteclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                    {{ l('انتقال به جاری') }}
                </a>
                @endif
            </li>
            @if($currentUser->isAdmin() && 0)
            <li>
                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از حذف این تقاضا مطمئن هستید؟')))deleteclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                    {{ l('حذف تقاضا') }}
                </a>
            </li>
            @endif
            @endif
        </ul>
    </td>
    @endif
</tr>
@endforeach
</tbody>
</table>
</div>

<style>
    .clickable-row{cursor: pointer}
</style>
<script>
    var CSRF_TOKEN = '{{csrf_token()}}';
    var userID = '{{$currentUser->id ?? 0}}';
    function deleteclick(customerId) {
        $.ajax({
                url: '/notecustomer/delete',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    customerid: customerId
                },
                dataType: 'json'
            })
            .done(function(response) {
                swal({
                    text: l('گزینه مورد نظر با موفقیت حذف شد.'),
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => {
                    CheckSend();
                    //location.reload();
                });
            })
            .fail(function() {
                swal('خطا!', l('حذف با مشکل مواجه شد!'), 'error');
            });
    }
    function undeleteclick(customerId) {
        $.ajax({
                url: '/notecustomer/undelete',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    customerid: customerId
                },
                dataType: 'json'
            })
            .done(function(response) {
                swal({
                    text: l('تقاضا با موفقیت جاری گردید'),
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => { CheckSend(); //location.reload(); }); }) .fail(function() { swal('خطا!', 'مشلکلی بوجود آمده است!', 'error'); }); }
</script>
<style>
    .sortable{
        /* color:blue !important; */
        cursor: pointer
    }
    .table > :not(caption) > * > * {
        padding: 0.5rem;
    }
</style>
