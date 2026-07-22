$(function(){
    pageLoad();
});

$('.switch').click(function()
{
    $(this).toggleClass("switchOn");
});

$(".dropdown").on("click", ".form-select > option", function () {

    var obOption=$(this);
if (!obOption.hasClass("added"))
{
    var parentId = $(this).parent().attr('id');
    var text2 = obOption.text();
    if($('#tag_'+ parentId).length < 1)
    {
        $(".tag-area").append('<div id="tag_'+ parentId +'" data-id="'+ parentId +'" class="search-pill font_11 secondary-pill me-1 mb-1 radius-4 pos-r py-1"> <div> <div class="pill-value">' + $(this).text() + '</div> <div class="pill-category">'+ $('#lbl'+parentId).text() + '</div> </div> <button id="'+ $(this).val() +'" type="button" class="btn btn-link btn-close pos-abs"> </button> </div>');
        obOption.addClass("added")
    }
    else
    {
        if(obOption.val() != '')
        {
            $('#tag_'+parentId+' .pill-value').text(text2)
        }
    }
    $('.pos-rr').removeClass("d-none");
}
// انتخاب حالت دیفالت برابر حذف آیتم است
    if($(this).val() == '')
    {
        $('#tag_'+ parentId).remove();
        if($('.tag-area .search-pill').length == 0){
            $('.pos-rr').addClass("d-none");
        }
    }
});

$("body").on("click", ".js_condition,.js_feature", function () {
    var obOption=$(this);
    let labelText=obOption.hasClass('js_feature')?'امکانات':'شرایط';
    if($(this).is(":checked"))
    {
        var txt=$('#js_lbl'+obOption.attr('id')).html();

        $(".tag-area").append('<div id="tag_con'+ obOption.attr('id') +'" data-id="#'+obOption.attr('id') +'" class="search-pill js_chk font_11 secondary-pill me-1 mb-1 radius-4 pos-r py-1"> <div> <div class="pill-value">' + txt + '</div> <div class="pill-category">'+labelText+'</div> </div> <button id="'+ $(this).attr('id') +'" type="button" class="btn btn-link btn-close pos-abs"> </button> </div>');
        $('.pos-rr').removeClass("d-none");
    }
    else
    {
        $('#tag_con'+ obOption.attr('id')).remove();
        if($('.tag-area .search-pill').length == 0){
            $('.pos-rr').addClass("d-none");
        }
    }
});

// Remove Tags
$(".pos-rr").on("click", ".btn-close", function ()
{
let par=$(this).parent();
par.remove();

if(par.hasClass('js_chk'))
{
    $(par.attr('data-id')).removeAttr('checked');
    $(par.attr('data-id')).prop('checked',false);
}
else
{
    $('select#'+par.attr('data-id') + ' option[value=""]').prop('selected',true);
    var idclose = $(this).attr('id');
    $('.form-select > option[value="' + idclose + '"]').removeClass("added");
}
var cont = $('.tag-area .search-pill').length;
if(cont == 0)
{
    $('.pos-rr').addClass("d-none");
}
});

function GetStateList(page)
{
if(page==0)
{
    $("#estate-wrapper").empty();
}
$.ajax({
    url: `?page=${page+1}${window.location.search.replace('?','&')}`,
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
        $(".btnmore1").addClass('d-none').removeClass('d-block');
        var htmlpage=data.html;
        if(hasPage==true){
            htmlpage+= "<div class='d-flex justify-content-center py-2 btnmore1' ><input class='btn btn-info' type='button' value='دیدن بیشتر' onclick='GetStateList("+parseInt(parseInt(page)+parseInt(1))+")'/></div>";
        }
        $("#estate-wrapper").append(htmlpage);
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
        alert('مشکلی در دریافت اطلاعات بوجود آمده است...');

    });
};

