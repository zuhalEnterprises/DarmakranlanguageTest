<table id="example" style="width: 100%" class="table table-bordered table-striped table-hover" dir="rtl">
    <thead class="table-primary">
            <tr>
                {{-- <th class="text-center" style="width: 50px;">{{ l('ردیف') }}</th>--}}
                <th class="text-center fixed-width-sm">{{ l('شناسه') }}
                    <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'id']))}}"><i class="icon-caret-down"></i></a>
                    <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'-id']))}}"><i class="icon-caret-up"></i></a>
                </th>

                <th class="text-center">{{ l('کد قولنامه') }}</th>
                <th class="text-center">{{ l('تاریخ ثبت قولنامه') }}
                    <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'register_at']))}}"><i class="icon-caret-down"></i></a>
                    <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'-register_at']))}}"><i class="icon-caret-up"></i></a>
                </th>
                <th class="text-center">{{ l('نوع قولنامه') }}</th>
                <th class="text-center">{{ l('نوع ملک') }}</th>
                <th class="text-center">{{ l('جمع کمیسیون(تومان)') }}</th>

                <th class="text-center"></th>
            </tr>

    </thead>
    <tbody>
            @foreach( $model as $item)
            <tr>
                {{-- <td class="text-center"><input type="checkbox" class="checkboxes" name="ids[]" value="{{$item->id}}" /></td>--}}
                {{-- <td class="text-center">{{toPersianNumbers($loop->iteration)}}</td>--}}
                <td tabindex="0" class="text-center">{{$item->id}}</td>

                <td class="text-center"><span class="bg-gray label text-sm">{{$item->contractid}}</span></td>
                <td>{{($item->register_at > '1970-01-01') ? toPersianDateYdm($item->register_at):''}}</td>
                <td>{{$item->type == 1 ? l('فروش') : ($item->{{ l('type == 2 ? \'اجاره\' : \'غیره\')}}') }}</td>
                <td>{{mapEstateCategoryName($item->estate_type)}}</td>
                <td class="text-center">{{toPersianNumbers($item->total_commission)}}</td>

                <td class="text-center">

                    @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super'))
                    <a href="/profile/contract/{{$item->id}}/edit" class="icon edit text-decoration-none">
                        <i class="fa fa-edit "></i>
                    </a>
                    @endif
                    @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super'))
                    <span data-toggle="tooltip" title="{{ l('نمایش پرداختی های قولنامه') }}">
                        <a href="/profile/contractearn/{{$item->id}}" class="text-decoration-none">
                            <i class="fa {{$item->archived == 1 ? 'fa-folder' : 'fa-folder-open'}}"></i>
                        </a>
                    </span>
                    @endif

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
