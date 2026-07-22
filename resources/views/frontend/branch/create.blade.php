@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => !empty($model)? l('ویرایش شعبه') :l('ثبت شعبه جدید')
])
@section('main_content')
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
<link rel="stylesheet" href="/vendor/map/leaflet.css" />
<script src="/vendor/map/leaflet.js"></script>
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
    .modal-dialog {
      max-width: 80%!important;
      margin: 1.75rem auto;
      }
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

    @media (min-width: 700px){
    .modal-dialog {
        max-width: 730px;
        margin: 1.75rem auto;
    }
}

    </style>
<!-- Main Theme Styles + Bootstrap-->
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
        <!-- Page content-->
        <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
            <!-- Page content-->
            <div class="row">
                @include('frontend.layouts.sidebar', ['menu' => 'branches'])
                <!-- Page content-->
                <div class="col-lg-9 col-md-12 mb-5 account add-property">
                    <!-- Breadcrumb-->
                    <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{!empty($model)? l('ویرایش شعبه') :l('ثبت شعبه جدید')}}</li>
                        </ol>
                    </nav>
                    <!-- Title-->
                    <div class="mb-4">
                        <h1 class="h2 mb-0">{{!empty($model)? l('ویرایش شعبه') :l('ثبت شعبه جدید')}} </h1>
                    </div>
                    <!-- Basic info-->

                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <li class="fw-bold">{{ $error }}</li>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form  id="js_form_add_state" role="form"  method="POST" action="<?php if (!empty($model)) echo '/profile/branches/update/' . $model->id; else echo '/profile/branches/store'; ?>" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="photoshow" class="photo" value="{{!empty($currentUser)?0:1}}" />
                    <input type="hidden" id="js_csrf_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="js_branches_storeMedia" value="{{ route('branches.storeMedia') }}">
                    <section class="card card-body shadow-sm rounded p-4 mb-4" id="basic-info">
                        <h2 class="h5 mb-4"><i class="fi-info-circle text-primary fs-5 mt-n1 me-2"></i>{{l('اطلاعات شعبه')}}
                        </h2>
                        <div class="row">
                            <div class="col-sm-4 mb-3">
                                <label class="form-label fw-bold" for="name">{{ l('نام شعبه') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text"  id="name" name="name"  value="{{!empty($model)?$model->name:''}}" required>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label fw-bold" for="phone">{{ l('تلفن دفتر') }}</label>
                                <input class="form-control" type="text" id="phone" name="phone" value="{{!empty($model)?$model->phone:''}}">
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label fw-bold">{{ l('نوع شعبه') }}</label>
                                <select name="type" class="form-control select2" >
                                    <option value="">{{ l('انتخاب کنید') }}</option>
                                    <option value="1" {{!empty($model) &&$model->type == 1 ? 'selected' :''}}>{{ l('اداری') }}</option>
                                    <option value="2" {{!empty($model) &&$model->type == 2 ? 'selected' :''}}>{{ l('مغازه') }}</option>
                                </select>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label fw-bold required">{{ l('استان') }}</label>
                                <select name="province_id" id="province_id" class="form-control select2">
                                    <option value="">{{ l('انتخاب کنید') }}</option>
                                    @foreach( $provinces as $item)
                                        <option value="{{$item->id}}"  {{!empty($model) && old('province_id',$model->province_id) == $item->id ? " selected " :''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label fw-bold ">{{l('شهر')}}</label>
                                <select name="city_id" id="city_id" class="form-control select2">
                                    @foreach( $cities as $item)
                                        <option value="{{$item->id}}" {{!empty($model) && old('city_id',$model->city_id) == $item->id ? " selected " :''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label for="address" class="form-label fw-bold">{{ l('آدرس دفتر') }}</label>
                                <textarea class="form-control" name="address" id="address">{{!empty($model)?$model->address:''}}</textarea>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label class="form-label fw-bold">{{ l('محل های فعالیت') }}</label>
                                <select name="districts[]" class="form-control select2 district_id" id="district_id"  multiple style="width: 100%">
                                    @if(isset($districts))
                                    @foreach( $districts as $item)
                                        <option value="{{$item->id}}" {{!empty($model) && in_array($item->id , $model->selectedDistricts) ? "selected" :''}}>{{$item->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class=" my-4" id="photos">

                                {{-- current images --}}
                                <?php

                                if(!empty($model)){
                                    $imageCount = $model->images->count();
                                    if($model->images->count() > 0){
                                        ?>
                                    <div id="images" class=" card mb-3">
                                        <div class="border-bottom card-header">
                                            <strong class="mb-0">{{l('تصاویر فعلی')}}</strong>
                                        </div>
                                        <div class="card-body align-content-center align-items-center d-flex flex-row flex-wrap justify-content-around">
                                            @foreach($model->images->where("is_360","=",0)->where("plan","=",0)->where("hidden","=",0) as $item)
                                                <div id="media-{{$item->id}}" data-id="{{$item->id}}" class="card p-1 rounded dz-preview {{$defaultImage && $defaultImage->id == $item->id ? 'img-cover' : ''}}">
                                                    <div class="mb-0 est-container" style="cursor:pointer">
                                                        <div class="middle">
                                                            <div class="text bg-primary rounded"><i class="fi fi-check"></i></div>

                                                            {{ l('تصویر شاخص') }}

                                                        </div>
                                                        <img src="/upload/images/branch/{{ $item->url() }}" class="w-100 est-img" style="height:250px;margin-bottom:10px">
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
                                <div id="img-upload" class="dropzone uploader text-center dz-clickable rounded mb-2" data-bs-toggle="dropzone" style="width: 100%;z-index:0">
                                    <div class="dz-message" data-dz-message="" style="width:120px;height:120px;border:1px solid;border-radius:25%;padding-top:35px">
                                        <i class="text-[50px] text-gray-500 fa-thin fa-camera" style="font-size:25px"></i>
                                        <div class="uploader-text">
                                            <span class="text-[16px] text-gray-500 font-light">{{l('تصاویر')}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label for="description" class="form-label fw-bold">{{ l('توضیحات') }}</label>
                                <textarea class="form-control" name="description" id="description">{{ !empty($model) ? $model->description : ''}}</textarea>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <p class="help-block">{{ l('برای مشخص کردن موقعیت شعبه روی نقشه، در محل موردنظر کلیک کنید') }}</p>
                                    <div id="branch-map" style="height: 300px"></div>
                                </div>
                                <input type="hidden" name="latitude" id="latitude" value="{{!empty($model) ?$model->latitude:''}}">
                                <input type="hidden" name="longitude" id="longitude" value="{{!empty($model) ?$model->longitude:''}}">
                                <script>
                                    var defaultLatitude = '{{$model->latitude ?? "35.6994838"}}';
                                    var defaultLongitude = '{{$model->longitude ?? "51.334744"}}';
                                    var defaultZoom = 15;
                                    var defaultLocation = [defaultLatitude, defaultLongitude];
                                    var map = L.map('branch-map').setView(defaultLocation, defaultZoom);
                                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                                        attribution: '2021 &copy; <a href="https://ekama.ir">Kama</a>',
                                        maxZoom: 18,
                                        id: 'mapbox/streets-v11',
                                        tileSize: 512,
                                        zoomOffset: -1,
                                        accessToken: 'pk.eyJ1Ijoicm1kZXY2NyIsImEiOiJja3F0a3F6N3cyNXg4MnVvNGQ0bGVubGR3In0.MCnbfbG3ix5IHdXa6CBTRg'
                                    }).addTo(map);
                                    if (defaultLatitude != '35.6994838') {
                                        var marker = L.marker(defaultLocation).addTo(map);
                                        marker.bindPopup("<h5 class='text-bold text-maroon' style='width: max-content;'>{{ l('موقعیت انتخابی شما اینجاست!') }}</h5>").openPopup();
                                    }
                                    var popup = L.popup();

                                    function onMapClick(e) {
                                        popup
                                            .setLatLng(e.latlng)
                                            .setContent("<h5 class='text-bold text-maroon'>{{ l('مکان انتخابی روی نقشه ثبت شد') }}</h5>")
                                            .openOn(map);
                                        var latitude = e.latlng.lat.toString();
                                        var longitude = e.latlng.lng.toString();
                                        $('input[name="latitude"]').val(latitude);
                                        $('input[name="longitude"]').val(longitude);
                                    }
                                    map.on('click', onMapClick);
                                </script>
                            </div>
                            @if($currentUser->isAdmin())
                            <div class="col-sm-4 mb-3">
                                <label for="role" class="form-label fw-bold">{{l('وضعیت')}}</label>
                                <select class="form-control user-status" name="status" id="status">
                                    <option value="0" {{!empty($model) && old('status' , $model->status) == "0" ? " selected " :''}} class="text-success">{{ l('در انتظار تائید') }}</option>
                                    <option value="1" {{!empty($model) && old('status' , $model->status) == "1" ? " selected " :''}} class="text-warning">{{ l('تائید شده') }}</option>
                                </select>
                            </div>

                            @endif
                            <div class="col-md-12">

                            </div>
                        </div>
                    </section>
                    <!-- Action buttons -->
                    <section class="d-sm-flex justify-content-between pt-2">
                        <input type="hidden" name="user_id" value="{{$currentUser->id}}">
                        <button type="submit" class="btn btn-primary btn-lg d-block mb-2">
                            {{!empty($model)? l('ویرایش شعبه') :l('ثبت شعبه جدید')}}
                        </a>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    @include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
    <script src="/vendor/jquery-3.6.0.js"></script>
    <script src="/vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <!-- Main theme script-->
    <script src="{{asset('/assets/js/valid.js')}}"></script>
    <script>
        $('.select2').select2();
    </script>
    <script src="/admin2/dist/js/regions.js"></script>
    <script src="{{asset('/frontend/vendor/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('frontend/vendor/sweetalert2.all.js')}}"></script>
<script>
const toast = swal.mixin({
    toast: true,
    position: 'bottom-left',
    showConfirmButton: false,
    timer: 2500
});
$(document).ready(function()
{
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
    $("#delete").click(function(){
        $("#delete").addClass('d-none');
        $('#preview').attr("src", "");
        $(".photo").val(1);
    });
    getCities();
    getDistricts();


});
$(".remove-img").on("click", function () {
    var branchId = '{{!empty($model)?$model->id:''}}';
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
                    url: '/branches/media/' + id,
                    type: 'DELETE',
                    data: {_token: '{{csrf_token()}}',branch_id:branchId},
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
    url: $('#js_branches_storeMedia').val(),
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
        // default image
        this.on("addedfile", function(file) {
            file.previewElement.addEventListener("click", function() {
                $('#img-upload').find('.dz-preview').removeClass('img-cover');
                $(this).addClass('img-cover');
                var defaultImageId = $(this).attr('data-id');
                $('input[name="default_image"]').val(defaultImageId);
                toast({type: 'success',title: '{{l('تصویر پیش فرض تغییر یافت')}}'});
            });
        });
        if (typeof drop !== 'undefined'){
        for(var c=0;c<drop.length;c++){
            //alert();
            var mockFile = { name: drop[c][0], size: 200000 };
            this.emit("addedfile", mockFile);
            this.emit("thumbnail", mockFile, "/upload/images/branch/"+drop[c][2]);
            this.emit("complete", mockFile);
        }
    }
    },
});
$('#images .dz-preview').on("click", function() {
    // current images
    $('#images').find('.dz-preview').removeClass('img-cover');
    // uploaded images
    $('#img-upload').find('.dz-preview').removeClass('img-cover');
    $(this).addClass('img-cover');
    var defaultImageId = $(this).attr('data-id');
    $('input[name="default_image"]').val(defaultImageId);
    toast({type: 'success',title: '{{l('تصویر پیش فرض تغییر یافت')}}'});
});
$('#images .dz-preview button').click(function(e) {
    e.stopPropagation();
});
</script>
@endsection
