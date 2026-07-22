@section('title', l('ویرایش ملک'))
@extends('frontend.layouts.app')

@section('head')
    <link rel="stylesheet" href="{{asset('/vendor/map/leaflet.css')}}"/>
    <script src="{{asset('/vendor/map/leaflet.js')}}"></script>
    <script src="{{asset('/frontend/js/jquery-1.9.1.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/basic.min.css')}}"/>

    <link href="{{asset('/admin/plugin/select2/4.0.3/css/select2.min.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('main_content')

    @include('frontend.layouts.header')

    <!---------start main part--------->

    <div class="submit-post" id="submit-post" style="display: block">

        <div class="kt-container">
            <div class="grid-submit ">
                <div class="row ">
                    <div class="submit-col ">
                        <h1 class="sabt" style="margin: 0 !important;">{{ l('ویرایش ملک') }}</h1>
                        <p class="px-3">
                            {{ l('نوع ملک :') }} <span class="">{{estateTypes($estate->estate_type)}}</span> ({{$estate->{{ l('type == 1 ? \'فروش\' : \'اجاره\'}})') }}<br>
                        </p>
                        <div class="form-wrapper ">
                            <div class="form-schema ">
                                <form id="add" class="form-schema-form" action="{{url('/estates/update/'.$estate->id)}}" method="post">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="default_image" id="default_image" value="{{$defaultImage->id ?? ''}}">
                                    <input type="hidden" name="estate_type" id="estate_type" value="{{$estate->estate_type}}">
                                    <input type="hidden" name="type" id="type" value="{{$estate->type}}">
                                    <input type="hidden" name="latitude" id="latitude" value="{{$estate->latitude}}">
                                    <input type="hidden" name="longitude" id="longitude" value="{{$estate->longitude}}">


                                    <h6 class="mahdod ">{{ l('انتخاب شهر') }}</h6>
                                    <select name="city_id" id="city_id" class="form-control select2 w-100" required style="width: 100%">
                                        <option value="" disabled>{{ l('انتخاب شهر') }}</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" {{$city->id == $estate->city_id ? 'selected' :''}}>{{$city->name}}</option>
                                        @endforeach
                                    </select>

                                    <h6 class="mahdod ">{{ l('انتخاب محل') }}</h6>
                                    <select name="district_id" id="district_id" class="form-control select2 w-100" required style="width: 100%">
                                        <option value="" selected disabled>{{ l('انتخاب محل') }}</option>
                                        @foreach($districts as $district)
                                            <option value="{{$district->id}}" {{$district->id == $estate->district_id ? 'selected' :''}}>{{$district->name}}</option>
                                        @endforeach
                                    </select>


                                    <h6 class="mahdod-map ">{{ l('انتخاب مکان ملک روی نقشه') }}</h6>
                                    <!--map-->
                                    <div class="row">
                                        <div id="estate-map" class="part--map col-lg-12" style="margin-top: 25px; width: 100%; height: 350px">
                                        </div>
                                    </div>



                                    <!--browser img-->
                                    <h6 class="mahdod ">{{ l('افزودن تصاویر ملک') }}</h6>
                                    <p class="p-broeser-img ">{{ l('عکس‌هایی از فضای داخل و بیرون ملک اضافه کنید. آگهی‌های دارای عکس تا «۳ برابر» بیشتر توسط کاربران دیده می‌شوند.') }}</p>
                                    <p class="p-broeser-img">{{ l('حداکثر میزان حجم هر تصویر : 10 مگابایت') }}</p>
                                    <p class="p-broeser-img">{{ l('حداقل اندازه تصویر : 600x600') }}</p>


                                    <div>

                                        {{-- current images --}}
                                        @php($imageCount = $estate->images->count() ?? 0)
                                        @if($estate->images->count() > 0)
                                            <div id="images" class=" card mb-3">
                                                <div class="border-bottom card-header">
                                                    <strong class="mb-0">{{ l('تصاویر فعلی') }}</strong>
                                                </div>

                                                <div class="card-body align-content-center align-items-center d-flex flex-row flex-wrap justify-content-around">

                                                    @foreach($estate->images as $item)
                                                        <div id="media-{{$item->id}}" data-id="{{$item->id}}" class="card p-1 rounded dz-preview {{$defaultImage && $defaultImage->id == $item->id ? 'img-cover' : ''}}" style="flex-basis: 19%;margin-bottom:10px">
                                                            <p class="mb-0">
                                                                <a target="_blank">
                                                                    <img src="{{ asset("{{getDomainImg($url->id)}}/upload/images/estate/".$item->dimension['small'])}}" class="w-100" style="height:250px;margin-bottom:10px">
                                                                </a>
                                                            </p>
                                                            <button type="button" data-toggle="tooltip" title="{{ l('حذف') }}" data-id="{{$item->id}}"
                                                                    id="itemID-{{$item->id}}" data-name="{{$item->name}}"
                                                                    data-route="images" class="btn btn-danger remove-img">
                                                                <i class="d-inline fa fa-trash"></i> {{ l('حذف') }}
                                                            </button>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        @endif
                                        {{-- /current images --}}

                                        <div id="img-upload" class="dropzone bord h-auto radius-5 text-center" data-toggle="dropzone" style="width: 100%">
                                            <div class="dz-message" data-dz-message><span>{{ l('تصاویر خود را انتخاب کنید') }}</span></div>
                                        </div>
                                    </div>


                                    {{-- form inputs --}}
                                    <h6 class="mahdod">{{ l('متراژ') }}</h6>
                                    <input type="text" id="area" name="area" class="form-control text-left number"
                                           value="{{old('area',$estate->area)}}" required>


                                    <div id="sale-inputs">
                                        <h6 class="mahdod">{{ l('قیمت') }}</h6>
                                        <input type="text" id="price" name="price" class="form-control text-left other sale number" value="{{old('price',$estate->price)}}" >
                                    </div>

                                    <div id="rent-inputs" style="display: none">
                                        <h6 class="mahdod">{{ l('مبلغ ودیعه') }}</h6>
                                        <input type="text" id="mortgage" name="mortgage" class="form-control text-left rent number" value="{{old('mortgage',$estate->mortgage)}}">


                                        <h6 class="mahdod">{{ l('اجارهٔ ماهانه') }}</h6>
                                        <input type="text" id="rent" name="rent" class="form-control text-left rent number" value="{{old('rent',$estate->rent)}}">
                                    </div>

                                    <h6 class="mahdod">{{ l('عنوان آگهی') }}</h6>
                                    <p>{{ l('در عنوان آگهی به موارد مهم و چشمگیر اشاره کنید.') }}</p>
                                    <input type="text" name="title" class="form-control" value="{{old('title',$estate->title)}}" required>

                                    <div class="form-group green-border-focus mahdod ">
                                        <h6>{{ l('توضیحات آگهی') }}</h6>
                                        <p class="mahdod1 ">{{ l('در توضیحات آگهی به مواردی مانند شرایط فروش/اجاره، جزئیات و ویژگی‌های قابل توجه، دسترسی‌های محلی و موقعیت قرارگیری ملک اشاره کنید.') }}</p>
                                        <textarea class="form-control" id="description" name="description" rows="3" required>{{old('description',$estate->description)}}</textarea>
                                    </div>


                                    {{--more details--}}
                                    <!--Accordion wrapper-->
                                    <div class="accordion md-accordion mt-2 sidefilter" id="accordionEx" role="tablist" aria-multiselectable="true">

                                        <!-- Accordion card -->
                                        <div class="bg--zebra-stipe-gray card">

                                            <!-- Card header -->
                                            <div class="border-bottom card-header" role="tab" id="headingOne1">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
                                                    <h5 class="mb-0">{{ l('اطلاعات بیشتر') }}<i class="far fa-angle-down rotate-icon"></i></h5>
                                                </a>
                                            </div>

                                            <!-- Card body -->
                                            <div id="collapseOne1" class="collapse" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
                                                <div class="card-body my-3" id="more-fields">
                                                    @foreach($fields as $fieldName => $fieldArray)
                                                        <div class="col-lg-12" id="{{$fieldName}}">
                                                            <div class="form-group">
                                                                <label class="control-label font-weight-bolder required text-body">{{getFieldFaName($fieldName)}}</label>
                                                                <select id="{{$fieldName}}" name="{{$fieldName}}{{$fieldArray['multiple'] =='multiple' ? '[]' : ''}}"
                                                                        class="form-control select2" {{$fieldArray['multiple']}}  style="width: 100%">
                                                                    @if($fieldArray['multiple'] !='multiple')
                                                                        <option value="" selected disabled>- {{getFieldFaName($fieldName)}} -</option>
                                                                    @endif

                                                                    @foreach($fieldArray['values'] as $k=>$v)
                                                                        @php($k = $fieldName=='floor' ? $k : $k++)
                                                                        <option value="{{$k}}" {{$fieldArray['multiple'] != 'multiple' && !is_null($estate->$fieldName) && $estate->$fieldName == $k ? 'selected' : ''}}>{{$v}}</option>
                                                                    @endforeach
                                                                </select>

                                                                @if($fieldArray['multiple'] == 'multiple')
                                                                    @php($selectedItems = $estate->$fieldName)
                                                                    <script type="text/javascript">
                                                                        var selectedItems = <?php echo $selectedItems; ?>;
                                                                        var selectID = '{{$fieldName}}';
                                                                        $.each(selectedItems,function(i,v){
                                                                            $('select#'+selectID+' option[value="' + v + '"]').prop('selected', true);
                                                                        });
                                                                    </script>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    {{-- /more details--}}

                                    <button class="btn btn-primary bu " type="submit">{{ l('ذخیره') }}</button>
                                </form>

                                <div class="clearfix "></div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---------start main part--------->


@endsection

@section('js')
    <script src="{{asset('/frontend/vendor/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('admin2/dist/js/regions.js')}}"></script>
    <script src="{{asset('/admin2/plugins/select2/4.0.3/js/select2.min.js')}}"></script>
    {{--<script type="text/javascript" src="{{asset('/frontend/js/mdb.min.js')}}"></script>--}}

    <script type="text/javascript">
        $('.select2').select2();

        getCities();
        getDistricts();

        var imagesCount = '{{$imageCount}}';
        var maxFileCount = 10 - imagesCount;

        // upload image
        var uploadedDocumentMap = {}
        $('#img-upload').dropzone ({
            uploadMultiple:false,
            acceptedFiles: ".jpeg,.jpg,.png",
            maxFilesize:10, // 10 MB
            maxFiles: maxFileCount, // files count
            addRemoveLinks: true,
            dictRemoveFile:l("حذف"),
            dictCancelUpload:l("لغو آپلود"),
            url: '{{ route('estates.storeMedia') }}',
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
            type: 'POST',
            success: function (file, response) {
                file.imgID = response.name;
                $(".dz-preview:last-child").attr('data-id', file.imgID);

                $('form#add').append('<input type="hidden" name="document[]" value="' + response.name + '">') uploadedDocumentMap[file.name] = response.name }, removedfile: function (file) { file.previewElement.remove() var name = '' if (typeof file.file_name !== 'undefined') { name = file.file_name } else { name = uploadedDocumentMap[file.name] } $('form#add').find('input[name="document[]"][value="' + name + '"]').remove() }, init: function() { // check file size this.on("maxfilesexceeded", function(file){ this.removeFile(file); alert(l("حداکثر تعداد تصاویر 10 عدد میباشد!")); }); // check dimensions this.on("thumbnail", function (file) { if (file.height < 600 || file.width < 600) {
                        this.removeFile(file);
                        alert(l("حداقل ابعاد تصویر باید 600 در 600 باشد!"));
                    }
                });

                // default image
                this.on("addedfile", function(file) {
                    file.previewElement.addEventListener("click", function() {
                        // current images
                        $('#images').find('.dz-preview').removeClass('img-cover');
                        // uploaded images
                        $('#img-upload').find('.dz-preview').removeClass('img-cover');

                        $(this).addClass('img-cover');

                        var defaultImageId = $(this).attr('data-id');
                        $('input[name="default_image"]').val(defaultImageId);

                        toast({type: 'success',title: l('تصویر پیش فرض تغییر یافت')});
                    });
                });
            },
        });


        // change default image
        $('#images .dz-preview').on("click", function() {
            // current images
            $('#images').find('.dz-preview').removeClass('img-cover');
            // uploaded images
            $('#img-upload').find('.dz-preview').removeClass('img-cover');

            $(this).addClass('img-cover');

            var defaultImageId = $(this).attr('data-id');
            $('input[name="default_image"]').val(defaultImageId);

            toast({type: 'success',title: l('تصویر پیش فرض تغییر یافت')});
        });
        $('#images .dz-preview button').click(function(e) {
            e.stopPropagation();
        });

        // delete image
        $(".remove-img").on("click", function () {
            var estateId = '{{$estate->id}}';
            var id = $(this).data('id');
            swal({
                text: l("آیا از حذف گزینه مورد نظر اطمینان دارید؟"),
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: l('لغو'),
                confirmButtonText: l('بله'),
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
                                    text: l('گزینه مورد نظر با موفقیت حذف شد.'),
                                    type: 'success',
                                    allowOutsideClick: false,
                                }).then((result)=>{
                                    $('#images #media-'+id).remove();
                            });

                            })
                            .fail(function () {
                                swal('خطا!', l('حذف با مشکل مواجه شد!'), 'error');
                            });
                    });
                },
                allowOutsideClick: ()=>!swal.isLoading()
        });

        });

    </script>
@endsection
