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
            {{$totalCount}}
        </p>

    </div>
</div>
<div class="my-3 table-responsive table-p">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th class="text-center" scope="col">{{ l('نام') }}</th>
                <th class="text-center" scope="col">{{ l('تلفن') }}</th>
                <th class="text-center" scope="col">{{ l('نوع ملک') }}</th>
                <th class="text-center" scope="col">{{ l('آدرس') }}</th>
                <th class="text-center" scope="col">{{ l('تاریخ') }}</th>
                <th class="text-center" scope="col" style="width:50px">{{ l('حذف') }}</th>
            </tr>
        </thead>
        <tbody>

            @foreach($appraisals as $appraisal)
            <tr>
                <td align="center" class="text-center">
                    {{$appraisal->name}}
                </td>
                <td align="center" class="text-center">
                    {{$appraisal->tel}}
                </td>
                <td align="center" class="text-center">
                    {{estateTypes($appraisal->estate_type)}}
                </td>
                <td align="center" class="text-center">
                    {{$appraisal->address}}
                </td>
                <td align="center" class="text-center">
                    {{toPersianDate($appraisal->created_at)}}
                </td>
                <td align="center" class="text-center">
                    <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از حذف مطمئن هستید؟')))destroy({{$appraisal->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                        <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                        {{ l('حذف') }}
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
