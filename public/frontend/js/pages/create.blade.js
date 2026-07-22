var estateType = 0,activityType = 0;
//
$(document).ready(function(){
$('.select2').select2();
});
getCities();
getDistricts();

// $('form#add').submit(function(e){
//     e.preventDefault();
// });

function delImg() {
    $("#preview").empty();

}

function dragNdrop(elm) {
    var fileName = URL.createObjectURL(elm.target.files[0]);
    var preview = document.getElementById("preview");
    var previewImg = document.createElement("img");
    previewImg.setAttribute("src", fileName);
    preview.innerHTML = "<i onclick='delImg()' class='far fa-trash'></i>";
    preview.appendChild(previewImg);
}


function showlisttwo(estate_type) {
    estateType = estate_type;
    // set value
    $("#estate_type").val(estate_type);
    //if($("#type").val()!="")
        //getMoreFields(estateType,activityType);
}

function showlistthree(type) {
    activityType = type;
    // set value
    $("#type").val(type);

    // check activity type (sale or rent)
    if(type == 1){ // sale
        $('#sale-inputs').show();
        $('#rent-inputs').hide();
        $('.sale').prop('required',true);
        $('.rent').prop('required',false);
    }else if(type == 2){ // rent
        $('#sale-inputs').hide();
        $('#rent-inputs').show();
        $('.sale').prop('required',false);
        $('.rent').prop('required',true);
    }

    if($("#estate_type").val()!="")
        getMoreFields(estateType,activityType);
}


var uploadedDocumentMap = {}
// {{--Dropzone.options.documentDropzone = {--}}
// {{--    init: function () {--}}
// {{--            @if(isset($project) && $project->document)--}}
// {{--        var files =--}}
// {{--        {!! json_encode($project->document) !!}--}}
// {{--            for (var i in files) {--}}
// {{--            var file = files[i]--}}
// {{--            this.options.addedfile.call(this, file)--}}
// {{--            file.previewElement.classList.add('dz-complete')--}}
// {{--            $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')--}}
// {{--        }--}}
// {{--        @endif--}}
// {{--    }--}}
// {{--}--}}
function dropzone(){
$('#img-upload').dropzone ({


    uploadMultiple:false,
    acceptedFiles: ".jpeg,.jpg,.png",// "image/*"
      parallelUploads: 10,
      maxFiles:10,
      maxFilesize: 5,
      maxThumbnailFilesize: 5,
      addRemoveLinks: true,
    dictRemoveFile:"حذف",
    dictCancelUpload:"لغو آپلود",

    url: $('#js_estates_storeMedia').val(),
    headers: {'X-CSRF-TOKEN': $('#js_csrf_token').val()},
    type: 'POST',
    success: function (file, response) {
        file.imgID = response.name;
        $(".dz-preview:last-child").attr('data-id', file.imgID);

        $('form#add').append('<input type="hidden" name="document[]" value="' + response.name + '">')
        uploadedDocumentMap[file.name] = response.name
    },
    removedfile: function (file) {
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
            alert("حداکثر تعداد تصاویر 10 عدد میباشد!");
        });
        this.on("error", function(file, message){
            if(message.indexOf('too big')>0){
            alert("حجم عکس بیش از 5 مگابایت می باشد.");
            this.removeFile(file);
            }

            if(message=="Invalid JSON response from server."){
            this.removeFile(file);
            alert("حجم عکس بیش از 10 مگابایت می باشد.");
            }
        });


        // check dimensions
        this.on("thumbnail", function (file) {
            if (file.height < 600 || file.width < 600) {
                this.removeFile(file);
                alert("حداقل ابعاد تصویر باید 600 در 600 باشد!");
            }
        });

        // default image
        this.on("addedfile", function(file) {
            file.previewElement.addEventListener("click", function() {
                $('#img-upload').find('.dz-preview').removeClass('img-cover');
                $(this).addClass('img-cover');

                var defaultImageId = $(this).attr('data-id');
                $('input[name="default_image"]').val(defaultImageId);

                toast({type: 'success',title: 'تصویر پیش فرض تغییر یافت'});
            });
        });
    },
});
};
dropzone();
map();

