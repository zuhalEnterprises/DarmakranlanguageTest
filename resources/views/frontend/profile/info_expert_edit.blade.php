@section('title', l('ویرایش پروفایل'))
@extends('frontend.profile.layouts.panel')
@section('head')
<link href="{{asset('admin2/plugins/fileuploads/css/dropify.min.css')}}" rel="stylesheet" />
<link href="{{asset('/admin/plugin/select2/4.0.3/css/select2.min.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('/mainpage/css/validationEngine.jquery.css')}}">
<link rel="stylesheet" href="{{asset('/mainpage/css/cropper.css')}}">
<script src="{{asset('/mainpage/js/jquery.validationEngine.js')}}"></script>
<script src="{{asset('/mainpage/js/jquery.validationEngine-fa.js')}}"></script>
<script src="{{asset('/mainpage/js/cropper.js')}}"></script>


<style>
    .form-control.small {
        padding: 1.15rem .5rem !important;
    }

    .form-control {
        font-size: 14px !important;
    }

    .form-select {
        font-size: 14px;
        padding: 8px;
    }

    .lblCode {
        border: 1px solid;
        width: 100%;
        height: calc(1.5em + .75rem + 2px);
        padding: .375rem .75rem;
        font-size: 1.6rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        cursor: pointer
    }


    .card-form-header {
        background: #F7F7F7;
        color: #2E7D32;
        padding: 24px 10px !important;
        /* background-color: red; */
        margin: 0 !important;
    }

    .tooltip1 {
        position: relative;
        display: inline-block;
    }

    .tooltip1 .tooltiptext {
        visibility: hidden;
        width: 140px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 150%;
        left: 50%;
        margin-left: -75px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip1 .tooltiptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .tooltip1:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

    /* Intro Form edit */
    .form-control.small {
        padding: 1.2rem .5rem !important;
    }

    img {
        display: block;
        max-width: 100%;
    }

    .preview {
        overflow: hidden;
        width: 300px;
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }

    .modal-lg {
        max-width: 1000px !important;
    }

    .lblCode {
        border: 1px solid;
        width: 100%;
        height: calc(1.5em + .75rem + 2px);
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        cursor: pointer
    }



    .tooltip1 {
        position: relative;
        display: inline-block;
    }

    .tooltip1 .tooltiptext {
        visibility: hidden;
        width: 140px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 150%;
        left: 50%;
        margin-left: -75px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip1 .tooltiptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .tooltip1:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

    input#mobile {
        text-align: end;
    }

    #bio {
        border: 1px solid #ced4da;
        width: 100%;
    }

    .col-title {
        font-size: 16px;
        font-weight: 700;
    }

    #btnsave {
        display: flex;
        justify-content: center;
        align-items: baseline;
        gap: 6px;
        padding: 6px 20px 8px;
        background-color: #17a2b8;
    }

    #btnsave:hover {
        background-color: #138496;
        color: #fff;
    }
    .card-img{
        height: 214px;
        width: 260px;
    }
    .card-img-box {
        width: 214px;
        height: 214px;
        border: 1px solid #dddddd;
        border-radius: 3px;
    }
    .card-img-box2 {
        width: 100%;
        height: 72px;
        border: 1px solid #dddddd;
        border-radius: 3px;
    }
    .file-icon p {
        font-size: 20px;
        color: #777;
    }
    @media  (max-width:768px) {
        .card-img{
            width: 218px;
        height: auto;
    }
    }
</style>

@endsection
@section('panel_content')
<div class="row">
    <div class="col-lg-12">
        <ul class="breadcrumb">
            <li><a href="/">{{ l('خانه') }}</a></li>
            <li><a href="/dashboard_v2">{{ l('داشبورد') }}</a></li>
            <li>{{ l('ویرایش اطلاعات پروفایل') }}</li>
        </ul>
    </div>
