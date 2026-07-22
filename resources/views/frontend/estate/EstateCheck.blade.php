<style>
    .sortable{
        /* color:blue !important; */
        cursor: pointer
    }
    .table-pic {
    height: 45px;
}
@media (min-width:996px) {
    .table-pic {
    height: 75px;
}
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
                <th scope="col">#</th>
                <th scope="col" class="sortable" onclick="sort('id')">{{l('کد ملک')}}</th>
                @if($currentUser->isExpert())
                <th scope="col">{{l('مالک')}}</th>
                @endif
                <th scope="col">{{l('نوع ملک')}}</th>
                <th scope="col">{{l('آدرس')}}</th>

                <th scope="col" class="sortable" onclick="sort('area')">
                    {{l('مساحت')}}
                </th>
                @if(env('COUNTRY') != 'UAE')
                <th scope="col" id="price1" class="sortable" onclick="sort('price1')">{{ l('قیمت / رهن') }}</th>
                <th scope="col" id="price2" class="sortable" onclick="sort('price2')">{{ l('متری / اجاره') }}</th>
                @else
                <th scope="col" id="price1" class="sortable" onclick="sort('price1')">
                    @if ($estate->type == 2)
                    {{l('اجاره')}}
                    @else
                    {{l('قیمت')}}
                    @endif
                </th>
                @endif
                <th scope="col" class="sortable" onclick="sort('updated_at')"> {{l('تاریخ')}}</th>

            </tr>
        </thead>
        <tbody>

            @foreach($estates as $estate)
            <tr>
                <th scope="row" width="100">
                    <a href="#">
                        <img class="w-100 object-cover rounded-1 table-pic" src="{{$estate->coverImage()}}"
                            alt="real estate" >
                    </a>
                </th>
                <td align="center">
                    <a class="text-body text-decoration-none" href="{{ $estate->url() }}">
                        {{$estate->id}}
                    </a>
                </td>
                @if($currentUser->isExpert())
                <td align="center">
                    <a class="text-body text-decoration-none" href="{{ $estate->url() }}">
                        {{$estate->phone()->name}}
                    </a>
                </td>
                @endif
                <td align="center"><a class="text-body text-decoration-none" href="{{ $estate->url() }}">{{estateTypes($estate->estate_type)}}</a> </td>
                <td align="center"><a class="text-body text-decoration-none" href="{{ $estate->url() }}">{{$estate->city->name??""}} - {{$estate->district->name??""}}</a> </td>
                <td align="center"><a class="text-body text-decoration-none" href="{{ $estate->url() }}">{{!empty($estate->area)?$estate->area:""}}</a></td>
                @if ($estate->type == 2)
                    @if(env('COUNTRY') != 'UAE')
                    <td>
                        <a class="text-body text-decoration-none" href="{{ $estate->url() }}">{{ toPersianNumbers($estate->mortgage) }}</a>
                    </td>
                    @endif
                    <td>
                        <a class="text-body text-decoration-none" href="{{ $estate->url() }}">
                            {{ toPersianNumbers($estate->rent) }}
                        </a>
                    </td>
                @else
                    @if ($estate->price > 0)
                        <td>
                            <a class="text-body text-decoration-none" href="{{ $estate->url() }}">
                            {{ toPersianNumbers($estate->price) }}
                            </a>
                        </td>
                        @if(env('COUNTRY') != 'UAE')
                        <td>
                            <a class="text-body text-decoration-none" href="{{ $estate->url() }}">
                            {{ toPersianNumbers($estate->price_per_meter) }}
                            </a>
                        </td>
                        @endif
                    @else
                        <td>
                            <a class="text-body text-decoration-none" href="{{ $estate->url() }}">
                                {{l('توافقی')}}
                            </a>
                        </td>
                        @if(env('COUNTRY') != 'UAE')
                        <td></td>
                        @endif
                    @endif
                @endif
                <td><a class="text-body text-decoration-none" href="{{ $estate->url() }}">{{toPersianDate($estate->updated_at)}}</a> </td>

            </tr>
            @endforeach

        </tbody>
    </table>
</div>

<script>
    @if (isset($estate) && $estate->type == 2)
    $('#price1').html('قیمت رهن [تومان]');
    $('#price2').html('قیمت اجاره [تومان]');
    @else
    $('#price1').html('قیمت کل [تومان]');
    $('#price2').html('قیمت متری [تومان]');
    @endif

</script>


