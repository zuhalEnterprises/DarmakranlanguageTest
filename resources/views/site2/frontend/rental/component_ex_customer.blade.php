<style>
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
            <th valign="middle" style="text-align:center" scope="col">
                <span>{{ l('کد') }}</span>
            </th>
            <th valign="middle" style="text-align:center" scope="col">{{l('نام خریدار')}}</th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('تلفن') }}</th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('تعداد افراد') }}</th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('کد ملک') }}</th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('اقامت از') }}</th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('اقامت تا') }}</th>
            <th valign="middle" style="text-align:center" scope="col">{{ l('وضعیت') }}</th>
            <th valign="middle" style="text-align:center" scope="col">
                {{ l('تاریخ ثبت') }}
            </th>
            <th valign="middle" style="text-align:center" scope="col">
                {{ l('آرشیو') }}
            </th>
        </tr>
    </thead>
    <tbody>

@foreach($model as $item)
<tr>
    <td valign="middle" align="center" data-href="/rental/customer/{{$item->id}}/edit" >
        <a class="text-decoration-none" href="/rental/customer/{{$item->id}}/edit" target="_blank">
            <span class="rounded-circle d-block" style="padding:10px;color:#000">{{$item->id}}</span>
        </a>
    </td>
    <td valign="middle" align="center" data-href="/rental/customer/{{$item->id}}/edit" >
        <a href="/rental/customer/{{$item->id}}/edit" target="_blank" class="text-decoration-none">
            {{$item->name}}
        </a>
    </td>
    <td valign="middle" align="center" data-href="/rental/customer/{{$item->id}}/edit" >
        <a href="/rental/customer/{{$item->id}}/edit" target="_blank" class="text-decoration-none">
            {{$item->mobile}}
        </a>
    </td>
    <td valign="middle" align="center" data-href="/rental/customer/{{$item->id}}/edit" >
        <a href="/rental/customer/{{$item->id}}/edit" target="_blank" class="text-decoration-none">
            {{$item->person_count}}
        </a>
    </td>
    <td valign="middle" align="center" data-href="/rental/customer/{{$item->id}}/edit" >
        <a href="/rental/customer/{{$item->id}}/edit" target="_blank" class="text-decoration-none">
            {{$item->estate_id}}
        </a>
    </td>
    <td valign="middle" align="center" data-href="/rental/customer/{{$item->id}}/edit" >
        <a href="/rental/customer/{{$item->id}}/edit" target="_blank" class="text-decoration-none">
            {{ toPersianDate($item->stay_from , false , false) }}
        </a>
    </td>
    <td valign="middle" align="center" data-href="/rental/customer/{{$item->id}}/edit" >
        <a href="/rental/customer/{{$item->id}}/edit" target="_blank" class="text-decoration-none">
            {{ toPersianDate($item->stay_to , false , false) }}
        </a>
    </td>
    <td valign="middle" align="center" data-href="/rental/customer/{{$item->id}}/edit" >
        <a href="/rental/customer/{{$item->id}}/edit" target="_blank" class="text-decoration-none">
            {{ $item->statusname() }}
        </a>
    </td>
    <td valign="middle" align="center" data-href="/rental/customer/{{$item->id}}/edit">
        <a href="/rental/customer/{{$item->id}}/edit" target="_blank" class="text-decoration-none">
        {{ toPersianDate($item->created_at) }}
        </a>
    </td>
    <td valign="middle" align="center">
        <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از آرشیو این تقاضا مطمئن هستید؟')))deleteclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
            <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
            {{ l('آرشیو') }}
        </a>
    </td>


</tr>
@endforeach
</tbody>
</table>
</div>
<script>
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

    function deleteclick(customerId) {
        $.ajax({
                url: '/rental/customer/delete',
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
