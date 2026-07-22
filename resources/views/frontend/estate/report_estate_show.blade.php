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
</style>
<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <p class="m-0">
            <b>{{ l('تعداد نتایج:') }}</b>
            {{$totalCount}}
        </p>

    </div>
</div>
<div class="my-3 table-responsive table-p">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th class="text-center fixed-width-sm">{{ l('شناسه') }}</th>
                <th class="text-center">{{ l('کاربر') }}</th>
                <th class="text-center">{{ l('ملک') }}</th>
                <th class="text-center">{{ l('دلیل گزارش') }}</th>
                <th class="text-center">{{ l('توضیحات') }}</th>
                <th class="text-center">{{ l('تاریخ ثبت') }}</th>
                <th class="text-center">{{ l('پلتفرم') }}</th>
                <th class="text-center">{{ l('وضعیت') }}</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>

            @foreach($estateReports as $item)
            <tr>
               <td class="text-center" data-id="{{$item->id}}">{{$item->id}}</td>
                <td class="text-center">
                    @if($item->user)
                        {{ $item->user->name ?? $item->user->username}}
                    @endif
                </td>
               <td class="text-center">
                @if($item->estate)
                   <a href="{{$item->estate->url()}}" target="_blank">
                   <span class="">
                       {{$item->estate_id}} - {{$item->estate->{{ l('title ?? \'بدون عنوان\'}}') }}
                   </span>
                   </a>
                @endif
               </td>
               <td class="text-center">
                   <b>{{estateReportReasons($item->reason_group)['group'] ?? ''}}</b><br>
                   {{estateReportReasons($item->reason_group)['subgroup'][$item->reason_subgroup] ?? ''}}
               </td>
               <td class="text-center">{{$item->description}}</td>
               <td class="text-center">{{toPersianDate($item->create_at)}}</td>
               <td class="text-center">{{$item->device.' '.$item->agent}}</td>
                <td class="text-center">
                    <select class="form-control item-status" name="status"
                            id="user-{{$item->id}}" data-id="{{$item->id}}" data-status="{{$item->status}}">
                        <option value="pending" class="text-warning">{{ l('در حال بررسی') }}</option>
                        <option value="verified" class="text-success">{{ l('بررسی شده') }}</option>
                        <option value="rejected" class="text-red">{{ l('رد شده') }}</option>
                    </select>
                    <script type="text/javascript">
                        var id = '{{$item->id}}';
                        var status = '{{$item->status}}';
                        $("select#user-" + id + " option[value='" + status + "']").prop('selected', true);
                    </script>
                </td>
                <td class="text-center">
                    <a data-toggle="tooltip" title="{{ l('حذف') }}" data-id="{{$item->id}}"
                       id="itemID-{{$item->id}}" class="icon remove">
                        <i class="fa fa-trash "></i>
                    </a>
                </td>
            </tr>

            @endforeach

        </tbody>
    </table>
</div>
<script src="{{asset('frontend/vendor/sweetalert2.all.js')}}"></script>
<script type="text/javascript">
    const toast = swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 2500
    });
    $(document).ready(function () {
        var CSRF_TOKEN = '{{csrf_token()}}';

        // remove
        $("a.remove").on("click", function () {
            var id = $(this).data('id');

            swal({
                text: l("آیا از حذف گزینه مورد نظر اطمینان دارید؟"),
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: l('لغو'),
                confirmButtonText: l('بله'),
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $.ajax({
                            url: '/profile/reportEstateDestroy/' + id,
                            type: 'GET',
                            data: {_token: CSRF_TOKEN},
                            dataType: 'json'
                        })
                            .done(function (response) {
                                swal({
                                    title: l('گزینه مورد نظر با موفقیت حذف شد.'),
                                    text: "",
                                    type: 'success',
                                    allowOutsideClick: false
                                }).then((result) => { CheckSend(); }); }) .fail(function () { swal('خطا!', 'حذف با مشکل مواجه شد!', 'error'); }); }); }, allowOutsideClick: false }); }); // status $('select.item-status').on('change', function () { var estateReportId = $(this).data('id'); var status = this.value; $.get("/profile/reportEstateStatus/" + estateReportId + "/" + status, function (data, status) { if (data.status) { toast({ type: 'success', title: data.result }); } else { toast({ type: 'error', title: 'عملیات با مشکل مواجه شد!' }); } }); }); });
</script>



