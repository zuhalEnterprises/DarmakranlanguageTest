@foreach($estates as $estate)

<div class="estatetype">
    <div class="rounded-[25px] border-[1px] border-[#E7E7E7]">
            <div class="relative">
                <a class="h-[245px] block" href="{{$estate->url()}}">
                    <img class="rounded-[25px] w-full h-full object-cover" src="{{$estate->coverImage()}}" alt="">
                </a>
                <div class="flex justify-between items-center absolute top-2 px-3 w-full">
                    <span
                        class="bg-white/[0.8] rounded-[25px] text-[#5C5C5C] hover:bg-[#025EC6] hover:text-white px-2 py-[1px]">{{toPersianDate($estate->showdate)}}
                        </span>
                    <span class="itemFavorite-{{$estate->id}} text-[20px]  {{count($estate->favorites)>0?'text-blue-500':'text-gray-500'}}  cursor-pointer hover:text-blue-500" onclick="addFavorite({{$estate->id}}) " data-id="{{$estate->id}}">
                        <i class=" fa-solid fa-bookmark"></i>
                    </span>
                </div>
            </div>
            <a  href="{{$estate->url()}}">
            <div class="p-6">
                <h3 class="text-lg font-extrabold text-[#5C5C5C]">

                    @if(!empty($estate->title))
                    {{$estate->title}}
                @endif

                   </h3>
                <p class="text-[15px] text-[#5C5C5C] font-light mt-4">{{$estate->district->name??""}}-{{$estate->city->name??""}}</p>
                <ul class="mt-4">
                    @if($estate->type == 1)
                    <li class="flex justify-between items-center">
                        <span class="text-base text-[#5C5C5C] font-light">{{ l('قیمت کل') }}</span>
                        <span class="text-xl font-medium text-[#5C5C5C]">
                            @if($estate->price>0)
                            {{toPersianNumbers($estate->{{ l('price)}} تومان') }}<br>
                            @else
                            توافقی
                            <br>
                            @endif</span>
                    </li>
                    <li class="flex justify-between items-center mt-2">
                        <span class="text-base text-[#5C5C5C] font-light">{{ l('قیمت متری') }}</span>
                        <span class="text-xl font-light text-[#5C5C5C]">{{$estate->price_per_meter==0?"":toPersianNumbers($estate->{{ l('price_per_meter)." تومان"}}') }} </span>
                    </li>
                    @endif
                    @if($estate->type == 2)
                    <li class="flex justify-between items-center">
                        <span class="text-base text-[#5C5C5C] font-light">{{ l('ودیعه') }}</span>
                        <span class="text-xl font-medium text-[#5C5C5C]">{{toPersianNumbers($estate->{{ l('mortgage)}} تومان') }}</span>
                    </li>
                    <li class="flex justify-between items-center mt-2">
                        <span class="text-base text-[#5C5C5C] font-light">{{ l('اجاره ماهیانه') }}</span>
                        <span class="text-xl font-light text-[#5C5C5C]">{{toPersianNumbers($estate->{{ l('rent)}} تومان') }}</span>
                    </li>

                    @endif
                </ul>
                <ul class="flex justify-between items-center mt-6">

                @if ($estate->estate_type == 1)
                    <li class="flex justify-between items-center">
                        <span class="text-[15px] text-gray-400">
                            <i class="fa-thin fa-ruler-horizontal"></i>
                        </span>
                        <span class="mr-2 font-light text-[#5C5C5C] text-xs"> {{getFeatureValue($featureValues, $estate->{{ l('room_count)}} خواب') }}</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="text-[15px] text-gray-400">
                            <i class="fa-thin fa-city"></i>
                        </span>
                        <span class="mr-2 font-light text-[#5C5C5C] text-xs"> {{getFeatureValue($featureValues, $estate->usage_type)}}</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="text-[15px] text-gray-400">
                            <i class="fa-thin fa-calendar-days"></i>
                        </span>
                        <span class="mr-2 font-light text-[#5C5C5C] text-xs">{{$estate->{{ l('built_year}} سال ساخت') }}</span>
                    </li>
                    @endif
                    @if($estate->estate_type == 2)

                    <li class="flex justify-between items-center">
                        <span class="text-[15px] text-gray-400">
                            <i class="fa-thin fa-ruler-horizontal"></i>
                        </span>
                        <span class="mr-2 font-light text-[#5C5C5C] text-xs"> {{getFeatureValue($featureValues, $estate->floor_count)}}</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="text-[15px] text-gray-400">
                            <i class="fa-thin fa-city"></i>
                        </span>
                        <span class="mr-2 font-light text-[#5C5C5C] text-xs"> {{ getFeatureValue($featureValues, $estate->geography)}}</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="text-[15px] text-gray-400">
                            <i class="fa-thin fa-calendar-days"></i>
                        </span>
                        <span class="mr-2 font-light text-[#5C5C5C] text-xs"> {{buildYear($estate->{{ l('built_year)}} سال ساخت') }}</span>
                    </li>
                    @endif

                    @if($estate->estate_type == 3 || $estate->estate_type == 4)

                    <li class="flex justify-between items-center">
                        <span class="text-[15px] text-gray-400">
                            <i class="fa-thin fa-ruler-horizontal"></i>
                        </span>
                        <span class="mr-2 font-light text-[#5C5C5C] text-xs"> {{$estate->front_area}}</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="text-[15px] text-gray-400">
                            <i class="fa-thin fa-city"></i>
                        </span>
                        <span class="mr-2 font-light text-[#5C5C5C] text-xs"> {{ getFeatureValue($featureValues, $estate->position_type)}}</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="text-[15px] text-gray-400">
                            <i class="fa-thin fa-calendar-days"></i>
                        </span>
                        <span class="mr-2 font-light text-[#5C5C5C] text-xs">

                            @if ($estate->type == 1)
                            {{getFeatureValue($featureValues, $estate->document_type)}}
                            @endif
                            @if ($estate->type == 2)
                            <svg height="32px" viewBox="0 0 32 32" title="{{ l('قابلیت معاوضه') }}" id="icon" xmlns="http://www.w3.org/2000/svg" width="21px">
                                <defs>
                                    <style>
                                        .cls-1 {
                                            fill: none;
                                        }
                                    </style>
                                </defs>
                                <path d="M31,29.5859l-4.6885-4.6884a8.028,8.028,0,1,0-1.414,1.414L29.5859,31ZM20,26a6,6,0,1,1,6-6A6.0066,6.0066,0,0,1,20,26Z" />
                                <path d="M8,26H4a2.0021,2.0021,0,0,1-2-2V20H4v4H8Z" />
                                <rect x="2" y="12" width="2" height="4" />
                                <path d="M26,8H24V4H20V2h4a2.0021,2.0021,0,0,1,2,2Z" />
                                <rect x="12" y="2" width="4" height="2" />
                                <path d="M4,8H2V4A2.0021,2.0021,0,0,1,4,2H8V4H4Z" />
                                <rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;" class="cls-1" width="32" height="32" />
                            </svg>
                        {{getFeatureValue($featureValues, $estate->convertible)}}
                            @endif

                        </span>
                    </li>
                    @endif
                </ul>
            </div>
            </a>
    </div>
</div>

@endforeach
<script>
 function addFavorite(id){ $.get("/estates/favorite/" + id, function (data, status) { if (data.result == 1) { toast({ type: 'success', text: 'ملک مورد نظر به لیست نشان شده های شما افزوده شد.' }); $(".itemFavorite-" + id).addClass("favorited"); } else { toast({ type: 'error', text: 'ملک مورد نظر از لیست نشان شده های شما حذف شد.' }); $(".itemFavorite-" + id).removeClass("favorited"); } }); }
</script>
