@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => l('ویرایش اطلاعات'),
])
@section('main_content')
<link rel="stylesheet" href="{{asset('/mainpage/css/cropper.css')}}">
<!-- Vendor Styles-->
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
<!-- Main Theme Styles + Bootstrap-->
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => '6'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{l('اطلاعات حساب کاربری')}}</li>
                    </ol>
                </nav>
                <!-- Page content-->
                <div class="mb-4">
                    <h1 class="h2">{{l('اطلاعات حساب کاربری')}}</h1>
                </div>
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
                @endif

                <form class="bg-gray-100 p-6 rounded-2xl mt-2 md:mt-0 " method="POST" action="{{url('/profile/info/update')}}" enctype="multipart/form-data" id="myform">
                    @csrf
                    @method('put')
                    <input type="hidden" id="activity_type" name="activity_type" />
                    <input type="hidden" name="images1" class="images1" />
                    <input type="hidden" name="images2" class="images2" />
                    <input type="hidden" name="photoshow" class="photo" value="0" />
                    <section class="card card-body shadow-sm rounded p-4 mb-4" id="basic-info">
                        <div class="row pb-2">
                            <div class="col-lg-9 col-sm-8 mb-4">
                                <label class="form-label fw-bold" for="account-bio">{{l('توضیح مختصر')}}</label>
                                <textarea class="form-control" name="bio" id="desc-state" rows="7" placeholder="{{l('بیوگرافی خود را اینجا بنویسید')}}">{{$currentUser->status_bio==1?$currentUser->temp_bio:$currentUser->bio}}</textarea>
                            </div>
                            <div class="col-lg-3 col-sm-4 mb-4">
                                <div class="d-flex flex-column gap-1 align-items-center" >

                                    <p class="form-label fw-bold">{{l('بارگزاری تصویر پروفایل')}}</p>
                                    @if(!empty($currentUser->photo()))
                                    <div onclick="document.getElementById('photo1').click()" data-target="#photo1">
                                        <img src="{{ old('photo',$currentUser->photo()) }}" id="preview" style="border-radius: 50%;width: 159px;height: 159px;" />
                                    </div>
                                    @endif
                                    @if(empty($currentUser->photo()))
                                    <i class="fa-thin fa-cloud-arrow-up text-[36px]"></i>
                                    @endif

                                    <a id="delete" class="cursor-pointer absolute bottom-7 left-0 text-blue-500 text-[14px] font-light {{(!empty($currentUser) && !empty($currentUser->photo))?'':'d-none'}}">{{l('حذف')}}</a>

                                </div>
                                <input type="file" name="image" class="image" id="photo1" accept=".jpg,.png,.jpeg" style="display:none">
                                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
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
                                                <button type="button" class="btn btn-black" id="cancel" data-dismiss="modal">{{l('انصراف')}}</button>
                                                <button type="button" class="btn btn-primary" id="crop">{{l('بریدن')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="name" class="form-label fw-bold required">{{l('نام')}}</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{old('name',$currentUser->name)}}" required>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="name" class="form-label fw-bold required">{{l('نام خانوادگی')}}</label>
                            <input id="last_name" type="text" class="form-control" name="last_name" value="{{old('last_name',$currentUser->last_name)}}" required>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold" for="name">{{l('تغییر رمز عبور')}}</label>
                            <input class="form-control" type="password" type="text" id="password" name="password">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold" for="mobile">{{l('تکرار رمز عبور جدید')}}
                            </label>
                            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation">
                        </div>
                        @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 2 || env('COUNTRY') == 'UAE')
                            @include(ss('THEME').'.frontend.profile.info_edit_v2')
                        @endif
                        <div class="d-flex align-items-center justify-content-between border-top mt-4 pt-4 pb-1">
                            <button type="submit" id="btnsave" class="btn btn-primary px-3 px-sm-4" type="button">{{l('ذخیره تغییرات')}}</button>
                        </div>
                    </section>
                </form>
            </div>
        </div>
        <input type="hidden" id="js_csrf_token" value="{{ csrf_token() }}">
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script src="{{asset('/mainpage/js/cropper.js')}}"></script>
<script src="/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/vendor/simplebar/dist/simplebar.min.js"></script>
<script src="/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
<script src="{{asset('/frontend/vendor/dropzone/dropzone.min.js')}}"></script>
<!-- Main theme script-->
<script>
    $(document).ready(function(){
        $("#delete").click(function(){
            $("#delete").addClass('d-none');
            $('#preview').attr("src", "");
            $(".photo").val(1);
        });
    });
    var $modal = $('#modal');
    var image = document.getElementById('image');
    var cropper;
    $("#cancel").click(function() {
        $modal.modal('hide');
        // $('#js_blure_overlay').hide()
        // $('#js_overlay').hide()
        // $('body').css({
        //     overflow: "auto"
        // })
    });
    $("body").on("change", ".image", function(e) {
        var fileName = document.getElementById("photo1").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {} else {
            document.getElementById("photo1").value = "";
            return false;
        }
        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            $modal.modal('show');
            // $('#js_blure_overlay').show()
            // $('#js_overlay').show()
            // $('body').css({
            //     overflow: "hidden"
            // })
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
    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });
    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 250,
            height: 250,
        });
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;
                $('#preview').attr('src', base64data);
                $(".images1").val(base64data);
                $("#delete").removeClass("d-none");
                $modal.modal('hide');
                // $('#js_blure_overlay').hide()
                // $('#js_overlay').hide()
                // $('body').css({
                //     overflow: "auto"
                // })
            }
        });
    });
    //dropzone();
</script>
@endsection
