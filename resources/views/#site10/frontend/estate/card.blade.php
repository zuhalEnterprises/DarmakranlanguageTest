
<div class="card shadow-sm card-hover border-0 h-100">
    <div class="card-img-top card-img-hover">
        <a class="img-gradient-overlay" href="{{$estate->url()}}" target="_blank" style="padding:0;"></a>

        <div class="position-absolute start-0 top-0 pt-3 pe-3">
            <span
                class="d-table badge bg-info mb-1">{{ toPersianDate($estate->created_at) }}</span>
            <span
                class="d-table badge bg-primary">{{ estateTypes($estate->estate_type) }}</span>
        </div>
        <div class="content-overlay end-0 top-0 pt-3 ps-3">
            @if(\Auth::user())
            <button class="itemFavorite_{{$estate->id}} text-[20px]  {{count($estate->favorites)>0?'text-blue-500':'text-gray-200'}}  btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="right" onclick="addFavorite({{$estate->id}}) " data-id="{{$estate->id}}">
                    <i class="fa-solid fa-bookmark"></i>
            </button>
            @endif
        </div>
        <img src="{{ crop($estate->coverImage() , 400 , 400) != '' ? crop($estate->coverImage() , 400 , 400) : asset('/img/site'.ss('SITE_ID').'/estate'.$estate->estate_type.rand(1,2).'.jpg') }}"
            style="height: 200px;width:100%;object-fit:cover"
            data-src="{{ crop($estate->coverImage() , 400 , 400) != '' ? crop($estate->coverImage() , 400 , 400) : asset('/img/site'.ss('SITE_ID').'/estate'.$estate->estate_type.rand(1,2).'.jpg') }}" alt="{{ $estate->title }}">

            <!-- start -->
            <div class="position-absolute bottom-0 pb-2 px-3 zindex-10">
                <h3 class="h6 mb-2 fs-base">
                    <a target="_blank" class=" text-white" href="{{$estate->url()}}">
                        {{ estateTypes($estate->{{ l('estate_type) }} در') }}
                    </a>
                        @if($estate->city->name)
                            @if($estate->city->post_id == null)
                                <span class="text-white">{{ $estate->city->name}}</span>
                            @else
                                <a  class=" text-white" href="{{$estate->city->post->url()}}" target="_blank" title="املاک {{ estateTypes($estate->estate_type) }} {{ $estate->city->name}}">
                                    {{ $estate->city->name}}
                                </a>
                            @endif
                        @endif
                        @if($estate->district && $estate->district->name)
                            @if($estate->district->post_id == null)
                            <span class="text-white">{{ " - ".$estate->district->name}}</a>
                            @else
                            <span class="text-white">-</span> <a  class=" text-white" href="{{$estate->district->post->url()}}" target="_blank"  title="املاک {{ estateTypes($estate->estate_type) }} {{ $estate->district->name}}">
                                    {{ $estate->district->name}}
                                </a>
                            @endif
                        @endif
                        @if($estate->street && $estate->street->name)
                            @if($estate->street->post_id == null)
                                <span class="text-white">{{ " - ".$estate->street->name}}</span>
                            @else
                            <span class="text-white">-</span> <a  class="text-white" href="{{$estate->street->post->url()}}" target="_blank"  title="املاک {{ estateTypes($estate->estate_type) }} {{ $estate->street->name}}">
                                    {{ $estate->street->name}}
                                </a>
                            @endif
                        @endif
                </h3>
                <div class="d-flex justify-content-between align-content-center">
                    <!-- detail -->
                    <div>
                        @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                            <span class="d-inline-block  fs-sm text-white">
                                <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                            </span>
                            <span class="d-inline-block  fs-sm text-white">
                                <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                {{ getFeatureValue($featureValues, $estate->geography) }}
                            </span>
                            <span class="d-inline-block  fs-sm text-white">
                                <i class="fi-clock me-1 mt-n1 fs-lg text-muted"></i> ساخت:
                                {{ buildYear($estate->built_year) }}
                            </span>
                        @endif
                        @if ($estate->estate_type == 3 || $estate->estate_type == 4)
                            <span class="d-inline-block  fs-sm text-white">
                                <i class="fi-layers me-1 mt-n1 fs-lg text-muted"></i>
                                {{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}
                            </span>
                            <span class="d-inline-block  fs-sm text-white">
                                <i class="fi-geo me-1 mt-n1 fs-lg text-muted"></i>
                                {{ getFeatureValue($featureValues, $estate->geography) }}
                            </span>
                            <span class="d-inline-block  fs-sm text-white">
                                <i class="fi-real-estate-buy me-1 mt-n1 fs-lg text-muted"></i>
                                @if ($estate->type == 1)
                                    {{ getFeatureValue($featureValues, $estate->document_type) }}
                                @endif
                                @if ($estate->type == 2)
                                    {{ getFeatureValue($featureValues, $estate->convertible) }}
                                @endif
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <!-- end -->
    </div>

    <div class="card-footer d-flex align-items-center justify-content-between pt-3 text-nowrap">

        @if ($estate->type == 2)
            <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('رهن')}}:
                {{ toPersianNumbers($estate->mortgage) }} {{l('ت')}}</div>
            <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('اجاره')}}:
                {{ toPersianNumbers($estate->rent) }} {{l('ت')}}</div>
        @else
            @if ($estate->price > 0)
                <div><i class="fi-cash lead align-middle opacity-70"></i>
                    {{ toPersianNumbers($estate->price) }} {{l('ت')}}</div>
                @if(env('COUNTRY') != 'UAE')
                <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('متری')}}:
                    {{ toPersianNumbers($estate->price_per_meter) }} {{l('ت')}}
                </div>
                @endif
            @else
                <div><i class="fi-cash lead align-middle opacity-70"></i> {{l('قیمت')}}:
                    {{l('توافقی')}}
                </div>
            @endif
        @endif
    </div>
</div>
