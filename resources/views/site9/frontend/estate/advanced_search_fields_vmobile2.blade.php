<script>
    var array = @json($districts);
    var arrayid = @json($districtsId);
    var str="";
    for (let i = 1; i < array.length; i++) {
        str+='<li class="relative mb-5">'+
        '<input class="hidden css_city js_filter_btn_0" type="checkbox"  onclick="typelocal('+arrayid[i]+',\''+array[i]+'\')" label_name="'+array[i]+'" id="districts_'+arrayid[i]+'"   name="districts[]"  element_name="'+array[i]+'">'+
        '<label class="before:content-[\' \'] before:w-[27px] before:h-[27px] before:bg-white before:border-[1px] border-gray-400 before:absolute  before:right-0 before:lg:rounded-25 before:rounded-[5px] mr-9 cursor-pointer css_city_label js_filter_action" for="districts_'+arrayid[i]+'">'+array[i]+'</label>'+
        '</li>'
    }
    $(".js_filter_by_search_list").html(str);
        $(document).ready(function(){
            $(".js_filter_by_search_search").keyup(function(){
                var str1="";
                for (let i = 0; i < array.length; i++)
                {
                    if(array[i].indexOf($(this).val())>-1){
                        str1+='<li class="relative mb-5">'+
        '<input class="hidden css_city js_filter_btn_0" type="checkbox"  onclick="typelocal('+arrayid[i]+','+array[i]+')" label_name="'+array[i]+'" id="districts_'+arrayid[i]+'"   name="districts[]"  element_name="'+array[i]+'">'+
        '<label class="before:content-[\' \'] before:w-[27px] before:h-[27px] before:bg-white before:border-[1px] border-gray-400 before:absolute  before:right-0 before:lg:rounded-25 before:rounded-[5px] mr-9 cursor-pointer css_city_label js_filter_action" for="districts_'+arrayid[i]+'">'+array[i]+'</label>'+
        '</li>'
                    }
                }
                $(".js_filter_by_search_list").html(str1);
            })

        });

</script>
<style>
.checkbox2 input[type="checkbox"]:focus + label::before {
    outline: rgb(59, 153, 252) auto 5px;
}
</style>

