<div class="card card-hover border-1 h-100 rounded rounded-md-3 ">
    <div class="tns-carousel-wrapper card-img-top card-img-hover">
        <div class="position-absolute start-0 top-0 pt-3 ps-3">
            @if(isValueShow($estate->conditions,15))
                <span class="d-table badge bg-success mb-1">{{l('پیش فروش')}}</span>
            @endif
        </div>
        <div class="content-overlay end-0 top-0 pt-3 pe-3">
            @if(\Auth::user())
            <button class="itemFavorite_{{$estate->id}} text-[20px]    btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" onclick="addFavorite({{$estate->id}}) " data-id="{{$estate->id}}">
                <i class="fa-solid fi-heart{{count($estate->favorites)>0?'-filled':''}}"></i>
            </button>
            @endif
        </div>
        <div @if(isset($slider) && $slider == true) class="tns-carousel-inner" data-carousel-options='{"items":1}' @endif style="cursor: pointer" onclick="window.location='{{$estate->url()}}'">
            @if(!(isset($slider) && $slider == true))
            <div>
                <img src="{{ crop($estate->coverImage() , 400 , 400) != '' ? crop($estate->coverImage() , 400 , 400) : asset('/img/site'.ss('SITE_ID').'/estate'.$estate->estate_type.rand(1,2).'.jpg') }}" alt="Image" style="height: 200px;width:100%;object-fit:cover">
            </div>
            @endif
            @if(isset($slider) && $slider == true)
            @foreach ($estate->images->where("is_360","=",0)->sortBy("priority")->take(3) as $url)
            <div>
                <img src="{{ crop('/upload/images/estate/'.$url->url(),400,400) }}" alt="Image" style="height: 200px;width:100%;object-fit:cover">
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <div class="card-body position-relative p-2">
        <a href="{{$estate->url()}}">
            <div class="fw-bold">
                @if ($estate->type == 2)
                <div>
                    <div>
                        <i class="fi-cash lead align-middle opacity-70"></i> {{l('اجاره')}}:
                        {{ toPersianNumbers($estate->rent) }} {{l('درهم')}}
                        @php
                        switch($estate->rentfrequency)
                        {
                            case "1": $rentfrequency = l('/روزانه'); break;
                            case "7": $rentfrequency = l('/هفتگی'); break;
                            case "30": $rentfrequency = l('/ماهانه'); break;
                            case "365": $rentfrequency = l('/سالانه'); break;
                            default: $rentfrequency = '';
                        }
                        echo $rentfrequency;
                        @endphp
                    </div>
                </div>
                @else
                    @if ($estate->price > 0)
                        <div>
                            <i class="fi-cash lead align-middle opacity-70 d-none"></i>
                            {{ l('قیمت:') }}
                            <span class="lead">
                                @if(isValueShow($estate->conditions,15) && !isValueShow($estate->{{ l('conditions,384)) از') }} <span class="priceval">{{ toPersianNumbers($estate->price) }}</span>
                                {{ l('تا') }} <span class="priceval">{{ toPersianNumbers($estate->mortgage) }}</span>
                                @else
                                <span class="priceval">{{ toPersianNumbers($estate->price) }}</span>
                                @endif
                            </span>
                            {{l('درهم')}}
                        </div>
                    @else
                        <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('قیمت')}}:
                            {{l('توافقی')}}
                        </div>
                    @endif
                @endif
            </div>
            <div class="mt-2">
                @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                <span class="d-inline-block">
                    <i class="fi-bed fs-lg text-muted"></i>
                    {{ $estate->room_count == 0 || getFeatureValue($featureValues , $estate->room_count) == l('بدون اتاق')  ? 'Studio' : l(getFeatureValue($featureValues , $estate->room_count))}}
                </span>
                @if($estate->bath_count>0)
                <span class="d-inline-block mx-1">
                    <i class="fi-bath  fs-lg text-muted"></i>
                    {{$estate->bath_count}}
                </span>
                @endif
                <span class="d-inline-block mx-1">
                    <i class="fi-grid fs-lg text-muted"></i>

                    @if(isValueShow($estate->conditions,15) && !isValueShow($estate->conditions,384))
                    از {{$estate->area}}
                    تا {{$estate->front_area}}
                    @else
                    {{$estate->area}}
                    @endif
                    <span class="areakey">sqft</span>
                </span>
                @endif
            </div>
            <p class="mb-2 fs-sm text-muted mt-3">
                {{ estateTypes($estate->estate_type) }} در
                {{ $estate->city->name ?? '' }}
                {{ $estate->district->name ?? '' }}
            </p>
            <h3 class="fs-sm">
                @if (!empty($estate->project_id) && isset($estate->project))
                <a target="_blank" class="fs-sm" href="{{$estate->project->post_id>0 && isset($estate->project->post) ? $estate->project->post->url() : 'javascript:void(0)'}}">
                {{ $estate->project->name }}
                </a>
                |
                @endif
                @if (!empty($estate->manufacturer_id))

                <a target="_blank" class="fs-sm" href="{{$estate->manufacturer->post_id>0 && isset($estate->project->post) ? $estate->manufacturer->post->url() : 'javascript:void(0)'}}">
                {{ $estate->manufacturer->name }}
                </a>
                |
                @endif
                @if (!empty($estate->brand_id))

                    <a target="_blank" class="fs-sm" href="{{$estate->brand->post_id>0 && isset($estate->brand->post) ? $estate->brand->post->url() : 'javascript:void(0)'}}">
                    {{ $estate->brand->name }}
                    </a>
                    |
                @endif
            </h3>
        </a>
    </div>
    <div class="card-footer  p-2 py-0" >
        <div class="d-flex justify-content-between align-items-center mx-1 text-nowrap p-1">
            <!-- اطلاعات کارشناس (سمت چپ) -->
            <div class="d-flex align-items-center">
                @php
                    $photo = $estate->expert ? $estate->expert->photo() : $estate->getAdminAttribute()->photo();
                @endphp
                <img alt="Agent" loading="lazy" width="50" height="50" class="rounded-lg" src="{{ $photo ?? asset('upload/images/avatar_man.png') }}">
                <div class="ms-3">
                    <p class="text-sm font-medium mb-0">{{ $estate->expert ? $estate->expert->fullname() : $estate->getAdminAttribute()->fullname()}}</p>
                    <p class="text-sm text-muted mb-0">
                        @php
                            $activity_type = $estate->expert ? $estate->expert->activity_type : $estate->getAdminAttribute()->activity_type;
                        @endphp
                        {{l('کارشناس '.($activity_type == 1 ? l('فروش') : ($activity_type == 2 ? l('اجاره') : l('فروش'))))}}
                    </p>
                </div>
            </div>

            <!-- دکمه‌های تماس (سمت راست) -->
            <div class="d-flex gap-2">

                @php

                    $phone = $estate->expert != null ? $estate->expert->phone : $estate->getAdminAttribute()->phone;
                @endphp
                <!-- تماس -->
                <a href="tel:{{ $phone }}" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" style="background-color: #fce4ec; width: 36px; height: 36px;">
                    <i class="fi-phone" style="color: #e91e63;"></i> <!-- صورتی تیره -->
                </a>

                <!-- واتساپ -->
                <a href="https://wa.me/{{ $phone }}" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e8f5e9; width: 36px; height: 36px;" target="_blank">
                    <i class="fi-whatsapp" style="color: #25D366;"></i> <!-- سبز واتساپ -->
                </a>
            </div>
        </div>
        <div class="border-top pt-2 pb-2 text-center">

        </div>



    </div>

</div>