function mapedit(x,y){
    var defaultZoom=13;
    var defaultLocation= [x,y];//tehran azadi
        var map = $('#estate-map').kamaMap({zoom:defaultZoom,maxZoom:18,click_zoom:14,zoomControl:true,lat:defaultLocation[0],lng:defaultLocation[1]});
        map.clickMap(true,function(e){
            $('input[name="latitude"]').val(e.markerPoint[0]);
            $('input[name="longitude"]').val(e.markerPoint[1]);
            $('input[name="latitude_secondary"]').val(e.circlePoint[0]);
            $('input[name="longitude_secondary"]').val(e.circlePoint[1]);
        });
    map.showCircle(x,y);
}


function map(){
var defaultZoom=10;
var defaultLocation= [34.619364824739804,50.87802886962891];//tehran azadi

    var map = $('#estate-map').kamaMap({zoom:defaultZoom,maxZoom:18,click_zoom:14,zoomControl:true,lat:defaultLocation[0],lng:defaultLocation[1]});
    map.clickMap(true,function(e){
        $('input[name="latitude"]').val(e.markerPoint[0]);
        $('input[name="longitude"]').val(e.markerPoint[1]);
        $('input[name="latitude_secondary"]').val(e.circlePoint[0]);
        $('input[name="longitude_secondary"]').val(e.circlePoint[1]);
    });
   // map.showCircle(x,y);
}
if($("#estate_type").val()!="" || $("#type").val()!=""){
    //activityType = $("#type").val();
    //estateType = $("#estate_type").val();
   // getMoreFields(estateType, activityType);
}
// get more fields by estate_type and activity_type
function getMoreFields(et,at) {

    $.ajax({
        type: 'POST',
        url: '/estates/get_fields',
        data:{_token:$('#js_csrf_token').val(),estateType:et,activityType:at},
        error: function()
        {
            //alert("خطای دریافت اطلاعات از سرور!");
        },
        success: function(response)
        {
            $('#more-fields').empty().append(response);
            $('#response').html(response);

            $('#more-fields').find('.select2').select2();
            //$('#btn-submit').removeAttr('disabled').trigger('refresh');
            $(".more-btn").removeClass("d-none");
            $(".js_submitbtn").toggleClass("btn-primary btn-secondary");
        }
    });
}

function addRow(tableID,maxCount=10) {
    var imgRow = document.getElementById("imgRow");
    var defaultCount = 10;
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var cellCount = table.rows[0].cells.length;

    if(cellCount < maxCount && cellCount < defaultCount){
        var newImgCell = imgRow.insertCell(-1);
        //newImgCell.innerHTML = table.rows[0].cells[0].innerHTML;
        newImgCell.innerHTML = '<input type="file" name="images[]" class="dropify" id="" data-max-file-size="5M" data-height="100"  data-width="100"/><button type="button" class="btn btn-block btn-outline-danger btn-sm mt-1 mb-1" onclick=" deleteRow(\'galleryTable\',this);"><i class="fa fa-trash-alt pl-2 remove-item"></i>حذف </button>';
        newImgCell.className = 'p-2';
        let newCellInput = newImgCell.getElementsByTagName('input')[0];
        newCellInput.value = '';
        newCellInput.className = 'dropify';
        newCellInput.id = 'img-input-'+cellCount;
        $('input#img-input-'+cellCount).dropify({
            messages: {
                'default': '',
                'replace': 'برای جایگزینی یک فایل را بکشید و رها کنید یا اینجا کلیک کنید',
                'remove': 'پاک کردن',
                'error': 'خطایی رخ داده است.'
            },
            error: {
                'fileSize': 'اندازه فایل بزرگ است. (حداکثر 5 مگابایت)'
            }
        });
    }
}

