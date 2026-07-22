<div class="card shadow-sm card-hover border-0 h-100">
    <div class="card-img-top card-img-hover">
        <div class=" p-2 ">
            <div class="overflow-hidden rounded">
                <div class="position-absolute start-0 top-0 pt-3 pe-3">
                    <span
                        class="d-table badge bg-info mb-1">{{ toPersianDate($estate->created_at) }}
                    </span>
                </div>
                <img class="card-est" src="{{ crop($estate->coverImage() , 400 , 400) }}" />
            </div>
            <h3 class="fs-5 my-3"><a href="{{$estate->url()}}" alt="{{ $estate->title }}">{{ !empty($estate->title) ? $estate->title : estateTypes($estate->estate_type) . l('در') . ($estate->district->name ?? '') . ' ' . ($estate->city->name ?? '') }}</a></h3>
            <div class="text-black-50">
                <i class="fi fi-map-pin"></i>
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

                    <span class="text-white">{{ " - ".$estate->district->name}}</a>

                @endif
                @if($estate->street && $estate->street->name)

                        <span class="text-white">{{ " - ".$estate->street->name}}</span>

                @endif
            </div>
            <div class="my-3 gap-2 align-items-center">
                @if ($estate->type == 2)
                    <div class="fs-5">
                        <i class="fi-cash lead align-middle opacity-70"></i> {{l('رهن')}}:
                        {{ toPersianNumbers($estate->{{ l('mortgage) }} تومان') }}
                    </div>
                    <div class="fs-5">
                        <i class="fi-cash lead align-middle opacity-70"></i> {{l('اجاره')}}:
                        {{ toPersianNumbers($estate->{{ l('rent) }} تومان') }}
                    </div>
                @else
                    @if ($estate->price > 0)
                        <div class="fs-5"><i class="fi-cash lead align-middle opacity-70"></i>
                            {{ toPersianNumbers($estate->{{ l('price) }} تومان') }}
                        </div>
                    @else
                        <div class="fs-5">
                            <i class="fi-cash lead align-middle opacity-70"></i> {{l('قیمت')}}:
                            {{l('توافقی')}}
                        </div>
                    @endif
                @endif

            </div>
            <div class="d-flex mt-3 border ">
                <div class="row w-100">
                    @if ($estate->estate_type == 1 || $estate->estate_type == 2)
                    <div class="col-4 d-flex flex-column align-items-center justify-content-center p-2 gap-2  border-end">
                        <div class="proprty_icon">
                        <i class="fi fi-layers"></i>
                        </div>
                        <h5 class="fs-xs text-dark mb-0">{{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}</h5>
                    </div>
                    <div class="col-4 d-flex flex-column align-items-center justify-content-center p-2 gap-2 border-end">
                        <div class="proprty_icon">
                            <i class="fi fi-geo"></i>
                        </div>
                        <h5 class="fs-xs text-dark mb-0">{{ getFeatureValue($featureValues, $estate->geography) }}</h5>
                    </div>
                    <div class="col-4 d-flex flex-column align-items-center justify-content-center p-2 gap-2">
                        <div class="proprty_icon">
                            <i class="fi fi-clock"></i>
                        </div>
                        <h5 class="fs-xs text-dark mb-0">ساخت:
                            {{ buildYear($estate->built_year) }}</h5>
                    </div>
                    @endif
                    @if ($estate->estate_type == 3 || $estate->estate_type == 4)
                    <div class="col-4 d-flex flex-column align-items-center justify-content-center p-2 gap-2  border-end">
                        <div class="proprty_icon">
                        <i class="fi fi-layers"></i>
                        </div>
                        <h5 class="fs-xs text-dark mb-0">{{ !empty($estate->area) ? $estate->{{ l('area . \' متر\' : \'\' }}') }}</h5>
                    </div>
                    <div class="col-4 d-flex flex-column align-items-center justify-content-center p-2 gap-2 border-end">
                        <div class="proprty_icon">
                            <i class="fi fi-geo"></i>
                        </div>
                        <h5 class="fs-xs text-dark mb-0">{{ getFeatureValue($featureValues, $estate->geography) }}</h5>
                    </div>
                    <div class="col-4 d-flex flex-column align-items-center justify-content-center p-2 gap-2">
                        <div class="proprty_icon">
                            <i class="fi fi-real-estate-buy"></i>
                        </div>
                        <h5 class="fs-xs text-dark mb-0">
                            @if ($estate->type == 1)
                            {{ getFeatureValue($featureValues, $estate->document_type) }}
                            @endif
                            @if ($estate->type == 2)
                                {{ getFeatureValue($featureValues, $estate->convertible) }}
                            @endif
                        </h5>
                    </div>
                    @endif
                </div>
            </div>
            <div class="d-flex mt-3">
                <div class="apart">{{ estateTypes($estate->estate_type) }} &nbsp;  برای
                    @if ($estate->type == 1)
                    فروش
                    @else
                    رهن و اجاره
                    @endif</div>
                <div class="sale">

                </div>
            </div>
        </div>
    </div>
</div>

