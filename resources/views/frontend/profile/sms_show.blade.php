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
                <th class="text-center" scope="col">{{ l('موبایل') }}</th>
                <th class="text-center" scope="col">{{ l('متن') }}</th>
                <th class="text-center" scope="col">{{ l('دریافت | ارسال') }}</th>
                <th class="text-center" scope="col" class="sortable">{{ l('تاریخ') }}</th>
            </tr>
        </thead>
        <tbody>

            @foreach($smss as $sms)
            <tr>
                <td width="100" class="text-center">
                    {{$sms->mobile}}
                </td>
                <td align="center" class="text-center">
                    {{$sms->text}}
                </td>
                <td width="100" class="text-center">
                    @if($sms->type == 1)
                    ارسالی
                        @if($sms->udh < 100)
                        (ارسال نشده)
                        @endif
                    @else
                    دریافتی
                    @endif
                </td>
                <td align="center" class="text-center">
                    {{toPersianDate($sms->created_at)}}
                </td>

            </tr>

            @endforeach

        </tbody>
    </table>
</div>




