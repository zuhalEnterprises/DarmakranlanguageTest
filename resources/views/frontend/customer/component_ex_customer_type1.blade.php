
@foreach($model as $item)
<div class="col-md-6">
    <div class="card card-hover border-0 shadow-sm mb-4">
        <div class="card-header bg-secondary">
            @if(!$currentUser->isAdmin() && $currentUser->id != $item->user_id )
            <span class="fw-bold">{{l('نام مشاور')}}:</span>
            <span class="">
                {{$item->user->fullname() ?? ''}}
            </span>
            @else
            <span class="fw-bold">{{l('نام خریدار')}}:</span>
            <span class="">
                {{$item->name}}
            </span>

            @endif
        </div>
        <div class="card-body">
            <p class="fw-bold mb-2">

                {{$item->request_type == 1 ? l('خرید') : l('اجاره')}}
                {{l(mapEstateCategoryName($item->estate_type))}}
            </p>

            @php
            $_districtList = array();
            @endphp

            <p> @if(count($item->districts))
                {{l('در')}}
                @endif
                @foreach($item->districts as $district)
                @php
                $_districtList[] = $district->name
                @endphp

                @endforeach
                {{implode(' , ',$_districtList)}}
            </p>

            <div class="d-flex gap-5 align-items-center mb-2">
                <div>
                    @if($item->area_min>0) {{l('از')}}<span>{{$item->area_min}}</span>{{l('متر به بالا')}} @endif
                </div>

                @if($item->request_type == 1)
                <div>
                    @if($item->price_max>0)
                    {{l('تا')}} <span>{{toPersianNumbers($item->price_max)}}</span> {{l('تومان')}}
                    @endif
                </div>
                @else
                    @if($item->mortgage_max>0 )
                    <div>
                    {{l('رهن تا')}} <span>{{toPersianNumbers($item->mortgage_max)}}</span> {{l('تومان')}}
                    </div>
                    @endif
                    @if($item->rent_max>0 )
                    <div>
                    {{l('اجاره تا')}} <span>{{toPersianNumbers($item->rent_max)}}</span> {{l('تومان')}}
                    </div>
                    @endif
                @endif
                </div>
            </div>
            <a href="/customer/{{$item->id}}" class="btn btn-primary btn-sm">{{l('جزییات خریدار')}} </a>
        </div>
    </div>
</div>
@endforeach
