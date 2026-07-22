$(document).ready(function () {

    //if not remove agarea
    
    
      // Add Tags
      $(".dropdown").on("click", ".form-select > option", function () {
          
        if (!$(this).hasClass("added")) {
            var parentId = $(this).parent().attr('id');
          console.log(parentId);
              var text = $('#lbl'+parentId).text();
              var text2 = $(this).text();
          console.log(text);
            console.log(text2);
          if($(this).val() != ''){
              $('#tag_'+parentId+' .pill-value').text(text2)
          }
          //$(this).addClass("added");
          console.log($('#tag_'+ parentId).length);
         if($('#tag_'+ parentId).length < 1){ 
          $(".tag-area").append('<div id="tag_'+ parentId +'" data-id="'+ parentId +'" class="search-pill font_11 secondary-pill me-1 mb-1 radius-4 pos-r py-1"> <div> <div class="pill-value">' + $(this).text() + '</div> <div class="pill-category">'+ $('#lbl'+parentId).text() + '</div> </div> <button id="'+ $(this).val() +'" type="button" class="btn btn-link btn-close pos-abs"> </button> </div>');
         }
          $('.pos-rr').removeClass("d-none");
        }
        
            if($(this).val() == ''){
                $('#tag_'+ parentId).remove();
                if($('.tag-area .search-pill').length == 0){
                 $('.pos-rr').addClass("d-none");
                }
          }
      });
    
      // Remove Tags
      $(".pos-rr").on("click", ".btn-close", function () {
        $(this).parent().remove();
        $('select#'+$(this).parent().attr('data-id') + ' option[value=""]').prop('selected',true);
        //var objectText = $(this).parent().text().slice(0, -1);
        var idclose = $(this).attr('id');
        
        $('.form-select > option[value="' + idclose + '"]').removeClass("added");
        var cont = $('.tag-area .search-pill').length;
        
        if(cont == 0)
        {
            $('.pos-rr').addClass("d-none");
        }
        
        
      });
    
    
    
     var descMinHeight = 58;
      var desc = $('.search-pill-wrapper');
      var descWrapper = $('.tag-area');
    
      // show more button if desc too long
      if (desc.height() > descWrapper.height()) {
        $('.more-info').show();
      }
      
      // When clicking more/less button
      $('.more-info').click(function() {
       // $('.search-pill-wrapper').css({"maxHeight":descWrapper.height()+40});
        var fullHeight = $('.search-pill-wrapper').height();
    
        if ($(this).hasClass('expand')) {
          // contract
          $('.tag-area').animate({'height': descMinHeight}, 'slow');
        }
        else {
          // expand 
          $('.tag-area').css({'height': descMinHeight, 'max-height': 'none'}).animate({'height': fullHeight}, 'slow');
        }
    
        $(this).toggleClass('expand');
        return false;
      });
    }); 

var page = 1,
hasPage = true;
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() >= $(document).height() && hasPage) {
        page++;
        loadMoreData(page);
    }
});

