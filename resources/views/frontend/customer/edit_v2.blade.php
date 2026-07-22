@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('ویرایش خریدار')
])
@section('main_content')
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" media="screen" href="/vendor/leaflet/dist/leaflet.css" />
<link rel="stylesheet" media="screen" href="/vendor/filepond/dist/filepond.min.css" />
<link href="/css/Mh1PersianDatePicker.css" rel="stylesheet" />
!-- Main Theme Styles + Bootstrap-->
    <!-- main -->
    <main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">

        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => '4'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <div class="flex justify-between items-center py-3">
                    <h3 class="text-[24px] text-gray-500 font-light">{{l('ویرایش خریدار')}}</h3>

                <form role="form" method="POST" id="form-cus" action="<?php if (!empty($model)) echo '/customer/update/' . $model->id ?>" >
                    @method('put')
                    @csrf
                    <section class="card card-body shadow-sm rounded p-4 mb-4" id="basic-info">
                        <h2 class="h5 mb-4"><i class="fi-info-circle text-primary fs-5 mt-n1 me-2"></i>{{l('اطلاعات خریدار')}}
                        </h2>
                            <div class="row">

                                <div class="col-sm-6 mb-3">
                                    <label for="gender" class="form-label fw-bold">
                                        {{ l('جنسیت') }}
                                    </label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="male" {{!empty($model) && $model->gender == "male" ? 'selected' :''}}>{{ l('آقا') }}</option>
                                        <option value="female" {{!empty($model) && $model->gender == "female" ? 'selected' :''}}>{{ l('خانم') }}</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="name">{{l('نام خریدار')}} <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text"  id="name" name="name"  value="{{!empty($model)?$model->name:''}}" required>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="mobile"> {{l('تلفن همراه')}} <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="mobile" name="mobile" value="{{!empty($model)?$model->mobile:''}}" required>
                                </div>
                                @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="mobile"> {{l('تلفن همراه 2')}}</label>
                                    <input class="form-control" type="text" id="mobile2" name="mobile2" value="{{!empty($model)?$model->mobile2:''}}" >
                                </div>
                                @endif
                                <div class="col-sm-6 mb-3">
                                    <div class="form-label fw-bold pt-3">{{l('نوع درخواست')}}
                                    </div>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="1" id="ap-buyer"
                                                name="request_type" {{!empty($model)?($model->request_type==1?'checked':''):'checked'}} >
                                            <label class="form-check-label" for="ap-buyer">{{l('خرید')}} </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="2" id="ap-rent"
                                                name="request_type" {{!empty($model)?($model->request_type==2?'checked':''):'checked'}}>
                                            <label class="form-check-label" for="ap-rent">{{l('اجاره')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-label fw-bold pt-3"> {{l('وضعیت نقدینگی')}}
                                    </div>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="full-cash" name="financial_liquidity_type"
                                                name="ap-cash-type" {{!empty($model)?($model->financial_liquidity_type==1?'checked':''):'checked'}} value="1">
                                            <label class="form-check-label" for="ap-full-cash">{{l('کاملا نقد')}} </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="part-cash" name="financial_liquidity_type"
                                                name="ap-cash-type" {{!empty($model)?($model->financial_liquidity_type==2?'checked':''):'checked'}} value="2">
                                            <label class="form-check-label" for="ap-cash">{{l('بخشی نقد')}}</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="none-cash" name="financial_liquidity_type"
                                                name="ap-cash-type" {{!empty($model)?($model->financial_liquidity_type==3?'checked':''):'checked'}} value="3">
                                            <label class="form-check-label" for="ap-non-cash">{{l('غیر نقد')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="ap-type">{{l('نوع ملک')}} <span
                                            class="text-danger">*</span></label>

                                    <select class="form-select" id="estate_type" name="estate_type" required>
                                        <option value="" disabled hidden>{{l('انتخاب نوع ملک')}}</option>
                                        @foreach (estateTypes() as $key=>$val)
                                        <option value="{{$key}}"  @php echo ($model->estate_type == $key ? "selected" :'') @endphp>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if ($currentUser->isAdmin())
                                @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 3 || ss('SITE_ID') == 5)

                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="ap-max-buy">{{ l('وضعیت تائید مشتری') }}</label>

                                    <select class="form-control" name="status" id="status" style="width:100%">
                                        <option value="1" {{!empty($model) && $model->status == "1" ? 'selected' :''}}>{{ l('جاری') }}</option>
                                        <option value="2" {{!empty($model) && $model->status == "2" ? 'selected' :''}}>{{ l('خرید از دفتر') }}</option>
                                        <option value="3" {{!empty($model) && $model->status == "3" ? 'selected' :''}}>{{ l('خرید از بیرون') }}</option>
                                        <option value="4" {{!empty($model) && $model->status == "4" ? 'selected' :''}}>{{ l('انصرافی') }}</option>
                                        <option value="5" {{!empty($model) && $model->status == "5" ? 'selected' :''}}>{{ l('در حال معامله') }}</option>
                                        <option value="6" {{!empty($model) && $model->status == "6" ? 'selected' :''}}>{{ l('اولویت آینده') }}</option>
                                        <option value="7" {{!empty($model) && $model->status == "7" ? 'selected' :''}}>{{ l('عمومی') }}</option>

                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3 d-none" id="returndate">
                                    <label class="form-label fw-bold" for="ap-max-buy">{{ l('تاریخ بازگشت به جاری') }}</label>
                                    <input type="text"   value="{{$model->datereconfirm ?? toPersianDateYdm($model->datereconfirm)}}" id="datereconfirm" onclick="Mh1PersianDatePicker.Show(this,'{{toPersianDateYdm($model->datereconfirm)}}')" class="form-control text-left" style="text-align: left" name="datereconfirm"/>
                                </div>
                                @endif
                                @if(ss('SITE_ID') != 3)
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="ap-max-buy">{{ l('وضعیت تائید مشتری') }}</label>
                                    <select class="form-control" name="status" id="status" style="width:100%">
                                        <option value="1" {{!empty($model) && $model->status == "1" ? 'selected' :''}}>{{ l('جاری') }}</option>
                                        <option value="2" {{!empty($model) && $model->status == "2" ? 'selected' :''}}>{{ l('آرشیو') }}</option>

                                    </select>
                                </div>
                                @endif
                                @endif
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="ap-city"> {{l('انتخاب شهر')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select"  name="city_id" id="city_id">
                                        <option value="" disabled>{{l('انتخاب شهر')}}</option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}" {{$city->id == (!empty($model)?$model->city_id : '') ? 'selected' :''}}>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12 mb-3 district">
                                    <label class="form-label fw-bold" for="ap-district"> {{l('منطقه')}}<span
                                            class="text-danger">*</span>
                                    </label>

                                    <select class="form-select js-example-disabled-results select2" id="districts" multiple name="districts[]">

                                        <option value="" disabled hidden>{{l('منطقه')}}</option>
                                        @foreach($districts as $district)

                                        <option value="{{$district->id}}" {{($model->districts->where('id','=',$district->id)->first() != null)?"selected":''}}>{{$district->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <style>
                                    .district .select2-container--default .select2-selection--multiple
                                    {
                                        display:table;
                                        width:100%
                                    }
                                </style>
                                <div class="col-sm-6 mb-3">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold" for="ap-min-area">{{l('حداقل متراژ درخواستی')}}</label>
                                        <input class="form-control" type="tel" min="20"  id="area_min" name="area_min"  value="{{!empty($model)?$model->area_min:''}}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold" for="area_max">{{l('حداکثر متراژ درخواستی')}}
                                            </label>
                                        <input class="form-control" type="tel" min="20"  id="area_max" name="area_max"  value="{{!empty($model)?$model->area_max:''}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 rent-content" style="{{($model->request_type==1)?'display: none;':''}}">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold" for="rent_min">{{l('حداقل مبلغ اجاره')}}
                                            </label>
                                        <input class="form-control" type="tel" id="rent_min"   name="rent_min"  onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));" value="{{!empty($model)?toPersianNumbers($model->rent_min):''}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 rent-content" style="{{($model->request_type==1)?'display: none;':''}}">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold" for="rent_max">{{l('حداکثر مبلغ اجاره')}}</label>
                                        <input class="form-control" type="tel" id="rent_max"   name="rent_max"  onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));" value="{{!empty($model)?toPersianNumbers($model->rent_max):''}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 rent-content" style="{{($model->request_type==1)?'display: none;':''}}">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold" for="deposit_min">{{l('حداقل مبلغ ودیعه')}}
                                           </label>
                                        <input class="form-control" type="tel" id="deposit_min"   name="mortgage_min" onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));" value="{{!empty($model)?toPersianNumbers($model->mortgage_min):''}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 rent-content" style="{{($model->request_type==1)?'display: none;':''}}">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold" for="deposit_max">{{l('حداکثر مبلغ ودیعه')}}</label>
                                        <input class="form-control" type="tel"  id="deposit_max" name="mortgage_max" onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));" value="{{!empty($model)?toPersianNumbers($model->mortgage_max):''}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 buyer-content" style="{{($model->request_type==2)?'display: none;':''}}">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold" for="price_min">{{l('حداقل مبلغ خرید')}}
                                           </label>
                                        <input class="form-control"  id="price_min" name="price_min"
                                        placeholder="{{l('حداقل مبلغ را وارد کنید')}}" onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));"   value="{{!empty($model)?toPersianNumbers($model->price_min):''}}">
                                        <div class="divprice"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 buyer-content" style="{{($model->request_type==2)?'display: none;':''}}">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold" for="price_max">{{l('حداکثر مبلغ خرید')}}</label>
                                        <input class="form-control" id="price_max" name="price_max"
                                            placeholder="{{l('حداکثر مبلغ را وارد کنید')}}" onkeypress="OnlyNumber(event,false)"  onkeyup="SplitNumber($(this));"  value="{{!empty($model)?toPersianNumbers($model->price_max):''}}">
                                            <div class="divprice"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-3 buyer-content ">
                                    <div>
                                        <label  class="form-label fw-bold" for="compensation">{{ l('قابلیت معاوضه') }}</label>
                                        <input class="form-check-input" id="compensation" {{!empty($model)?($model->compensation==1?"checked":""):""}} value="1" type="checkbox" name="compensation">
                                    </div>
                                </div>
                                @include(ss('THEME').'.frontend.customer.create',['model=>'.$model])
                                <div class="col-sm-12 mb-3">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold" for="ap-max-buy">{{l('یادداشت')}}</label>
                                        <textarea  name="note" id="desc-state" class="form-control" rows="6" required="">{{!empty($model)?$model->note:''}}</textarea>
                                    </div>
                                </div>
                                @if ($currentUser->isAdmin())
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-bold" for="ap-max-buy">{{l('انتخاب مشاور')}}</label>
                                    <select class="form-control select2" name="expertid" id="expertid" style="width: 100%;">
                                        <option value="">{{ l('انتخاب کنید') }}</option>
                                        @foreach($users as $item)
                                            <option value="{{$item->id}}" {{!empty($model) && $model->user_id == $item->id ? 'selected' :''}}>{{$item->fullname()}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @else
                                <input type="hidden" name="expertid" value="{{$currentUser->id}}">
                                @endif
                            </div>
                    </section>
                    <!-- Action buttons -->
                    <section class="d-sm-flex justify-content-between pt-2">
                        <input type="hidden" name="user_id" value="{{$currentUser->id}}">
                        <button type="submit" class="btn btn-primary btn-lg d-block mb-2">
                            {{l('ویرایش خریدار')}}
                        </a>
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
    <script src="/vendor/jquery-3.6.0.js"></script>
    <script src="/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="/vendor/leaflet/dist/leaflet.js"></script>
    <script src="/vendor/filepond/dist/filepond.min.js"></script>
    <script src="/vendor/cleave.js/dist/cleave.min.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <!-- Main theme script-->
    <script src="/js/theme.min.js"></script>
    <script src="/js/Mh1PersianDatePicker.js"></script>
    <script>
function changeaccess(){
    $(".not").hide();
    $(".not").each(function(){
        var splaccess= $(this).attr('access').toString().split(",");
        for(var i=0;i<splaccess.length;i++){
            var dealtype=splaccess[i].substring(0,1);
            var estatetype=splaccess[i].substring(1,2);
            var estate_type = $("#estate_type").val();
            @if (env('COUNTRY') == 'UAE')
            if(estate_type>4)
            {
                estate_type = 4;
            }
            @endif
            if($("#deal_type").val()==dealtype){
                changeaccess();
                if(estate_type == estatetype){
                    $(this).show();
                    $(this).find(".select2").select2();
                }
            }
        }
    });
}
changeaccess();
    function OnlyNumber(event,HasBullet){
        if(HasBullet){
            var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,<>+\/?-]/;
        }
        else{
            var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,.<>+\\/?-]/; } var key = String.fromCharCode(!event.charCode ? event.which : event.charCode); if (blockSpecialRegex.test(key)) { event.preventDefault(); } } "use strict";var delimiter=l("و"),zero=l("صفر"),negative=l("منفی"),letters=[["",l("یک"),l("دو"),l("سه"),l("چهار"),l("پنج"),l("شش"),l("هفت"),l("هشت"),l("نه")],["ده",l("یازده"),l("دوازده"),l("سیزده"),l("چهارده"),l("پانزده"),l("شانزده"),l("هفده"),l("هجده"),l("نوزده"),l("بیست")],["","",l("بیست"),l("سی"),l("چهل"),l("پنجاه"),l("شصت"),l("هفتاد"),l("هشتاد"),l("نود")],["",l("یکصد"),l("دویست"),l("سیصد"),l("چهارصد"),l("پانصد"),l("ششصد"),l("هفتصد"),l("هشتصد"),l("نهصد")],["",l("هزار"),l("میلیون"),l("میلیارد"),l("بیلیون"),l("بیلیارد"),l("تریلیون"),l("تریلیارد"),l("کوآدریلیون"),l("کادریلیارد"),l("کوینتیلیون"),l("کوانتینیارد"),l("سکستیلیون"),l("سکستیلیارد"),l("سپتیلیون"),l("سپتیلیارد"),l("اکتیلیون"),l("اکتیلیارد"),l("نانیلیون"),l("نانیلیارد"),l("دسیلیون"),l("دسیلیارد")]],decimalSuffixes=["",l("دهم"),l("صدم"),l("هزارم"),l("ده‌هزارم"),l("صد‌هزارم"),l("میلیونوم"),l("ده‌میلیونوم"),l("صدمیلیونوم"),l("میلیاردم"),l("ده‌میلیاردم"),l("صد‌‌میلیاردم")],prepareNumber=function(e){var t=e;return"number"==typeof t&&(t=t.toString()),t.length%3==1?t="00".concat(t):t.length%3==2&&(t="0".concat(t)),t.replace(/\\d{3}(?=\\d)/g,"$&*").split("*")},tinyNumToWord=function(e){if(0===parseInt(e,0))return"";var t=parseInt(e,0);if(t<10)return letters[0][t];if(t<=20)return letters[1][t-10];if(t<100){var r=t%10,n=(t-r)/10;return r>0?letters[2][n]+delimiter+letters[0][r]:letters[2][n]}var i=t%10,u=(t-t%100)/100,s=(t-(100*u+i))/10,a=[letters[3][u]],o=10*s+i;return 0===o?a.join(delimiter):(o<10?a.push(letters[0][o]):o<=20?a.push(letters[1][o-10]):(a.push(letters[2][s]),i>0&&a.push(letters[0][i])),a.join(delimiter))},convertDecimalPart=function(e){return""===(e=e.replace(/0*$/,""))?"":(e.length>11&&(e=e.substr(0,11)),l("ممیز")+Num2persian(e)+" "+decimalSuffixes[e.length])},Num2persian=function(e){e=e.toString().replace(/[^0-9.-]/g,"");var t=!1,r=parseFloat(e);if(isNaN(r))return zero;if(0===r)return zero;r<0&&(t=!0,e=e.replace(/-/g,""));var n="",i=e,u=e.indexOf(".");if(u>-1&&(i=e.substring(0,u),n=e.substring(u+1,e.length)),i.length>66)return"خارج از محدوده";for(var s=prepareNumber(i),a=[],o=0;o<s.length;o+=1){var l=tinyNumToWord(s[o]);""!==l&&a.push(l+letters[4][s.length-(o+1)])}return n.length>0&&(n=convertDecimalPart(n)),(t?negative:"")+a.join(delimiter)+n};String.prototype.toPersianLetter=function(){return Num2persian(this)},Number.prototype.toPersianLetter=function(){return Num2persian(parseFloat(this).toString())},String.prototype.num2persian=function(){return Num2persian(this)},Number.prototype.num2persian=function(){return Num2persian(parseFloat(this).toString())};
    function SplitNumber(obj){
        var Getnumber=obj.val().replace(/,/g,'');
        obj.val(Getnumber.split("").reverse().join("").replace(/(.{3}\B)/g, "$1,").split("").reverse().join(""));
        @if(env('COUNTRY') != 'UAE')
        obj.parent().find(".divprice").html(obj.val().num2persian()+" تومان");
        @endif
    }
    window.SplitNumber=SplitNumber;
    $('.select2').select2();
    const buyer = document.getElementById('ap-buyer')
    const rent = document.getElementById('ap-rent')
    const buyerContent = document.querySelectorAll('.buyer-content')
    const rentContent = document.querySelectorAll('.rent-content')
    buyer.addEventListener('click', () => {
        rentContent.forEach(item => {
            item.style.display = 'none'
        })
        buyerContent.forEach(item => {
            item.style.display = 'block'
        })
    })
    rent.addEventListener('click', () => {
        buyerContent.forEach(item => {
            item.style.display = 'none'
        })
        rentContent.forEach(item => {
            item.style.display = 'block'
        })
    });
    function ConfirmationCheck(id)
    {
        if(id==6)
            $("#returndate").removeClass("d-none");
        else
            $("#returndate").addClass("d-none");
    }
    $(document).ready(function(){

        $(".max_room_count1").removeClass('d-none');
        $(".min_floor_count1").removeClass('d-none');
        $(".max_unit_in_floor1").removeClass('d-none');
        $(".max_building_age1").removeClass('d-none');
        $(".conditions151").removeClass('d-none');
        $(".floor_count1").removeClass('d-none');
        $("#status").change(function(){
            ConfirmationCheck($(this).val());
        });

        <?php if(!empty($model) && $model->status){?>
        ConfirmationCheck({{$model->status}});
        <?php } ?>
        $("#estate_type").change(function(){
            changeaccess();
            $(".min_front_area1").addClass('d-none');
                $(".max_unit_in_floor1").addClass('d-none');
                $(".max_building_age1").addClass('d-none');
                $(".conditions151").addClass('d-none');
                $(".floor_count1").addClass('d-none');
                $(".floor_start1").addClass('d-none');
                $(".min_floor_area1").addClass('d-none');
                $(".min_street_width1").addClass('d-none');
                $(".min_density1").addClass('d-none');
                $(".build_license1").addClass('d-none');
                $(".geography1").addClass('d-none');


                $(".max_room_count1").addClass('d-none');
                if($(this).val()==1 || $(this).val()==2){
                $(".max_room_count1").removeClass('d-none');
                $(".min_floor_count1").removeClass('d-none');


            }
            if($(this).val()==3 || $(this).val()==2){
                $(".min_front_area1").removeClass('d-none');

            }
            if($(this).val()==1){
                $(".max_unit_in_floor1").removeClass('d-none');
                $(".max_building_age1").removeClass('d-none');
                $(".conditions151").removeClass('d-none');
                $(".floor_count1").removeClass('d-none');

            }
            if($(this).val()==2){
                $(".floor_start1").removeClass('d-none');
                $(".min_floor_area1").removeClass('d-none');
                $(".min_street_width1").removeClass('d-none');
                $(".min_density1").removeClass('d-none');
                $(".geography1").removeClass('d-none');
                $(".build_license1").removeClass('d-none');
            }

        });

    });

</script>
@endsection
