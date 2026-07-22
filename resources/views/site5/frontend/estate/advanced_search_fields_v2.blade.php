<div class="hidden absolute top-1/2 -translate-y-[20%] w-[820px] js_multiple_radio_selection_1 m-auto left-0 right-0" id="js_another_filter_content" style="display: block;z-index:1002">
    <div
        class="p-5 rounded-2xl border-[1px] border-gray-400 bg-[#F9F9F9] max-w-[820px] flex flex-wrap justify-between items-start w-full">
        <div class="flex justify-between items-center w-full mb-4">
            <span class="text-lg lg:text-xl font-light text-gray-500">{{ l('سایر فیلتر ها') }}</span>
            <span class="text-[32px] text-gray-400 js_close cursor-pointer"><i class="fa-thin fa-xmark"></i></span>
        </div>
        <div class="w-1/2 pl-4 mt-6">
            <div class="js_Filter_by_features_0">
                <p class="hidden lg:flex text-gray-500 text-lg lg:text-xl font-light  items-center gap-2">
                    <i class="fa-thin fa-chevron-left"></i>
                            <span>{{ l('بر اساس امکانات') }}</span>
                            </p>
                <div class="rounded-2xl border-[1px] border-gray-400 bg-white p-[10px] lg:mt-4 min-h-[60px] flex">

                    <div>
                        <ul class="flex items-center justify-start flex-wrap"
                            id="js_search_result_Basics_facilities">

                        </ul>
                    </div>
                    <div class="mt-3 relative">
                        <input class="w-full h-8 outline-none font-light text-gray-500 hidden" type="text" name=""
                            id="js_other_facilities" value="">
                        <span class="absolute right-0 bottom-[3px]">
                            <span class="invisible" id="js_text_shadow_visibility"></span>
                            <span class="text-gray-400 font-light absolute select-none pointer-events-none w-max"
                                id="js_text_shadow"></span>
                        </span>
                    </div>
                </div>
                <div class="mt-3 mb-3 lg:mb-0">
                    <ul class="flex flex-wrap justify-start items-center js_tag_filters">

                    </ul>
                </div>
            </div>
            <div>
                <div class="mt-6">
                    <p class="text-gray-500 text-lg lg:text-xl font-light flex items-center gap-2">
                      <i class="fa-thin fa-chevron-left"></i>
                      <span>{{ l('نوع کاربری') }}</span>
                    </p>
                    <div class="w-full overflow-hidden bg-white mt-3 rounded-2xl">
                        <select name="usage_type" id="usage_type"
                            class="select2 w-full h-full outline-none text-gray-500 font-light text-right pr-3" multiple>
                            <option value="">{{ l('انتخاب نمایید') }}</option>
                            <option value="107">{{ l('مسکونی') }}</option>
                            <option value="108">{{ l('اداری') }}</option>
                            <option value="109">{{ l('تجاری') }}</option>
                            <option value="110">{{ l('مسکونی با موقعیت اداری - تجاری') }}</option>
                            <option value="111">{{ l('گردشگری') }}</option>
                            <option value="112">{{ l('غیره') }}</option>
                            <option value="252">{{ l('مسکونی با موقعیت اداری') }}</option>
                            <option value="253">{{ l('مسکونی به همراه تجاری') }}</option>
                            <option value="254">{{ l('باغ ویلا') }}</option>
                            <option value="255">{{ l('ویلا جنگلی') }}</option>
                            <option value="256">{{ l('ویلا ساحلی') }}</option>
                            <option value="285">{{ l('کشاورزی') }}</option>
                            <option value="286">{{ l('باغ') }}</option>
                            <option value="287">{{ l('دامپروری') }}</option>
                            <option value="288">{{ l('صنعتی') }}</option>
                            <option value="289">{{ l('بایر') }}</option>
                            <option value="337">{{ l('گردشگری ( اقامتی)') }}</option>
                            <option value="341">{{ l('بدون توافق') }}</option>

                        </select>
                    </div>
                </div>
                <div class="mt-6">
                    <p class="text-gray-500 text-lg lg:text-xl font-light mb-3 flex items-center gap-2">
                        <i class="fa-thin fa-chevron-left"></i>
                     <span>{{ l('موقعیت جغرافیایی') }}</span>
                </p>
                    <div class= "w-full overflow-hidden bg-white mt-3 rounded-2xl">
                        <select  name="geography" id="geography"
                            class="select2 w-full h-full outline-none text-gray-500 font-light text-right pr-3" multiple>
                            <option value="">{{ l('انتخاب نمایید') }}</option>
                            <option value="113">{{ l('شمالی') }}</option>
                            <option value="114">{{ l('جنوبی') }}</option>
                            <option value="115">{{ l('شرقی') }}</option>
                            <option value="116">{{ l('غربی') }}</option>
                            <option value="346">{{ l('یک بر') }}</option>
                            <option value="117">{{ l('دوبر') }}</option>
                            <option value="118">{{ l('سه بر') }}</option>
                            <option value="119">{{ l('چهاربر') }}</option>
                            <option value="120">{{ l('دوکله') }}</option>

                        </select>
                    </div>
                </div>
                <div class="mt-6">
                    <p class="text-gray-500 text-lg lg:text-xl font-light mb-3 flex items-center gap-2" >
                        <i class="fa-thin fa-chevron-left"></i>
                               <span>{{ l('شرایط') }}</span>
                            </p>
                    <div class=" w-full overflow-hidden bg-white">
                        <select  name="condition" id="condition" class="select2 w-full h-full outline-none text-gray-500 font-light text-right" multiple>
                            <option value="">{{ l('انتخاب نمایید') }}</option>
                            <option value="15">{{ l('پیش فروش') }}</option>
                            <option value="16">{{ l('قابل معاوضه') }}</option>
                            <option value="17">{{ l('وام دار') }}</option>
                            <option value="18">{{ l('مجتمع/برج') }}</option>
                            <option value="19">{{ l('قدرالسهمی') }}</option>
                            <option value="302">{{ l('مناسب مطب و دفتر کار') }}</option>
                            <option value="303">{{ l('اتاق اداری') }}</option>
                            <option value="344">{{ l('بازسازی شده') }}</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>
        <div class="w-1/2 pr-4">
            <div class="hidden flex justify-between "  id="converti">
                <p class="text-gray-500 text-lg lg:text-xl font-light">{{ l('قابلیت تبدیل') }}</p>
                <label class="inline-flex relative items-center cursor-pointer">
                    <input type="checkbox" value="1" name="convertible" class="sr-only peer" id="convertible">
                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                </label>
            </div>

            <div class="flex justify-between mt-2">
                <p class="text-gray-500 text-lg lg:text-xl font-light">{{ l('عکس دار') }}</p>
                <label class="inline-flex relative items-center cursor-pointer">
                    <input type="checkbox" value="1" name="hasPhoto" class="sr-only peer" id="hasPhoto">
                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                </label>
            </div>
            <div class="flex justify-between  mt-2">
                <p class="text-gray-500 text-lg lg:text-xl font-light">{{ l('آگهی دهنده(کارشناس)') }}</p>
                <label class="inline-flex relative items-center cursor-pointer">
                    <input type="checkbox" value="1" name="hasAgent" class="sr-only peer" id="hasAgent">
                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                </label>
            </div>

            <div class="mt-6">
                <p class="text-lg lg:text-xl text-gray-500 font-light flex items-center gap-2">
                     <i class="text-lg lg:text-xl fa-thin fa-chevron-left"></i>
                     <span>{{ l('حداکثر تعداد طبقات') }}</span>
                </p>
                <div dir="ltr"
                    class="px-[5px] mt-4 border-[1px] border-gray-400 rounded-2xl h-12 flex items-center justify-between overflow-hidden">
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
            <div class="mt-6">
                <p class="text-gray-500 text-lg lg:text-xl font-light mb-3 flex items-center gap-2" >
                    <i class="fa-thin fa-chevron-left"></i>
                           <span>{{ l('نوع سند') }}</span>
                        </p>
                <div class=" w-full overflow-hidden bg-white">
                    <select  name="document_type" id="document_type" class="select2 w-full h-full outline-none text-gray-500 font-light text-right" multiple>
                        <option value="">{{ l('انتخاب نمایید') }}</option>
                        <option value="20">{{ l('شش دانگ') }}</option>
                        <option value="21">{{ l('سرقفلی') }}</option>
                        <option value="22">{{ l('مشاع') }}</option>
                        <option value="23">{{ l('اوقافی') }}</option>
                        <option value="24">{{ l('مسکن مهر') }}</option>
                        <option value="25">{{ l('وکالتی') }}</option>
                        <option value="26">{{ l('قولنامه ای') }}</option>
                        <option value="27">{{ l('بنیادی') }}</option>
                        <option value="28">{{ l('زمین شهری') }}</option>
                        <option value="29">{{ l('شورایی') }}</option>
                        <option value="30">{{ l('در دست اقدام') }}</option>
                        <option value="284">{{ l('قراداد واگذاری') }}</option>
                    </select>
                </div>
            </div>



            <div class="mt-6">
                <p class="text-gray-500 text-lg lg:text-xl font-light mb-3 flex items-center gap-2">
                  <i class="fa-thin fa-chevron-left"></i>
                    <span>{{ l('سال ساخت') }}</span>
                        </p>
                <div class=" w-full overflow-hidden bg-white">
                    <select  name="built_year" id="built_year" multiple
                        class="select2 w-full h-full outline-none text-gray-500 font-light text-right pr-3">
                        <option value="">{{ l('انتخاب کنید') }}</option>
                        <?php for($i=1401;$i>=1360;$i--){?>
                        <option value="<?=$i;?>"><?=$i;?></option>
                        <?php }?>
                        <option value="1359">{{ l('کمتر از 1360') }}</option>
                    </select>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-lg lg:text-xl text-gray-500 font-light flex items-center gap-2">
                    <i class=" fa-thin fa-chevron-left"></i>
                        <span>{{ l('حداکثر تعداد اتاق') }}</span>
                    </p>
                <div dir="ltr"
                    class="px-[5px] mt-3 border-[1px] border-gray-400 rounded-2xl h-12 flex items-center justify-between overflow-hidden">
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


        <div class="w-1/2 pr-4">
            <div class="mt-11">
                <input
                    class="text-white text-lg lg:text-xl font-medium w-full h-12 rounded-2xl bg-blue-500 flex items-center justify-center cursor-pointer"
                   id="filter_click"  type="button" value="{{ l('اعمال فیلتر') }}">
            </div>

        </div>