</div>
<div class="card text-right">
    <h5 class="card-header py-3">
        {{ l('ویرایش اطلاعات پروفایل') }}
    </h5>
    <div class="card-body">
        <form method="POST" id="form1" action="{{url('/profile/info/update')}}" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="row">
                <!--div class="col-lg-6 col-md-6 col-sm-12 form-group ">
                    <span class="col-title">{{ l('نام مستعار') }}</span>
                    <span class="col-value">
                        <input type="text" name="title" id="title" class="form-control small" placeholder="{{ l('نام مستعار') }}" value="{{$currentUser->title}}">
                    </span>
                </div-->
                <!--div class="col-lg-6 col-md-6 col-sm-12 form-group ">
                    <span class="col-title">{{ l('شماره موبایل') }}</span>
                    <span class="col-value">
                        <input type="tel" name="phone" id="phone" class="form-control small" placeholder="{{ l('شماره موبایل') }}" value="{{$currentUser->phone}}">
                    </span>
                </div-->
                <div class="col-lg-6 col-md-6 col-sm-12 form-group ">
                    <span class="col-title">{{ l('نام کاربری (آدرس پروفایل)') }}</span>
                    <span class="col-value">
                        <input type="text" name="alias" id="alias" class="form-control small" placeholder="{{ l('آدرس پروفایل') }}" value="{{$currentUser->alias}}" {{$currentUser->alias_status?'disabled':''}}>
                    </span>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 form-group ">
                    <span class="col-title">{{ l('نوع ملک فعالیت') }}</span>
                    <span class="col-value">
                        <select class="form-control property_type" name="activity_estate_type[]" id="activity_estate_type" aria-label="Default select" multiple="multiple">
                            <option value="" disabled>{{ l('انتخاب کنید') }}</option>
                            @foreach(estateTypes() as $key=>$val)
                            <option value="{{$key}}" {{in_array($key , $currentUser->activity_estate_type)?'selected':''}}>{{$val}}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 form-group ">
                    <span class="col-title ">{{ l('تخصص فعالیت') }}</span>
                    <span class="col-value ">
                        <select class="form-select " aria-label="Default select" name="activity_type" id="activity_type">
                            <option value="3">{{ l('هر دو') }}</option>
                            <option value="1" {{$currentUser->activity_type == 1?"selected":""}}>{{ l('فروش') }}</option>
                            <option value="2" {{$currentUser->activity_type == 2?"selected":""}}>{{ l('اجاره') }}</option>

                        </select>
                    </span>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 form-group ">
                    <span class="col-title ">{{ l('محل های فعالیت') }}</span>
                    <div class="col-value row">


                        @php($index = 0)
                        @if(!empty($selectedDistricts))
                        @foreach( $selectedDistricts as $districtId=>$selectCount)
                        @for($i=1;$i<=$selectCount;$i++) @php($index +=1) <div class="col-lg-3 col-md-6 col-sm-6 col-6 mb-3">
                            <select name="districts[]" class="form-select district_id" aria-label="Default select ">
                                @foreach( $districts as $item)
                                <option value="{{$item->id}}" {{$districtId == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                    </div>
                    @endfor
                    @endforeach
                    @endif
                    @for($i = $index + 1;$i<=$user->city->district_selection_count;$i++)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6 mb-3">
                            <select name="districts[]" class="form-select district_id" aria-label="Default select ">
                                <option value="" disabled selected>{{ l('انتخاب کنید') }}</option>
                                @foreach( $districts as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endfor





                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 form-group ">
                <span class="col-title ">{{ l('درباره من') }}</span>
                <span class="col-value ">
                    <textarea name="bio" id="bio" rows="10">{{$currentUser->status_bio==1?$currentUser->temp_bio:$currentUser->bio}}</textarea>
                </span>
            </div>
            <input type="hidden" name="images1" class="images1" />
            <input type="hidden" name="images2" class="images2" />
            <input type="hidden" name="photoshow" class="photo" value="{{!empty($currentUser)?0:1}}" />
            <input type="hidden" name="profile_covershow" class="profile_cover1" value="{{!empty($currentUser)?0:1}}" />
            <div class="col-lg-6 col-md-6 col-sm-12 form-group ">



                <label for="photo" class="control-label col-title ">{{ l('تصویر پروفایل') }}</label>
                <div class="text-center">
                    <div class='card-img-box'>
                        <img src="{{ old('photo',$currentUser->photo()) }}" id="preview" />
                    </div>
                </div>
                <div class="d-flex justify-content-start gap-2 align-items-center">
                    <a class="btn btn-primary text-light mt-3" onclick="document.getElementById('photo1').click()">{{ l('انتخاب فایل') }}</a>
                    <a id="delprofile" class="btn btn-danger text-light mt-3" style="width:100px;cursor:pointer">{{ l('حذف') }}</a>
                </div>
                <input type="file" name="image" class="image" id="photo1" accept=".jpg,.png,.jpeg" style="display:none">
                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">

                            <div class="">
                                <div class="img-container">
                                    <div class="row">
                                        <div style="width:80%;margin:0 auto">
                                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                                        </div>
                                        <div style="display:none" class="preview"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-black" id="cancel" data-dismiss="modal">{{ l('انصراف') }}</button>
                                <button type="button" class="btn btn-primary" id="crop">{{ l('بریدن') }}</button>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <div class="w-100 mt-2 btn-store">
                <button type="submit" class="btn btn-info" id="btnsave">
                    <i class="d-inline fa fa-check"></i> {{ l('ذخیره') }}
                </button>
            </div>
    </div>
    </form>
</div>
</div>
<input type="hidden" id="js_csrf_token" value="{{ csrf_token() }}">
<script>
    var $modal = $('#modal');
    var image = document.getElementById('image');
    var cropper;

    var $modal1 = $('#modal1');
    var image1 = document.getElementById('image1');
    var cropper1;

    $("#cancel").click(function() {
        $modal.modal('hide');
    });
    $("#cancel1").click(function() {
        $modal1.modal('hide');
    });
    $("body").on("change", ".image", function(e) {
        var fileName = document.getElementById("photo1").value;
        var idxDot = fileName.lastIndexOf(".") + 1;

        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {

        } else {
            document.getElementById("photo1").value = "";
            return false;
        }

        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $("body").on("change", ".profile_cover", function(e) {
        var fileName = document.getElementById("profile1").value;
        var idxDot = fileName.lastIndexOf(".") + 1;

        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {

        } else {
            document.getElementById("profile1").value = "";
            return false;
        }



        var files = e.target.files;


        var done = function(url) {
            image1.src = url;
            $modal1.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) { file = files[0]; if (URL) { done(URL.createObjectURL(file)); } else if (FileReader) { reader = new FileReader(); reader.onload = function(e) { done(reader.result); }; reader.readAsDataURL(file); } } }); $modal.on('shown.bs.modal', function() { cropper = new Cropper(image, { aspectRatio: 1, viewMode: 3, preview: '.preview' }); }).on('hidden.bs.modal', function() { cropper.destroy(); cropper = null; }); $modal1.on('shown.bs.modal', function() { cropper1 = new Cropper(image1, { aspectRatio: 12 / 3, viewMode: 3, preview: '.preview' }); }).on('hidden.bs.modal', function() { cropper1.destroy(); cropper1 = null; }); $("#crop").click(function() { canvas = cropper.getCroppedCanvas({ width: 250, height: 250, }); canvas.toBlob(function(blob) { url = URL.createObjectURL(blob); var reader = new FileReader(); reader.readAsDataURL(blob); reader.onloadend = function() { var base64data = reader.result; $('#preview').attr('src', base64data); $(".images1").val(base64data); $modal.modal('hide'); /* $.ajax({ type: "POST", url: '/estates/get_fields1', data: {_token:$('#js_csrf_token').val(),image: base64data}, error: function() { alert(l("خطای دریافت اطلاعات از سرور!")); },success: function(data){ $modal.modal('hide'); alert("success upload image"); } });*/ } }); }); $("#crop1").click(function() { canvas1 = cropper1.getCroppedCanvas({ width: 1280, height: 853, }); canvas1.toBlob(function(blob) { url = URL.createObjectURL(blob); var reader = new FileReader(); reader.readAsDataURL(blob); reader.onloadend = function() { var base64data = reader.result; $('#preview1').attr('src', base64data); //alert('adadadad'); $(".images2").val(base64data); $modal1.modal('hide'); } }); });
</script>
<style>

</style>
@endsection
@section('js')
<script src="{{asset('admin2/plugins/fileuploads/js/dropify.min.js')}}"></script>
<script src="{{asset('/admin2/plugins/select2/4.0.3/js/select2.min.js')}}"></script>
<script src="{{asset('/admin2/dist/js/persian-date-0.1.8.min.js')}}"></script>
<script src="{{asset('/admin2/dist/js/persian-datepicker-0.4.5.min.js')}}"></script>
<script type="text/javascript">
    $('.select-lang').select2();
    $('.property_type').select2();
    $('.dropify').dropify({
        messages: {
            'default': l('برای جایگزینی یک فایل را بکشید و رها کنید یا اینجا کلیک کنید'),
            'replace': '',
            'remove': l('پاک کردن'),
            'error': l('خطایی رخ داده است.')
        },
        error: {
            'fileSize': l('اندازه فایل بزرگ است. (حداکثر 5 مگابایت)')
        }
    });
    $(document).ready(function() {
        $('#btnsave').on('click', function() {
            var flag=0;
           // alert($("#phone").val().length);
            if($("#phone").val().length!=11){
                alert($("#phone").val().length);
                flag++;
                swal({
                    text: l("اطلاعات موبایل را به درستی وارد کنید"),
                    confirmButtonColor: '#faa61a',
                    confirmButtonText: l('تایید')
                });

            }
            var letters = /^[0-9a-zA-Z-]+$/;
            var name = $('#alias').val();
            if ($("#alias").val().match(letters) && $("#alias").val().length > 3) {


            } else {

                flag++;
                swal({
                    text: l("نام کاربری (آدرس پروفایل) بایستی از حروف لاتین, - و ارقام تشکیل شده و حداقل 4 کاراکتر باشد"),
                    confirmButtonColor: '#faa61a',
                    confirmButtonText: l('تایید')
                });

            }
            if(flag>0)
                return false;
            else
                return true;

        });
        $(".dropify-clear").on("click", function() {
            $("." + $(this).siblings("input").attr('id')).val(1);
        });

        $("#delprofile").on("click", function() {
            $(".photo").val(1);
            $("#preview").attr('src', '');
            $(".images1").val('');
        });
        $("#delprofilecover").on("click", function() {
            $(".profile_cover1").val(1);
            $("#preview1").attr('src', '');
            $(".images2").val('');
        });
    })
</script>
@endsection
