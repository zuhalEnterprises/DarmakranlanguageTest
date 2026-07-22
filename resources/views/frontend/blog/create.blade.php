@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
'title' => !empty($model)? l('ویرایش مطلب') :l('ثبت مطلب')
])
@section('main_content')
<link rel="stylesheet" href="{{asset('/mainpage/css/cropper.css')}}">
<!-- Vendor Styles-->
<link rel="stylesheet" media="screen" href="/vendor/simplebar/dist/simplebar.min.css" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
<script src="{{asset('/vendor/tinymce/tinymce.min.js') }}"></script>
<!-- Main Theme Styles + Bootstrap-->
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => 'article'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <!-- Breadcrumb-->
                <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            @if(empty($model))
                                {{l('ایجاد پست جدید')}}
                            @else
                                {{l('ویرایش پست')}}
                            @endif
                        </li>
                    </ol>
                </nav>
                <!-- Page content-->
                <div class="mb-4">
                    <h1 class="h2">
                        @if(empty($model))
                            {{l('ایجاد پست جدید')}}
                        @else
                            {{l('ویرایش پست')}}
                        @endif
                    </h1>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form  id="js_singup"
                    role="form"
                    method="POST"
                    enctype="multipart/form-data"
                    action="<?php if (!empty($model)) echo '/profile/posts/update/' . $model->id; else echo '/profile/posts/store'; ?>">
                @csrf
                <div class="card card-body shadow-sm rounded p-4 mb-4">
                     <div class="row">
                        <div class="col-md-7 mb-4">
                            <label for="name" class="form-label fw-bold required">{{l('عنوان')}}</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{!empty($model)?$model->title:''}}" required>
                        </div>
                        <div class="col-md-5 mb-4">
                            <label for="name" class="form-label fw-bold required"> {{l('مجموعه')}}</label>
                            <select class="form-select"  name="category_id" id="category_id" aria-label="Default select example">
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}"  @php echo (!empty($model) && $model->category_id == $category->id ? "selected" :'') @endphp>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="name" class="form-label fw-bold "> {{l('تصویر')}}</label>
                            <div class="input-group mb-3" style="direction: ltr;">
                              <input type="file" class="form-control" name="image"  id="upload-file-info" aria-label="Example text with button addon" aria-describedby="button-addon1">
                            </div>
                        </div>
                        @if(ss('SITE_ID') == 2)
                        <div class="col-12 mb-4">
                            <label for="name" class="form-label fw-bold ">{{ l('فیلم آپارات') }}</label>
                            <div class="input-group mb-3">

                                <input type="text" style="direction: ltr" class="form-control" name="video" id="video" value="{{!empty($model)?$model->video:''}}">
                            </div>
                        </div>
                        @endif
                        <div class="col-12 mb-4">
                            <label for="summary" class="form-label fw-bold required">{{l('خلاصه مطلب')}}</label>
                            <textarea type="text" class="form-control" name="description" required id="description" style="height:100px" >{{!empty($model)?$model->description:''}}</textarea>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="body" class="form-label fw-bold "> {{l('توضیحات')}}</label>
                            <textarea  class="form-control" name="body" id="editor1" autofocus rows="30">{{!empty($model)?$model->body:''}}</textarea>
                            <script type="text/javascript">
                                tinymce.init({
                                    selector: "#editor1",
                                    relative_urls: false,
                                    remove_script_host: false,
                                    /*theme: "inlite",*/
                                    directionality : @if (env('COUNTRY') == 'UAE') "ltr" @else "rtl" @endif,
                                    plugins: [
                                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                                        "insertdatetime media nonbreaking save table contextmenu directionality",
                                        "emoticons template paste textcolor colorpicker textpattern"
                                    ],
                                    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image|print preview media | forecolor backcolor emoticons",
                                    image_advtab: true,
                                    templates: [
                                        {title: 'Test template 1', content: 'Test 1'},
                                        {title: 'Test template 2', content: 'Test 2'}
                                    ],
                                    // without images_upload_url set, Upload tab won't show up
                                    images_upload_url: '/upload.php',
                                    // override default upload handler to simulate successful upload
                                    images_upload_handler: function (blobInfo, success, failure) {
                                        var xhr, formData;
                                        xhr = new XMLHttpRequest();
                                        xhr.withCredentials = false;
                                        xhr.open('POST', '/upload.php');
                                        xhr.onload = function() {
                                            var json;
                                            if (xhr.status != 200) {
                                                failure('HTTP Error: ' + xhr.status);
                                                return;
                                            }
                                            json = JSON.parse(xhr.responseText);
                                            if (!json || typeof json.location != 'string') {
                                                failure('Invalid JSON: ' + xhr.responseText);
                                                return;
                                            }
                                            success(json.location);
                                        };
                                        formData = new FormData();
                                        formData.append('file', blobInfo.blob(), blobInfo.filename());
                                        xhr.send(formData);
                                    }
                                });
                            </script>
                        </div>
                        @if(ss('SITE_ID') == 3 && 0)
                        <div class="col-12 mb-4">
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
                            <select class="form-control select2" multiple="multiple" style="width: 100%;direction:ltr"></select>
                            <script src="https://code.jquery.com/jquery-3.3.1.min.js"
                                    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                                    crossorigin="anonymous"></script>

                            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
                                    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
                                    crossorigin="anonymous"></script>

                            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>

                            <script>
                                $('.select2').select2({
                                    data: [],
                                    tags: true,
                                    maximumSelectionLength: 10,
                                    tokenSeparators: [',', ' '],
                                    placeholder: "Select or type keywords"
                                });
                            </script>
                        </div>
                        @endif

                        <div class="col-6 mb-4">
                            <label for="name" class="form-label fw-bold">{{l('تاریخ انقضا')}}</label>
                            <input type="text"  class="form-control date-picker rounded pe-5" name="expire_at" id="expire_at"  value="{{$expire_at}}"  data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold">
                                {{l('تگ')}}
                            </label>

                            <select class="form-select  select3"  multiple="multiple"  name="tags[]" id="tags">
                                <option value="" disabled>{{l('انتخاب تگ')}}</option>
                                @foreach($tags as $ci)
                                <option value="{{$ci->name}}" {{!empty($model) && is_array($tag_selected) && in_array($ci->id , $tag_selected) ? "selected" :''}}>{{$ci->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="name" class="form-label fw-bold">{{l('صفحات مستقل')}}</label>
                            <input type="checkbox" name="type" id="type" value="page" {{!empty($model)?($model->type == 'page'?"checked":''):''}}>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">{{l('ذخیره')}}</button>
                        </div>
                     </div>
                </div>
                </form>
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script>
$(document).ready(function() {
    $('#js_singup').validate({
        errorPlacement: function (error, element) {
            var type = $(element).attr('cus-valid')
            if (type == 'true') {
                error.insertAfter(element.parent().parent());
            } else {
                error.insertAfter(element)
            }
        },
    });
});
</script>


<link rel="stylesheet" href="/admin2/dist/css/persian-datepicker-0.4.5.min.css" />
<!-- custom css -->
<link href="/admin/css/date_picker/kamadatepicker.css" rel="stylesheet">
<script src="/admin/js/date_picker/kamadatepicker.js"></script>
<script>

    var customOptions = {
        placeholder: "{{l('روز / ماه / سال')}}"
        , twodigit: false
        , closeAfterSelect: true
        , nextButtonIcon: "fa fa-angle-right"
        , previousButtonIcon: "fa fa-angle-left"
        , buttonsColor: "#37b5b5"
        , forceFarsiDigits: true
        , markToday: true
        , markHolidays: true
        , highlightSelectedDay: true
        , sync: true
        , gotoToday: true
    };
    kamaDatepicker('expire_at', customOptions);

    $('.select3').select2({
        tags: true
    });
</script>
@endsection

