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
            <b> {{l('تعداد نتایج')}}:  </b>
            {{$totalCount}}
        </p>

    </div>
</div>
<div class="my-3 table-responsive table-p">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th class="text-center" scope="col">{{l('کد')}}</th>
                <th scope="col" class="sortable text-center" onclick="sort('customer_id')"> {{l('کد مشتری')}} </th>


                <th class="text-center" scope="col" onclick="sort('expert_id')">{{l('مشاور')}}</th>

                <th class="text-center" scope="col" onclick="sort('type')">{{l('نوع عملکرد')}}</th>

                <th class="text-center" scope="col">{{l('متن عملکرد')}}</th>

                <th class="text-center" scope="col" class="sortable" onclick="sort('created_at')"> {{l('تاریخ')}}</th>

            </tr>
        </thead>
        <tbody>

            @foreach($operationsCustomer as $operationcustomer)
            <tr>
                <td class="text-center" scope="row">
                    {{$operationcustomer->id}}
                </td>
                <td width="100" class="text-center">
                    <a href="/customer/{{$operationcustomer->customer_id}}" target="_blank">
                        {{$operationcustomer->customer_id}}
                    </a>
                </td>

                <td align="center" class="text-center">
                    @if($operationcustomer->expert_id>0 && $operationcustomer->expert != null)
                    <a class="text-body text-decoration-none" href="/agents/{{$operationcustomer->expert ?? $operationcustomer->expert->id}}" target="_blank">
                        {{$operationcustomer->expert->fullname()}}
                    </a>
                    @endif
                </td>

                <td width="100" class="text-center">
                    {{$operationcustomer->typeName()}}
                </td>

                <td width="100" class="text-center">
                    {{$operationcustomer->comment}}
                </td>
                <td class="text-center">
                    {{toPersianDate($operationcustomer->created_at)}}
                </td>

            </tr>
            @endforeach

        </tbody>
    </table>
</div>