$(".js_typeTransaction").click(function(){

$(".js_typeTransaction").parent().parent().removeClass("active");

$(this).parent().parent().addClass("active");
if($(this).parent().parent().attr('id')=="sell"){
    $(".js_rahn").removeClass('d-flex').addClass('d-none');
    $("#priceshow").removeClass('d-none').addClass('d-flex');
    $(".js_typeTransaction").removeAttr('checked');
    $(".js_typeTransaction").prop('checked',false);
    $(this).prop('checked',true);
    $('#transaction_type').text($('#sell').find('.text-nowrap').html())
}
else if($(this).parent().parent().attr('id')=="rent")
{
    inttypesale=2;
    $(".js_rahn").removeClass('d-none').addClass('d-flex');
    $("#priceshow").removeClass('d-flex').addClass('d-none');
    $(".js_typeTransaction").removeAttr('checked');
    $(".js_typeTransaction").prop('checked',false);
    $(this).prop('checked',true);
    $('#transaction_type').text($('#rent').find('.text-nowrap').html())
}
//in method barayeh gereftane eshterake properti ha seda zade mishod gharar shod hame propetiha aval page load seda zade shavand
// checkMoreFiled();
$('#transaction_type').click();
});

// set kardan noe melk
$(".property-checkbox").click(function()
{
if($(this).is(":checked"))
{
    if($(this).hasClass('js_proptype-any-desktop'))
    {
        $('.js_parentH').find('.property-checkbox[id!="proptype-any-desktop"]').prop('checked', false);
    }
    else
    {
        $(this).prop('checked', true);
        $('.js_parentH').find('.property-checkbox[id="proptype-any-desktop"]').prop('checked', false);
        if($('.js_parentH').find('.property-checkbox[id!="proptype-any-desktop"]').not(":checked").length==0)
        {
            $('.property-checkbox[id!="proptype-any-desktop"]').prop('checked', false);
            $('.property-checkbox[id="proptype-any-desktop"]').prop('checked', true);
        }
    }
   // alert($('.js_parentH'))
}
else
{
    if($(this).hasClass('js_proptype-any-desktop'))
    {
        $('.js_parentH').find('.property-checkbox[id="proptype-any-desktop"]').prop('checked', true);
    }
    else
    {
        $(this).prop('checked', false);
        $('.property-checkbox[id="proptype-any-desktop"]').prop('checked', false);

        if($('.js_parentH').find('.property-checkbox[id!="proptype-any-desktop"]:checked').length==0)
        {
            $('.js_parentH').find('.property-checkbox[id="proptype-any-desktop"]').prop('checked', true);
        }
    }
}
//in method barayeh gereftane eshterake properti ha seda zade mishod gharar shod hame propetiha aval page load seda zade shavand
checkMoreFiled();

});

var hasPage = true;
var pageflag=true;
function pageLoad()
{
    GetStateList(0); // load avaliye data dar grid
    ///Load More Start
    var page =1;
    /*
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height() && hasPage) {
            if(pageflag==true){
                pageflag=false;
            page++;
            GetStateList(page);
            }
        }
    });*/
    ///Load More End

    checkMoreFiled();
    var inttypesale=1;
    //initial kardam manategh ghabl az set kardan plugin
     var arrdistricts = eval($('#js_json_encode_selectedDistricts').val());
     arrdistricts.forEach(function(element){
        $('#districts').find('option[value="'+element+'"]').prop('selected','selected');
     });
    $('.select2,.js_select2').select2({tags:true});
    //$('.js_select2_v2').select2();

  $('body').click((e)=>{
      if($(e.target).closest('#Neighbourhood_dropdown').length==0 && !$(e.target).hasClass('select2-selection__choice__remove'))
      {
          $("#Neighbourhood_dropdown").removeClass('golabSelect2');
      }
    });

  $(".js_Neighbourhood").click(function () {
    $('.js_select2_v2').select2({closeOnSelect: true});
    setTimeout(() => {
        $('.select2-selection__rendered').click();
        $('#Neighbourhood_dropdown').addClass('golabSelect2').show();
    }, 10);
  });

    // var list = $('.js_select2_v2').select2({
    //     allowClear: true,

    //       closeOnSelect: false,
    //     }).on("js_select2_v2:closing", function(e) {
    //       e.preventDefault();
    //     }).on("js_select2_v2:closed", function(e) {
    //       list.select2("open");
    //     });
    //     list.select2("open");

    // $('.js_select2_v2').select2({tags:true});
    //-----------------------------------------------
    if($('#rent').hasClass('active'))
    {
        $('#rent').find('.js_typeTransaction').click();
    }
    var price_range =eval($('#js_json_encode_price').val());
    if(price_range[0]!=0)
    {
        $('#price_min').val(price_range[0]).trigger('change');
    }
    if(price_range[1]!=0)
    {
        $('#price_max').val(price_range[1]).trigger('change');
    }

    var rent_range = $('#js_json_encode_rent').val().split(',');

    if(rent_range[0]!=0)
    {
        $('#rent_min').val(rent_range[0]).trigger('change');
    }
    if(rent_range[1]!=0)
    {
        $('#rent_max').val(rent_range[1]).trigger('change');
    }
    var price_mortgage = $('#js_json_encode_mortgage').val().split(',');

    if(price_mortgage[0]!=0)
    {
        $('#mortgage_min').val(price_mortgage[0]).trigger('change');
    }
    if(price_mortgage[1]!=0)
    {
        $('#mortgage_max').val(price_mortgage[1]).trigger('change');
    }
    //-----------------------------------------------
    $('body').on("keyup","input.select2-search__field",function () {
        var seperatedval = separateNum(this.value);
        this.value = seperatedval;
        $(".select2-results__option--highlighted").text(seperatedval);
    });
    $('.js_select2').on('select2:select', function (e) {
        $(e.target).append('<option selected="selected" value="' + $(e.target).val().replace(/\,/g,"")+ '">' + separateNum($(e.target).val().replace(/\,/g,"")) + '</option>');

    $(e.target).val($(e.target).val().replace(/\,/g,""));
        $(e.target).trigger("change");
    });
   SetMapCluster();
}//page load

