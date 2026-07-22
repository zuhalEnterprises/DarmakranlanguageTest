@foreach($estates as $estate)
    <!-- Item-->
    <div class="col-sm-12 col-xl-6 pt-3">
        <div class="card shadow-sm card-hover h-100">
            <div class="card-img-top card-img-hover">
                <a class="img-gradient-overlay" href="{{ $estate->url() }}" target="_blank" style="padding:0;"></a>
                <!-- <a class="link-img p-0" href="{{ $estate->url() }}" target="_blank" style="padding:0;"></a> -->
                <div class="position-absolute start-0 top-0 pt-3 pe-3">
                    <span
                        class="d-table badge bg-info m-1">{{ toPersianDate($estate->updated_at) }}</span>

                </div>
                <div class="content-overlay end-0 top-0 p-3 ps-3 m-1">
                    @if(\Auth::user())
                    <button class="itemFavorite_{{$estate->id}} text-[20px]  {{count($estate->favorites)>0?'text-blue-500':'text-gray-200'}}  btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" onclick="addFavorite({{$estate->id}}) " data-id="{{$estate->id}}">
                            <i class="fa-solid fa-bookmark"></i>
                    </button>
                    @endif
                </div>
                <img src="{{ $estate->coverImage() }}" class="rounded-1 imgestate object-cover" style="height: 200px;width:100%;object-fit:cover" data-src="{{ $estate->coverImage() }}" alt="{{ $estate->title }}">

                <!-- start -->
                <div class="position-absolute bottom-0 pb-2 px-3 zindex-10">
                    <h3 class="h6 mb-2 fs-base">
                        <a target="_blank" class="nav-link stretched-link text-white" href="{{ $estate->url() }}">
                            {{ estateTypes($estate->estate_type) . ' in ' . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? '') }}</a>
                    </h3>

                </div>
                <!-- end -->
            </div>


            <div class="card-body d-flex align-items-center justify-content-between text-nowrap p-3">
                <div class="d-flex flex-column gap-2 w-100">

                    <h4 class="fs-sm fw-normal text-uppercase text-primary m-0"></h4>
                    <h3 class="h6 m-0 fs-base">
                        <a class="nav-link" href="{{$estate->url()}}">
                            @if($estate->title != '')
                                {{$estate->title}}
                            @else
                                {{estateTypes($estate->estate_type)}} | {{$estate->area}} متر مربع
                            @endif
                        </a>
                    </h3>
                    <div class="row mb-3">
                        <div class="col-12 col-md-12 col-lg-12 col-sm-12 mt-1">

                            <i class="fi-cash mt-n1 me-1 mt-n1 fs-lg text-muted"></i>
                            @if($estate->type==1)
                            {{ toPersianNumbers($estate->price) }} {{l('ت')}}
                            @else
                            {{ toPersianNumbers($estate->rent) }} {{l('ت')}}
                            @php
                            switch($estate->rentfrequency)
                            {
                            case "1": $rentfrequency = ' /Daily'; break;
                            case "7": $rentfrequency = ' /Weekly'; break;
                            case "30": $rentfrequency = ' /Montly'; break;
                            case "365": $rentfrequency = ' /Yearly'; break;
                            default: $rentfrequency = '';
                            }
                            echo $rentfrequency;
                            @endphp
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap">
                <span class="d-inline-block mx-1 px-2 fs-sm">
                    <i class="fa-thin fa-ruler-horizontal me-1 mt-n1 fs-lg text-muted"></i>
                    {{$estate->area}} {{l('متر مربع')}}

                </span>
                <span class="d-inline-block mx-1 px-2 fs-sm">
                    <i class="fi-bed ms-1 mt-n1 fs-lg text-muted"></i>
                    {{ (int)getFeatureValue($featureValues, $estate->room_count) == 0 ? l(getFeatureValue($featureValues, $estate->room_count)) : getFeatureValue($featureValues, $estate->room_count)}}
                </span>
                @if($estate->bed_count>0)
                <span class="d-inline-block mx-1 px-2 fs-sm">
                    <i class="fi-bath ms-1 mt-n1 fs-lg text-muted"></i>
                    {{$estate->bed_count}}

                </span>
                @endif
            </div>
        </div>
    </div>
    <!-- Item-->
@endforeach

