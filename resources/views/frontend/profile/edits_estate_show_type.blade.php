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

                <th class="text-center" scope="col" class="sortable" onclick="sort('estate_id')">{{ l('ملک') }}</th>
                <th class="text-center" scope="col" onclick="sort('user_id')">{{ l('مشاور') }}</th>
                <th class="text-center" scope="col" class="sortable" onclick="sort('type')">{{ l('فیلد تغییر کرده') }}</th>
                <th class="text-center" scope="col">{{ l('مقدار از') }}</th>
                <th class="text-center" scope="col">{{ l('مقدار به') }}</th>
                <th class="text-center" scope="col" class="sortable" onclick="sort('created_at')">{{ l('تاریخ') }}</th>

            </tr>
        </thead>
        <tbody>

            @foreach($estateEdits as $estateEdit)
            <tr>
                <td width="100" class="text-center" valign="middle" align="center">
                    <a href="/v/{{$estateEdit->estate_id}}" target="_blank">
                        {{$estateEdit->estate_id}}
                    </a>
                </td>
                <td align="center" style="width:100px" class="text-center" valign="middle" align="center">
                    @if($estateEdit->user)
                    {{$estateEdit->user->fullname()}}
                    @endif
                </td>
                <td width="100" class="text-center" valign="middle" align="center">
                    @if(array_key_exists($estateEdit->type , $typeName))
                    {{$typeName[$estateEdit->type]}}
                    @else
                    {{$estateEdit->type}}
                    @endif
                </td>
                <td align="center" class="text-center" valign="middle" align="center">
                    @if($estateEdit->type=='description' || $estateEdit->type=='exchange_comment')<div style="width: 250px;height:80px;overflow:auto">@endif
                        {{estateValue($estateEdit->type , $estateEdit->changefrom)}}
                    @if($estateEdit->type=='description' || $estateEdit->type=='exchange_comment')</div>@endif
                </td>
                <td width="100" class="text-center" valign="middle" align="center">
                    @if($estateEdit->type=='description' || $estateEdit->type=='exchange_comment')<div style="width: 250px;height:80px;overflow:auto">@endif
                        {{estateValue($estateEdit->type , $estateEdit->changeto)}}
                    @if($estateEdit->type=='description' || $estateEdit->type=='exchange_comment')</div>@endif
                </td>
                <td class="text-center" style="width:100px" valign="middle" align="center">
                    {{toPersianDate($estateEdit->created_at)}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<style>
    .sortable{
        color:blue !important;
        cursor: pointer
    }
    .table > :not(caption) > * > * {
        padding: 0.5rem;
    }
</style>




