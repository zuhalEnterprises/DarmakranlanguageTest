<style>
.table-pic {
    height: 45px;
}
@media (min-width:996px) {
    .table-pic {
    height: 75px;
}
}
    </style>
<div class="my-3 table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ l('کد ملک') }}</th>
                <th scope="col">{{ l('نوع ملک') }}</th>
                <th scope="col">{{ l('شهر') }}</th>
                <th scope="col">{{ l('منطقه') }}</th>

                <th scope="col">{{ l('مساحت کل') }}</th>
                @if ($type == 2)
                <th scope="col">{{ l('قیمت رهن') }}</th>
                <th scope="col">{{ l('قیمت اجاره') }}</th>
                @else

                <th scope="col">
                            {{ l('قیمت') }}</th>
                            <th scope="col">
                            {{ l('قیمت متری') }}</th>

                @endif

                <th scope="col">{{ l('سال ساخت') }}</th>
                <th scope="col">{{ l('تاریخ') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estates as $estate)
            <tr>
                <th scope="row" width="100">
                    <a href="{{$estate->url()}}">
                        <img class="w-100 object-cover rounded-1 table-pic" src="{{$estate->coverImage()}}"
                            alt="real estate" >
                    </a>
                </th>
                <td>
                    <a class="text-body text-decoration-none" href="{{$estate->url()}}">
                        {{$estate->id}}
                    </a>
                </td>
                <td><a class="text-body text-decoration-none" href="{{$estate->url()}}">{{estateTypes($estate->estate_type)}}</a> </td>
                <td><a class="text-body text-decoration-none" href="{{$estate->url()}}">{{$estate->city->name??""}}</a> </td>
                <td><a class="text-body text-decoration-none" href="{{$estate->url()}}">{{$estate->district->name??""}}</a> </td>
                <td><a class="text-body text-decoration-none" href="{{$estate->url()}}">{{!empty($estate->area)?$estate->{{ l('area." متر":""}}') }}</a></td>
                @if ($estate->type == 2)
                    <td><a class="text-body text-decoration-none" href="{{$estate->url()}}">{{ toPersianNumbers($estate->{{ l('mortgage) }} ت') }}</td>
                    <td><a class="text-body text-decoration-none" href="{{$estate->url()}}">{{ toPersianNumbers($estate->{{ l('rent) }} ت') }}</td>
                @else
                    @if ($estate->price > 0)
                        <td><a class="text-body text-decoration-none" href="{{$estate->url()}}">
                            {{ toPersianNumbers($estate->{{ l('price) }} ت') }}
                        </a>
                        </td>
                            <td>
                                <a class="text-body text-decoration-none" href="{{$estate->url()}}">
                            {{ toPersianNumbers($estate->{{ l('price_per_meter) }} ت') }}
                                </a>
                        </td>
                    @else
                        <td> <a class="text-body text-decoration-none" href="{{$estate->url()}}">
                             {{ l('توافقی') }}
                        </a>
                        </td>
                        <td></td>
                    @endif
                @endif
                <td><a class="text-body text-decoration-none" href="{{$estate->url()}}"> {{buildYear($estate->built_year)}}</a> </td>
                <td><a class="text-body text-decoration-none" href="{{$estate->url()}}">{{toPersianDate($estate->showdate)}}</a> </td>

            </tr>
            @endforeach

        </tbody>
    </table>
</div>
