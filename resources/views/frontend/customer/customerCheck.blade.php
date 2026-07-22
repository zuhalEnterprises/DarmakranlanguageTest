<style>
    .sortable{
        /* color:blue !important; */
        cursor: pointer
    }
</style>
<div class="border rounded p-3 bg-secondary mb-2">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <p class="m-0">
            <b> {{l('تعداد نتایج')}}:  </b>
            {{$totalCount}}
        </p>

    </div>
</div>
<div class="my-3 table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th scope="col" >{{l('کد مشتری')}}</th>
                <th scope="col" >{{l('نام مشاور')}}</th>
                <th scope="col">{{l('نام مشتری')}}</th>
                <th scope="col">{{l('شماره موبایل مشتری')}}</th>
                @if(ss('SITE_ID') != 6)
                <th scope="col">{{l('نوع درخواست')}}</th>

                <th scope="col">{{l('نوع ملک')}}</th>
                @endif
                <th scope="col">{{l('تاریخ ثبت')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estates as $estate)
            <tr>

                <td align="center">
                    <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                        {{$estate->id}}
                    </a>
                </td>
                <td align="center">
                    <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                        {{isset($estate->user)  ? $estate->user->fullname() : ''}}
                    </a>
                </td>
                <td align="center">
                    <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                        {{$estate->name}}
                    </a>
                </td>
                <td align="center">
                    <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                        {{$estate->mobile}}
                    </a>
                </td>
                @if(ss('SITE_ID') != 6)
                <td align="center">
                    <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                        @if ($estate->request_type == 2)
                        {{l('رهن واجاره')}}
                        @else
                        {{l('خرید و فروش')}}
                        @endif
                    </a>
                </td>
                <td align="center">
                    <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                        {{estateTypes($estate->estate_type)}}
                    </a>
                </td>
                @endif
                <td align="center">
                    <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                        {{ toPersianDate($estate->created_at) }}
                    </a>
                </td>




            </tr>
            @endforeach

        </tbody>
    </table>
</div>