</div>
</div>
<script src="/assets/vendors/select2/js/select2.js"></script>
<script>

    $(document).ready(function(){
        var sidcheck=0;



        $("input[name='asas']").click(function(){
            if(sidcheck!=$(this).val()){
                sidcheck=$("input[name='asas']:checked").val();
            }
            else
            {
                sidcheck=0;
                $(this).prop('checked', false);
            }
        });

        var nidcheck=0;
        $("input[name='Number_of_floors']").click(function(){
            if(nidcheck!=$(this).val()){
                nidcheck=$("input[name='Number_of_floors']:checked").val();
            }
            else
            {
                nidcheck=0;
                $(this).prop('checked', false);
            }
        });



        $("#js_overlay , .js_close").click(function(e) {
        $("#js_another_filter_content").hide("fast");
        $("#js_overlay").fadeOut("500");
        $(".js_multiple_radio_selection_1").remove();
        // $("#js_filter_result").html('');
    });

        $("#filter_click").on('click',function(){



            if($(".usage").html()!=null){
                    $(".usage").remove();
            }
            if($(".geog").html()!=null){
                    $(".geog").remove();
            }
            if($(".cond").html()!=null){
                    $(".cond").remove();
            }
            if($(".built").html()!=null){
                    $(".built").remove();
            }
            if($(".doc").html()!=null){
                    $(".doc").remove();
            }
            if($(".js_facilities").html()!=null){
                    $(".js_facilities").remove();
            }
            if($("#js_numberfloors").html()!=null){
                    $("#js_numberfloors").remove();
            }
            if($("#js_asas").html()!=null){
                    $("#js_asas").remove();
            }
            if($("#js_convertible").html()!=null){
                    $("#js_convertible").remove();
            }

            if($("#js_hasPhoto").html()!=null){
                    $("#js_hasPhoto").remove();
            }

            if($("#js_hasAgent").html()!=null){
                    $("#js_hasAgent").remove();
            }
            //alert($("#room_count").val());
            for (let i = 0; i < selection_array.length; i++)
            {
                $("#js_filter_result").append('<button id="faculties_'+selection_array[i]+'" name_id="faculties" attr_id="'+selection_array[i]+'" class="searchappend js_facilities border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+check(selection_array[i])+'</span><span class="text-red-200 pr-3" onclick="remove1(\'faculties_'+selection_array[i]+'\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
            }

    if($("#convertible").prop("checked")== true)
        $("#js_filter_result").append('<button id="js_convertible"  name_id="convertible" attr_id="1" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>{{ l('قابلیت تبدیل') }}</span><span class="text-red-200 pr-3" onclick="remove1(\'js_convertible\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');


        if($("#hasPhoto").prop("checked")== true)
        $("#js_filter_result").append('<button id="js_hasPhoto"  name_id="hasPhoto" attr_id="1" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>{{ l('دارای عکس') }}</span><span class="text-red-200 pr-3" onclick="remove1(\'js_hasPhoto\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');


        if($("#hasAgent").prop("checked")== true)
        $("#js_filter_result").append('<button id="js_hasAgent"  name_id="hasAgent" attr_id="1" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>{{ l('کارشناس دار') }}</span><span class="text-red-200 pr-3" onclick="remove1(\'js_hasAgent\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');

        if($("input[name='asas']:checked").val()>0)
            $("#js_filter_result").append('<button id="js_asas" name_id="room_count" attr_id="'+$("input[name='asas']:checked").val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>حداکثر اتاق '+room($("input[name='asas']:checked").val())+'</span><span class="text-red-200 pr-3" onclick="remove1(\'js_asas\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
        if($("input[name='Number_of_floors']:checked").val()>0)
            $("#js_filter_result").append('<button id="js_numberfloors" name_id="floor" attr_id="'+$("input[name='Number_of_floors']:checked").val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>حداکثر طبقه '+floor($("input[name='Number_of_floors']:checked").val())+'</span><span class="text-red-200 pr-3" onclick="remove1(\'js_numberfloors\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
//if($("#usage_type").val()>0)
  //          $("#js_filter_result").append('<button id="js_usagetype" name_id="usage_type" attr_id="'+$("#usage_type").val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+$("#usage_type option:selected").text()+'</span><span class="text-red-200 pr-3" onclick="remove1(\'js_usagetype\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
//if($("#geography").val()>0)

var geoArray = $("#geography").val().toString().split(',');
for (var i = 0; i < geoArray.length; i++) {
    if(geoArray[i].length>0)
    $("#js_filter_result").append('<button id="js_geography_'+geoArray[i]+'" name_id="geography" attr_id="'+geoArray[i]+'" class="searchappend geog border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+geoghraphitext(geoArray[i])+' </span><span class="text-red-200 pr-3" onclick="remove1(\'js_geography_'+geoArray[i]+'\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
}

var usageArray = $("#usage_type").val().toString().split(',');
for (var i = 0; i < usageArray.length; i++) {
    if(usageArray[i].length>0)
    $("#js_filter_result").append('<button id="js_usagetype_'+usageArray[i]+'" name_id="usage_type" attr_id="'+usageArray[i]+'" class="searchappend usage border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+usagetext(usageArray[i])+' </span><span class="text-red-200 pr-3" onclick="remove1(\'js_usagetype_'+usageArray[i]+'\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
}


var conditionArray = $("#condition").val().toString().split(',');
for (var i = 0; i < conditionArray.length; i++) {
    if(conditionArray[i].length>0)
    $("#js_filter_result").append('<button id="js_condition_'+conditionArray[i]+'" name_id="condition" attr_id="'+conditionArray[i]+'" class="searchappend cond border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+conditiontext(conditionArray[i])+' </span><span class="text-red-200 pr-3" onclick="remove1(\'js_condition_'+conditionArray[i]+'\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
}


var documentArray = $("#document_type").val().toString().split(',');
for (var i = 0; i < documentArray.length; i++) {
    if(documentArray[i].length>0)
    $("#js_filter_result").append('<button id="js_documenttype_'+documentArray[i]+'" name_id="document_type" attr_id="'+documentArray[i]+'" class="searchappend doc border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+documenttext(documentArray[i])+' </span><span class="text-red-200 pr-3" onclick="remove1(\'js_documenttype_'+documentArray[i]+'\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
}

var buildArray = $("#built_year").val().toString().split(',');
for (var i = 0; i < buildArray.length; i++) {
    if(buildArray[i].length>0)
    $("#js_filter_result").append('<button id="js_builtyear_'+buildArray[i]+'" name_id="built_year" attr_id="'+buildArray[i]+'" class="searchappend built border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+buildtext(buildArray[i])+' </span><span class="text-red-200 pr-3" onclick="remove1(\'js_builtyear_'+buildArray[i]+'\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
}



            //alert($("#condition").val());

            //if($("#document_type").val()>0)
            //$("#js_filter_result").append('<button id="js_documenttype" name_id="document_type" attr_id="'+$("#document_type").val()+'" class="searchappend border-[1px] border-gray-200 rounded-[15px] lg:rounded-2xl text-base text-gray-500 font-light bg-[#f9f9f9] px-5 h-[59px] flex items-center justify-between"><span>'+$("#document_type option:selected").text()+'</span><span class="text-red-200 pr-3"  onclick="remove1(\'js_documenttype\')"><i class="fa-thin fa-xmark text-2xl"></i></span></button>');
            checkSend();
            $("#js_another_filter_content").hide("fast");
        $("#js_overlay").fadeOut("500");
        $(".js_multiple_radio_selection_1").remove();
        });
    });

    remove_element('');
    create_element('');
    function tagclick(name) {
        var element_name = name;
        add_item_array(element_name);
    }

    function removeclick(name) {
        var element_name = name;
        remove_item_array(element_name);
    }

    function add_item_array(name) {
        for (let i = 0; i < input_array.length; i++) {
            if (input_array[i] == name) {

                selection_array.push(name);

                const index = input_array.indexOf(name);
                if (index > -1) { // only splice array when item is found
                    input_array.splice(index, 1); // 2nd parameter means remove one item only
                }

                create_element(name);
                remove_element(name);
            }
        }
    }

    function remove_item_array(name) {

        for (let i = 0; i < selection_array.length; i++) {
            if (selection_array[i] == name) {

                input_array.push(name);
                const index = selection_array.indexOf(name);
                if (index > -1) { // only splice array when item is found
                    selection_array.splice(index, 1); // 2nd parameter means remove one item only
                }

                create_element(name);
                remove_element(name);
            }
        }
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
    function create_element(name) {
        var ab = "";
        j = 0
        for (let i = 0; i < selection_array.length; i++) {
            ab +=
                '<li class="flex items-center justify-between h-12 px-3 bg-white border-[1px] border-blue-500 rounded-[15px] lg:rounded-2xl ml-1">' +
                '<span class="text-base text-red-200 pl-2 pt-[6px] cursor-pointer remove_tag js_remove_tag" onclick="removeclick(\'' +
                selection_array[i] + '\')"><i class="fa-solid fa-minus"></i></span>' +
                '<p class="text-base text-gray-500 font-light w-max">' + check(selection_array[i]) + '</p>' +
                '</li>';
        }
        $("#js_search_result_Basics_facilities").html(ab);
    }

    function remove_element(name) {
        var ab = "";
        for (let i = 0; i < input_array.length; i++) {
            ab +=
                '<li class="rounded-2xl border-[1px] border-gray-400 h-[38px] flex items-center justify-center w-fit px-3 py-3 mx-1 my-1">' +
                '<span class="pl-2 text-lg lg:text-xl text-gray-400 cursor-pointer js_add_tag" onclick="tagclick(\'' +
                input_array[i] + '\')"><i class="fa-thin fa-plus"></i></span>' +
                '<p class="text-base text-gray-500 font-light">' + check(input_array[i]) + '</p>' +
                '</li>';

        }
        $(".js_tag_filters").html(ab);
    }
    $(".removeall").click(function(){

            selection_array.length = 0;
            input_array.length = 0;
            input_array.push('35');
            input_array.push('36');
            input_array.push('37');
            create_element('');
            remove_element('');
        });

</script>