function getId(element) {
    cellNumber = element.parentNode.cellIndex;
    return cellNumber;
}
$(".js_number").keyup(function () {
    separateNum(this.value, this);
})

function separateNum(value, input) {
    var nStr = value + '';
    nStr = nStr.replace(/\,/g, "");
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    if (input !== undefined) {

        input.value = x1 + x2;
    } else {
        return x1 + x2;
    }
}
function deleteRow(tableID, cellIndex) {
    var targetCell = getId(cellIndex);

    var table = document.getElementById(tableID);
    var cellCount = table.rows[0].cells.length;

    if (cellCount > 1) {
        //var row = document.getElementById("myRow");
        table.rows[0].deleteCell(targetCell);
    }
}

function deletephoto(){
    $(".remove-img").on("click", function () {
        var estateId = '{{$estate->id}}';
        var id = $(this).data('id');

        swal({
            text: " آیا از حذف گزینه مورد نظر اطمینان دارید؟",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'لغو',
            confirmButtonText: 'بله',
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
                                text: 'گزینه مورد نظر با موفقیت حذف شد.',
                                type: 'success',
                                allowOutsideClick: false,
                            }).then((result)=>{
                                $('#images #media-'+id).remove();
                        });

                        })
                        .fail(function () {
                            swal('خطا!', 'حذف با مشکل مواجه شد!', 'error');
                        });
                });
            },
            allowOutsideClick: ()=>!swal.isLoading()
      });
  });
}


// $('#city_id').trigger("change");
// $('#city_id').change(function(){
//     var mapdata = ($(this).val()=="1" ? "[[50.8083253,34.6761356],[50.8194619,34.682805],[50.8333879,34.6749525],[50.8526271,34.6896844],[50.8554893,34.6921721],[50.856176,34.6927367],[50.8486229,34.7012057],[50.8481722,34.7018761],[50.8438163,34.7091101],[50.8436447,34.7099922],[50.844503,34.7108039],[50.8451896,34.7113685],[50.8623558,34.7187082],[50.8699146,34.7215571],[50.879643,34.7217879],[50.8822286,34.7190995],[50.8812424,34.7146371],[50.8796672,34.707509],[50.8795219,34.7068517],[50.8795219,34.7034641],[50.8795219,34.7028995],[50.8822685,34.6978181],[50.8829551,34.6972535],[50.8994346,34.6904783],[50.9009796,34.6902489],[50.9193258,34.6961416],[50.930956,34.6889609],[50.9303337,34.6825739],[50.9310203,34.6820093],[50.9118723,34.6731827],[50.9143887,34.6712083],[50.9165688,34.6694978],[50.9200432,34.6667716],[50.9306341,34.6582238],[50.937522,34.6627247],[50.9443026,34.657894],[50.9399681,34.6554055],[50.9363847,34.651324],[50.9434228,34.6269615],[50.9362413,34.6113812],[50.9434917,34.5984954],[50.957007,34.5790628],[50.9422403,34.5778303],[50.9346354,34.5771956],[50.924592,34.5763573],[50.9202826,34.57551],[50.9047961,34.572465],[50.9001892,34.5715592],[50.8972068,34.5712457],[50.8943506,34.5738332],[50.8783632,34.5787702],[50.8719688,34.5766324],[50.870338,34.5732291],[50.8661323,34.5675758],[50.8517081,34.550162],[50.8436103,34.5465542],[50.8102748,34.5317008],[50.7937139,34.5418703],[50.7837267,34.5492333],[50.7759716,34.5549591],[50.7711091,34.5591054],[50.7679194,34.5645157],[50.7674614,34.5662855],[50.7553793,34.5616925],[50.7459165,34.5840253],[50.7434059,34.5886536],[50.745202,34.5894439],[50.7496286,34.5913917],[50.7566337,34.5942174],[50.7605551,34.5957992],[50.768668,34.6023756],[50.7929097,34.6104994],[50.8124819,34.6251456],[50.8122306,34.634168],[50.8128284,34.6349478],[50.8152059,34.6365987],[50.8170694,34.6374092],[50.8203436,34.6412038],[50.8191602,34.6433569],[50.81914,34.6463331],[50.8192902,34.6481511],[50.8187966,34.6492805],[50.8183898,34.6532227],[50.8179108,34.6578652],[50.8167796,34.6688263],[50.8083253,34.6761356]]":"");
//     //todo: call web service and get map data and set to mapdata variable

