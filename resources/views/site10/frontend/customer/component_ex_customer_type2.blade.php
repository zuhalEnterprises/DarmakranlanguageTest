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
                    <span>{{l('کد')}}</span>
                </div>
            </th>
            <th valign="middle" style="text-align:center" scope="col">{{l('نام خریدار')}}</th>
            <th valign="middle" style="text-align:center" scope="col">{{l('نام مشاور')}}</th>
            <th valign="middle" style="text-align:center" scope="col">{{l('نوع معامله')}}</th>
            <th valign="middle" style="text-align:center" scope="col">{{l('نوع ملک')}}</th>
            
            <th valign="middle" style="text-align:center" scope="col" class="sortable" onclick="sort('created_at')">
                <div class="d-flex align-items-center gap-1">
                     <span class="d-flex flex-column">
                        <i class="fi fi-chevron-up fs-xxs"></i>
                        <i class="fi fi-chevron-down fs-xxs"></i>
                    </span>
                    <span>{{l('تاریخ ایجاد')}}</span>
                </div>
            </th>
            @if($currentUser->isExpert() || $currentUser->isAdmin())
            <th valign="middle" style="text-align:center" scope="col">{{l('ابزار')}}</th>
            @endif
        </tr>
    </thead>
    <tbody>

@foreach($model as $item)

<tr>
    
    <td valign="middle" align="center" data-href="/customer/{{$item->id}}" >
        <a class="text-decoration-none" href="/customer/{{$item->id}}" target="_blank">
        <span class=" d-block" style="padding:10px;color:#000">{{$item->id}}</span>
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
    
    <td valign="middle" align="center" data-href="/customer/{{$item->id}}">
        <a href="/customer/{{$item->id}}" target="_blank" class="text-decoration-none">
        {{ toPersianDate($item->created_at) }}
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
                    <i class="fa-light fa-eye opacity-60 me-2"></i>{{l('مشاهده جزئیات')}}
                </a>
            </li>
            @if($item->user_id == $currentuserid || $currentUser->hasAnyRole('admin_super|admin_site|admin_marketing|admin_branch'))
            @if($item->status == 1)
            <li>
                <a class="dropdown-item"  target="_blank" href="/customer/{{$item->id}}/edit_v2" class="flex items-center gap-2 p-2 hover:text-blue-500">
                    <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                    {{l('ویرایش')}}
                </a>
            </li>
            @if(env('COUNTRY') != 'UAE')
            <li>
                <a class="dropdown-item"  target="_blank" style="cursor:pointer" onclick="if(confirm('{{l('آیا از بروزکردن این تقاضا مطمئن هستید؟')}}'))ladder({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                    <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                    {{l('بروزرسانی')}}
                </a>
            </li>
            @endif
            @endif
            <li>
                @if($item->status == 1)
                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm('{{l('آیا از آرشیو کردن این تقاضا مطمئن هستید؟')}}'))deleteclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                    {{l('انتقال به آرشیو')}}
                </a>
                @else
                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm('{{l('آیا از جاری کردن این تقاضا مطمئن هستید؟')}}'))undeleteclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                    {{l('انتقال به جاری')}}
                </a>
                @endif
            </li>
            @if($currentUser->isAdmin() && ss('SITE_ID') == 5)
            <li>
                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از حذف این تقاضا مطمئن هستید؟')))deleteclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                    {{l('حذف تقاضا')}}
                </a>
            </li>
            @endif
            @endif
            @if($currentUser->isAdmin() || ($currentUser->isExpert() &&  $item->user_id == $currentuserid))
            <li>
                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm('{{l('آیا از حذف کارشناس این تقاضا مطمئن هستید؟')}}'))removeagentclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                    {{l('حذف کارشناس')}}
                </a>
            </li>
            @endif
            @if(!$currentUser->isAdmin() && $currentUser->isExpert() &&  $item->user_id == null)
            <li>
                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm('{{l('آیا از انتقال کارشناس این تقاضا مطمئن هستید؟')}}'))assigntomeclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                    {{l('انتقال به من')}}
                </a>
            </li>
            @endif
        </ul>
    </td>
    @endif
</tr>
@endforeach
</tbody>
</table>
</div>
<script>
    @if (isset($estate) && $estate->type == 2)
    $('#price1').html('{{l('قیمت رهن [تومان]')}}');
    $('#price2').html('{{l('قیمت اجاره [تومان]')}}');
    @else
    $('#price1').html('{{l('قیمت کل [تومان]')}}');
    $('#price2').html('{{l('قیمت متری [تومان]')}}');
    @endif
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
});
</script>
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
                    text: '{{l('گزینه مورد نظر با موفقیت حذف شد.')}}',
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => {
                    CheckSend();
                    //location.reload();
                });
            })
            .fail(function() {
                swal('خطا!', '{{l('حذف با مشکل مواجه شد!')}}', 'error');
            });
    }
    function removeagentclick(customerId) {
        $.ajax({
                url: '/customer/removeagent',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    customerid: customerId
                },
                dataType: 'json'
            })
            .done(function(response) {
                swal({
                    text: '',
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => {
                    CheckSend();
                    //location.reload();
                });
            })
            .fail(function() {
                swal('خطا!', '{{l('حذف با مشکل مواجه شد!')}}', 'error');
            });
    }
    function assigntomeclick(customerId) {
        $.ajax({
                url: '/customer/assignToMe',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    customerid: customerId
                },
                dataType: 'json'
            })
            .done(function(response) {
                swal({
                    text: '',
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => {
                    CheckSend();
                    //location.reload();
                });
            })
            .fail(function() {
                swal('خطا!', '{{l('عملیات با مشکل مواجه شد!')}}', 'error');
            });
    }

    function ladder(customerId) {
        $.ajax({
                url: '/customer/ladder',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    customerid: customerId
                },
                dataType: 'json'
            })
            .done(function(response) {
                swal({
                    text: '',
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => {
                   // CheckSend();
                });
            })
            .fail(function() {
                swal('{{l('خطا!')}}', '{{l('حذف با مشکل مواجه شد!')}}', 'error');
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
                    text: '{{l('تقاضا با موفقیت جاری گردید')}}',
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => {
                    CheckSend();
                    //location.reload();
                });
            })
            .fail(function() {
                swal('{{l('خطا!')}}', '{{l('مشلکلی بوجود آمده است!')}}', 'error');
            });
    }
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