<div class="fixed backdrop-blur-sm left-0 right-0 top-0 bottom-0 z-30 hidden js_blure_overlay" id="js_blure_overlay1" >
    <div class=" fixed bottom-0 left-0 right-0 h-0 z-30 bg-white rounded-t-25 shadow-[0px_-12px_23px_-7px_rgba(0,0,0,0.25)] px-[30px] duration-500 js_popup_dropdown" id="js_popup_dropdown" >
        <span class="w-10 mx-auto mt-3 rounded-full h-1 bg-gray-400 block js_close_popup_dropdown"></span>
        <div class="border-b-[1px] border-gray-200 mt-5 pb-5">
            <p class="text-center text-xl text-gray-500 font-light" id="js_popup_title_dropdown">{{ l('نوع کاربری') }}</p>
        </div>
        <div class="mt-7" id="js_body_popups_dropdown">
            <p class="text-center text-xl text-gray-500 font-light mb-6" id="js_popup_custom_dropdown"></p>
            <div>

                <ul class="space-y-4 overflow-auto lg:max-h-[200px] pt-2 text-right pr-3 h-[calc(100vh-320px)]" id="js_popup_body_dropdown " >
                    <li class="text-center">

                        <input value="107" type="checkbox" onclick="usage_type(107)" label_name=l("مسکونی") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_107">
                        <label class="" for="js_mobile_type_of_Document_107">{{ l('مسکونی') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="108" type="checkbox" onclick="usage_type(108)" label_name=l("اداری") class=" usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_108">
                        <label class="" for="js_mobile_type_of_Document_108">{{ l('اداری') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="109" type="checkbox" onclick="usage_type(109)" label_name=l("تجاری") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_109">
                        <label class="" for="js_mobile_type_of_Document_109">{{ l('تجاری') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="110" type="checkbox" onclick="usage_type(110)" label_name=l("مسکونی با موقعیت اداری - تجاری") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_110">
                        <label class="" for="js_mobile_type_of_Document_110">{{ l('مسکونی با موقعیت اداری - تجاری') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="111" type="checkbox" onclick="usage_type(111)" label_name=l("گردشگری") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_111">
                        <label class="" for="js_mobile_type_of_Document_111">{{ l('گردشگری') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="252" type="checkbox" onclick="usage_type(252)" label_name=l("مسکونی با موقعیت اداری") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_252">
                        <label class="" for="js_mobile_type_of_Document_252">{{ l('مسکونی با موقعیت اداری') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="253" type="checkbox" onclick="usage_type(253)" label_name=l("مسکونی به همراه تجاری") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_253">
                        <label class="" for="js_mobile_type_of_Document_253">{{ l('مسکونی به همراه تجاری') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="254" type="checkbox" onclick="usage_type(254)" label_name=l("باغ ویلا") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_254">
                        <label class="" for="js_mobile_type_of_Document_254">{{ l('باغ ویلا') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="255" type="checkbox" onclick="usage_type(255)" label_name=l("ویلا جنگلی") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_255">
                        <label class="" for="js_mobile_type_of_Document_255">{{ l('ویلا جنگلی') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="256" type="checkbox" onclick="usage_type(256)" label_name=l("ویلا ساحلی") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_256">
                        <label class="" for="js_mobile_type_of_Document_256">{{ l('ویلا ساحلی') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="285" type="checkbox" onclick="usage_type(285)" label_name=l("کشاورزی") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_285">
                        <label class="" for="js_mobile_type_of_Document_285">{{ l('کشاورزی') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="286" type="checkbox" onclick="usage_type(286)" label_name=l("باغ") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_286">
                        <label class="" for="js_mobile_type_of_Document_286">{{ l('باغ') }}</label>
                    </li>

                    <li class="text-center">
                        <input value="287" type="checkbox" onclick="usage_type(287)" label_name=l("دامپروری") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_287">
                        <label class="" for="js_mobile_type_of_Document_287">{{ l('دامپروری') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="288" type="checkbox" onclick="usage_type(288)"  label_name=l("صنعتی") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_288">
                        <label class="" for="js_mobile_type_of_Document_288">{{ l('صنعتی') }}</label>
                    </li>

                    <li class="text-center">
                        <input value="289" type="checkbox" onclick="usage_type(289)" label_name=l("بایر") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_289">
                        <label class="" for="js_mobile_type_of_Document_289">{{ l('بایر') }}</label>
                    </li>

                    <li class="text-center">
                        <input value="337" type="checkbox" onclick="usage_type(337)" label_name=l("گردشگری ( اقامتی)") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_337">
                        <label class="" for="js_mobile_type_of_Document_337">{{ l('گردشگری ( اقامتی)') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="341" type="checkbox" onclick="usage_type(341)" label_name=l("بدون توافق") class="usage_type text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Document_341">
                        <label class="" for="js_mobile_type_of_Document_341">{{ l('بدون توافق') }}</label>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>

<div class="fixed backdrop-blur-sm left-0 right-0 top-0 bottom-0 z-30 hidden js_blure_overlay" id="js_blure_overlay2" >
    <div class=" fixed bottom-0 left-0 right-0 h-0 z-30 bg-white rounded-t-25 shadow-[0px_-12px_23px_-7px_rgba(0,0,0,0.25)] px-[30px] duration-500 js_popup_dropdown" id="js_popup_dropdown_1" >
        <span class="w-10 mx-auto mt-3 rounded-full h-1 bg-gray-400 block js_close_popup_dropdown"></span>
        <div class="border-b-[1px] border-gray-200 mt-5 pb-5">
            <p class="text-center text-xl text-gray-500 font-light" id="js_popup_title_dropdown">{{ l('نوع سند') }}</p>
        </div>
        <div class="mt-7" id="js_body_popups_dropdown">
            <p class="text-center text-xl text-gray-500 font-light mb-6" id="js_popup_custom_dropdown"></p>
            <form action="">
                <ul class="space-y-4 overflow-auto lg:max-h-[200px] pt-2 text-right pr-3 h-[calc(100vh-320px)]" id="js_popup_body_dropdown">
                <li class="text-center">
                    <input value="20" type="checkbox" onclick="document1(20)" label_name=l("شش دانگ") class="document1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Documents_20">
                    <label class="" for="js_mobile_type_of_Documents_20">{{ l('شش دانگ') }}</label>
                </li>
                <li class="text-center">
                    <input value="21" type="checkbox" onclick="document1(21)" label_name=l("سرقفلی") class="document1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Documents_21">
                    <label class="" for="js_mobile_type_of_Documents_21">{{ l('سرقفلی') }}</label>
                </li>

                <li class="text-center">
                    <input value="22" type="checkbox" onclick="document1(22)" label_name=l("مشاع") class="document1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Documents_22">
                    <label class="" for="js_mobile_type_of_Documents_22">{{ l('مشاع') }}</label>
                </li>
                <li class="text-center">
                    <input value="23" type="checkbox" onclick="document1(23)" label_name=l("اوقافی") class="document1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Documents_23">
                    <label class="" for="js_mobile_type_of_Documents_23">{{ l('اوقافی') }}</label>
                </li>

                <li class="text-center">
                    <input value="24" type="checkbox" onclick="document1(24)" label_name=l("مسکن مهر") class="document1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Documents_24">
                    <label class="" for="js_mobile_type_of_Documents_24">{{ l('مسکن مهر') }}</label>
                </li>
                <li class="text-center">
                    <input value="25" type="checkbox" onclick="document1(25)" label_name=l("وکالتی") class="document1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Documents_25">
                    <label class="" for="js_mobile_type_of_Documents_25">{{ l('وکالتی') }}</label>
                </li>
                <li class="text-center">
                    <input value="26" type="checkbox" onclick="document1(26)" label_name=l("قولنامه ای") class="document1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Documents_26">
                    <label class="" for="js_mobile_type_of_Documents_26">{{ l('قولنامه ای') }}</label>
                </li>
                <li class="text-center">
                    <input value="27" type="checkbox" onclick="document1(27)" label_name=l("بنیادی") class="document1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Documents_27">
                    <label class="" for="js_mobile_type_of_Documents_27">{{ l('بنیادی') }}</label>
                </li>
                <li class="text-center">
                    <input value="28" type="checkbox" onclick="document1(28)" label_name=l("زمین شهری") class="document1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Documents_28">
                    <label class="" for="js_mobile_type_of_Documents_28">{{ l('زمین شهری') }}</label>
                </li>
                <li class="text-center">
                    <input value="29" type="checkbox" onclick="document1(29)" label_name=l("شورایی") class="document1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Documents_29">
                    <label class="" for="js_mobile_type_of_Documents_29">{{ l('شورایی') }}</label>
                </li>
                <li class="text-center">
                    <input value="30" type="checkbox" onclick="document1(30)" label_name=l("در دست اقدام") class="document1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Documents_30">
                    <label class="" for="js_mobile_type_of_Documents_30">{{ l('در دست اقدام') }}</label>
                </li>
                <li class="text-center">
                    <input value="284" type="checkbox" onclick="document1(284)" label_name=l("قراداد واگذاری") class="document1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_Documents_12">
                    <label class="" for="js_mobile_type_of_Documents_284">{{ l('قراداد واگذاری') }}</label>
                </li>
            </ul>
            <div style="height: 100px;width:100%" class="w-100"></div>
            </form>
        </div>

    </div>

</div>

<div class="fixed backdrop-blur-sm left-0 right-0 top-0 bottom-0 z-30 hidden js_blure_overlay" id="js_blure_overlay3" >
    <div class=" fixed bottom-0 left-0 right-0 h-0 z-30 bg-white rounded-t-25 shadow-[0px_-12px_23px_-7px_rgba(0,0,0,0.25)] px-[30px] duration-500 js_popup_dropdown" id="js_popup_dropdown_2" >
        <span class="w-10 mx-auto mt-3 rounded-full h-1 bg-gray-400 block js_close_popup_dropdown"></span>
        <div class="border-b-[1px] border-gray-200 mt-5 pb-5">
            <p class="text-center text-xl text-gray-500 font-light" id="js_popup_title_dropdown">{{ l('سال ساخت') }}</p>
        </div>
        <div class="mt-7" id="js_body_popups_dropdown">
            <p class="text-center text-xl text-gray-500 font-light mb-6" id="js_popup_custom_dropdown"></p>
            <form action="">
                <ul class="space-y-4 overflow-auto lg:max-h-[200px] pt-2 text-right pr-3 h-[calc(100vh-320px)]" id="js_popup_body_dropdown">

                    <?php for($i=1401;$i>=1360;$i--){?>
                        <li class="text-center">
                            <input type="checkbox" onclick="year(<?=$i;?>)"  value="<?=$i;?>" class="year text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_year_<?=$i;?>">
                            <label class="" for="js_mobile_type_of_year_<?=$i;?>"><?=$i ?></label>
                        </li>
                        <?php }?>
                        <li class="text-center">
                            <input type="checkbox" onclick="year(1359)" value="1359"  class="year text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_year_1359">
                            <label class="" for="js_mobile_type_of_year_1359">{{ l('کمتر از 1360') }}</label>
                        </li>
                </ul>
            </form>
        </div>
    </div>
</div>


<div class="fixed backdrop-blur-sm left-0 right-0 top-0 bottom-0 z-30 hidden js_blure_overlay" id="js_blure_overlay4" >
    <div class=" fixed bottom-0 left-0 right-0 h-0 z-30 bg-white rounded-t-25 shadow-[0px_-12px_23px_-7px_rgba(0,0,0,0.25)] px-[30px] duration-500 js_popup_dropdown" id="js_popup_dropdown_3" >
        <span class="w-10 mx-auto mt-3 rounded-full h-1 bg-gray-400 block js_close_popup_dropdown"></span>
        <div class="border-b-[1px] border-gray-200 mt-5 pb-5">
            <p class="text-center text-xl text-gray-500 font-light" id="js_popup_title_dropdown">{{ l('جغرافیا') }}</p>
        </div>
        <div class="mt-7" id="js_body_popups_dropdown">
            <p class="text-center text-xl text-gray-500 font-light mb-6" id="js_popup_custom_dropdown"></p>
            <form action="">
                <ul class="space-y-4 overflow-auto lg:max-h-[200px] pt-2 text-right pr-3 h-[calc(100vh-320px)]" id="js_popup_body_dropdown">

                    <li class="text-center">
                        <input  value="113" type="checkbox" onclick="geoghraphi(113)"  label_name=l("شمالی") class="geoghraphi text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_geo_113">
                        <label class="" for="js_mobile_type_of_geo_113">{{ l('شمالی') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="114" type="checkbox" onclick="geoghraphi(114)"  label_name=l("جنوبی") class="geoghraphi text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_geo_114">
                        <label class="" for="js_mobile_type_of_geo_114">{{ l('جنوبی') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="115" type="checkbox"  onclick="geoghraphi(115)"  label_name=l("شرقی") class="geoghraphi text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_geo_115">
                        <label class="" for="js_mobile_type_of_geo_115">{{ l('شرقی') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="116" type="checkbox" onclick="geoghraphi(116)"  label_name=l("غربی") class="geoghraphi text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_geo_116">
                        <label class="" for="js_mobile_type_of_geo_116">{{ l('غربی') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="117" type="checkbox" onclick="geoghraphi(117)"  label_name=l("دوبر") class="geoghraphi text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_geo_117">
                        <label class="" for="js_mobile_type_of_geo_117">{{ l('دوبر') }}</label>
                    </li>
                    <li class="text-center">
                        <input value="118" type="checkbox" onclick="geoghraphi(118)"  label_name=l("سه بر") class="geoghraphi text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_geo_118">
                        <label class="" for="js_mobile_type_of_geo_118">{{ l('سه بر') }}</label>
                    </li>
                    <li class="text-center">
                    <input value="119" type="checkbox" onclick="geoghraphi(119)"  label_name=l("چهاربر") class="geoghraphi text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_geo_119">
                    <label class="" for="js_mobile_type_of_geo_119">{{ l('چهاربر') }}</label>
                </li>
                <li class="text-center">
                    <input value="120" type="checkbox" onclick="geoghraphi(120)"  label_name=l("دوکله") class="geoghraphi text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_geo_120">
                    <label class="" for="js_mobile_type_of_geo_120">{{ l('دوکله') }}</label>
                </li>

                <li class="text-center">
                    <input value="274" type="checkbox" onclick="geoghraphi(274)"  label_name=l("یک بر") class="geoghraphi text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_geo_274">
                    <label class="" for="js_mobile_type_of_geo_274">{{ l('یک بر') }}</label>
                </li>

                <li class="text-center">
                    <input value="275" type="checkbox" onclick="geoghraphi(275)"  label_name=l("دو بر") class="geoghraphi text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_Document_" id="js_mobile_type_of_geo_275">
                    <label class="" for="js_mobile_type_of_geo_275">{{ l('دو بر') }}</label>
                </li>
            </ul>
            </form>
        </div>
    </div>
</div>
<div class="fixed backdrop-blur-sm left-0 right-0 top-0 bottom-0 z-30 hidden js_blure_overlay" id="js_blure_overlay5" >
    <div class=" fixed bottom-0 left-0 right-0 h-0 z-30 bg-white rounded-t-25 shadow-[0px_-12px_23px_-7px_rgba(0,0,0,0.25)] px-[30px] duration-500 js_popup_dropdown" id="js_popup_dropdown_5" >
        <span class="w-10 mx-auto mt-3 rounded-full h-1 bg-gray-400 block js_close_popup_dropdown"></span>
        <div class="border-b-[1px] border-gray-200 mt-5 pb-5">
            <p class="text-center text-xl text-gray-500 font-light" id="js_popup_title_dropdown">{{ l('شرایط') }}</p>
        </div>
        <div class="mt-7" id="js_body_popups_dropdown">
            <p class="text-center text-xl text-gray-500 font-light mb-6" id="js_popup_custom_dropdown"></p>
            <form action="">
                <ul class="space-y-4 overflow-auto lg:max-h-[200px] pt-2 text-right pr-3 h-[calc(100vh-320px)]" id="js_popup_body_dropdown">
                <li class="text-center">
                    <input value="15" type="checkbox" onclick="condition(15)" label_name=l("پیش فروش") class="condition1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_condition_" id="js_mobile_type_of_condition_15">
                    <label class="" for="js_mobile_type_of_condition_15">{{ l('پیش فروش') }}</label>
                </li>
                <li class="text-center">
                    <input value="16" type="checkbox" onclick="condition(16)" label_name=l("قابلیت معاوضه") class="condition1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_condition_" id="js_mobile_type_of_condition_16">
                    <label class="" for="js_mobile_type_of_condition_16">{{ l('قابلیت معاوضه') }}</label>
                </li>
                <li class="text-center">
                    <input value="17" type="checkbox" onclick="condition(17)" label_name=l("وام دار") class="condition1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_condition_" id="js_mobile_type_of_condition_17">
                    <label class="" for="js_mobile_type_of_condition1_17">{{ l('وام دار') }}</label>
                </li>

                <li class="text-center">
                    <input value="18" type="checkbox" onclick="condition(18)" label_name=l("مجتمع/برج") class="condition1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_condition_" id="js_mobile_type_of_condition_18">
                    <label class="" for="js_mobile_type_of_condition_18">{{ l('مجتمع/برج') }}</label>
                </li>
                <li class="text-center">
                    <input value="19" type="checkbox" onclick="condition(19)" label_name=l("قدرالسهمی") class="condition1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_condition_" id="js_mobile_type_of_condition_19">
                    <label class="" for="js_mobile_type_of_condition1_19">{{ l('قدرالسهمی') }}</label>
                </li>

                <li class="text-center">
                    <input value="302" type="checkbox" onclick="condition(302)" label_name=l("مناسب مطب و دفتر کار") class="condition1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_condition_" id="js_mobile_type_of_condition_302">
                    <label class="" for="js_mobile_type_of_condition_302">{{ l('مناسب مطب و دفتر کار') }}</label>
                </li>
                <li class="text-center">
                    <input value="303" type="checkbox" onclick="condition(303)" label_name=l("اتاق اداری") class="condition1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_condition_" id="js_mobile_type_of_condition_303">
                    <label class="" for="js_mobile_type_of_condition1_303">{{ l('اتاق اداری') }}</label>
                </li>
                <li class="text-center">
                    <input value="344" type="checkbox" onclick="condition(344)" label_name=l("بازسازی شده") class="condition1 text-lg lg:text-xl text-gray-500 font-light js_mobile_type_of_condition_" id="js_mobile_type_of_condition_344">
                    <label class="" for="js_mobile_type_of_condition1_344">{{ l('بازسازی شده') }}</label>
                </li>
            </ul>
            </form>
        </div>
    </div>
</div>



    <div class="hidden p-5 h-screen bg-[#f8f8f8] fixed top-0 right-0 left-0 w-full z-10 overflow-auto" id="js_mobile_filters_menu" style="display: block;">
        <div class="flex items-center justify-between">
            <p class="text-gray-500 text-lg lg:text-2xl font-light" id="js_mobile_close_filter">
                <span class="text-gray-400 relative top-2"><i class="fa-thin fa-arrow-right text-[32px]"></i></span>
                <span>{{ l('فیلترها') }}</span></p>
            <p class="text-gray-500 text-lg lg:text-xl font-light">{{ l('حذف فیلترها') }}</p>
        </div>

        <div>
            <div class="mt-6 pb-[14px] border-b-[1px] border-gray-200" id="js_mobile_popup_filter_Buy_And_Sell">
                <p class="text-gray-500 text-lg lg:text-[22px] font-light pb-4 js_accordion_btn">{{ l('نوع آگهی') }}</p>
                <div class="js_multiple_radio_selection_1">


                    <div class="lg:hidden lg:bg-[#F9F9F9] lg:rounded-[23px] lg:border-[1px] lg:border-gray-400 lg:p-[22px] lg:w-full lg:max-w-[397px]" id="js_Buy_And_Sell">
                        <div class="border-[1px] border-gray-400 rounded-25 h-[59px] flex items-center justify-between overflow-hidden px-[5px] js_inner">





                <div class="cursor-pointer h-[48px] w-full js_radio_selection">
                    <input class="hidden radios" type="radio" name="type" id="type15" value="1" text=l("خرید و فروش") onclick="typechange(1)" checked>
                    <label class="h-full flex items-center justify-center text-base text-gray-500 font-light rounded-25 cursor-pointer js_label-radio css_label-radio js_filter_action" for="type15">{{ l('خرید و فروش') }}</label>
                </div>
                <div class="cursor-pointer h-[48px] w-full js_radio_selection">
                    <input class="hidden radios" type="radio" name="type" id="type16" text=l("اجاره")  value="2" onclick="typechange(2)">
                    <label class="h-full flex items-center justify-center text-base text-gray-500 font-light rounded-25 cursor-pointer js_label-radio css_label-radio js_filter_action" for="type16">{{ l('اجاره') }}</label>
                </div>







        </div>
                    </div>



                </div>
            </div>
            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-between js_accordion_btn" id="js_mobile_open_Property_Type">{{ l('انتخاب نوع ملک') }}</h3>
                <div class="js_multiple_checkbox_selection_1">
                    <ul class="grid grid-cols-3 md:grid-cols-6 gap-3 pb-4 js_inner">
                        <li class="mt-2 text-black rounded-25 text-base font-light w-[78px] h-[78px]  js_Property_Type">
                            <input class="hidden css_checkbox js_filter_checkbox estatechange" value="0" checked type="checkbox" id="Property_Type_0" name="estateTypes[]" label_name=l("همه")  value="0">
                            <label class="flex items-center justify-center flex-col cursor-pointer w-full h-full border-[3px] border-gray-400 rounded-25 css_lable" for="Property_Type_0">
                                <span class=""><i class=""></i></span>
                                <p class="js_filter_action">{{ l('همه') }}</p>
                            </label>
                        </li>
                        <li class="mt-2 text-gray-500 rounded-25 text-base font-light w-[78px] h-[78px]  js_Property_Type">
                            <input class="hidden css_checkbox js_filter_checkbox estatechange" value="1" type="checkbox" id="Property_Type_1" name="estateTypes[]" label_name=l("آپارتمان") value="1" >
                            <label class="flex items-center justify-center flex-col cursor-pointer w-full h-full border-[3px] border-gray-400 rounded-25 css_lable" for="Property_Type_1">
                                <span class=""><i class=""></i></span>
                                <p class="js_filter_action">{{ l('آپارتمان') }}</p>
                            </label>
                        </li>
                        <li class="mt-2 text-gray-500 rounded-25 text-base font-light w-[78px] h-[78px] js_Property_Type">
                            <input class="hidden css_checkbox js_filter_checkbox estatechange" value="2"  type="checkbox" id="Property_Type_2" name="estateTypes[]" label_name=l("ویلایی") value="2"  >
                            <label class="flex items-center justify-center flex-col cursor-pointer w-full h-full border-[3px] border-gray-400 rounded-25 css_lable" for="Property_Type_2">
                                <span class=""><i class=""></i></span>
                                <p class="js_filter_action">{{ l('ویلایی') }}</p>
                            </label>
                        </li>
                        <li class="mt-2 text-gray-500 rounded-25 text-base font-light w-[78px] h-[78px]  js_Property_Type">
                            <input class="hidden css_checkbox js_filter_checkbox  estatechange" value="3" type="checkbox" id="Property_Type_3" name="estateTypes[]" label_name=l("مغازه") value="3" >
                            <label class="flex items-center justify-center flex-col cursor-pointer w-full h-full border-[3px] border-gray-400 rounded-25 css_lable" for="Property_Type_3">
                                <span class=""><i class=""></i></span>
                                <p class="js_filter_action">{{ l('مغازه') }}</p>
                            </label>
                        </li>
                        <li class="mt-2 text-gray-500 rounded-25 text-base font-light w-[78px] h-[78px]  js_Property_Type">
                            <input class="hidden css_checkbox js_filter_checkbox estatechange" value="4" type="checkbox" id="Property_Type_4" name="estateTypes[]" label_name=l("زمین و باغ") value="4" >
                            <label class="flex items-center justify-center flex-col cursor-pointer w-full h-full border-[3px] border-gray-400 rounded-25 css_lable" for="Property_Type_4">
                                <span class=""><i class=""></i></span>
                                <p class="js_filter_action">{{ l('زمین و باغ') }}</p>
                            </label>
                        </li>
                        <li class="mt-2 text-gray-500 rounded-25 text-base font-light w-[78px] h-[78px]  js_Property_Type">
                            <input class="hidden css_checkbox js_filter_checkbox estatechange" value="5" type="checkbox" name="estateTypes[]" id="Property_Type_5" label_name=l("تجاری") value="5" >
                            <label class="flex items-center justify-center flex-col cursor-pointer w-full h-full border-[3px] border-gray-400 rounded-25 css_lable" for="Property_Type_5">
                                <span class=""><i class=""></i></span>
                                <p class="js_filter_action">{{ l('صنعتی') }}</p>
                            </label>
                        </li>
        </ul>
                </div>
            </div>
            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-start js_accordion_btn">
                    <span class="text-lg lg:text-2xl ml-3 relative top-1"><i class="fa-thin fa-angle-down"></i></span>
                    <span>{{ l('قیمت') }}</span>
                </h3>
                <div class="hidden js_accordion_content pb-[18px]" id="another_filter_2">

                    <div class="js_multiple_radio_selection_1 z-50 rounded-25 lg:border-[1px] lg:border-gray-400 lg:bg-[#F9F9F9] lg:py-4 lg:px-5 lg:w-[397px] lg:h-[354px] hidden lg:overflow-hidden  js_min_max_content_2" style="display: block;">
                        <div class="flex items-start justify-between">
                            <div class=" bg-white rounded-25 border-[1px] border-gray-400 text-center px-[18px] ">
                                <button class="flex items-center justify-between w-full h-[59px] js_min_button js_min_Price js_button">
                                    <span class="text-gray-400 text-2xl"><i class="fa-thin fa-angle-down"></i></span>
                                    <input type="hidden" id="minPrice" name="minPrice" >
                                    <input type="text" id="minPrice1" placeholder="{{ l('حداقل قیمت') }}" name="minPrice1" class="text-gray-400 text-lg font-light w-full outline-0 text-center js_min_max_input" disabled>

                                </button>
                                <ul class="hidden text-right text-gray-500 font-light space-y-3 overflow-auto scroll-p-4 duration-300 h-0 !h-[260px] css_scroll js_min_query_2 miniprice">
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items  jsbutton" >{{ l('مقدار دلخواه') }}</button> </li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="300000000" onclick="js_price('min',300000000)">{{ l('300 میلیون') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="500000000" onclick="js_price('min',500000000)">{{ l('500 میلیون') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="750000000" onclick="js_price('min',750000000)">{{ l('750 میلیون') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="1000000000" onclick="js_price('min',1000000000)">{{ l('1 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="1500000000" onclick="js_price('min',1500000000)">{{ l('1.5 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="2000000000" onclick="js_price('min',2000000000)">{{ l('2 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="3000000000" onclick="js_price('min',3000000000)">{{ l('3 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="5000000000" onclick="js_price('min',5000000000)">{{ l('5 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="10000000000" onclick="js_price('min',10000000000)">{{ l('10 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="20000000000" onclick="js_price('min',20000000000)">{{ l('20 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="30000000000" onclick="js_price('min',30000000000)">{{ l('30 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="40000000000" onclick="js_price('min',40000000000)">{{ l('40 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action1" value="50000000000" onclick="js_price('min',50000000000)">{{ l('50 میلیارد') }}</button></li>
                            </ul>
                            </div>
                            <span class="h-[59px] flex items-center px-3 text-[22px] text-gray-500">{{ l('تا') }}</span>
                            <div class=" bg-white rounded-25 border-[1px] border-gray-400 text-center px-[18px] ">
                                <button class="flex items-center justify-between w-full h-[59px] js_max_button js_max_Price js_button">
                                    <span class="text-gray-400 text-2xl"><i class="fa-thin fa-angle-down"></i></span>
                                    <input type="text" name="maxPrice1" id="maxPrice1" placeholder="{{ l('حداکثر قیمت') }}" class="text-gray-400 text-lg font-light w-full outline-0 text-center js_min_max_input" disabled>
                                    <input type="hidden" name="maxPrice" id="maxPrice">

                                </button>

                                <ul class="maxiprice hidden text-right text-gray-500 font-light space-y-3 overflow-auto scroll-p-4 duration-300 h-0 !h-[260px] css_scroll  js_max_query_2">

                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items    jsbutton" >{{ l('مقدار دلخواه') }}</button> </li>
                                 <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action1" value="300000000" onclick="js_price('max',300000000)">{{ l('300 میلیون') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action1" value="500000000" onclick="js_price('max',500000000)">{{ l('500 میلیون') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action1" value="750000000" onclick="js_price('max',750000000)">{{ l('750 میلیون') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action1" value="1000000000" onclick="js_price('max',1000000000)">{{ l('1 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action1" value="1500000000" onclick="js_price('max',1500000000)">{{ l('1.5 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action1" value="2000000000" onclick="js_price('max',2000000000)">{{ l('2 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action1" value="3000000000" onclick="js_price('max',3000000000)">{{ l('3 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action1" value="5000000000" onclick="js_price('max',5000000000)">{{ l('5 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action1" value="10000000000" onclick="js_price('max',10000000000)">{{ l('10 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_maX js_filter_action1" value="20000000000" onclick="js_price('max',20000000000)">{{ l('20 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action1" value="30000000000" onclick="js_price('max',30000000000)">{{ l('30 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action1" value="40000000000" onclick="js_price('max',40000000000)">{{ l('40 میلیارد') }}</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action1" value="50000000000" onclick="js_price('max',50000000000)">{{ l('50 میلیارد') }}</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>




                </div>
            </div>




            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-start js_accordion_btn">
                    <span class="text-lg lg:text-2xl ml-3 relative top-1"><i class="fa-thin fa-angle-down"></i></span>
                    <span>{{ l('متراژ') }}</span>
                </h3>
                <div class="hidden js_accordion_content pb-[18px]" id="another_filter_3">
                    <div class="js_multiple_radio_selection_1 z-50 rounded-25  lg:border-[1px] lg:border-gray-400 lg:bg-[#F9F9F9] lg:py-4 lg:px-5 lg:w-[397px] lg:h-[354px] hidden  js_min_max_content_1" style="display: block;">
                        <div class="flex items-start justify-between">
                            <div class="w-1/2 bg-white rounded-25 border-[1px] border-gray-400 text-center px-[18px] ">
                                <button class="flex items-center justify-between w-full h-[59px] js_min_button js_button">
                                    <span class="text-gray-400 text-2xl"><i class="fa-thin fa-angle-down"></i></span>
                                    <input type="text" id="minArea" name="minArea" placeholder="{{ l('حداقل') }}" class="text-gray-400 text-lg font-light w-full outline-0 text-center js_min_max_input" disabled>

                                </button>
                                <ul class="hidden  text-right text-gray-500 font-light space-y-3 overflow-auto scroll-p-4 duration-300 h-0 !h-[260px] css_scroll js_min_query_1 miniarea">
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items    jsbutton" >{{ l('مقدار دلخواه') }}</button> </li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min " onclick="js_area('min',65)">65</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action" onclick="js_area('min',80)">80</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action" onclick="js_area('min',90)">90</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action" onclick="js_area('min',100)">100</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action" onclick="js_area('min',120)">120</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action" onclick="js_area('min',150)">150</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action" onclick="js_area('min',200)">200</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action" onclick="js_area('min',250)">250</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action" onclick="js_area('min',350)">350</button></li>
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action" onclick="js_area('min',650)">650</button></li>

                            </ul>
                            </div>
                            <span class="h-[59px] flex items-center px-3 text-[22px] text-gray-500">{{ l('تا') }}</span>
                            <div class="w-1/2 bg-white rounded-25 border-[1px] border-gray-400 text-center px-[18px]">
                                <button class="flex items-center justify-between w-full h-[59px] js_max_button js_button">
                                    <span class="text-gray-400 text-2xl"><i class="fa-thin fa-angle-down"></i></span>
                                    <input type="text" name="maxArea" id="maxArea" placeholder="{{ l('حداکثر') }}" class="text-gray-400 text-lg font-light w-full outline-0 text-center js_min_max_input" disabled>

                                </button>
                                <ul class="hidden text-right text-gray-500 font-light space-y-3 overflow-auto scroll-p-4 duration-300 h-0  !h-[260px]  css_scroll js_max_query_1 maxiarea">
                                    <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items    jsbutton" >{{ l('مقدار دلخواه') }}</button> </li>
                                <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action" onclick="js_area('max',65)">65</button></li>
                                <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action" onclick="js_area('max',80)">75</button></li>
                                <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action" onclick="js_area('max',90)">90</button></li>
                                <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action" onclick="js_area('max',100)">100</button></li>
                                <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action" onclick="js_area('max',120)">120</button></li>
                                <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action" onclick="js_area('max',150)">150</button></li>
                                <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action" onclick="js_area('max',200)">200</button></li>
                                <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action" onclick="js_area('max',250)">250</button></li>
                                <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action" onclick="js_area('max',350)">350</button></li>
                                <li><button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action" onclick="js_area('max',650)">650</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-start js_accordion_btn">
                    <span class="text-lg lg:text-2xl ml-3 relative top-1"><i class="fa-thin fa-angle-down"></i></span>
                    <span>{{ l('متراژ') }}</span>
                </h3>
                <div class="hidden js_accordion_content pb-[18px]" id="another_filter_3">

                    <div class="rounded-25 js_min_max_content_1">
                        <div class="flex items-start justify-between">
                            <div class="w-1/2 bg-white rounded-25 border-[1px] border-gray-400 text-center px-[18px]">
                                <button class="flex items-center justify-between w-full h-[59px] js_min_button">
                                    <span class="text-gray-400 text-2xl"><i class="fa-thin fa-angle-down"></i></span>
                                    <input type="number" class="text-gray-400 text-lg font-light w-full outline-0 text-center js_min_max_input">
                                    <span class="text-gray-400 text-lg font-light w-full outline-0">{{ l('متراژ') }}</span>
                                </button>
                                <ul class="text-right text-gray-500 font-light space-y-3 overflow-auto scroll-p-4 duration-300 h-0 !h-[260px] css_scroll js_min_query_1">
                                                        <li>
                                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action">65</button>
                                                        </li>

                                                        <li>
                                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action">80</button>
                                                        </li>

                                                        <li>
                                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action">90</button>
                                                        </li>

                                                        <li>
                                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action">100</button>
                                                        </li>

                                                        <li>
                                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action">120</button>
                                                        </li>

                                                        <li>
                                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action">150</button>
                                                        </li>

                                                        <li>
                                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action">200</button>
                                                        </li>

                                                        <li>
                                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action">250</button>
                                                        </li>
                                                        <li>
                                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action">350</button>
                                                        </li>
                                                        <li>
                                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action">650</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            <span class="h-[59px] flex items-center px-3 text-[22px] text-gray-500">{{ l('تا') }}</span>
                                            <div class="w-1/2 bg-white rounded-25 border-[1px] border-gray-400 text-center px-[18px]">
                                                <button class="flex items-center justify-between w-full h-[59px] js_max_button">
                                                    <span class="text-gray-400 text-2xl"><i class="fa-thin fa-angle-down"></i></span>
                                                    <input type="number" class="text-gray-400 text-lg font-light w-full outline-0 text-center js_min_max_input">
                                                    <span class="text-gray-400 text-lg font-light w-full outline-0">{{ l('متراژ') }}</span>
                                                </button>
                                                <ul class="text-right text-gray-500 font-light space-y-3 overflow-auto scroll-p-4 duration-300 h-0 css_scroll js_max_query_1">


                                        <li>
                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action">65</button>
                                        </li>

                                        <li>
                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action">75</button>
                                        </li>

                                        <li>
                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action">90</button>
                                        </li>

                                        <li>
                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action">100</button>
                                        </li>

                                        <li>
                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action">120</button>
                                        </li>

                                        <li>
                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action">150</button>
                                        </li>

                                        <li>
                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action">200</button>
                                        </li>

                                        <li>
                                            <button class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_max js_filter_action">500</button>
                                        </li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-start" id="js_mobile_Select_location_btn">
                    <span>{{ l('محلات') }}</span>
                </h3>
            </div>
            <div class="hidden border-b-[1px] border-gray-200" id="converti" >
                <div class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-between" id="js_mobile_Select_location_btn">
                    <p>{{ l('قابلیت تبدیل') }}</p>
                    <label class="inline-flex relative items-center cursor-pointer">
                        <input type="checkbox" value="1" name="convertible" class="sr-only peer" id="convertible">
                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-between js_accordion_btn">
                    <div class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center  justify-start">
                        <span class="text-lg lg:text-2xl ml-3 relative top-1"><i class="fa-thin fa-angle-down"></i></span>
                        <span>{{ l('تعداد طبقات') }}</span>
                    </div>
                    <div>
                        <span id="floorcount1"></span>
                    </div>


                </h3>
                <div class="hidden js_accordion_content pb-[18px]">
                    <div dir="ltr" class="px-[5px] border-[1px] border-gray-400 rounded-25 h-12 flex items-center justify-between overflow-hidden">
                        <input class="hidden radios" value="155" type="radio" name="Number_of_floors" id="floors_155">
                    <label
                        class="h-[38px] w-1/5 flex items-center justify-center text-lg lg:text-xl text-gray-500 font-light rounded-2xl cursor-pointer css_label-radio"
                        for="floors_155">1</label>
                    <input class="hidden radios" value="156" type="radio" name="Number_of_floors" id="floors_156">
                    <label
                        class="h-[38px] w-1/5 flex items-center justify-center text-lg lg:text-xl text-gray-500 font-light rounded-2xl cursor-pointer css_label-radio"
                        for="floors_156">2</label>
                    <input class="hidden radios" value="157" type="radio" name="Number_of_floors" id="floors_157">
                    <label
                        class="h-[38px] w-1/5 flex items-center justify-center text-lg lg:text-xl text-gray-500 font-light rounded-2xl cursor-pointer css_label-radio"
                        for="floors_157">3</label>
                    <input class="hidden radios" value="158" type="radio" name="Number_of_floors" id="floors_158">
                    <label
                        class="h-[38px] w-1/5 flex items-center justify-center text-lg lg:text-xl text-gray-500 font-light rounded-2xl cursor-pointer css_label-radio"
                        for="floors_158">4</label>
                    <input class="hidden radios" value="159" type="radio" name="Number_of_floors" id="floors_159" >
                    <label
                        class="h-[38px] w-1/5 flex items-center justify-center text-lg lg:text-xl text-gray-500 font-light rounded-2xl cursor-pointer css_label-radio"
                        for="floors_159">+5</label>
                    </div>
                </div>
            </div>

            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center  justify-between js_accordion_btn">
                    <div class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center  justify-start">
                    <span class="text-lg lg:text-2xl ml-3 relative top-1"><i class="fa-thin fa-angle-down"></i></span>
                    <span>{{ l('تعداد اتاق') }}</span>
                    </div>
                    <div>
                    <span id="roomcount1"></span>
                    </div>
                </h3>

                <div class="hidden js_accordion_content pb-[18px]">
                    <div dir="ltr" class="px-[5px] border-[1px] border-gray-400 rounded-25 h-12 flex items-center justify-between overflow-hidden">
                        <input class="hidden radios" type="radio" value="187" name="asas" id="room_187">
                        <label class="h-[38px] w-1/5 h-full flex items-center justify-center text-lg lg:text-xl text-gray-500 font-light rounded-2xl cursor-pointer css_label-radio"
                            for="room_187">1</label>
                        <input class="hidden radios" type="radio" value="188" name="asas" id="room_188">
                        <label
                            class="h-[38px] w-1/5 h-full flex items-center justify-center text-lg lg:text-xl text-gray-500 font-light rounded-2xl cursor-pointer css_label-radio"
                            for="room_188">2</label>
                        <input class="hidden radios" type="radio" value="189" name="asas" id="room_189">
                        <label
                            class="h-[38px] w-1/5 h-full flex items-center justify-center text-lg lg:text-xl text-gray-500 font-light rounded-2xl cursor-pointer css_label-radio"
                            for="room_189">3</label>
                        <input class="hidden radios" type="radio" value="190" name="asas" id="room_190">
                        <label
                            class="h-[38px] w-1/5 h-full flex items-center justify-center text-lg lg:text-xl text-gray-500 font-light rounded-2xl cursor-pointer css_label-radio"
                            for="room_190">4</label>
                        <input class="hidden radios" type="radio" value="191" name="asas" id="room_191">
                        <label
                            class="h-[38px] w-1/5 h-full flex items-center justify-center text-lg lg:text-xl text-gray-500 font-light rounded-2xl cursor-pointer css_label-radio"
                            for="room_191">+5</label>
                    </div>
                </div>
            </div>
            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-between" id="js_mobile_type_of_Document">
                    <span>{{ l('نوع سند') }}</span>
                    <span id="mobile_type_of_Documentcounter"></span>
                    <input type="hidden" name="mobile_type_of_Document" id="mobile_type_of_Document" value="">
                </h3>
            </div>
            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-between" id="js_mobile_type_of_codition">
                    <span>{{ l('شرایط') }}</span>
                    <span id="mobile_condition_constructioncounter"></span>
                    <input type="hidden" name="mobile_type_of_codition" id="mobile_type_of_codition" value="">
                </h3>
            </div>
            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-between" id="js_mobile_Account_Type">
                    <span>{{ l('نوع کاربری') }}</span>
                    <span id="mobile_Account_Typecounter"></span>
                    <input type="hidden" name="mobile_Account_Type" id="mobile_Account_Type" value="">
                </h3>
            </div>
            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-between" id="js_mobile_Year_construction">
                    <span>{{ l('سال ساخت') }}</span>
                    <span id="mobile_Year_constructioncounter"></span>
                    <input type="hidden" name="mobile_Year_construction" id="mobile_Year_construction" value="">
                </h3>
            </div>
            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-between" id="js_mobile_geographical_direction">
                    <span>{{ l('جهت جغرافیایی') }}</span>
                    <span id="mobile_geographical_directioncounter"></span>
                    <input type="hidden" name="mobile_geographical_direction" id="mobile_geographical_direction">
                </h3>
            </div>

            <div class="border-b-[1px] border-gray-200">
                <div class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-between" id="js_mobile_Photographer">
                    <p>{{ l('عکس دار') }}</p>
                    <label class="inline-flex relative items-center cursor-pointer">
                        <input type="checkbox" value="1" name="hasPhoto" class="sr-only peer" id="hasPhoto">
                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

            </div>
           <div class="border-b-[1px] border-gray-200">
                <div class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-between" id="js_mobile_Advertiser">
                    <span>{{ l('آگهی دهنده(کارشناس)') }}</span>
                    <label class="inline-flex relative items-center cursor-pointer">
                        <input type="checkbox" value="1" name="hasAgent" class="sr-only peer" id="hasAgent">
                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
            <div class="border-b-[1px] border-gray-200">
                <h3 class="text-gray-500 text-lg lg:text-[22px] font-light h-[75px] flex items-center justify-start js_accordion_btn">
                    <span class="text-lg lg:text-2xl ml-3 relative top-1"><i class="fa-thin fa-angle-down"></i></span>
                    <span>{{ l('بر اساس امکانات') }}</span>
                </h3>
                <div id="another_filter_1" style="display:none">
                    <input type="checkbox" name="facilities_35" id="facilities_35" onclick="facalties(35)" value="35" class="bg-gray-200 hover:bg-gray-300 cursor-pointer
    w-4 h-4 border-3 border-amber-500 focus:outline-none rounded-lg facalties" />
                    <label for="facilities_35" class="ml-3 mb-1">{{ l('پارکینگ') }}</label>

                    <input type="checkbox" name="facilities_36" id="facilities_36" value="36" onclick="facalties(36)" class="bg-gray-200 hover:bg-gray-300 cursor-pointer
                    w-4 h-4 border-3 border-amber-500 focus:outline-none rounded-lg facalties" />
                    <label for="facilities_36" class="ml-3 mb-1">{{ l('انباری') }}</label>

                    <input type="checkbox" name="facilities_37" id="facilities_37" value="37" onclick="facalties(37)" class="bg-gray-200 hover:bg-gray-300 cursor-pointer
                    w-4 h-4 border-3 border-amber-500 focus:outline-none rounded-lg facalties" />
                    <label for="facilities_37" class="ml-3 mb-1">{{ l('آسانسور') }}</label>
                </div>
            </div>
            <div class="mt-4">
                <button class="flex items-center justify-center bg-blue-500 rounded-25 px-4 w-full h-[60px] relative js_mobile_close_filter">
                    <span class="text-base text-white font-light absolute right-4"></span>
                    <span class="text-lg lg:text-2xl font-medium text-white ">{{ l('اعمال فیلتر') }}</span>
                </button>
            </div>
        </div>
        <!-- ------------filter---------------- -->
        <div class="hidden fixed top-0 right-0 w-full h-screen z-30 bg-[#f9f9f9] p-5" id="js_mobile_Select_location">
            <p class="text-gray-500 text-lg lg:text-2xl font-light" id="js_mobile_close_Select_location">
                <span class="text-gray-400 relative top-1"><i class="fa-thin fa-arrow-right text-[32px]"></i></span>
                <span>{{ l('فیلترها') }}</span>
            </p>
            <div class="w-full m-auto js_popup_Location_0">
                <!--<div class="flex justify-between items-center h-[68px]">
                    <div class="hidden lg:block"><i class="fa-thin fa-angle-up text-4xl text-gray-500"></i></div>
                    <div class="overflow-x-auto mx-4 w-full">
                        <ul class="flex items-center justify-start space-x-4 pb-3 js_filter_by_search_tag">

                        </ul>
                    </div>
                    <div class="hidden lg:block text-[20px] text-gray-400 w-[45px]">
                        <span class="js_tag_counter">0</span><span class="pr-1"><i class="fa-thin fa-plus"></i></span>
                    </div>
                </div>-->
                <div class="rounded-25 border-[1px] border-gray-400 flex justify-between items-center px-4 h-[60px] bg-white overflow-hidden mt-4">
                    <input class="h-full w-full outline-0 ml-4 text-gray-400 font-light js_filter_by_search_search" type="search">
                    <span class="text-4xl mt-2 text-gray-400"><i class="fa-thin fa-magnifying-glass"></i></span>
                </div>
                <div class="mt-4">
                    <ul dir="ltr" class="space-y-4 overflow-auto  pt-2 text-right pr-3 h-[calc(100vh-320px)] js_filter_by_search_list">

                    </ul>
                </div>
                <div class="mt-5 absolute left-5 right-5 bottom-5">
                    <button class="flex items-center justify-center bg-blue-500 rounded-25 px-4 w-full h-[60px] relative js_mobile_close_filter1">
                        <p class="text-base text-white font-light absolute right-4"><span class="js_Neighbourhood_count">0</span>{{ l('محله') }}</p>
                        <span class="text-2xl font-medium text-white ">{{ l('اعمال فیلتر') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>


$(document).ready(function(){

    var sidcheck=0;



$("input[name='asas']").click(function(){
    $("#js_asas").remove();
    if(sidcheck!=$(this).val()){
        sidcheck=$("input[name='asas']:checked").val();

            $("#js_filter_result").append('<button id="js_asas" name_id="room_count" attr_id="'+$(this).val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>حداکثر اتاق '+room($("input[name='asas']:checked").val())+'</span><span class="text-red-200 pr-3" onclick="remove1(\'js_asas\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
            checkSend();
        }
    else
    {
        sidcheck=0;
        $(this).prop('checked', false);
        checkSend();
    }
});

var nidcheck=0;
$("input[name='Number_of_floors']").click(function(){
    $("#js_numberfloors").remove();
    if(nidcheck!=$(this).val()){
   //     alert($(this).val());
        $("#js_filter_result").append('<button id="js_numberfloors" name_id="floor" attr_id="'+$(this).val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>حداکثر طبقه '+floor($("input[name='Number_of_floors']:checked").val())+'</span><span class="text-red-200 pr-3" onclick="remove1(\'js_numberfloors\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
        nidcheck=$("input[name='Number_of_floors']:checked").val();
        checkSend();
    }
    else
    {
        nidcheck=0;
        $(this).prop('checked', false);
        checkSend();
    }
});


    $("input[name='convertible']").click(function(){
        $("#js_convertible").remove();
        if($("#convertible").prop("checked")== true){
            $("#js_filter_result").append('<button id="js_convertible"  name_id="convertible" attr_id="1" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>{{ l('قابلیت تبدیل') }}</span><span class="text-red-200 pr-3" onclick="remove1(\'js_convertible\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
        }
        checkSend();
    });
    $("input[name='hasPhoto']").click(function(){
        $("#js_hasPhoto").remove();
        if($("#hasPhoto").prop("checked")== true){
            $("#js_filter_result").append('<button id="js_hasPhoto"  name_id="hasPhoto" attr_id="1" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>{{ l('دارای عکس') }}</span><span class="text-red-200 pr-3" onclick="remove1(\'js_hasPhoto\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');

        }
        checkSend();
    });

    $("input[name='hasAgent']").click(function(){
        $("#js_hasAgent").remove();
        if($("#hasAgent").prop("checked")== true){
            $("#js_filter_result").append('<button id="js_hasAgent"  name_id="hasAgent" attr_id="1" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>{{ l('دارای کارشناس') }}</span><span class="text-red-200 pr-3" onclick="remove1(\'js_hasAgent\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
        }
        checkSend();
    });



    $(".js_filter_by_search_search").keyup(function(){
            var array1 = [];
            var arrayid1 = [];
            var value = $(this).val().toLowerCase();


            for (let i = 0; i < array.length; i++)
            {

                if(array[i].indexOf(value)>-1)
                {
                    //alert($(this).text().toLowerCase());
                    array1.push(array[i]);
                    arrayid1.push(arrayid[i]);
                }
            }
            new filter_by_search1(array1, arrayid1, 'districts[]', selectedDistricts, 1,'search');


        });

    $(".js_mobile_close_filter1").on('click',function () {

        $("#js_mobile_Select_location").slideUp('slow');
    $("#js_mobile_filters_menu").css('overflow','auto');
        //$("#js_overlay").fadeOut("500");
    });
    $(".js_mobile_close_filter").on('click',function () {
        $("#js_mobile_filters_menu").hide("fast");
        //$("#js_overlay").fadeOut("500");
    });
    $("#js_mobile_close_filter").on('click',function () {
        $("#js_mobile_filters_menu").hide("fast");
        //$("#js_overlay").fadeOut("500");
    });

});

function remove1(id)
{
       // alert(id);
        $("#"+id).remove();
        var countrr=0;
        $(".searchappend").each(function(index) {
            countrr++;
        });
        if(countrr==0){
            $(".removeall").addClass('hidden');
        }
        checkSend();
}

function room(id){
        var str="";
        switch(id){
            case "187":str="1";break;
            case "188":str="2";break;
            case "189":str="3";break;
            case "190":str="4";break;
            case "191":str="5";break;
        }

        return str;
    }

    function floor(id){
        var str="";
        switch(id){
            case "155":str="1";break;
            case "156":str="2";break;
            case "157":str="3";break;
            case "158":str="4";break;
            case "159":str="5";break;
        }

        return str;
    }
function typechange(id){
    if($("input[name='type']:checked").val()==2)
    $("#converti").removeClass('hidden');
    else
    $("#converti").addClass('hidden');
    $(".type_buy").html($("input[name='type']:checked").attr('text'));

    // $("#js_filter_result").html('');
    if($("#js_type").html()!=null){
        $("#js_type").remove();
    }
    $("#js_filter_result").append('<button id="js_type" name_id="type" attr_id="'+$("input[name='type']:checked").val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+$("input[name='type']:checked").attr('text')+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_type\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
    checkSend();
}
/*
function floor(id){
    $("#js_numberfloors").remove();
    $("#js_filter_result").append('<button id="js_numberfloors" name_id="floor" attr_id="'+id+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>{{ l('طبقه \'+id+\'') }}</span><span class="text-red-200 pr-3" onclick="remove1(\'js_numberfloors\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');

    checkSend();
}*/
/*
function checkSend(id){

    $(".searchappend" ).each(function( index ) {

        switch($(this).attr('name_id')){
            case 'document_type':document_type+=$(this).attr('attr_id')+",";break;
            case 'built_year':built_year+=$(this).attr('attr_id')+",";break;
            case 'geography':geography+=$(this).attr('attr_id')+",";break;
            case 'usage_type':usage_type+=$(this).attr('attr_id')+",";break;
            case 'floor':floor+=$(this).attr('attr_id')+",";break;
            case 'room_count':room_count+=$(this).attr('attr_id')+",";break;
            case 'convertible':convertible+=$(this).attr('attr_id')+",";break;
            case 'type':type+=$(this).attr('attr_id')+",";break;
            case 'estateTypes':estateTypes+=$(this).attr('attr_id')+",";break;
            case 'minArea':minArea+=$(this).attr('attr_id')+",";break;
            case 'maxArea':maxArea+=$(this).attr('attr_id')+",";break;
            case 'price':price+=$(this).attr('attr_id')+",";break;
            case 'districts':districts+=$(this).attr('attr_id')+",";break;
        }


});

}*/

/*
    function loadMoreData_v2(page,type)
    {
        if(page==1)
        {
            $("#estate-wrapper").empty();
        }
        $.ajax({
            url: `?page=${page}&&${type}`,
            type: "get",
            beforeSend: function () {
                $("#spiner" ).removeClass( "d-none" );
            }
        }).done(function (data) {
            if(data.totalCount < 9)
                hasPage=false;
            else
                hasPage = data.hasPage;
            $( "#spiner" ).addClass( "d-none" );

            if (data.length == 0) {
                return;
            }
            //$(".btnmore1").addClass('d-none').removeClass('d-block');
            var htmlpage=data.html;

            $("#estate-wrapper").html(htmlpage);

            var result = Paging(pagin ,9,data.totalCount, "myClass", "myDisableClass");

            $("#pagination").html(result);

            if(data.totalCount==0){
                $(".js_stateCount2").addClass("d-none").removeClass("d-block");
                $(".js_stateCount1").addClass("d-block").removeClass("d-none");
                //$(".js_stateCount1").html(data.totalCount);
            }
            else
            {
                $(".js_stateCount2").addClass("d-block").removeClass("d-none");
                $(".js_stateCount1").addClass("d-none").removeClass("d-block");
                $(".js_stateCount").html(data.totalCount);
            }
            pageflag=true;
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            $( "#spiner" ).addClass( "d-none" );
            //alert(l('مشکلی در دریافت اطلاعات بوجود آمده است...'));

        });
    };
    */
    $(document).ready(function(){


        $('.estatechange').click(function(){
            var id=$(this).val();

    $(".js_est").remove();


    if(id==0){

        var counte=0;
        $(".estatechange:checked").each(function() {
            counte += 1;
        });

            $("#Property_Type_1").prop("checked",false);
            $("#Property_Type_2").prop("checked",false);
            $("#Property_Type_3").prop("checked",false);
            $("#Property_Type_4").prop("checked",false);
            $("#Property_Type_5").prop("checked",false);
            $("#js_estate_1").remove();
            $("#js_estate_2").remove();
            $("#js_estate_3").remove();
            $("#js_estate_4").remove();
            $("#js_estate_5").remove();

            $("#Property_Type_0").prop("checked",true);

        }
    else
    {

        var list = '';
        var count = 0;
        const estatechange_array = [];

        $(".estatechange:checked").each(function() {
            if ($(this).val() != 0) {
                count += 1;
                $("#js_filter_result").append('<button  name_id="estateTypes" id="js_estate_' + $(this).val() + '"  attr_id="' + $(this).val() + '" class="searchappend js_est border border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>' + $(this).attr('label_name') + '</span><span class="text-red-200 pr-3" onclick="remove1(\'js_estate_' + $(this).val() + '\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
            }

        });
        if (count == 5)
        {
            //list = l('همه');
            $("#Property_Type_1").prop("checked",false);
            $("#Property_Type_2").prop("checked",false);
            $("#Property_Type_3").prop("checked",false);
            $("#Property_Type_4").prop("checked",false);
            $("#Property_Type_5").prop("checked",false);
            $("#js_estate_1").remove();
            $("#js_estate_2").remove();
            $("#js_estate_3").remove();
            $("#js_estate_4").remove();
            $("#js_estate_5").remove();

           // alert(count);
            $("#Property_Type_0").prop("checked",true);

        }
        else if(count>0 && count<5 ){
            $("#Property_Type_0").prop("checked",false);
        }
        else if(count==0)
            $("#Property_Type_0").prop("checked",true);

    //$(".estatetype1").html(list);

    }
    checkSend();

  //  $(".s_accordion_btn").trigger('click');
});
    });
/*
function estatechange(id){
        $(".js_est").remove();


        if(id==0){
            var counte=0;
            $(".estatechange:checked").each(function() {
                counte += 1;
            });
            if(counte==0){
                $("#Property_Type_0").prop("checked",true);
            }
                $("#Property_Type_1").prop("checked",false);
                $("#Property_Type_2").prop("checked",false);
                $("#Property_Type_3").prop("checked",false);
                $("#Property_Type_4").prop("checked",false);
                $("#Property_Type_5").prop("checked",false);
                $("#js_estate_1").remove();
                $("#js_estate_2").remove();
                $("#js_estate_3").remove();
                $("#js_estate_4").remove();
                $("#js_estate_5").remove();
            }
        else
        {
            var list = '';
            var count = 0;
            const estatechange_array = [];

            $(".estatechange:checked").each(function() {
                if ($(this).val() != 0) {
                    count += 1;
                }

            });
            if (count == 5)
            {
                //list = l('همه');
                $("#Property_Type_1").prop("checked",false);
                $("#Property_Type_2").prop("checked",false);
                $("#Property_Type_3").prop("checked",false);
                $("#Property_Type_4").prop("checked",false);
                $("#Property_Type_5").prop("checked",false);
                $("#Property_Type_"+id).prop("checked",false);
                alert(id);
                $("#js_estate_1").remove();
                $("#js_estate_1").remove();
                $("#js_estate_2").remove();
                $("#js_estate_3").remove();
                $("#js_estate_4").remove();
                $("#js_estate_5").remove();
                $("#Property_Type_0").prop("checked",true);
               // estatechange_array[0] = l('همه');
                //$("#js_filter_result").append('<button name_id="estateTypes" id="js_estate_0" attr_id="0" class="searchappend js_est border border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>{{ l('همه') }}</span><span class="text-red-200 pr-3" onclick="remove1(\'js_estate_0\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
            }
            else if(count>0 && count<5 ){
                $("#Property_Type_0").prop("checked",false);
            }
            else if(count==0)
                $("#Property_Type_0").prop("checked",true);
        checkSend();
        $(".estatetype1").html(list);
    }
}
*/
    function usage_type(id){
        /*$(".js_usagetype").remove();
        var list='';

        $(".usage_type:checked").each(function(){
            if($(this).val()!=-1){
                count+=1;

                list+=$(this).attr('label_name')+',';
                //estatechange_array[$(this).val()]=$(this).attr('label_name');
                $("#js_filter_result").append('<button  name_id="usage_type" id="js_usage_type_'+$(this).val()+'"  attr_id="'+$(this).val()+'" class="searchappend js_usagetype border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+$(this).attr('label_name')+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_usage_type_'+$(this).val()+'\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');

            }

        });*/
    }
    function document1(id){
       // alert(id);
    }
    function year(id){
        //alert(id);
        $(".js_year").remove();
        var list='';

        $(".year:checked").each(function(){
                $("#js_filter_result").append('<button  name_id="built_year" id="js_year_'+$(this).val()+'"  attr_id="'+$(this).val()+'" class="searchappend js_year border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+$(this).val()+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_year_'+$(this).val()+'\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
        });
        checkSend();

    }
    function condition(id){
        //alert(id);
        $(".js_condition").remove();
        var list='';

        $(".condition:checked").each(function(){
                $("#js_filter_result").append('<button  name_id="condition" id="js_condition_'+$(this).val()+'"  attr_id="'+$(this).val()+'" class="searchappend js_condition border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+$(this).val()+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_condition_'+$(this).val()+'\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
        });
        checkSend();

    }
    function check(id){
    var value="";
    switch(id){
        case '35':value='{{ l('پارکینگ') }}';break;
        case '36':value='{{ l('انباری') }}';break;
        case '37':value='{{ l('آسانسور') }}';break;
    }
    return value;
}
    function facalties(id){
        $(".js_facalties").remove();
        $(".facalties:checked").each(function(){
                $("#js_filter_result").append('<button  name_id="facalties" id="js_facalties_'+$(this).val()+'"  attr_id="'+$(this).val()+'" class="searchappend js_facalties border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+check($(this).val())+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_facalties_'+$(this).val()+'\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
        });
        checkSend();

    }


    function geoghraphi(id){
        $(".js_geoghraphi").remove();
        var list='';

        $(".geoghraphi:checked").each(function(){

                //estatechange_array[$(this).val()]=$(this).attr('label_name');
                $("#js_filter_result").append('<button  name_id="geography" id="js_geoghraphi_'+$(this).val()+'"  attr_id="'+$(this).val()+'" class="searchappend js_geoghraphi border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+$(this).attr('label_name')+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_geoghraphi_'+$(this).val()+'\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');



        });

    }
    var countdis=0;
    function typelocal(id,str){

        if($("#js_local_"+id).html()!=null){
            $("#js_local_"+id).remove();
       }

       if($("#districts_" + id).prop("checked")== true){
        $(".js_Neighbourhood_count").html(parseInt($(".js_Neighbourhood_count").html())+1);
            $("#js_filter_result").append('<button id="js_local_'+id+'" name_id="districts" attr_id="'+id+'" class="local searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+str+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_local_'+id+'\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
       }
        else{
            $(".js_Neighbourhood_count").html(parseInt($(".js_Neighbourhood_count").html())-1);
            $("#js_local_"+id).remove();
        }
        checkSend();
    }

    //function room(id){
      //  $("#js_asas").remove();
        //alert($("input[name='asas']:checked").val());
        //if($("input[name='asas']:checked").val()>0)
        //    $("#js_filter_result").append('<button id="js_asas" name_id="room_count" attr_id="'+id+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>{{ l('اتاق \'+id+\'') }}</span><span class="text-red-200 pr-3" onclick="remove1(\'js_asas\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');

       // $("#js_filter_result").append('<button id="js_local_'+id+'" name_id="districts" attr_id="'+id+'" class="local searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+str+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_local_'+id+'\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
        //checkSend();

    //}
    /*
    function floor(id){

        $("#js_numberfloors").remove();
        $("#js_filter_result").append('<button id="js_numberfloors" name_id="floor" attr_id="'+id+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>{{ l('طبقه \'+id+\'') }}</span><span class="text-red-200 pr-3" onclick="remove1(\'js_numberfloors\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>'); checkSend(); }*/ function js_area(minmax,id){ //alert('sadsad'); //$('.js_max_query_1').addClass('!h-[260px]'); $("#"+minmax+"Area").val(id); // min_query(id,1); //max_query(id,1); //$(".metrajtype1").text($("#minArea").val()+" تا "+$("#maxArea").val()+" متر"); if(minmax=="min"){ if($("#js_minarea").html()!=null){ $("#js_minarea").remove(); } $("#js_filter_result").append('<button name_id="minArea" id="js_minarea" attr_id="'+$("#minArea").val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>از '+$("#minArea").val()+' متر</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_minarea\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
            $(".miniarea").addClass('hidden');
        }
        if(minmax=="max"){
            if($("#js_maxarea").html()!=null)
            {
                $("#js_maxarea").remove();
            }
            $("#js_filter_result").append('<button name_id="maxArea"  id="js_maxarea" attr_id="'+$("#maxArea").val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>تا '+$("#maxArea").val()+' متر</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_maxarea\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');

            $(".maxiarea").addClass('hidden');
        }
        checkSend();
    }
    $(document).ready(function(){

        $(".js_filter_action1").click(function()
        {
            if($(this).hasClass('js_min')){
                $("#minPrice").val($(this).attr('value'));
                $("#minPrice1").val($(this).html());
            }
            else
            {
                $("#maxPrice").val($(this).attr('value'));
                $("#maxPrice1").val($(this).html());
            }
            $(this).parent().parent().addClass('hidden');
            if($("#minPrice").val().length>0){
                if($("#js_minPrice").html()!=null){
                $("#js_minPrice").remove();
            }
                $("#js_filter_result").append('<button name_id="minPrice" id="js_minPrice" attr_id="'+$("#minPrice").val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>از '+$("#minPrice1").val()+' تومان</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_minPrice\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
            }
            if($("#maxPrice").val().length>0)
            {
                if($("#js_maxPrice").html()!=null){
                $("#js_maxPrice").remove();
            }
                $("#js_filter_result").append('<button name_id="maxPrice" id="js_maxPrice" attr_id="'+$("#maxPrice").val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>تا '+$("#maxPrice1").val()+' تومان</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_maxPrice\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
            }
            checkSend();

        })
    });
    function js_price(minmax,id){


        //alert(minmax+"Price");
    }
    var flag10=true;
    var flag11=true;
    var flag12=true;
    var flag13=true;
    var flag23=true;

    $(".js_button").click(function(){
        if($(this).siblings('ul').hasClass('hidden'))
            $(this).siblings('ul').removeClass('hidden');
        else
            $(this).siblings('ul').addClass('hidden');
    })

    var modal = document.querySelector("#js_blure_overlay1");

    modal.addEventListener("click", handleModalClick);

    function handleModalClick(evt) {
  // `evt.target` is the DOM node the user clicked on.
  if (evt.target.closest(".usage_type")) {
    flag10=false;
  }
  else
  {

    $(".js_usagetype").remove();
        var list='';
        $(".usage_type:checked").each(function(){
            //if($(this).val()!=-1){
                //list+=$(this).attr('label_name')+',';
                $("#js_filter_result").append('<button  name_id="usage_type" id="js_usage_type_'+$(this).val()+'"  attr_id="'+$(this).val()+'" class="searchappend js_usagetype border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+$(this).attr('label_name')+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_usage_type_'+$(this).val()+'\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
            //}
        });
        checkSend();
            $(".js_blure_overlay").fadeOut("slow");
            $(".js_popup_dropdown").css("height", "0");

    flag10=true;
  }

}

var modal1 = document.querySelector("#js_blure_overlay2");
    modal1.addEventListener("click", handleModalClick2);
    function handleModalClick2(evt) {
  // `evt.target` is the DOM node the user clicked on.
  if (evt.target.closest(".document1")) {
    flag11=false;
  }
  else
  {

    $(".js_document").remove();
    $(".document1:checked").each(function(){
            $("#js_filter_result").append('<button  name_id="document_type" id="js_document_'+$(this).val()+'"  attr_id="'+$(this).val()+'" class="searchappend js_document border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+$(this).attr('label_name')+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_document_'+$(this).val()+'\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
    });
    checkSend();
        $(".js_blure_overlay").fadeOut("slow");
        $(".js_popup_dropdown").css("height", "0");

    flag11=true;
  }

}

var modal2 = document.querySelector("#js_blure_overlay3");
    modal2.addEventListener("click", handleModalClick3);
    function handleModalClick3(evt) {

  if (evt.target.closest(".year")) {
    flag12=false;
  }
  else
  {

    $(".js_year").remove();

        $(".year:checked").each(function(){
                $("#js_filter_result").append('<button  name_id="built_year" id="js_year_'+$(this).val()+'"  attr_id="'+$(this).val()+'" class="searchappend js_year border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+$(this).val()+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_year_'+$(this).val()+'\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
        });
        checkSend();



        $(".js_blure_overlay").fadeOut("slow");
        $(".js_popup_dropdown").css("height", "0");

    flag12=true;
  }

}

var modal3 = document.querySelector("#js_blure_overlay4");
    modal3.addEventListener("click", handleModalClick4);
    function handleModalClick4(evt) {
  // `evt.target` is the DOM node the user clicked on.
  if (evt.target.closest(".geoghraphi")) {
    flag13=false;
  }
  else
  {

    $(".js_geoghraphi").remove();
        var list='';

        $(".geoghraphi:checked").each(function(){
                $("#js_filter_result").append('<button  name_id="geography" id="js_geoghraphi_'+$(this).val()+'"  attr_id="'+$(this).val()+'" class="searchappend js_geoghraphi border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+$(this).attr('label_name')+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_geoghraphi_'+$(this).val()+'\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
        });
        checkSend();
        $(".js_blure_overlay").fadeOut("slow");
        $(".js_popup_dropdown").css("height", "0");

    flag13=true;
  }

}

var modal5 = document.querySelector("#js_blure_overlay5");
    modal5.addEventListener("click", handleModalClick5);
    function handleModalClick5(evt) {
  // `evt.target` is the DOM node the user clicked on.
  if (evt.target.closest(".condition1")) {
    flag23=false;
  }
  else
  {

    $(".js_condition").remove();
        var list='';

        $(".condition1:checked").each(function(){
                $("#js_filter_result").append('<button  name_id="condition" id="js_condition_'+$(this).val()+'"  attr_id="'+$(this).val()+'" class="searchappend js_condition border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+$(this).attr('label_name')+'</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_condition_'+$(this).val()+'\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
        });
        checkSend();
        $(".js_blure_overlay").fadeOut("slow");
        $(".js_popup_dropdown").css("height", "0");

    flag23=true;
  }

}
//$(".js_blure_overlay").click(function (e) {

       // $(".js_blure_overlay").fadeOut("slow");
        // $(".js_popup_dropdown").css("height", "0");
  //  }
//);

    $('#js_mobile_type_of_Document').click(function () {

            $("#js_popup_dropdown_1").css("height", "75%");
            $("#js_blure_overlay2").fadeIn("slow");

    });
    $('#js_mobile_type_of_codition').click(function () {

$("#js_popup_dropdown_5").css("height", "75%");
$("#js_blure_overlay5").fadeIn("slow");

});

$('#js_mobile_Account_Type').click(function () {
    $("#js_popup_dropdown").css("height", "75%");
    $("#js_blure_overlay1").fadeIn("slow");
});


$('#js_mobile_Year_construction').click(function () {
    $("#js_popup_dropdown_2").css("height", "75%");
    $("#js_blure_overlay3").fadeIn("slow");
    //alert('sadasda');
});
$('#js_mobile_geographical_direction').click(function () {
    $("#js_popup_dropdown_3").css("height", "75%");
    $("#js_blure_overlay4").fadeIn("slow");
});
    $(".js_accordion_btn").click(function (e) {
        var slide = $(this).next();
        $(slide).slideToggle();
        $(".js_accordion_content").not($(slide)).slideUp();
    });
/*
    $('.js_min_query_2 li , .js_max_query_2 li').click(function (e) {
        $('.js_max_query_2').addClass('!h-[260px]');
        var query = $(this)[0].innerText;
        var parentElement = $($(this).parents()[1]).find('input')[0];
        $(parentElement).val(query);
        var element = $($(this).parents()[1]).children()[0];
        send_query_data(element,2);
    });
/*
    $('.js_min_query_1 li , .js_max_query_1 li').click(function (e) {

        $('.js_max_query_1').addClass('!h-[260px]');
        var query = $(this)[0].innerText;
        var parentElement = $($(this).parents()[1]).find('input')[0];
        $(parentElement).val(query);
        var element = $($(this).parents()[1]).children()[0];
        send_query_data(element,1);
    });
*/

    function min_query(item,k){
            var elements = $('.js_max_query_'+k).find('li button');
            for (let i = 0; i < elements.length; i++) {
                if (parseInt($(elements)[i].innerText) < item && item != '') {
                    //$($(elements)[i]).attr('disabled','disabled')
                }else{
                   // $($(elements)[i]).removeAttr('disabled');
                }
            }
        }

        function max_query(item,k){
            var elements = $('.js_min_query_'+k).find('li button');
            for (let i = 0; i < elements.length; i++) {

                if (parseInt($(elements)[i].innerText) > item && item != '') {
                    //$($(elements)[i]).attr('disabled','disabled')
                }else{
                    //$($(elements)[i]).removeAttr('disabled');
                }
            }
        }

        function min_query1(item,k){

            //var elements = .find('li button');
            $('.js_max_query_2').find("li button").each(function() {
                if(parseInt($(this).val())==item)
                    {
                        $('.js_min_query_2').parent().find('minPrice1').val($(this).html());
                    }
                if (parseInt($(this).val()) < item && item != '') {
                    //alert($(this).val());
                   // $(this).attr('disabled','disabled')
                  //  $(this).css('color','blue');
                }
                else{

                    //$(this).removeAttr('disabled');
                }

            });
        }

        function max_query1(item,k){
            $('.js_min_query_2').find("li button").each(function() {
                if(parseInt($(this).val())==item)
                    {
                        $('.js_max_query_2').parent().find('maxPrice1').val($(this).html());
                    }
                if (parseInt($(this).attr('value')) > item && item != '') {
                    //alert($(this).attr('value'),item);
                    //$(this).attr('disabled',true);
                    //$(this).css('color','red');
                }
                else{

                    //$(this).removeAttr('disabled');
                }
            });
            /*
            var elements = $('.js_min_query_2').find('li button');
            for (let i = 0; i < elements.length; i++) {
                if (parseInt($(elements)[i].attr('value')) > item && item != '') {
                    $($(elements)[i]).attr('disabled','disabled')
                }else{
                    $($(elements)[i]).removeAttr('disabled');
                }
            }*/
        }

    function send_query_data(element,k) {
        /*
            var minValue = 0;
            var maxValue = 0;
            if($(element).hasClass( "js_min_button" )){
                minValue = $(element).find('input').val();
                maxValue = $($($($(element).parents()[1]).children()[2]).children()[0]).find('input').val();

            }else if($(element).hasClass( "js_max_button" )){
                minValue = $($($($(element).parents()[1]).children()[0]).children()[0]).find('input').val();
                maxValue = $(element).find('input').val();
            }
            min_query(parseInt(minValue),k);
            max_query(parseInt(maxValue),k);
            if (parseInt(maxValue) < parseInt(minValue)) {
                maxValue = parseInt(minValue);
            }*/
            //result(minValue,maxValue);
        }
        $("#js_mobile_Select_location_btn").click(function (e) {
    $("#js_mobile_Select_location").slideDown('slow');
    $("#js_mobile_filters_menu").css('overflow','hidden');
});
$("#js_mobile_close_Select_location").click(function (e) {
    $("#js_mobile_Select_location").slideUp('slow');
    $("#js_mobile_filters_menu").css('overflow','auto');
});
$(".jsbutton").click(function(){
    //alert($(this).parent().parent().parent().find('.js_min_max_input').val());
    $(this).parent().parent().parent().find('.js_min_max_input').removeAttr('disabled');
    $(this).parent().parent().parent().find('.js_min_max_input').val('');
    $(this).parent().parent().parent().find('.js_min_max_input').focus();

    $(this).parent().parent().parent().find('ul').addClass('hidden');

});
$(".js_min_max_input").change(function(){
    var attr = $(this).attr('disabled');
    if (typeof attr == 'undefined' && attr !== true) {



        if($(this).attr('id')=='minPrice1'){
            if($("#js_minPrice").html()!=null)
                $("#js_minPrice").remove();

            $("#js_filter_result").append('<button name_id="minPrice" id="js_minPrice" attr_id="'+$(this).val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between checkhand"><span>از '+$(this).val()+' تومان</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_minPrice\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
        }
        if($(this).attr('id')=='maxPrice1'){
            if($("#js_maxPrice").html()!=null)
                $("#js_maxPrice").remove();
            $("#js_filter_result").append('<button name_id="maxPrice" id="js_maxPrice" attr_id="'+$(this).val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between checkhand"><span>تا '+$(this).val()+' تومان</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_maxPrice\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
        }
        if($(this).attr('id')=='minArea'){

            if($("#js_minArea").html()!=null)
                $("#js_minArea").remove();

            $("#js_filter_result").append('<button name_id="minArea" id="js_minArea" attr_id="'+$(this).val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between checkhand"><span>از '+$(this).val()+' متر</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_minArea\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
        }
        if($(this).attr('id')=='maxArea'){
            //alert($(this).val());
            if($("#js_maxarea").html()!=null)
                $("#js_maxarea").remove();
            $("#js_filter_result").append('<button name_id="maxArea" id="js_maxArea" attr_id="'+$(this).val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-25 text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between checkhand"><span>تا '+$(this).val()+' متر</span><span class="text-red-200 pr-3 " onclick="remove1(\'js_maxArea\')"><i class="fa-thin fa-xmark text-2xl "></i></span></button>');
        }




        checkSend();
    }
});

    </script>
