@foreach($estates as $estate)


<div class="col-sm-12 col-md-6 col-lg-6 mb-4 main">

    <div class="property_listing_wrapper h-100">
        <div class="property_listing ovh pos-r h-100 font_9 d-flex flex_direction_column mx-auto">

            <!-- image box -->
            <div class="listing-unit-img-wrapper w-100 pos-r">
                <!-- image -->
                <div class="property_thumbnail">
                    <a href="{{ $estate->url() }}" class="card-group card-link">
                        <img style="background:#f8f9ff;height:220px!important" class="imgthum" src="{{$estate->coverImage()}}" data-src="{{$estate->coverImage()}}" class="lazyload" alt="" loading="lazy">
                    </a>
                </div>

                <!-- heart -->

                <div class="pos-abs icon-fav ">
                    @if($currentUser)
                    <!-- <a data-toggle="tooltip" title="{{ l('افزودن به علاقمندی ها') }}"> -->
                    <svg  xmlns="http://www.w3.org/2000/svg"   viewBox="0 0 40 40" data-testid="complex-svg-heart" width="35" height="35" aria-hidden="true" focusable="false" tabindex="-1">
                    <path fill="rgba(0,0,0,0.4)" onclick="addFavorite({{$estate->id}}) " data-id="{{$estate->id}}" class="{{count($estate->favorites)>0?'favorited':''}} fill-none heart favorite itemFavorite-{{$estate->id}}"  stroke="#ffffff" stroke-width="3" data-testid="complex-svg-heart-path" d="M20 8.3c4.9-8 18.5-5.9 18.5 5l-.1 1.9c-.8 4.6-4 9.3-8.9 14a66.6 66.6 0 0 1-8.7 7l-.7.6-.8-.5a27.6 27.6 0 0 1-2.8-1.7c-2-1.4-4-3-6-4.7-5.6-5-9-10.3-9-15.8A10 10 0 0 1 20 8.3z"></path>
                    </svg>
                    @endif
                </div>
            </div>

            <!-- descripton -->
            <div class="property-unit-information-wrapper flex-grow-1">
                <!-- عنوان -->
                <h5 class="title">
                    <a class="font_15 font_800 color_black" href="{{ $estate->url() }}">
                        {{$estate->type==1? l("فروش"):l("رهن و اجاره")}} {{estateTypes($estate->estate_type)}} {{!empty($estate->area)?$estate->area." متری":l("توافقی") }}

                        در {{$estate->district->name??""}} {{$estate->city->name??""}}


                    </a>
                </h5>
                <!-- قیمت  -->
                <div class="listing_unit_price_wrapper mb-2">

                    <span class="font_14 mb-1 font_700 color_main_orange totl_price">
                        @if($estate->type == 2)
                        ودیعه: {{toPersianNumbers($estate->{{ l('mortgage)}} تومان') }}<br>
                        اجاره ماهیانه:{{toPersianNumbers($estate->{{ l('rent)}} تومان') }}<br>
                        @else
                            @if($estate->price>0)
                            {{toPersianNumbers($estate->{{ l('price)}} تومان') }}<br>
                            @else
                            توافقی<br>
                            @endif
                        @endif
                    </span>
                    @if($estate->price_per_meter!=0)
                    <small class="font_12 d-block color_grey price_per_meter">متری {{toPersianNumbers($estate->{{ l('price_per_meter)}} تومان') }}</small>
                    @endif
                </div>
                <!-- توضیحات -->
                <div class="listing_details text ovh mb-2">
                    {{$estate->description}}
                </div>
                <!-- جزئیات -->
                <div class="property_listing_details">
                    <?php
                    if ($estate->estate_type == 1) {
                    ?>
                      @if(!empty(getFeatureValue($featureValues, $estate->room_count)))
                        <span class="document_type" title="{{ l('تعداد اتاق') }}">

                            <i class="fa fa-bed"></i>
                            {{getFeatureValue($featureValues, $estate->{{ l('room_count),l("خواب")}}') }}


                        </span>
                        @endif
                        @if(!empty(getFeatureValue($featureValues, $estate->usage_type)))
                        <span class="location" title="{{ l('نوع کاربری') }}">

                            <i class="fa fa-house"></i>
                            {{getFeatureValue($featureValues, $estate->usage_type)}}

                        </span>
                        @endif
                        @if(!empty(getFeatureValue($featureValues, $estate->built_year)))
                        <span class="area" title="{{ l('سال ساخت') }}">
                            <i class="fa fa-calendar"></i>
                            {{getFeatureValue($featureValues, $estate->built_year)}}

                        </span>
                        @endif
                    <?php
                    }
                    if ($estate->estate_type == 2) {

                    ?>
                    @if(!empty(getFeatureValue($featureValues, $estate->floor_count)))
                        <span class="document_type" title="{{ l('تعداد طبقه') }}">

                        <i class="fa fa-building"></i>
                            <?php echo getFeatureValue($featureValues, $estate->floor_count); ?>
                        </span>
                        @endif
                        @if(!empty(getFeatureValue($featureValues, $estate->geography)))
                        <span class="location" title="{{ l('جهت جغرافیایی') }}">
                        <i class="fa fa-compass"></i>
                            <?php echo  getFeatureValue($featureValues, $estate->geography); ?>
                        </span>
                        @endif
                        @if(!empty(getFeatureValue($featureValues, $estate->built_year)))
                        <span class="area" title="{{ l('سال ساخت') }}">
                        <i class="fa fa-calendar"></i>
                        <?php echo getFeatureValue($featureValues, $estate->built_year); ?>
                        </span>
                        @endif
                    <?php
                    }

                    if ($estate->estate_type == 3 || $estate->estate_type == 4) {
                    ?>
                        @if(!empty($estate->front_area))
                        <span class="document_type" title="{{ l('متراژ بر') }}">
                            <i class="fa fa-ruler-horizontal"></i>
                            <?php echo $estate->front_area ?>
                        </span>
                        @endif
                        @if(!empty(getFeatureValue($featureValues, $estate->position_type)))
                        <span class="location" title="{{ l('موقعیت مکانی') }}">
                            <i class="fa fa-compass"></i>
                            <?php echo getFeatureValue($featureValues, $estate->position_type); ?>
                        </span>
                        @endif
                        <span class="area" title="{{ l('نوع سند') }}">
                            <?php
                            if ($estate->type == 1) {
                                if(!empty(getFeatureValue($featureValues, $estate->document_type))){
                                ?>

                                    <i class="fa fa-file-signature"></i>
                                <?php echo getFeatureValue($featureValues, $estate->document_type);
                                }
                            }
                            if ($estate->type == 2) {
                                if(!empty(getFeatureValue($featureValues, $estate->convertible))){
                            ?>
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
                            <?php
                                echo getFeatureValue($featureValues, $estate->convertible);
                                        }
                            }
                            ?>
                        </span>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <!--  footer -->
            <div class="property-footer font_9 d-flex align-items-center justify_content_between">
                <!-- نام کارشناس -->
                <div class="property_agent_wrapper d-flex align-items-center font_11">
                    @if($estate->expert!=false && $estate->expert->isExpert())
                    <a href="{{$estate->expert->id?'/agents_v2/'.$estate->expert->id:'javascript:void(0)'}}">
                        <div class="property_agent_image radius-3" style="background-image:url('{{$estate->expert ? $estate->expert->photo() : noImage()}}')">
                        </div>
                    </a>
                    @endif
                    @if($estate->expert!=false && $estate->expert->isExpert())
                    <a href="{{$estate->expert->id?'/agents_v2/'.$estate->expert->id:'javascript:void(0)'}}">

                        {{!empty($estate->expert->title)?($estate->expert->title):($estate->expert->fullname())}}

                    </a>
                    {{-- @else

                    {{$estate->owner_name}} --}}
                    @endif
                </div>

                <!-- باکس تماس -->

                <div class="property_agent_actions">
                    <a href="tel:+98{{substr(!empty($estate->expert)?$estate->expert->username:$estate->phone,1)}}" class="radius-20 font_9" data-toggle="tooltip" title="{{ l('تماس با کارشناس') }}">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 53.942 53.942" style="enable-background:new 0 0 53.942 53.942;" xml:space="preserve">
                            <path d="M53.364,40.908c-2.008-3.796-8.981-7.912-9.288-8.092c-0.896-0.51-1.831-0.78-2.706-0.78c-1.301,0-2.366,0.596-3.011,1.68
	c-1.02,1.22-2.285,2.646-2.592,2.867c-2.376,1.612-4.236,1.429-6.294-0.629L17.987,24.467c-2.045-2.045-2.233-3.928-0.632-6.291
	c0.224-0.309,1.65-1.575,2.87-2.596c0.778-0.463,1.312-1.151,1.546-1.995c0.311-1.123,0.082-2.444-0.652-3.731
	c-0.173-0.296-4.291-7.27-8.085-9.277c-0.708-0.375-1.506-0.573-2.306-0.573c-1.318,0-2.558,0.514-3.49,1.445L4.7,3.986
	c-4.014,4.013-5.467,8.562-4.321,13.52c0.956,4.132,3.742,8.529,8.282,13.068l14.705,14.705c5.746,5.746,11.224,8.66,16.282,8.66
	c0,0,0,0,0.001,0c3.72,0,7.188-1.581,10.305-4.698l2.537-2.537C54.033,45.163,54.383,42.833,53.364,40.908z" />

                        </svg>

                    </a>
                    <!--a href="https://api.whatsapp.com/send?text=سلام {{!empty($estate->expert)?($estate->expert->title??$estate->expert->fullname()):$estate->owner_name}} عزیز من این ملک را در سایت {{ss('SITE_NAME')}} دیدم. خوشحال میشم تا اطلاعات بیشتری در مورد این ملک به من بدید ekama.ir{{ $estate->url() }} &phone=+98{{substr(!empty($estate->expert)?$estate->expert->username:$estate->phone,1)}}" class="radius-20 font_9" data-toggle="tooltip" title="{{ l('ارتباط با کارشناس در واتساپ') }}">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30.667px" height="30.667px" viewBox="0 0 30.667 30.667" style="enable-background:new 0 0 30.667 30.667;" xml:space="preserve">
                            <g>
                                <path d="M30.667,14.939c0,8.25-6.74,14.938-15.056,14.938c-2.639,0-5.118-0.675-7.276-1.857L0,30.667l2.717-8.017
		c-1.37-2.25-2.159-4.892-2.159-7.712C0.559,6.688,7.297,0,15.613,0C23.928,0.002,30.667,6.689,30.667,14.939z M15.61,2.382
		c-6.979,0-12.656,5.634-12.656,12.56c0,2.748,0.896,5.292,2.411,7.362l-1.58,4.663l4.862-1.545c2,1.312,4.393,2.076,6.963,2.076
		c6.979,0,12.658-5.633,12.658-12.559C28.27,8.016,22.59,2.382,15.61,2.382z M23.214,18.38c-0.094-0.151-0.34-0.243-0.708-0.427
		c-0.367-0.184-2.184-1.069-2.521-1.189c-0.34-0.123-0.586-0.185-0.832,0.182c-0.243,0.367-0.951,1.191-1.168,1.437
		c-0.215,0.245-0.43,0.276-0.799,0.095c-0.369-0.186-1.559-0.57-2.969-1.817c-1.097-0.972-1.838-2.169-2.052-2.536
		c-0.217-0.366-0.022-0.564,0.161-0.746c0.165-0.165,0.369-0.428,0.554-0.643c0.185-0.213,0.246-0.364,0.369-0.609
		c0.121-0.245,0.06-0.458-0.031-0.643c-0.092-0.184-0.829-1.984-1.138-2.717c-0.307-0.732-0.614-0.611-0.83-0.611
		c-0.215,0-0.461-0.03-0.707-0.03S9.897,8.215,9.56,8.582s-1.291,1.252-1.291,3.054c0,1.804,1.321,3.543,1.506,3.787
		c0.186,0.243,2.554,4.062,6.305,5.528c3.753,1.465,3.753,0.976,4.429,0.914c0.678-0.062,2.184-0.885,2.49-1.739
		C23.307,19.268,23.307,18.533,23.214,18.38z" />
                            </g>
                        </svg>

                    </a-->
                </div>

            </div>
        </div>
    </div>
</div>
@endforeach
<div style="height:25px;width:100%"></div>