//     //pointArray,fillColor,fillOpacity,borderColor,borderWith,borderOpacity
//     map.drawBoundary(mapdata,'#F00',0.1);
// });
// $('#district_id').change(function(){
//     var mapdata = ($(this).val()=="1" ? "[[50.8083253,34.6761356],[50.8194619,34.682805],[50.8333879,34.6749525],[50.8526271,34.6896844],[50.8554893,34.6921721],[50.856176,34.6927367],[50.8486229,34.7012057],[50.8481722,34.7018761],[50.8438163,34.7091101],[50.8436447,34.7099922],[50.844503,34.7108039],[50.8451896,34.7113685],[50.8623558,34.7187082],[50.8699146,34.7215571],[50.879643,34.7217879],[50.8822286,34.7190995],[50.8812424,34.7146371],[50.8796672,34.707509],[50.8795219,34.7068517],[50.8795219,34.7034641],[50.8795219,34.7028995],[50.8822685,34.6978181],[50.8829551,34.6972535],[50.8994346,34.6904783],[50.9009796,34.6902489],[50.9193258,34.6961416],[50.930956,34.6889609],[50.9303337,34.6825739],[50.9310203,34.6820093],[50.9118723,34.6731827],[50.9143887,34.6712083],[50.9165688,34.6694978],[50.9200432,34.6667716],[50.9306341,34.6582238],[50.937522,34.6627247],[50.9443026,34.657894],[50.9399681,34.6554055],[50.9363847,34.651324],[50.9434228,34.6269615],[50.9362413,34.6113812],[50.9434917,34.5984954],[50.957007,34.5790628],[50.9422403,34.5778303],[50.9346354,34.5771956],[50.924592,34.5763573],[50.9202826,34.57551],[50.9047961,34.572465],[50.9001892,34.5715592],[50.8972068,34.5712457],[50.8943506,34.5738332],[50.8783632,34.5787702],[50.8719688,34.5766324],[50.870338,34.5732291],[50.8661323,34.5675758],[50.8517081,34.550162],[50.8436103,34.5465542],[50.8102748,34.5317008],[50.7937139,34.5418703],[50.7837267,34.5492333],[50.7759716,34.5549591],[50.7711091,34.5591054],[50.7679194,34.5645157],[50.7674614,34.5662855],[50.7553793,34.5616925],[50.7459165,34.5840253],[50.7434059,34.5886536],[50.745202,34.5894439],[50.7496286,34.5913917],[50.7566337,34.5942174],[50.7605551,34.5957992],[50.768668,34.6023756],[50.7929097,34.6104994],[50.8124819,34.6251456],[50.8122306,34.634168],[50.8128284,34.6349478],[50.8152059,34.6365987],[50.8170694,34.6374092],[50.8203436,34.6412038],[50.8191602,34.6433569],[50.81914,34.6463331],[50.8192902,34.6481511],[50.8187966,34.6492805],[50.8183898,34.6532227],[50.8179108,34.6578652],[50.8167796,34.6688263],[50.8083253,34.6761356]]":"");
//     //todo: call web service and get map data and set to mapdata variable

//     //pointArray,fillColor,fillOpacity,borderColor,borderWith,borderOpacity
//     map.drawBoundary(mapdata,'#F00',0.1);
// });