function loadMoreData(page){
    
    $.ajax({
        url: '?page=' + page,
        type: "get",
        beforeSend: function () {
            $( "#spiner" ).removeClass( "d-none" );
        }
    }).done(function (data) {
            hasPage = data.hasPage;
            $( "#spiner" ).addClass( "d-none" );

            if (data.length == 0) {
                return;
            }

            $("#estate-wrapper").append(data.html);
            
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            $( "#spiner" ).addClass( "d-none" );
            alert('مشکلی در دریافت اطلاعات بوجود آمده است...');
            
        });
    };

    $(document).ready(function(){
        checkMoreFiled();
        var inttypesale=1;
        var arrpush=[];
        $('.select2').select2();
    $(".typeTransaction").click(function(){
        //checkMoreFiled();
          
        $(".typeTransaction").parent().parent().removeClass("active");
    
        $(this).parent().parent().addClass("active");
        if($(this).parent().parent().attr('id')=="sell"){
            $("#price1show").removeClass('d-flex').addClass('d-none');
            $("#priceshow").removeClass('d-none').addClass('d-flex');
            $(".typeTransaction").removeAttr('checked');
            $(this).attr('checked',true);
            
        }
        else if($(this).parent().parent().attr('id')=="rent")
        {
            inttypesale=2;
            $("#price1show").removeClass('d-none').addClass('d-flex');
            $("#priceshow").removeClass('d-flex').addClass('d-none');
            $(".typeTransaction").removeAttr('checked');
            $(this).attr('checked',true);
        }
        checkMoreFiled();
    
    });
    $(".property-checkbox").click(function(){
        if($(this).attr("checked")){
            $(this).removeAttr("checked", '');
        }
        else{
            $(this).attr("checked", '');
        }
        checkMoreFiled();
    });
    
    
    });
    
    function checkMoreFiled(){
        var array=[]
        var salekind=1;
        $(".property-checkbox").each(function()
        { 
            if($(this).attr('checked')){
                
                array.push($(this).val());
            }
        });
        $(".typeTransaction").each(function(i, requiredField)
        {
            if($(this).attr('checked')){
                salekind=$(this).val();
            }
        });
        //alert(array);
       if(array==''){
            getMoresearchFields([0],salekind);
    
       }
        else
            getMoresearchFields(array,salekind);  
    }
        //setEstateTypeFilter();
        var selectedCity = '{{$city->name_en}}';
        var q = '{{$q ?? ''}}';
        var price_range = <?php echo json_encode($price);?>;
        //$('#price_min option[value="'+price_range[0]+'"]').prop('selected');
        // $('#price_max option[value="'+price_range[1]+'"]').prop('selected');
        $('#price_min').val(price_range[0]).trigger('change');
        $('#price_max').val(price_range[1]).trigger('change');
    
    
    
        var selectedDistricts = <?php echo json_encode($selectedDistricts);?>;
        $('#districts').val(selectedDistricts).trigger('change');
    
        // $('select#districts').on('change', function (e) {
        //     var selected = $(e.target).val();
        //     console.log(selected);
        // });
    
        $('input[name=q]').keyup(function (e) {
            alert("dsdsds");
    
            if(e.keyCode == 13){
                $("#filterclick").trigger("click");
                //setUrlParams('q',val);
            }
        });
    
        function setQueryFilter(elm){
            var val = $('select#districts').val();
            setUrlParams('districts',val);
        }
    
        function setDistrictFilter(elm){
            var val = $('select#districts').val();
            setUrlParams('districts',val);
        }
    
        function setPriceFilter(elm){
            var pmin = $('#price_min').val();
            var pmax = $('#price_max').val();
    
            if(pmin.length == 0 && pmin.length == 0 ){
                return false;
            }
    
            var val = [pmin,pmax];
            setUrlParams('price',val);
        }
    
        function setEstateTypeFilter(et){
            setUrlParams('url',et)
        }
        function setEstateTypeFilter(){
           // setUrlParams('url','buy#buy-apartment#c')
        }
    
    
        function setPhotoFilter(cb){
          //  var val = cb.checked?'true':'false';
            setUrlParams('has_photo',cb)
        }
    
    $(document).ready(function(){
        
            
            //alert(searchParams);
    
        $("#filterclick").click(function(){
        
            var condition="";
            var facilitie="";
            var kitchen="";
            var heating_cooling="";
            var feathers="";
            var estateTypes="";
            var type="";
            var districts="";
            var price="";
    
            $(".condition").each(function(){
                if($(this).prop('checked')){
                    if($(this).val()!="undefined"){
                        condition+=$(this).val()+",";
                    }
                }
            });
            
            $(".facilities").each(function(){
                if($(this).prop('checked')){
                    if($(this).val()!="undefined"){
                        facilitie+=$(this).val()+",";
                    }
                }
            });
            $(".kitchen").each(function(){
                if($(this).prop('checked')){
                    if($(this).val()!="undefined"){
                        kitchen+=$(this).val()+",";
                    }
                }
            });
            
            $(".heating_cooling").each(function(){
                if($(this).prop('checked')){
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
                if($(this).attr('checked')){     
                    estateTypes+=$(this).val()+",";
                }
            });
            $(".typeTransaction").each(function(i, requiredField)
            {
                if($(this).attr('checked')){
                    type+=$(this).val()+",";
                }
            });
            if($("#districts").val().length>0)
                districts=$("#districts").val();
    
            if($('#price_min').val().length>0 || $('#price_max').val().length>0)
                price=$('#price_min').val()+","+$('#price_min').val()
            var str="?";
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
            if(price.length>0)
                str+='price='+price+"&";
            if(type.length>0)
                str+='type='+type.slice(0, -1)+"&";
            if(estateTypes.length>0)
                str+='estateTypes='+estateTypes.slice(0, -1)+"&";
            if($("#q").val().length>0)
                str+='q='+$("#q").val()+"&";
            if($("#hasPhoto").hasClass("switchOn"))
                str+='has_photo=true&';
            if($("#hasAgent").hasClass("switchOn"))
                str+='has_agent=true&'
            str+='sortBy='+$("#inputGroupSelect1").val()+"&";
            location.replace((str+feathers).slice(0, -1));    
            
           // setUrlParams('facilities',codition);
        })
    });
        function setUrlParams(param,value){
            var url = window.location.href;
            var paramsString = url.split("?");
            var searchParams = new URLSearchParams(paramsString[1]);
    
            if(param == 'url'){
    
                url = '/c/'+selectedCity+'/'+value;
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
                data: {_token:'{{csrf_token()}}',title: title,url: url},
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
        function getMoresearchFields(et,at) {

            $.ajax({
                type: 'POST',
                url: '/estates/get_search_fields',
                data:{_token:'{{csrf_token()}}',estateType:et,activityType:at},
                error: function()
                {
                    //alert("خطای دریافت اطلاعات از سرور!");
                },
                success: function(response)
                {
                    console.log(response);
                    //$('#more-fields').empty().append(response);
            
                   
            
                    $('#apartment-rent').html(response);
                    //alert($('#showgroup').html());
                        // Loop through each div element with the class box
                        
                    //$('#more-fields').find('.select2').select2();
                    //$('#btn-submit').removeAttr('disabled').trigger('refresh');
                    var url = window.location.href;
                    var paramsString = url.split("?");
                    var searchParams = new URLSearchParams(paramsString[1])+ '';
                    var arr = searchParams.split('&');
                    //alert(searchParams);
                    for(var i=0;i<arr.length;i++){
                        var arr1 = arr[i];
                        var arr2=arr1.split("=");
                        var arr21=arr2[0];
                        if(arr21=="conditions") 
                        {
                            var arr3=arr2[1];
                            var arr4=arr3.split("%2C");
                            for(var j=0;j<arr4.length;j++){
                                $("#conditions"+arr4[j]).attr('checked','true') ;
                            }
                        }
                        
                        
                        else if(arr21=='facilities') 
                        {
                            var arr3=arr2[1];
                            var arr4=arr3.split("%2C");
                            
                           for(var j=0;j<arr4.length;j++){
                                $("#facilities"+arr4[j]).attr('checked','true') ;
                            }
                        }
                        else if(arr21=='kitchen') 
                        {
                            var arr3=arr2[1];
                            var arr4=arr3.split("%2C");
                            for(var j=0;j<arr4.length;j++){
                                $("#kitchen"+arr4[j]).attr('checked','true') ;
                            }
                        }
                        else if(arr21=='heating_cooling') 
                        {
                            var arr3=arr2[1];
                            var arr4=arr3.split("%2C");
                            for(var j=0;j<arr4.length;j++){            
                                $("#heating_cooling"+arr4[j]).attr('checked','true') ;
                            }
                        }
                        else if(arr21=='q') {}
                        else if(arr21=='price'){}
                        else if(arr21=='type'){}
                        else if(arr21=='districts'){}
                        else if(arr21=='estateTypes'){}
                        else if(arr21=='price'){}
                        else if(arr21=='mortgage'){}
                        else{
                            var arr3=arr2[1];
                            $("#"+arr21+" select").val(arr3).change();
                        }
                        
            
                        
            
                    }
            
                }
            });
            }
            
            $(document).ready(function()
            {
            
            $('.switch').click(function()
            {
                $(this).toggleClass("switchOn");
            });
            
            });    