function separateNum(value) {
    var nStr = value;
    nStr = nStr.replace(/\,/g, "");
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function checkMoreFiled()
{
    var array=[]
    var salekind=1;
    $(".property-checkbox").each(function()
    {
        if($(this).is(":checked")){
            array.push($(this).val());
        }
    });
    $(".js_typeTransaction").each(function(i, requiredField)
    {
        if($(this).is(":checked")){

            salekind=$(this).val();
        }
    });

    if(array=='')
    {
        getMoresearchFields([0],salekind);
    }
    else
    {
        getMoresearchFields(array,salekind);
    }
}

// in method fild haye dropdown jostejuye bishtar ra por mikonad
// dar tarikh 18-9-1400 in method faghat yek bar seda zade khahad shod
//
function getMoresearchFields(et,at) {
/*[0](et.includes("0")?[0]:et) //in comment jahat tabdil eshterak properies be ejtema ast*/
    $.ajax({
        type: 'POST',
        url: '/estates/get_search_fields',
        data:{_token:$('#js_csrf_token').val(),estateType:et.includes("0")?[0]:et,activityType:at},
        error: function()
        {
            //alert("خطای دریافت اطلاعات از سرور!");
        },
        success: function(response)
        {
            $('#apartment-rent').html(response);
            BindFromByUrl();
        }
    });
}

function BindFromByUrl()
{
    var url = window.location.href;

    var paramsString = url.split("?");
    var searchParams = new URLSearchParams(paramsString[1])+ '';
    var arr = searchParams.split('&');

    //set page component by url parameter
    for(var i=0; i<arr.length; i++) {
        var arr2=arr[i].split("=");
        var urlVariableName=arr2[0];
        var urlVariableValue=arr2[1];

        if(urlVariableName=="conditions")
        {
            var arr4=urlVariableValue.split("%2C");
            for(var j=0;j<arr4.length;j++){
                let ob=$("#conditions"+arr4[j]);
               if(!ob.is(":checked"))
                {
                    ob.click();
                }
            }
        }
        else if(urlVariableName=='facilities')
        {
           var arr4=urlVariableValue.split("%2C");
           for(var j=0;j<arr4.length;j++){
                let ob=$("#facilities"+arr4[j]);
                if(!ob.is(":checked"))
                {
                    ob.click();
                }
            }
        }
        else if(urlVariableName=='kitchen')
        {
            var arr4=urlVariableValue.split("%2C");
            for(var j=0;j<arr4.length;j++){
                $("#kitchen"+arr4[j]).attr('checked','true') ;
            }
        }
        else if(urlVariableName=='heating_cooling')
        {
            var arr4=urlVariableValue.split("%2C");
            for(var j=0;j<arr4.length;j++){
                $("#heating_cooling"+arr4[j]).attr('checked','true') ;
            }
        }
        else if(urlVariableName=='q') {}
        else if(urlVariableName=='price'){}
        else if(urlVariableName=='type'){}
        else if(urlVariableName=='districts'){}
        else if(urlVariableName=='estateTypes'){}
        else if(urlVariableName=='price'){}
        else if(urlVariableName=='mortgage'){}
        else
        {
           if(urlVariableValue!=undefined)
           {
                $("#"+urlVariableName+" select").val(urlVariableValue).change();
                $("#"+urlVariableName+" select").find('option[value="'+urlVariableValue+'"]').click();
           }
        }
    }
 }

$.fn.updateNextSelect=function(obj,val)
{
    $(obj).find('option').each(function(){
        if(parseInt($(this).val())<parseInt(val))
        {
            $(this).attr('disabled','disabled');
        }
        else
        {
            $(this).removeAttr('disabled');
        }
    });
    $('.select2,.js_select2').select2({tags:true});
}

$.fn.filterclick= function (t)
{
    var condition="";
    var facilitie="";
    var kitchen="";
    var heating_cooling="";
    var feathers="";
    var estateTypes="";
    var type="";
    var districts="";
    var price="";

    $(".js_condition").each(function(){
        if($(this).is(":checked"))
    {
            if($(this).val()!="undefined"){
                condition+=$(this).val()+",";
            }
        }
    });

    $(".js_feature").each(function(){

        if($(this).is(":checked"))
        {
            if($(this).val() != "undefined"){
                facilitie+=$(this).val()+",";
            }
        }
    });
    $(".kitchen").each(function(){
        if($(this).is(":checked")){
            if($(this).val()!="undefined"){
                kitchen+=$(this).val()+",";
            }
        }
    });

    $(".heating_cooling").each(function(){
        if($(this).is(":checked")){
            if($(this).val()!="undefined"){
                heating_cooling+=$(this).val()+",";
            }
        }
    });

    $(".feathers option:selected" ).each(function() {
        if($(this).val()!=""){
            feathers+=$(this).parent().attr('id')+"="+$(this).val()+"&";
        }
    });

    $(".property-checkbox").each(function()
    {
        if($(this).is(":checked")){
            if($('.js_parentH').find('.property-checkbox[id!="proptype-any-desktop"]').not(":checked").length>0)
            {
                estateTypes+=$(this).val()+",";
            }
        }
    });

    $(".js_typeTransaction").each(function(i, requiredField)
    {
        if($(this).is(":checked")){
            type+=$(this).val()+",";
        }
    });

    if($("#districts").val().length>0)
        districts=$("#districts").val();

        if($("#minArea").val().length>0)
        minArea=$("#minArea").val();

     if($('#rent').hasClass('active'))
     {
        if($('#rent_min').val().length>0 || $('#rent_max').val().length>0)
            rent=$('#rent_min').val()+","+$('#rent_max').val();
            var str="?";
        if($('#mortgage_min').val().length>0 || $('#mortgage_max').val().length>0)
            mortgage=$('#mortgage_min').val()+","+$('#mortgage_max').val();
            var str="?";
     }
     else
     {
        if($('#price_min').val().length>0 || $('#price_max').val().length>0)
        price=$('#price_min').val().replace(/\,/g,"") +","+$('#price_max').val().replace(/\,/g,"") ;
        var str="?";
     }
    if(condition.length>0)
        str+='conditions='+condition.slice(0, -1)+"&";
    if(facilitie.length>0)
        str+='facilities='+facilitie.slice(0, -1)+"&";
    if(kitchen.length>0)
        str+='kitchen='+kitchen.slice(0, -1)+"&";
    if(heating_cooling.length>0)
        str+='heating_cooling='+heating_cooling.slice(0, -1)+"&";
    if(districts.length>0)
        str+='districts='+districts+"&";
    if(minArea.length>0)
        str+='minArea='+minArea+"&";

    if($('#rent').hasClass('active'))
    {
        if(mortgage.length>0)
            str+='mortgage='+mortgage+"&";
        if(rent.length>0)
            str+='rent='+rent+"&";
    }
    else
    {
        if(price.length>0)
        str+='price='+price+"&";
    }
    if(type.length>0)
        str+='type='+type.slice(0, -1)+"&";
    if(estateTypes.length>0)
        str+='estateTypes='+estateTypes.slice(0, -1)+"&";
    if($("#hasPhoto").hasClass("switchOn"))
        str+='has_photo=true&';
    if($("#hasAgent").hasClass("switchOn"))
        str+='has_agent=true&'
    str+='sortBy='+$("#inputGroupSelect1").val();

    if($('#map').length>0)
    {
        let points= $('#js_HiddenMapDrawPoints').val();
        if(!isNullOrEmpty(points))
        {
            str+='&eslistflag=true&eslist='+points;
        }
    }
    window.history.pushState('', 'New Page Title', (str+feathers.slice(0, -1)));
    BindFromByUrl();
    GetStateList(0);
    SetMapCluster();
  //  location.replace();
}
function ClearPenBoundry()
{
    $('#js_HiddenMapDrawPoints').val('');
    $('#js_PenIsActive').val('');
   $('.filterclick').click();
}
function Global_RemoveParam(key, sourceURL)
{
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        if (params_arr.length) rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}

setInterval(function() {
    $('.leaflet-marker-icon').on('click', function() {
        if($(this).attr('title') != undefined){
            window.location.href = ('https://mmelk.ir.ir/v/' + $(this).attr('title'));
            return;
        }

    })
}, 2000);

function SetMapCluster()
{
    $.ajax({
        url: `?mapexists=1${window.location.search.replace('?','&')}`,
        type: "get",
        beforeSend: function () {
            $("#spiner" ).removeClass( "d-none" );
        }
    })
    .done(function (data) {
            addressPoints=eval(data.map);
            mp.setCluster();
            // if(addressPoints.length==0)
            // {
            //     mp.drawBoundary($('#js_boundary').val(),'#F00',0.1);
            // }

        })
    .fail(function (jqXHR, ajaxOptions, thrownError) {
        $( "#spiner" ).addClass( "d-none" );
        //alert('مشکلی در دریافت اطلاعات بوجود آمده است...');

    });
}

function setUrlParams(param,value){
    var url = window.location.href;
    var paramsString = url.split("?");
    var searchParams = new URLSearchParams(paramsString[1]);
    if(param == 'url'){

        url = '/c/'+$('#js_city_name').val()+'/'+value;
        url += searchParams!='' ? `?${searchParams.toString()}` : '';
    }else{

        searchParams.set(param, value);
        //searchParams.set('page', 1);
        url = `${paramsString[0]}?${searchParams.toString()}`;
    }
    location.replace(url);
}

function removeQueryFilter(f){
    var url = window.location.href;
    paramsString = url.split("?")
    var searchParams = new URLSearchParams(paramsString[1]);
    searchParams.delete(f);
    //searchParams.set('page', 1);
    url = `${paramsString[0]}?${searchParams.toString()}`;
    location.replace(url);
}

$('#save-search').on('click',function () {
    $('input[name=title]').val('');
});

$('#submit-save-search').on('click',function () {
    var title = $('input[name=title]').val();
    if(title.replace(/\s/g, "").length == 0){
        $('#title').focus();
        return false;
    }

    var url = window.location.href;
    submitSaveSearch(title,url)
});

// send save-search request
function submitSaveSearch(title,url) {
    $.ajax({
        type: 'POST',
        url: '/save-search',
        data: {_token:$('#js_csrf_token').val(),title: title,url: url},
        error: function(response)
        {
            toast({
                type: 'error',
                text: 'مشکل در ثبت اطلاعات!',
            });
        },
        success: function(response)
        {
            if (response.status == 'true') {
                $("#modalSaveSearch").modal('hide');
                toast({
                    type: 'success',
                    text: 'جستجوی شما با موفقیت ذخیره شد.',
                });

            }
        }
    });
}
