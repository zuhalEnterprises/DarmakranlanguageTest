<style>
    .sortable{
        /* color:blue !important; */
        cursor: pointer
    }
    .table-p{
        max-height:500px;
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
                <th class="text-center" scope="col">{{ l('کد') }}</th>

                @if($currentUser->isAdmin())
                <th class="text-center" scope="col" onclick="sort('expert_id')">{{ l('مشاور') }}</th>
                @endif
                <th class="text-center" scope="col" onclick="sort('type')">{{ l('نوع عملکرد') }}</th>
                <th class="text-center" scope="col">{{ l('امتیاز') }}</th>

                <th class="text-center" scope="col" class="sortable" onclick="sort('created_at')">{{ l('تاریخ') }}</th>
                @if($currentUser->isAdmin())
                <th class="text-center" scope="col">{{ l('ابزار') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>

            @foreach($operationsUser as $operationuser)
            <tr>
                <td class="text-center" scope="row">
                    {{$operationuser->id}}
                </td>

                @if($currentUser->isAdmin())
                <td align="center" class="text-center">
                    @if($operationuser->expert_id>0 && $operationuser->expert != null)
                    <a class="text-body text-decoration-none" href="/agents/{{$operationuser->expert ?? $operationuser->expert->id}}" target="_blank">
                        {{$operationuser->expert->fullname()}}
                    </a>
                    @endif
                </td>
                @endif
                <td width="100" class="text-center">
                    {{$operationuser->typeName()}}
                </td>

                <td width="100" class="text-center">
                    {{$operationuser->score}}
                </td>
                <td class="text-center">
                    {{toPersianDate($operationuser->created_at)}}
                </td>
                @if($currentUser->isAdmin())
                <td class="text-center">
                    <a class="dropdown-item text-center" style="cursor:pointer" onclick="if(confirm(l('آیا از حذف مطمئن هستید؟')))destroy({{$operationuser->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                        <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                    </a>
                </td>
                @endif
            </tr>
            @endforeach

        </tbody>
    </table>
</div>




