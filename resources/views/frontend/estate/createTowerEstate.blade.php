@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',
[
'title'=>l('ثبت ملک رایگان')
])
@section('head')
<link href="{{asset('/frontend/js/modules/leaflet/leaflet.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/basic.min.css')}}" />
<link rel="stylesheet" media="screen" href="/vendor/persian-datepicker/persian-datepicker.min.css" />
@endsection
@section('main_content')
    <link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
    <link rel="stylesheet" media="screen" href="/vendor/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" media="screen" href="/vendor/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" />
    <link rel="stylesheet" media="screen" href="/vendor/filepond/dist/filepond.min.css" />
    <style>
    .modal1 {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1055;
    display: none;
    width: 100%;
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
    outline: 0;
    }
    .land{display:none}
    .dropzone.dz-started .dz-message {
        border:1px solid gray;
    display: block!important;display: inline-table;
        width: 120px !important;
        height: 125px !important;
        float: right;
        display: inline-table;
    }
    .not{display:none}
    .form-select{
        width:100%
    }
    .rent{display: none}
    .dropzone {
    min-height: 150px;
    border: 2px solid rgba(0,0,0,0.1);
    background: white;
    padding: 20px 20px;
    }
    .dropzone .dz-message {
    text-align: center;
    margin: .5em 0;
    }
    .dz-preview{
        float: right;
        flex-basis: 100%;
    }

    @media (min-width: 500px){
        .dz-preview{
        float: right;
        flex-basis: 50%;
    }
    }
    @media (min-width: 900px){
        .dz-preview{
        float: right;
        flex-basis: 30%;
    }
    }
    @media (min-width: 1200px){
        .dz-preview{
        float: right;
        flex-basis: 19%;
    }
    }
    .est-container{
        position: relative;
    }
    .est-img {
        opacity: 1;
    display: block;
    width: 100%;
    height: auto;
    transition: .5s ease;
    backface-visibility: hidden;
    object-fit: cover;
    }
    .est-container:hover .est-img {
    opacity: 0.3;
    }
    .est-container:hover .middle {
    opacity: 1;
    }
    .middle {
    transition: .5s ease;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    text-align: center;
    }
    .text {
    background-color: red;
    color: white;
    font-size: 16px;
    padding: 16px 32px;
    }
    </style>
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <!-- Page container-->
        <div class="container mt-5 mb-md-4 py-5">
            <div class="row">
                @if($currentUser != null && $currentUser->isExpert())
                @include('frontend.layouts.sidebar', ['menu' => 'addestate'])
                <!-- Page content-->
                <div class="col-lg-9 col-md-12 mb-5 account add-property">
                @else
                <div class="col-lg-12 col-md-12 mb-5 account add-property">
                @endif
                    <div class="row">
                        <div class="col-lg-12 add-property">
                            <!-- Breadcrumb-->
                            <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{!empty($estate)? l('ویرایش ملک') :l('ثبت ملک جدید')}}</li>
                                </ol>
                            </nav>
                            <!-- Title-->
                            <div class="mb-4">
                                <h1 class="h2 mb-0">{{!empty($estate)? l('ویرایش ملک') :l('ثبت ملک جدید')}}</h1>
                            </div>
                        </div>
                        @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                                style="background-color: #a6f4a6; color: #000; padding: 20px; font-size: 16px; line-height: 1.8;">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @else

                        <form  enctype="multipart/form-data" id="js_form_add_state" action="<?php echo empty($estate) ? '/add' : '/estates/update1/' . $estate->id ?>" method="post">
                            @csrf
                            <input type="hidden" name="default_image" id="default_image">
                            <input type="hidden" id="estatelatitude" value="{{!empty($estate)?$estate->latitude:''}}">
                            <input type="hidden" id="estatelongitude" value="{{!empty($estate)?$estate->longitude:''}}">
                            <input type="hidden" name="latitude"  id="latitude" value="{{!empty($estate)?$estate->latitude:''}}">
                            <input type="hidden" name="longitude" id="longitude" value="{{!empty($estate)?$estate->longitude:''}}">
                            <input type="hidden" name="latitude_secondary" id="latitude_secondary">
                            <input type="hidden" name="longitude_secondary" id="longitude_secondary">
                            <input type="hidden" name="type" value="1">
                            <input type="hidden" name="baseestate" value="1">
                            <input type="hidden" name="confirmation" value="pending">
                            <input type="hidden" id="project_id" value="{{!empty($estate)?$estate->project_id:''}}">
                            <input type="hidden" name="esatateid" id="esatateid" value='{{!empty($estate)?$estate->id:""}}'>
                        <section class="card card-body shadow-sm rounded p-2 mb-4" id="basic-info">
                            <h2 class="h5 mb-4"><i class="fi-info-circle text-primary fs-5 mt-n1 me-2"></i>{{l('اطلاعات پایه')}}</h2>
                            <!--div class="mb-3">
                                <label class="form-label fw-bold" for="ap-title">{{l('عنوان آگهی')}}</label>
                                <input class="form-control js_input_max" value="{{!empty($estate)?$estate->title:""}}" name="title" placeholder="{{l('عنوان آگهی')}}" />
                            </div-->
                            <div class="row">

                                <div class="col-sm-6 col-lg-3 mb-3" >
                                    <label class="form-label fw-bold" for="ap-usage_type"> {{l('نوع کاربری')}}</label>
                                    <select class="necessary form-select"  id="usage_type" name="usage_type"  cus-valid="true">
                                        <option value="" disabled selected>{{l('انتخاب')}} </option>
                                        @foreach (usage_type() as $key=>$val)
                                        <option value="{{$key}}" {{!empty($estate)?($estate->usage_type==$key ? 'selected':''):""}}>{{l($val)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-3 mb-3">
                                    <label class="form-label fw-bold" for="ap-type">{{l('نوع ملک')}}
                                        <span class="text-danger" >*</span>
                                    </label>
                                    <select class="form-select"  name="estate_type" id="estate_type" required>
                                        <option value="" >{{l('انتخاب کنید')}}</option>
                                        <optgroup label="{{l('مسکونی')}}" id="g107">
                                            @foreach (estateTypesResidential() as $key=>$val)
                                            <option value="{{$key}}" {{!empty($estate)?($estate->estate_type==$key ? 'selected':''):""}} attr="107">{{l($val)}}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="{{l('تجاری')}}" id="g109">
                                            @foreach (estateTypesCommercial() as $key=>$val)
                                            <option value="{{$key}}" {{!empty($estate)?($estate->estate_type==$key ? 'selected':''):""}} attr="109">{{l($val)}}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <input type="hidden" id="hide_estate_type" value="{{!empty($estate)?$estate->estate_type:''}}"/>
                                </div>




                                <div class="col-sm-12 col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input offplan"  id="condition15" value="15" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,15):""}} name="conditions[]">
                                                <label class="form-label fw-bold form-check-label" for="condition15">{{l('پیش فروش')}}</label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="existing_document" value="1" type="checkbox" id="existing_document" {{!empty($estate)?(($estate->existing_document == 1)?"checked":""):""}}>
                                                <label class="form-label fw-bold form-check-label" for="existing_document">{{l('آماده تحویل')}} </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input secondary"  id="secondary" value="384" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,384):""}} name="conditions[]">
                                                <label class="form-label fw-bold form-check-label" for="secondary">{{l('دسته دوم')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Price-->
                        <section class="card card-body shadow-sm rounded p-2 mb-4" id="price">
                            <h2 class="h5 mb-4"><i class="fi-cash text-primary fs-5 mt-n1 me-2"></i>{{l('قیمت و مساحت')}}</h2>
                            <div class="row">
                                <div class="col-sm-6 col-md-3 col-lg-2 fw-bold">
                                    <label class="form-label fw-bold" for="ap-meterage"><span class="areafrom">{{l('مساحت')}}</span></label>
                                    <div class="d-sm-flex">
                                        <input class="necessary form-control w-100 mb-2 js_valid_number_float number" type="tel"  value="{{old('area',!empty($estate)?$estate->area:'')}}"  id="area" name="area" >
                                    </div>
                                </div>

                                <div class="divareato col-sm-6 col-md-3 col-lg-2 fw-bold none">
                                    <label class="form-label fw-bold" for="ap-meterage"><span class="areato">{{l('مساحت تا')}}</span> </label>
                                    <div class="d-sm-flex">
                                        <input class="necessary form-control w-100 mb-2 js_valid_number_float number" type="tel"  value="{{old('front_area',!empty($estate)?$estate->front_area:'')}}"   id="front_area" name="front_area">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-2 fw-bold not" access="12,22,16,26">
                                    <label class="form-label fw-bold" for="ap-meterage">{{l('مساحت زیربنا')}} </label>
                                    <div class="d-sm-flex">
                                        <input class="form-control w-100 mb-2 js_valid_number_float number" type="tel"  value="{{old('built_area',!empty($estate)?$estate->built_area:'')}}"   id="built_area" name="built_area">
                                    </div>
                                </div>


                                <div class="col-sm-6 col-md-3 col-lg-2 " id="sale-inputs">
                                    <label class="form-label fw-bold" for="ap-price"><span class="pricefrom">{{l('قیمت کل')}}</span></label>
                                    <div class="d-sm-flex">
                                        <input class="necessary form-control w-100 mb-2 number js_number js_Splitnumber1" type="text"   onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));"   id="price" name="price"  value="{{old('price',!empty($estate)?$estate->price:'')}}">
                                    </div>
                                    <div id="divprice"  class="w-100"></div>
                                </div>
                                <div class="divpriceto col-sm-6 col-md-3 col-lg-2 ">
                                    <label class="form-label fw-bold" for="ap-price"><span class="priceto">{{l('قیمت تا')}}</span></label>
                                    <div class="d-sm-flex">
                                        <input class="necessary form-control w-100 mb-2 number js_number js_Splitnumber1" type="text" onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));"   id="mortgage" name="mortgage" value="{{old('mortgage',!empty($estate)?$estate->mortgage:'')}}"  >
                                    </div>
                                    <div id="divmortgage"  class="w-100"></div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-2 not" access="21,22,23,24,25" >
                                    <label class="form-label fw-bold">
                                        {{l('آیا تخلیه است؟')}}
                                    </label>
                                    <select class="form-select"  name="evacuation" id="evacuation">
                                    <option value="">{{l('انتخاب کنید')}}</option>
                                        <option value="0" {{!empty($estate)?($estate->evacuation==0?'selected':''):'selected'}}>{{l('هست')}}</option>
                                        <option value="1" {{!empty($estate)?($estate->evacuation==1?'selected':''):''}}>{{l('نیست')}}</option>
                                    </select>
                                </div>



                            </div>
                        </section>
                        <section class="card card-body shadow-sm rounded p-2 mb-4" id="location">
                            <h2 class="h5 mb-4"><i class="fi-map-pin text-primary fs-5 mt-n1 me-2"></i>{{l('موقعیت مکانی')}}</h2>
                            <div class="row">
                                <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                                    <label class="form-label fw-bold" for="ap-city"> {{l('شهر')}} </label>
                                    <select class="form-select  select2"  name="city_id" id="city_id">
                                        <option value="" disabled>{{l('شهر')}}</option>
                                        @foreach($cities as $ci)
                                        <option value="{{$ci->id}}" {{!empty($estate) && $estate->city_id == $ci->id ? 'selected' :''}}>{{$ci->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" id="hide_cityId" value="{{!empty($estate)?$estate->city_id:''}}"/>
                                <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                                    <label class="form-label fw-bold" for="ap-district"> {{l('محله‌')}}
                                        @if ($currentUser != null && $currentUser->isAdmin())
                                        <a href="/profile/district/create" target="blank" style="color: blue">[Add]</a>
                                        @endif
                                    </label>
                                    <select class="form-select js-example-disabled-results  select2"  name="district_id" id="district_id" aria-placeholder="test">
                                        <option value="" >&nbsp;</option>
                                        @foreach($districts as $district)
                                        <option value="{{$district->id}}" {{!empty($estate) && $estate->district_id == $district->id ? 'selected' :''}}>{{$district->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" id="hide_district" value="{{!empty($estate)?$estate->district_id:''}}"/>

                                <div class="col-sm-6 col-md-6  mb-3">
                                    <label class="form-label fw-bold" for="ap-address">{{l('آدرس ')}} </label>
                                    <input class="necessary form-control" type="text" id="ap-address" name="address" value="{{!empty($estate)?($estate->address):""}}" >
                                </div>

                                <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                                    <label class="form-label fw-bold">{{l('شماره پلاک / واحد')}}</label>
                                    <input class="necessary form-control" name="unit_no" id="unit_no" value="{{!empty($estate)?($estate->unit_no):""}}"  >
                                </div>
                            </div>
                            <div class="necessary form-label fw-bold pt-3 pb-2">{{l('نمایش روی نقشه')}}</div>
                            <div class="necessary rounded-3"  id="estate-map" style="height: 400px;"></div>
                        </section>
                        <section class="card card-body shadow-sm rounded p-2 mb-4" id="details">
                            <h2 class="h5 mb-4"><i class="fi-edit text-primary fs-5 mt-n1 me-2"></i>{{l('جزئیات ملک')}}</h2>
                            <div class="row">

                                <div class="col-sm-6 col-lg-3 mb-3">
                                    <label class="form-label fw-bold">
                                        {{l('برند')}}
                                        @if ($currentUser != null && $currentUser->isAdmin())
                                        <a href="/profile/brand/create" target="blank" style="color: blue">[Add]</a>
                                        @endif
                                    </label>
                                    <select class="form-select"  name="brand_id" id="brand_id" name="brand_id">
                                        <option value="">{{l('انتخاب')}}</option>
                                        @foreach ($brands as $brand)
                                        <option value="{{$brand->id}}" {{!empty($estate)?($estate->brand_id==$brand->id?'selected':''):''}}>{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 col-lg-3 mb-3">
                                    <label class="form-label fw-bold" for="ap-floors"> {{l('تعداد طبقات')}} </label>
                                    <select class="necessary form-select" id="floor_count" name="floor_count" >
                                        <option value=""  selected>{{l('انتخاب')}} </option>
                                        <option value="155" {{!empty($estate)?($estate->floor_count==155?'selected':''):''}}>1</option>
                                        <option value="156" {{!empty($estate)?($estate->floor_count==156?'selected':''):''}}>2</option>
                                        <option value="157" {{!empty($estate)?($estate->floor_count==157?'selected':''):''}}>3</option>
                                        <option value="158" {{!empty($estate)?($estate->floor_count==158?'selected':''):''}}>4</option>
                                        <option value="159" {{!empty($estate)?($estate->floor_count==159?'selected':''):''}}>5</option>
                                        <option value="160" {{!empty($estate)?($estate->floor_count==160?'selected':''):''}}>6</option>
                                        <option value="161" {{!empty($estate)?($estate->floor_count==161?'selected':''):''}}>7</option>
                                        <option value="162" {{!empty($estate)?($estate->floor_count==162?'selected':''):''}}>8</option>
                                        <option value="163" {{!empty($estate)?($estate->floor_count==163?'selected':''):''}}>9</option>
                                        <option value="164" {{!empty($estate)?($estate->floor_count==164?'selected':''):''}}>10</option>
                                        <option value="165" {{!empty($estate)?($estate->floor_count==165?'selected':''):''}}>11</option>
                                        <option value="166" {{!empty($estate)?($estate->floor_count==166?'selected':''):''}}>12</option>
                                        <option value="167" {{!empty($estate)?($estate->floor_count==167?'selected':''):''}}>13</option>
                                        <option value="168" {{!empty($estate)?($estate->floor_count==168?'selected':''):''}}>14</option>
                                        <option value="169" {{!empty($estate)?($estate->floor_count==169?'selected':''):''}}>15</option>
                                        <option value="170" {{!empty($estate)?($estate->floor_count==170?'selected':''):''}}>16</option>
                                        <option value="171" {{!empty($estate)?($estate->floor_count==171?'selected':''):''}}>17</option>
                                        <option value="172" {{!empty($estate)?($estate->floor_count==172?'selected':''):''}}>18</option>
                                        <option value="173" {{!empty($estate)?($estate->floor_count==173?'selected':''):''}}>19</option>
                                        <option value="174" {{!empty($estate)?($estate->floor_count==174?'selected':''):''}}>20</option>
                                        <option value="175" {{!empty($estate)?($estate->floor_count==175?'selected':''):''}}>21</option>
                                        <option value="176" {{!empty($estate)?($estate->floor_count==176?'selected':''):''}}>22</option>
                                        <option value="177" {{!empty($estate)?($estate->floor_count==177?'selected':''):''}}>23</option>
                                        <option value="178" {{!empty($estate)?($estate->floor_count==178?'selected':''):''}}>24</option>
                                        <option value="179" {{!empty($estate)?($estate->floor_count==179?'selected':''):''}}>25</option>
                                        <option value="180" {{!empty($estate)?($estate->floor_count==180?'selected':''):''}}>26</option>
                                        <option value="181" {{!empty($estate)?($estate->floor_count==181?'selected':''):''}}>27</option>
                                        <option value="182" {{!empty($estate)?($estate->floor_count==182?'selected':''):''}}>28</option>
                                        <option value="183" {{!empty($estate)?($estate->floor_count==183?'selected':''):''}}>29</option>
                                        <option value="184" {{!empty($estate)?($estate->floor_count==184?'selected':''):''}}>30</option>
                                        <option value="185" {{!empty($estate)?($estate->floor_count==185?'selected':''):''}}>{{l('بیشتر از')}} 30</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 col-lg-3 mb-3">
                                    <label class="form-label fw-bold" for="ap-room"> {{l('تعداد اتاق')}} </label>
                                    <select class="necessary form-select" id="room_count" name="room_count">
                                        <option value="" disabled selected>{{l('انتخاب')}} </option>
                                        <option value="186" {{!empty($estate)?($estate->room_count==186?'selected':''):''}}>{{l('بدون اتاق')}}</option>
                                        <option value="187" {{!empty($estate)?($estate->room_count==187?'selected':''):''}}>1</option>
                                        <option value="188" {{!empty($estate)?($estate->room_count==188?'selected':''):''}}>2</option>
                                        <option value="189" {{!empty($estate)?($estate->room_count==189?'selected':''):''}}>3</option>
                                        <option value="190" {{!empty($estate)?($estate->room_count==190?'selected':''):''}}>4</option>
                                        <option value="191" {{!empty($estate)?($estate->room_count==191?'selected':''):''}}>{{l('بیشتر از')}} 4</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 col-lg-3 mb-3">
                                    <label class="form-label fw-bold"> {{l('تعداد حمام')}} </label>
                                    <select class="necessary form-select" id="bath_count" name="bath_count">
                                        <option value="1" {{!empty($estate)?($estate->bath_count==1?'selected':''):''}}>1</option>
                                        <option value="2" {{!empty($estate)?($estate->bath_count==2?'selected':''):''}}>2</option>
                                        <option value="3" {{!empty($estate)?($estate->bath_count==3?'selected':''):''}}>3</option>
                                        <option value="4" {{!empty($estate)?($estate->bath_count==4?'selected':''):''}}>4</option>
                                        <option value="5" {{!empty($estate)?($estate->bath_count==5?'selected':''):''}}>5</option>
                                        <option value="6" {{!empty($estate)?($estate->bath_count==6?'selected':''):''}}>6</option>
                                        <option value="7" {{!empty($estate)?($estate->bath_count==7?'selected':''):''}}>7</option>
                                        <option value="8" {{!empty($estate)?($estate->bath_count==8?'selected':''):''}}>8</option>
                                        <option value="9" {{!empty($estate)?($estate->bath_count==9?'selected':''):''}}>9</option>
                                        <option value="10" {{!empty($estate)?($estate->bath_count==10?'selected':''):''}}>10</option>
                                    </select>
                                </div>


                                <div class="col-sm-6 col-lg-3 mb-3  year-build">
                                    <label class="form-label fw-bold" for="ap-made-year">{{l('سال ساخت')}}</label>

                                    <select id="year-build" class="necessary form-select"  name="built_year"  cus-valid="true">
                                        <option value="" disabled selected>{{l('انتخاب')}} </option>
                                        @if(!empty($estate) && checkValueCreate($estate->conditions,15)=="checked")
                                            @foreach(offplanyear() as $key=>$val)
                                            <option value="{{$key}}" {{!empty($estate)?($estate->built_year == $key?"selected":''):''}}>{{$val}}</option>
                                            @endforeach
                                        @else
                                        <?php for ($i = date('Y'); $i >= date('Y') - 40; $i--) { ?>
                                            <option value="<?= $i; ?>" {{!empty($estate)?($estate->built_year==$i?'selected':''):''}}><?= $i ?></option>
                                        <?php } ?>
                                        @endif
                                    </select>
                                </div>


                                <div class="col-sm-12 mb-4">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="row">
                                                <label class="form-label d-block fw-bold mb-2 pb-1">{{l('امکانات تفریحی و خانوادگی')}} </label>
                                                <div class="col-6 col-sm-6 col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="facilities[]" value="369" type="checkbox" id="Barbeque" {{!empty($estate)?checkValueCreate($estate->facilities,369):""}}>
                                                        <label class="form-check-label" for="Barbeque">{{l('محل باربیکیو')}} </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="facilities[]" value="368" type="checkbox" id="DayCareCenter" {{!empty($estate)?checkValueCreate($estate->facilities,368):""}}>
                                                        <label class="form-check-label" for="DayCareCenter">{{l('مهد کودک')}} </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="367" type="checkbox" id="KidsPlayArea" {{!empty($estate)?checkValueCreate($estate->facilities,367):""}}>
                                                        <label class="form-check-label" for="KidsPlayArea">{{l('فضای بازی کودکان')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="366" type="checkbox" id="Lawn" {{!empty($estate)?checkValueCreate($estate->facilities,366):""}}>
                                                        <label class="form-check-label" for="Lawn">{{l('چمنزار یا باغ')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="365" type="checkbox" id="Cafeteria" {{!empty($estate)?checkValueCreate($estate->facilities,365):""}}>
                                                        <label class="form-check-label" for="Cafeteria">{{l('کافه تریا یا غذاخوری')}}</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-3 ">
                                            <label class="form-label fw-bold">
                                                {{l('شرایط')}}
                                            </label>
                                            <div class="row">

                                                <div class="col-6 col-sm-6 col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input"  id="condition344" value="344" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,344):""}} name="conditions[]">
                                                        <label class="form-check-label" for="condition344">{{l('بازسازی شده')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input"  id="condition383" value="383" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,383):""}} name="conditions[]">
                                                        <label class="form-check-label" for="condition383">{{l('ارتقا یافته')}}</label>
                                                    </div>
                                                </div>


                                                <div class="col-6 col-sm-6 col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input"  id="condition383" value="403" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,403):""}} name="conditions[]">
                                                        <label class="form-check-label" for="condition383">{{l('بدون سکنه')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input"  id="condition383" value="404" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,404):""}} name="conditions[]">
                                                        <label class="form-check-label" for="condition383">{{l('زمان انتقال مالکیت')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input"  id="condition383" value="405" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,405):""}} name="conditions[]">
                                                        <label class="form-check-label" for="condition383">{{l('اجاره‌داده‌شده')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input"  id="condition383" value="406" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,406):""}} name="conditions[]">
                                                        <label class="form-check-label" for="condition383">{{l('در دوره اعلام تخلیه')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input"  id="condition383" value="407" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,407):""}} name="conditions[]">
                                                        <label class="form-check-label" for="condition383">{{l('دارای وام مسکن')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input"  id="condition383" value="408" type="checkbox" {{!empty($estate)?checkValueCreate($estate->conditions,408):""}} name="conditions[]">
                                                        <label class="form-check-label" for="condition383">{{l('فروشنده جدی')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="row">
                                                <label class="form-label d-block fw-bold mb-2 pb-1">{{l('سلامتی و آمادگی جسمانی')}} </label>
                                                <div class="col-6 col-sm-6 col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="facilities[]" value="364" type="checkbox" id="MedicalCenter" {{!empty($estate)?checkValueCreate($estate->facilities,364):""}}>
                                                        <label class="form-check-label" for="MedicalCenter">{{l('مرکز فوریت‌های پزشکی')}} </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="facilities[]" value="363" type="checkbox" id="HealthClub" {{!empty($estate)?checkValueCreate($estate->facilities,363):""}}>
                                                        <label class="form-check-label" for="HealthClub">{{l('باشگاه ورزشی یا مرکز سلامت')}} </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="facilities[]" value="395" type="checkbox" id="PrivateGym" {{!empty($estate)?checkValueCreate($estate->facilities,395):""}}>
                                                        <label class="form-check-label" for="PrivateGym">{{l('باشگاه اختصاصی')}} </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="362" type="checkbox" id="Jacuzzi" {{!empty($estate)?checkValueCreate($estate->facilities,362):""}}>
                                                        <label class="form-check-label" for="Jacuzzi">{{l('جکوزی')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="361" type="checkbox" id="Sauna" {{!empty($estate)?checkValueCreate($estate->facilities,361):""}}>
                                                        <label class="form-check-label" for="Sauna">{{l('سونا')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="360" type="checkbox" id="SteamRoom" {{!empty($estate)?checkValueCreate($estate->facilities,360):""}}>
                                                        <label class="form-check-label" for="SteamRoom">{{l('اتاق بخار')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="359" type="checkbox" id="SwimmingPool" {{!empty($estate)?checkValueCreate($estate->facilities,359):""}}>
                                                        <label class="form-check-label" for="SwimmingPool">{{l('استخر شنا')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="390" type="checkbox" id="InfinityPool" {{!empty($estate)?checkValueCreate($estate->facilities,390):""}}>
                                                        <label class="form-check-label" for="InfinityPool">{{l('استخر با لبه باز')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="391" type="checkbox" id="PrivatePool" {{!empty($estate)?checkValueCreate($estate->facilities,391):""}}>
                                                        <label class="form-check-label" for="PrivatePool">{{l('استخر اختصاصی')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="392" type="checkbox" id="ChildrenPool" {{!empty($estate)?checkValueCreate($estate->facilities,392):""}}>
                                                        <label class="form-check-label" for="ChildrenPool">{{l('استخر کودک')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="row">
                                                <label class="form-label d-block fw-bold mb-2 pb-1">{{l('امکانات')}} </label>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="354" type="checkbox" id="StudyRoom" {{!empty($estate)?checkValueCreate($estate->facilities,354):""}}>
                                                        <label class="form-check-label" for="warehouse">{{l('اتاق مطالعه')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="372" type="checkbox" id="LaundryRoom" {{!empty($estate)?checkValueCreate($estate->facilities,372):""}}>
                                                        <label class="form-check-label" for="LaundryRoom">{{l('اتاق رختشویی')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="397" type="checkbox" id="MaidService" {{!empty($estate)?checkValueCreate($estate->facilities,397):""}}>
                                                        <label class="form-check-label" for="MaidService">{{l('خدمات نظافت')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="398" type="checkbox" id="PetsAllowed" {{!empty($estate)?checkValueCreate($estate->facilities,398):""}}>
                                                        <label class="form-check-label" for="PetsAllowed">{{l('خدمات نظافت')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="399" type="checkbox" id="SmartHomeSystem" {{!empty($estate)?checkValueCreate($estate->facilities,399):""}}>
                                                        <label class="form-check-label" for="SmartHomeSystem">{{l('خانه هوشمند')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="400" type="checkbox" id="ConciergeService" {{!empty($estate)?checkValueCreate($estate->facilities,400):""}}>
                                                        <label class="form-check-label" for="ConciergeService">{{l('خدمات پذیرش')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="373" type="checkbox" id="DriverRoom" {{!empty($estate)?checkValueCreate($estate->facilities,373):""}}>
                                                        <label class="form-check-label" for="DriverRoom">{{l('اتاق راننده')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="374" type="checkbox" id="MaidRoom" {{!empty($estate)?checkValueCreate($estate->facilities,374):""}}>
                                                        <label class="form-check-label" for="MaidRoom">{{l('اتاق خدمتکار')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="401" type="checkbox" id="BuiltinWardrobes" {{!empty($estate)?checkValueCreate($estate->facilities,401):""}}>
                                                        <label class="form-check-label" for="BuiltinWardrobes">{{l('کمد دیواری')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="402" type="checkbox" id="WalkinCloset" {{!empty($estate)?checkValueCreate($estate->facilities,402):""}}>
                                                        <label class="form-check-label" for="WalkinCloset">{{l('رختکن')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="facilities[]" value="35" type="checkbox" id="parking" {{!empty($estate)?checkValueCreate($estate->facilities,35):""}}>
                                                        <label class="form-check-label" for="parking">{{l('پارکینگ')}} </label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="36" type="checkbox" id="warehouse" {{!empty($estate)?checkValueCreate($estate->facilities,36):""}}>
                                                        <label class="form-check-label" for="warehouse">{{l('انباری')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="keynot" id="keynot" type="checkbox" value="1" {{!empty($estate)?($estate->keynot==1?"checked":""):""}} />
                                                        <label class="form-check-label" for="wkeynot">{{l('کلید نخورده')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="348" type="checkbox" id="Furnished" {{!empty($estate)?checkValueCreate($estate->facilities,348):""}}>
                                                        <label class="form-check-label" for="Furnished">{{l('فول امکانات')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="371" type="checkbox" id="Unfurnished" {{!empty($estate)?checkValueCreate($estate->facilities,371):""}}>
                                                        <label class="form-check-label" for="Unfurnished">{{l('بدون امکانات')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="370" type="checkbox" id="SemiFurnished" {{!empty($estate)?checkValueCreate($estate->facilities,370):""}}>
                                                        <label class="form-check-label" for="SemiFurnished">{{l('نیمه مبله')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="375" type="checkbox" id="phpp" {{!empty($estate)?checkValueCreate($estate->facilities,375):""}}>
                                                        <label class="form-check-label" for="phpp">{{l('اقساط پس از تحویل')}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="358" type="checkbox" id="DoubleGlazedWindows" {{!empty($estate)?checkValueCreate($estate->facilities,358):""}}>
                                                        <label class="form-check-label" for="DoubleGlazedWindows">{{l('پنجره‌های دوجداره')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="357" type="checkbox" id="AirConditioned" {{!empty($estate)?checkValueCreate($estate->facilities,357):""}}>
                                                        <label class="form-check-label" for="AirConditioned">{{l('سیستم تهویه مطبوع مرکزی')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="356" type="checkbox" id="CentralHeating" {{!empty($estate)?checkValueCreate($estate->facilities,356):""}}>
                                                        <label class="form-check-label" for="CentralHeating">{{l('گرمایش مرکزی')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="355" type="checkbox" id="electricityBackup" {{!empty($estate)?checkValueCreate($estate->facilities,355):""}}>
                                                        <label class="form-check-label" for="electricityBackup">{{l('برق اضطراری')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="393" type="checkbox" id="ViewWater" {{!empty($estate)?checkValueCreate($estate->facilities,393):""}}>
                                                        <label class="form-check-label" for="ViewWater">{{l('چشم‌انداز آب')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="394" type="checkbox" id="ViewLandmark" {{!empty($estate)?checkValueCreate($estate->facilities,394):""}}>
                                                        <label class="form-check-label" for="ViewLandmark">{{l('چشم‌انداز بنای معروف')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-3 ">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" name="facilities[]" value="396" type="checkbox" id="Garden" {{!empty($estate)?checkValueCreate($estate->facilities,396):""}}>
                                                        <label class="form-check-label" for="Garden">{{l('فضای سبز')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                                <div class="col-sm-12 mb-4">
                                    <label class="form-label fw-bold" for="ap-description">{{l('توضیحات')}} </label>
                                    <textarea  name="description" id="desc-state" class="js_input_max form-control mb-3 " rows="5" placeholder="{{l('ملک خود را شرح دهید')}}">{{old('description',!empty($estate)?$estate->description:'')}}</textarea>
                                </div>
                            </section>

                            <section class="card card-body shadow-sm rounded p-2 mt-4 d-none" id="photos">
                                <h2 class="h5">
                                    <i class="fi-camera-plus text-primary fs-5 mt-n1 me-2"></i>{{l('تصاویر و اسناد')}}
                                </h2>
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">{{l('تصاویر ملک')}}</button>
                                        @if ($currentUser != null && $currentUser->isAdmin())
                                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">{{l('مدارک مرتبط')}}</button>
                                        @endif
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <!-- Photos / video-->
                                        <div class=" my-4" id="photos">
                                            {{-- current images --}}
                                            <?php
                                            if($estate!=null){
                                                $imageCount = $estate->images->count();
                                                if($estate->images->count() > 0){
                                                    ?>
                                                <div id="images" class=" card mb-3">
                                                    <div class="border-bottom card-header">
                                                        <strong class="mb-0">{{l('تصاویر فعلی')}}</strong>
                                                    </div>
                                                    <div id="sortable-images" class="image-list card-body align-content-center align-items-center d-flex flex-row flex-wrap justify-content-around">
                                                        @foreach($estate->images->where("is_360","=",0)->where("plan","=",0)->where("hidden","=",0)->sortBy("priority") as $item)
                                                            <div id="media-{{$item->id}}" data-id="{{$item->id}}" class="image-item card p-1 rounded dz-preview {{$defaultImage && $defaultImage->id == $item->id ? 'img-cover' : ''}}">
                                                                <div class="mb-0 est-container">
                                                                    <img src="/upload/images/estate/{{ $item->url() }}" class="w-100 est-img" style="height:250px;margin-bottom:10px">
                                                                    <input type="hidden" name="image_orders[]" value="{{$item->id}}:{{$item->priority}}">
                                                                </div>
                                                                <button type="button" data-toggle="tooltip" title="{{l('حذف')}}" data-id="{{$item->id}}"
                                                                        id="itemID-{{$item->id}}" data-name="{{$item->name}}"
                                                                        data-route="images" class="btn btn-danger remove-img rounded-0">
                                                                    <i class="d-inline fa fa-trash me-2"></i>{{l('حذف')}}
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <?php
                                                }
                                            }
                                            ?>
                                            <div id="img-upload" class="dropzone uploader text-center dz-clickable rounded mb-2" data-bs-toggle="dropzone" style="width: 100%;z-index:0;display:table">
                                                <div class="dz-message" data-dz-message="" style="width:120px;height:120px;border:1px solid;border-radius:25%;padding-top:35px">
                                                    <i class="text-[50px] text-gray-500 fa-thin fa-camera" style="font-size:25px"></i>
                                                    <div class="uploader-text">
                                                        <span class="text-[16px] text-gray-500 font-light">{{l('تصاویر')}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <div class=" mt-4" id="photos">
                                            <label class="form-label mt-2">
                                            {{l('فایلهای مرتبط')}}
                                            </label>
                                            @php
                                                $previewable = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                                                $pdfTypes = ['pdf'];
                                                $wordTypes = ['doc', 'docx'];
                                                $excelTypes = ['xls', 'xlsx'];
                                                $videoTypes = ['mp4', 'webm', 'ogg'];
                                                $fileExtension = function($item) {
                                                    return strtolower(pathinfo($item->name, PATHINFO_EXTENSION));
                                                };
                                            @endphp

                                            @if($estate != null && $estate->images->count() > 0)
                                                <div id="images" class="card mb-3">
                                                    <div class="border-bottom card-header">
                                                        <strong class="mb-0">{{ l('فایلهای فعلی') }}</strong>
                                                    </div>
                                                    <div class="card-body d-flex flex-wrap justify-content-around gap-3">
                                                        @foreach($estate->images->where("plan", "=", 1) as $item)
                                                        @php $ext = $fileExtension($item); @endphp
                                                        <div id="media-{{$item->id}}" data-id="{{$item->id}}" class="card p-2 rounded dz-preview text-center" style="width: 160px;">
                                                            <a href="{{ $item->url() }}" target="_blank">
                                                                @if(in_array($ext, $previewable))
                                                                    <img src="{{ $item->url() }}" class="w-100 rounded" style="height: 120px; object-fit: cover;">
                                                                @elseif(in_array($ext, $pdfTypes))
                                                                    <img src="/img/icon/pdf.png" style="height: 80px;"><br>
                                                                    <span class="small text-muted">PDF</span>
                                                                @elseif(in_array($ext, $wordTypes))
                                                                    <img src="/img/icon/word.png" style="height: 80px;"><br>
                                                                    <span class="small text-muted">Word</span>
                                                                @elseif(in_array($ext, $excelTypes))
                                                                    <img src="/img/icon/excel.png" style="height: 80px;"><br>
                                                                    <span class="small text-muted">Excel</span>
                                                                @elseif(in_array($ext, $videoTypes))
                                                                    <video src="{{ $item->url() }}" controls style="width: 100%; height: 120px; object-fit: cover;"></video>
                                                                @else
                                                                    <img src="/img/icon/file.png" style="height: 80px;"><br>
                                                                    <span class="small text-muted">{{ strtoupper($ext) }}</span>
                                                                @endif
                                                            </a>

                                                            <!-- عنوان فایل و URL -->
                                                            <div class="mt-2 small text-break">
                                                                <strong>{{ $item->name }}</strong><br>
                                                                <strong>{{ $item->extension }}</strong>
                                                            </div>

                                                            <button type="button"
                                                                data-toggle="tooltip"
                                                                title="{{ l('حذف') }}"
                                                                data-id="{{ $item->id }}"
                                                                id="itemID-{{ $item->id }}"
                                                                data-name="{{ $item->name }}"
                                                                data-route="images"
                                                                class="btn btn-danger btn-sm mt-2 remove-img">
                                                                <i class="fa fa-trash"></i> {{ l('حذف') }}
                                                            </button>
                                                        </div>
                                                    @endforeach

                                                    </div>
                                                </div>
                                            @endif

                                            <div id="appendimage"></div>
                                            <div>
                                                <button id="create" type="button" class="btn btn-primary mt-3 ">{{l('اضافه کردن فایل جدید')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Action buttons -->
                            <section class="d-sm-flex justify-content-between pt-2 my-4">
                                <button type="submit" class="btn btn-primary btn-lg d-block mb-2" onclick="return savecheck()" >
                                    {{!empty($estate)? l('ویرایش ملک') :l('ثبت ملک')}}
                                </button>
                            </section>
                            <input type="hidden" id="js_csrf_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="js_estates_storeMedia" value="{{ route('estates.storeMedia') }}">
                            <div class="modal fade" id="estatecheck"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel"> {{l('املاک مشابه')}} </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body" id="estatecheck1" style="max-height:550px;overflow:auto">
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="modal1 fade" id="estatecheck11"  tabindex="-1" role="dialog" >
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel"> {{l('ملک های مشابه شماره تلفن اول ')}} </h5>
                                    </div>
                                    <div class="modal-body" id="estatecheck111" style="max-height:550px;overflow:auto">
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center" id="estatecheck11">
                                        <div class="btn btn-primary checkaccept1">{{l('ثبت کن')}}</div>
                                        <div class="btn btn-danger close1">{{l('بستن')}}</div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="modal1 fade" id="estatecheck2"  tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel"> {{l('ملک های مشابه شماره تلفن دوم ')}} </h5>
                                    </div>
                                    <div class="modal-body" id="estatecheck22" style="max-height:500px;overflow:auto">
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center" id="estatecheck11">
                                        <div class="btn btn-primary checkaccept2">{{l('ثبت کن')}}</div>
                                        <div class="btn btn-danger close2">{{l('بستن')}}</div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
        <script src="/vendor/jquery-3.6.0.js"></script>
        <script src="/vendor/persian-datepicker/persian-date.min.js" ></script>
        <script src="/vendor/persian-datepicker/persian-datepicker.min.js" ></script>
        <script src="/vendor/simplebar/dist/simplebar.min.js"></script>
        <script src="/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
        <script src="/vendor/cleave.js/dist/cleave.min.js"></script>
        <script src="/vendor/select2/select2.min.js"></script>
        <!-- Main theme script-->
        <script src="/js/theme.min.js"></script>
        <script src="/frontend/js/modules/leaflet/leaf.js"></script>
        <script src="/frontend/js/modules/leaflet/leaflet.draw-src.js"></script>
        <script src="/admin2/dist/js/regions.js"></script>

        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script>
        $(function () { $('#sortable-images').sortable({ items: '.image-item', update: function () { $('#sortable-images .image-item').each(function (index) { const id = $(this).data('id'); // مقدار hidden را به‌روزرسانی می‌کنیم: مثلا "3:1" $(this).find('input[type="hidden"]').val(id + ':' + (index + 1)); }); } }); });
        </script>

        <script>
            function offplan()
            {
                if ($('.offplan').is(':checked') && !$('.secondary').is(':checked')) {
                    $('#year-build').html('@foreach(offplanyear() as $key=>$val)<option value="{{$key}}" {{!empty($estate)?($estate->built_year == $key?"selected":''):''}}>{{$val}}</option>@endforeach');
                    $('.areafrom').html('{{l('مساحت از')}}');
                    $('.pricefrom').html('{{l('قیمت از')}}');
                    $('.divareato').show();
                    $('.divpriceto').show();
                }
                else
                {
                    $('#year-build').html('<?php for ($i = date('Y'); $i >= date('Y') - 40; $i--) { ?><option value="<?= $i; ?>" {{!empty($estate)?($estate->built_year==$i?'selected':''):''}}><?= $i ?></option><?php } ?>');
                    $('.areafrom').html('{{l('مساحت')}}');
                    $('.pricefrom').html('{{l('قیمت کل')}}');
                    $('.divareato').hide();
                    $('.divpriceto').hide();
                }
            }
            $(document).ready(function() {
                $('.offplan').change(function() {
                    var checkboxValue = $(this).val();
                    offplan()
                });
                $('.secondary').change(function() {
                    offplan()
                });
                offplan();

            });
            function changeusagetype(id)
            {
                if(id == 107)
                {
                    $('#g107').show();
                    $('#g109').hide();
                }
                else
                {
                    $('#g109').show();
                    $('#g107').hide();
                }
            }
            $(document).ready(function() {
                $("#usage_type").change(function(){
                    changeusagetype($("#usage_type").val());
                });
            });
            changeusagetype($("#usage_type").val());
            // delete image
            $(".remove-img").on("click", function () {
                var estateId = '{{!empty($estate)?$estate->id:''}}';
                var id = $(this).data('id');
                swal({
                    text: " {{l('آیا از حذف گزینه مورد نظر اطمینان دارید')}} ?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "{{l('لغو')}}",
                    confirmButtonText: "{{l('بله')}}",
                    showLoaderOnConfirm: true,
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            $.ajax({
                                url: '/estates/media/' + id,
                                type: 'DELETE',
                                data: {_token: '{{csrf_token()}}',estate_id:estateId},
                                dataType: 'json'
                            })
                                .done(function (response) {
                                    swal({
                                        title: "",
                                        text: "{{l('گزینه مورد نظر با موفقیت حذف شد')}}.",
                                        type: 'success',
                                        allowOutsideClick: false,
                                    }).then((result)=>{
                                        $('#images #media-'+id).remove();
                                });
                                })
                                .fail(function () {
                                    swal("{{l('خطا')}}!", "{{l('حذف با مشکل مواجه شد')}}!", 'error');
                                });
                        });
                    },
                    allowOutsideClick: ()=>!swal.isLoading()
                });
            });
            var i=0;
            $("#create").click(function(){
                i++;
                let html = `
                <div class="form-group gap-3">
                    <input type="file" onchange="validateFile(this)" id="js_National_card_upload${i}" name="js_National_card_upload[]" class="hidden js_National_card_upload" data-max-file-size="5M">
                    <label class="btn btn-info labelupload" for="js_National_card_upload${i}">
                        {{l("آپلود فایل")}}
                    </label>
                    <input type="text" name="title1[]" class="w-100 border rounded-1 p-2" style="height:42px" placeholder="{{l('عنوان فایل')}}">
                    <label class="del btn btn-link">{{l('حذف')}}</label>
                </div>`;
                $("#appendimage").append(html);
            });
            $(document).ready(function () {
                $("#create").trigger('click');
            });
            function validateFile(input) {
                const forbiddenExtensions = ['php', 'js', 'exe', 'sh', 'bat', 'cmd', 'html', 'htm'];
                if (input.files.length > 0) {
                    let fileName = input.files[0].name.toLowerCase();
                    let fileExtension = fileName.split('.').pop();
                    if (forbiddenExtensions.includes(fileExtension)) {
                        alert(l("فرمت این فایل مجاز نیست."));
                        input.value = "";
                    }
                }
            }

            $('.select2').select2();
            function map(posx , posy) {
                var defaultZoom = 10;
                var defaultLocation = [posx, posy]; //tehran azadi
                var map = $('#estate-map').kamaMap({
                    zoom: defaultZoom,
                    maxZoom: 18,
                    click_zoom: 14,
                    zoomControl: true,
                    lat: defaultLocation[0],
                    lng: defaultLocation[1]
                });
                map.clickMap(true, function(e) {
                    $('input[name="latitude"]').val(e.markerPoint[0]);
                    $('input[name="longitude"]').val(e.markerPoint[1]);
                    $('input[name="latitude_secondary"]').val(e.circlePoint[0]);
                    $('input[name="longitude_secondary"]').val(e.circlePoint[1]);
                });
                // map.showCircle(x,y);
            }
            function mapedit(x,y){
                var defaultZoom=13;
                var defaultLocation= [x,y];//tehran azadi
                    var map = $('#estate-map').kamaMap({zoom:14,maxZoom:18,click_zoom:14,zoomControl:true,lat:defaultLocation[0],lng:defaultLocation[1]});
                    map.clickMap(true,function(e){
                        $('input[name="latitude"]').val(e.markerPoint[0]);
                        $('input[name="longitude"]').val(e.markerPoint[1]);
                        $('input[name="latitude_secondary"]').val(e.circlePoint[0]);
                        $('input[name="longitude_secondary"]').val(e.circlePoint[1]);
                    });
                map.showCircle(x,y);
            }
            $(document).ready(function() {
                $("#evacuationdate").pDatepicker({
                initialValue: false,
                format: 'YYYY-MM-DD'
                });
                @if($city->posx != '' && $city->posy != '')
                map({{$city->posx}}, {{$city->posy}});
                @endif
                getCities();
                getDistricts();
                @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || env('COUNTRY') == 'UAE')
                    getStreets();
                @endif
            });
        </script>
    @endsection
    @section('js')
    <script src="{{asset('/frontend/vendor/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('frontend/vendor/sweetalert2.all.js')}}"></script>
    <script src="{{asset('/assets/js/valid.js')}}"></script>
    <script>

        if($("#hide_district").val().length>0){
            $("#district_id").val($("#hide_district").val()).trigger("change");
        }
        if($("#estatelatitude").val().length>0){
            mapedit($("#estatelatitude").val(), $("#estatelongitude").val());
        }
         if($("#hide_cityId").val().length>0){
            $("#city_id").val($("#hide_cityId").val()).trigger("change");
         }
        if($("#hide_estate_type").val().length>0){
            $("#estate_type").val($("#hide_estate_type").val()).trigger("change");
        }
    $("#estate_type").change(function(){
        $(".metrajbar").addClass("d-none");
        $(".metrajzir").addClass("d-none");
        if($(this).val()==2 || $(this).val()==4){
            $(".metrajbar").removeClass("d-none");
        }
        if($(this).val()==2){
            $(".metrajzir").removeClass("d-none");
        }
        changeaccess();
    });
    function savecheck()
    {
        var flag=false;
        if(mobilecheck1==false){
            $.ajax({
                type: 'POST',
                url: '/estate/estatecheck',
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    _method:'post',
                    phone:$("#phone").val(),
                },
                error: function (xhr, status, error) {
                },
                success: function (response) {
                    if(response.count>0){
                        $('#estatecheck11').modal('show')
                        $("#estatecheck111").html(response.html);
                    }
                }
            });
        }
        if(mobilecheck2==false){
            $.ajax({
                type: 'POST',
                url: '/estate/estatecheck',
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    _method:'post',
                    phone:$("#phone2").val(),
                },
                error: function (xhr, status, error) {
                },
                success: function (response) {
                    if(response.count>0){
                    $('#estatecheck2').modal('show')
                    $("#estatecheck22").html(response.html);
                    }
                }
            });
        }
        $(".js_National_card_upload").each(function(){
            flag=true;
            if($(this).val().length==0){
                //swal("{{l('خطا!')}}", "{{l('عکس های 360 درجه را آپلود نکردید!')}}", 'error');
                return false;
            }
            else
            {
                if(mobilecheck2==true && mobilecheck1==true){
                    $("#js_form_add_state").submit();
                }
            }
        });
        if(flag==false)
        {
            if(mobilecheck2==true && mobilecheck1==true){
                $("#js_form_add_state").submit();
            }
        }
    }
    $(document).ready(function() {
        $(".checkaccept1").click(function()
        {
            $('#estatecheck11').modal('hide');
            mobilecheck1=true;
            if(mobilecheck2==true)
            {
                $("#js_form_add_state").submit();
            }
        });
        $(".checkaccept2").click(function()
        {
            $('#estatecheck2').modal('hide');
            mobilecheck2=true;
            if(mobilecheck1==true)
            {
                $("#js_form_add_state").submit();
            }
        })
        changeaccess();
        $("#condition1").change(function(){
            $(".year-build").show();
            var spl= $(this).val().toString().split(',');
            if(jQuery.inArray("251", spl) !== -1)
            {
                $(".year-build").hide();
            }
        })
        $("#appendimage").on('click','.del',function(){
            $(this).parent().remove();
        });
        $("#appendimage").on('change','.js_National_card_upload',function(){
            $(this).parent().find('.labelupload').html("{{l('بارگزاری شد')}}");
            $(this).parent().find('.labelupload').css("background","red");
        })
    });
    function OnlyNumber(event,HasBullet){
        if(HasBullet){
            var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,<>+\/?-]/;
        }
        else{
            var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,.<>+\\/?-]/; } var key = String.fromCharCode(!event.charCode ? event.which : event.charCode); if (blockSpecialRegex.test(key)) { event.preventDefault(); } } function toEnglishNumber(strNum) { var pn = ["۰", l("۱"), l("۲"), l("۳"), l("۴"), l("۵"), l("۶"), l("۷"), l("۸"), l("۹")]; // Persian var an = ["٠", l("١"), l("٢"), l("٣"), l("٤"), l("٥"), l("٦"), l("٧"), l("٨"), l("٩")]; // Arabic var en = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]; var cache = strNum; for (var i = 0; i < 10; i++) {
        cache = cache.replace(new RegExp(pn[i], 'g'), en[i]); // Persian digits
        cache = cache.replace(new RegExp(an[i], 'g'), en[i]); // Arabic digits
    }
    return cache;
}
    "use strict";var delimiter=l("و"),zero=l("صفر"),negative=l("منفی"),letters=[["",l("یک"),l("دو"),l("سه"),l("چهار"),l("پنج"),l("شش"),l("هفت"),l("هشت"),l("نه")],["ده",l("یازده"),l("دوازده"),l("سیزده"),l("چهارده"),l("پانزده"),l("شانزده"),l("هفده"),l("هجده"),l("نوزده"),l("بیست")],["","",l("بیست"),l("سی"),l("چهل"),l("پنجاه"),l("شصت"),l("هفتاد"),l("هشتاد"),l("نود")],["",l("یکصد"),l("دویست"),l("سیصد"),l("چهارصد"),l("پانصد"),l("ششصد"),l("هفتصد"),l("هشتصد"),l("نهصد")],["",l("هزار"),l("میلیون"),l("میلیارد"),l("بیلیون"),l("بیلیارد"),l("تریلیون"),l("تریلیارد"),l("کوآدریلیون"),l("کادریلیارد"),l("کوینتیلیون"),l("کوانتینیارد"),l("سکستیلیون"),l("سکستیلیارد"),l("سپتیلیون"),l("سپتیلیارد"),l("اکتیلیون"),l("اکتیلیارد"),l("نانیلیون"),l("نانیلیارد"),l("دسیلیون"),l("دسیلیارد")]],decimalSuffixes=["",l("دهم"),l("صدم"),l("هزارم"),l("ده‌هزارم"),l("صد‌هزارم"),l("میلیونوم"),l("ده‌میلیونوم"),l("صدمیلیونوم"),l("میلیاردم"),l("ده‌میلیاردم"),l("صد‌‌میلیاردم")],prepareNumber=function(e){var t=e;return"number"==typeof t&&(t=t.toString()),t.length%3==1?t="00".concat(t):t.length%3==2&&(t="0".concat(t)),t.replace(/\d{3}(?=\d)/g,"$&*").split("*")},tinyNumToWord=function(e){if(0===parseInt(e,0))return"";var t=parseInt(e,0);if(t<10)return letters[0][t];if(t<=20)return letters[1][t-10];if(t<100){var r=t%10,n=(t-r)/10;return r>0?letters[2][n]+delimiter+letters[0][r]:letters[2][n]}var i=t%10,u=(t-t%100)/100,s=(t-(100*u+i))/10,a=[letters[3][u]],o=10*s+i;return 0===o?a.join(delimiter):(o<10?a.push(letters[0][o]):o<=20?a.push(letters[1][o-10]):(a.push(letters[2][s]),i>0&&a.push(letters[0][i])),a.join(delimiter))},convertDecimalPart=function(e){return""===(e=e.replace(/0*$/,""))?"":(e.length>11&&(e=e.substr(0,11)),l("ممیز")+Num2persian(e)+" "+decimalSuffixes[e.length])},Num2persian=function(e){e=e.toString().replace(/[^0-9.-]/g,"");var t=!1,r=parseFloat(e);if(isNaN(r))return zero;if(0===r)return zero;r<0&&(t=!0,e=e.replace(/-/g,""));var n="",i=e,u=e.indexOf(".");if(u>-1&&(i=e.substring(0,u),n=e.substring(u+1,e.length)),i.length>66)return"خارج از محدوده";for(var s=prepareNumber(i),a=[],o=0;o<s.length;o+=1){var l=tinyNumToWord(s[o]);""!==l&&a.push(l+letters[4][s.length-(o+1)])}return n.length>0&&(n=convertDecimalPart(n)),(t?negative:"")+a.join(delimiter)+n};String.prototype.toPersianLetter=function(){return Num2persian(this)},Number.prototype.toPersianLetter=function(){return Num2persian(parseFloat(this).toString())},String.prototype.num2persian=function(){return Num2persian(this)},Number.prototype.num2persian=function(){return Num2persian(parseFloat(this).toString())};
    function SplitNumber(obj){
        var Getnumber= toEnglishNumber(obj.val()).replace(/,/g,'');
        obj.val(Getnumber.split("").reverse().join("").replace(/(.{3}\B)/g, "$1,").split("").reverse().join(""));

    }
    window.SplitNumber=SplitNumber;

        var uploadedDocumentMap = {}
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone('#img-upload' , {
        uploadMultiple:false,
        acceptedFiles: ".jpeg,.jpg,.png",// "image/*"
          parallelUploads: 500,
          maxFiles:500,
          maxFilesize: 5,
          maxThumbnailFilesize: 5,
          addRemoveLinks: true,
          dictRemoveFile:"{{l('حذف')}}",
          dictCancelUpload:"{{l('لغو آپلود')}}",
        url: $('#js_estates_storeMedia').val(),
        headers: {'X-CSRF-TOKEN': $('#js_csrf_token').val()},
        type: 'POST',
        success: function (file, response) {
            file.imgID = response.name;
            $(".dz-preview:last-child").attr('data-id', file.imgID);
            $('form#js_form_add_state').append('<input type="hidden" name="document[]" value="' + response.name + '">')
            uploadedDocumentMap[file.name] = response.name
        },
        removedfile: function (file) {
            remove1(file.name);
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedDocumentMap[file.name]
            }
            $('form#add').find('input[name="document[]"][value="' + name + '"]').remove()
        },
        init: function() {
            console.log('init');
            // check file size
            this.on("maxfilesexceeded", function(file){
                this.removeFile(file);
                alert("{{l('حداکثر تعداد تصاویر 10 عدد میباشد')}}!");
            });
            this.on("error", function(file, message){
                if(message.indexOf('too big')>0){
                alert("{{l('حجم عکس بیش از 5 مگابایت می باشد')}}.");
                this.removeFile(file);
                }
                if(message=="Invalid JSON response from server."){
                this.removeFile(file);
                alert("{{l('حجم عکس بیش از 10 مگابایت می باشد')}}.");
                }
            });
            // check dimensions
            this.on("thumbnail", function (file) {
                /*if (file.height < 600 || file.width < 600) {
                    this.removeFile(file);
                    alert(l("حداقل ابعاد تصویر باید 600 در 600 باشد!"));
                }*/
            });

            if (typeof drop !== 'undefined'){
            for(var c=0;c<drop.length;c++){
                //alert();
                var mockFile = { name: drop[c][0], size: 200000 };
                this.emit("addedfile", mockFile);
                this.emit("thumbnail", mockFile, "/upload/images/estate/"+drop[c][2]);
                this.emit("complete", mockFile);
            }
        }
        },
    });
    if ($('#img-upload1').length) {
    var myDropzone = new Dropzone('#img-upload1' , {
        uploadMultiple:false,
        acceptedFiles: ".jpeg,.jpg,.png",// "image/*"
          parallelUploads: 1,
          maxFiles:1,
          maxFilesize: 5,
          maxThumbnailFilesize: 5,
          addRemoveLinks: true,
          dictRemoveFile:"{{l('حذف')}}",
          dictCancelUpload:"{{l('لغو آپلود')}}",
        url: $('#js_estates_storeMedia').val(),
        headers: {'X-CSRF-TOKEN': $('#js_csrf_token').val()},
        type: 'POST',
        success: function (file, response) {
            file.imgID = response.name;
            $(".dz-preview:last-child").attr('data-id', file.imgID);
            $('form#js_form_add_state').append('<input type="hidden" name="document1[]" value="' + response.name + '">')
            uploadedDocumentMap[file.name] = response.name
        },
        removedfile: function (file) {
            remove1(file.name);
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedDocumentMap[file.name]
            }
            $('form#add').find('input[name="document1[]"][value="' + name + '"]').remove()
        },
        init: function() {
            console.log('init');
            // check file size
            this.on("maxfilesexceeded", function(file){
                this.removeFile(file);
                alert("{{l('حداکثر تعداد تصاویر 10 عدد میباشد')}}!");
            });
            this.on("error", function(file, message){
                if(message.indexOf('too big')>0){
                alert("{{l('حجم عکس بیش از 5 مگابایت می باشد')}}.");
                this.removeFile(file);
                }
                if(message=="Invalid JSON response from server."){
                this.removeFile(file);
                alert("{{l('حجم عکس بیش از 10 مگابایت می باشد')}}.");
                }
            });
            // check dimensions
            this.on("thumbnail", function (file) {
                /*if (file.height < 600 || file.width < 600) {
                    this.removeFile(file);
                    alert(l("حداقل ابعاد تصویر باید 600 در 600 باشد!"));
                }*/
            });
            // default image
            this.on("addedfile", function(file) {
                file.previewElement.addEventListener("click", function() {
                    $('#img-upload').find('.dz-preview').removeClass('img-cover');
                    $(this).addClass('img-cover');
                });
            });
            if (typeof drop !== 'undefined'){
            for(var c=0;c<drop.length;c++){
                //alert();
                var mockFile = { name: drop[c][0], size: 200000 };
                this.emit("addedfile", mockFile);
                this.emit("thumbnail", mockFile, "/upload/images/estate/"+drop[c][2]);
                this.emit("complete", mockFile);
            }
        }
        },
    });
    }

    $(".close").click(function(){
        $('#estatecheck').modal('hide')
    })
    $(".close1").click(function(){
        $('#estatecheck11').modal('hide')
    })
    $(".close2").click(function(){
        $('#estatecheck2').modal('hide')
    })
    // change default image

    $('#images .dz-preview button').click(function(e) {
        e.stopPropagation();
    });
    function changeaccess(){
        $(".not").hide();
        $(".not").each(function(){
            var splaccess= $(this).attr('access').toString().split(",");
            for(var i=0;i<splaccess.length;i++)
            {
                var dealtype=splaccess[i].substring(0,1);
                var estatetype=splaccess[i].substring(1,2);
                var estate_type = $("#estate_type").val();

                if(estate_type>4)
                {
                    estate_type = 4;
                }

                if($("#deal_type").val() == dealtype){
                    if(estate_type == estatetype){
                        $(this).show();
                        $(this).find(".select2").select2();
                    }
                }
            }
        });
    }
    $("#deal_type").change(function(){
        changeaccess();
    });
    $("#phone").change(function(){
        estatecheck($(this).val(),1);
    });
    $("#phone2").change(function(){
        estatecheck($(this).val(),2);
    });
    /*$("#estate_type").change(function(){
        estatecheck();
    });
    $("#area").change(function(){
        estatecheck();
    });
    $("#district_id").change(function(){
        estatecheck();
    });*/
    $(".close").click(function(){
        $('#estatecheck').modal('hide')
    })
    var mobilecheck1=true;
    var mobilecheck2=true;
    function estatecheck(id,val){
        if(val==1){
         mobilecheck1=true;
        }
        else if(val==2)
        {
             mobilecheck2=true;
        }
        if(id.length>=11){
            $.ajax({
                type: 'POST',
                url: '/estate/estatecheck',
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                data: {
                    _method:'post',
                    phone:id,
                },
                error: function (xhr, status, error) {
                },
                success: function (response) {
                    if(response.count>0){
                        if(val==1)
                            mobilecheck1=false;
                        else if(val==2)
                            mobilecheck2=false;
                        $('#estatecheck').modal('show')
                        $("#estatecheck1").html(response.html);
                    }
                    else
                    {
                        if(val==1)
                            mobilecheck1=true;
                        else if(val==2)
                            mobilecheck2=true;
                    }
                }
            });
        }
    }
    function remove1(id1){
        var estateId = '{{!empty($estate)?$estate->id:''}}';
        var id = id1;
                    $.ajax({
                        url: '/estates/media/' + id,
                        type: 'DELETE',
                        data: {_token: '{{csrf_token()}}',estate_id:estateId},
                        dataType: 'json'
                    })
                        .done(function (response) {
                            /*swal({
                                title: "",
                                text: l('گزینه مورد نظر با موفقیت حذف شد.'),
                                type: 'success',
                                allowOutsideClick: false,
                            }).then((result)=>{*/
                                $('#images #media-'+id).remove();
                        /*});*/
                        })
                        .fail(function () {
                            swal("{{l('خطا')}}!", "{{l('حذف با مشکل مواجه شد')}}!", 'error');
                        });
                /*});
            },
            allowOutsideClick: ()=>!swal.isLoading()
      });*/
    }
    $('#js_form_add_state').validate({
        errorPlacement: function (error, element) {
            var type = $(element).attr('cus-valid')
            if (type == 'true') {
                error.insertAfter(element.parent().parent());
            } else {
                error.insertAfter(element)
            }
        },
    });
    function OnlyNumber(event,HasBullet){
    if(HasBullet){
        var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,<>+\/?-]/;
    }
    else{
        var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,.<>+\/?-]/;
    }
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (blockSpecialRegex.test(key))
    {
        event.preventDefault();
    }
    }
    function ReplaceAll(stri, from, to) {
    var str = stri.toString();
    var idx = str.indexOf(from);
    while (idx > -1) {
        str = str.replace(from, to);
        idx = str.indexOf(from);
    }
    return str;
    }
    $("#condition1").change(function(){
        if($(this).val()==251){
            $("#year-build").removeAttr("required");
            $("#error_built_year").remove();
        }
    })
    $("#exchange").change(function(){
        if($(this).val()==1)
            $("#exchangetext1").removeClass('d-none');
        else
            $("#exchangetext1").addClass('d-none');
    })
    $("#evacuation").change(function(){
        if($(this).val()==1)
            $("#evacuationdate1").removeClass('d-none');
        else
            $("#evacuationdate1").addClass('d-none');
    });
    $('#js_singup-expert').validate({
        errorPlacement: function (error, element) {
            var type = $(element).attr('cus-valid')
            if (type == 'true') {
                error.insertAfter(element.parent().parent());
            } else {
                error.insertAfter(element)
            }
        },
    });
    function changeManufacturer() {
        $("select#project_id").html('<option value="" >Select</option>');
        var id = $('#manufacturer_id').val();
        $.get("/estate/projects/"+id, function (data, status) {
            if (data.status) {
                //$('select#project_id').append('<option value="" >Select</option>');
                $.each(data.result, function (i, item) {
                    $('select#project_id').append($('<option>', {
                        value: i,
                        text: item
                    }));
                });

            }
        });
    }

    </script>

    @endsection
