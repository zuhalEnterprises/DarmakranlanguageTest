<div id="stickerMe">

    <div class="mr-3 mt-5 select-filters clearfix">
        <h5>{{ l('فیلتر ها') }}</h5>
{{--        <span>{{ l('حذف فیلتر ها') }}<i class="close fas fa-times"></i></span>--}}
{{--        <div class="chip waves-effect">{{ l('فقط عکس دار ها') }}<i class="close fas fa-times"></i></div>--}}
        <span>
            <a href=""><i class="close fas fa-times"></i>{{ l('حذف فیلتر ها') }}</a>

            @if(Auth::check())
            <a href="javascript:void(0)" id="save-search" data-toggle="modal" data-target="#modalSaveSearch">{{ l('ذخیره جستجو') }}<i class="far fa-inbox-in"></i></a>
            <!-- modal filter -->
            <div class="modal fade" id="modalSaveSearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">{{ l('ذخیره جستجو') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-3">

                        <div class="">
                            <input type="text" name="title" id="defaultForm" class="form-control" placeholder="{{ l('عنوان جستجو') }}" required>
{{--										<label data-error="wrong" data-success="right" for="defaultForm-pass"></label>--}}
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button class="btn btn-primary" id="submit-save-search"><i class="far fa-inbox-in text-white"></i>{{ l('ذخیره') }}</button>
                    </div>
                    </div>
                </div>
            </div>
            <!-- end save filter -->
            @endif

        </span>

    </div>

    <ul class="nav flex-column sidemenu">
        <li class="nav-item mr-3 mt-3">
            <a href="/c/{{$city->name_en}}"><h5>{{ l('همه اگهی ها') }}</h5></a>
        </li>

        @foreach(estateTypes() as $key=>$val)
            <li class="nav-item et">
                <a class="nav-link text-secondary {{$key == ($selectedEstateType ?? 0) ? 'active font-weight-bold' : ''}}"><i class="far fa-home"></i>{{$val}}</a>
                    <ul class="mr-5 pr-3 sidemenu-child" style="border-right: 1px solid rgb(204, 204, 204); display: {{$key == ($selectedEstateType ?? 0) ? '' : 'none'}}">
{{--                        <li><a href="/c/{{$city->name_en}}/buy-{{estateTypesEn($key)}}">{{ l('فروش') }}</a></li>--}}
{{--                        <li><a href="/c/{{$city->name_en}}/rent-{{estateTypesEn($key)}}">{{ l('اجاره') }}</a></li>--}}

                        <li><a href="javascript:void(0)" onclick="setEstateTypeFilter('buy-{{estateTypesEn($key)}}')">{{ l('فروش') }}</a></li>
                        <li><a href="javascript:void(0)" onclick="setEstateTypeFilter('rent-{{estateTypesEn($key)}}')">{{ l('اجاره') }}</a></li>
                    </ul>
            </li>
        @endforeach

        <script>
            $('.et').on('click',function () {
                $('.sidemenu-child').slideUp();

                if ($(this).children('.sidemenu-child').is(':visible')) {
                    $(this).children('.sidemenu-child').slideUp(250);
                } else {
                    $(this).children('.sidemenu-child').slideDown(250);
                }

                //$(this).children('.sidemenu-child').slideToggle(250);
            });

            $(".et .sidemenu-child li").click(function(e) {
                e.stopPropagation();
            });
        </script>
    </ul>

    <!--Accordion wrapper-->
    <div class="accordion md-accordion mt-2 sidefilter" id="accordionEx" role="tablist" aria-multiselectable="true">

        <!-- Accordion card -->
        <div class="card">

            <!-- Card header -->
            <div class="card-header" role="tab" id="headingOne1">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
                    <h5 class="mb-0">
                        {{ l('محل') }} <i class="far fa-angle-down rotate-icon"></i>
                    </h5>
                </a>
            </div>

            <!-- Card body -->
            <div id="collapseOne1" class="collapse" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
                <div class="card-body">
                    <select name="districts[]" id="districts" class="mdb-select md-form colorful-select dropdown-primary"
                            data-mdb-clear-button="true" multiple searchable=l("نام محل...")>
                        <option value="" selected disabled>{{ l('نام محل') }}</option>
                        @foreach($districts as $district)
                            <option value="{{$district->id}}" data-id="{{$district->id}}">{{$district->name}}</option>
                        @endforeach
                    </select>

                    <button onclick="setDistrictFilter(this)" class='btn btn-block btn-primary mb-3'>{{ l('اعمال فیلتر') }}</button>
                </div>
            </div>

        </div>
        <!-- Accordion card -->

        <!-- Accordion card -->
        <div class="card">

            <!-- Card header -->
            <div class="card-header" role="tab" id="headingTwo2">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                    <h5 class="mb-0">
                        {{ l('قیمت') }} <i class="far fa-angle-down rotate-icon"></i>
                    </h5>
                </a>
            </div>

            <!-- Card body -->
            <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2" data-parent="#accordionEx">
                <div class="card-body">
                    <select name="price_min" id="price_min" class="mdb-select md-form colorful-select dropdown-primary" data-mdb-clear-button="true">
                        <option value="0" selected>{{ l('حداقل') }}</option>
                        <option value="150000000">{{ l('150 میلیون') }}</option>
                        <option value="250000000">{{ l('250 میلیون') }}</option>
                        <option value="350000000">{{ l('350 میلیون') }}</option>
                        <option value="500000000">{{ l('500 میلیون') }}</option>
                        <option value="650000000">{{ l('650 میلیون') }}</option>
                        <option value="850000000">{{ l('850 میلیون') }}</option>
                        <option value="1000000000">{{ l('1 میلیارد') }}</option>
                        <option value="1200000000">{{ l('1 میلیارد و 200 میلیون') }}</option>
                        <option value="1400000000">{{ l('1 میلیارد و 400 میلیون') }}</option>
                        <option value="1800000000">{{ l('1 میلیارد و 800 میلیون') }}</option>
                        <option value="2000000000">{{ l('2 میلیارد') }}</option>
                        <option value="2500000000">{{ l('2 میلیارد و 500 میلیون') }}</option>
                        <option value="3000000000">{{ l('3 میلیارد') }}</option>
                        <option value="4000000000">{{ l('4 میلیارد') }}</option>
                        <option value="5000000000">{{ l('5 میلیارد') }}</option>
                        <option value="7000000000">{{ l('7 میلیارد') }}</option>
                        <option value="10000000000">{{ l('10 میلیارد') }}</option>
                    </select>
                    <select name="price_max" id="price_max" class="mdb-select md-form colorful-select dropdown-primary"  data-mdb-clear-button="true">
                        <option value="0" selected>{{ l('حداکثر') }}</option>
                        <option value="150000000">{{ l('150 میلیون') }}</option>
                        <option value="250000000">{{ l('250 میلیون') }}</option>
                        <option value="350000000">{{ l('350 میلیون') }}</option>
                        <option value="500000000">{{ l('500 میلیون') }}</option>
                        <option value="650000000">{{ l('650 میلیون') }}</option>
                        <option value="850000000">{{ l('850 میلیون') }}</option>
                        <option value="1000000000">{{ l('1 میلیارد') }}</option>
                        <option value="1200000000">{{ l('1 میلیارد و 200 میلیون') }}</option>
                        <option value="1400000000">{{ l('1 میلیارد و 400 میلیون') }}</option>
                        <option value="1800000000">{{ l('1 میلیارد و 800 میلیون') }}</option>
                        <option value="2000000000">{{ l('2 میلیارد') }}</option>
                        <option value="2500000000">{{ l('2 میلیارد و 500 میلیون') }}</option>
                        <option value="3000000000">{{ l('3 میلیارد') }}</option>
                        <option value="4000000000">{{ l('4 میلیارد') }}</option>
                        <option value="5000000000">{{ l('5 میلیارد') }}</option>
                        <option value="7000000000">{{ l('7 میلیارد') }}</option>
                        <option value="10000000000">{{ l('10 میلیارد') }}</option>
                    </select>

                    <button onclick="setPriceFilter(this)" class='btn btn-block btn-primary mb-3'>{{ l('اعمال محدوده قیمت') }}</button>

                </div>
            </div>

        </div>
        <!-- Accordion card -->

        <!-- Accordion card -->
        @if(isset($type) && isset($estate_type))
            <!-- Accordion card -->
            <div class="bg-white border-primary card">

                <!-- Card header -->
                <div class="bg-primary card-header" role="tab" id="advancedSearch">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseAdvancedSearch" aria-expanded="false" aria-controls="collapseAdvancedSearch">
                        <h5 class="mb-0 text-white">{{ l('جستجوی پیشرفته') }}<i class="far fa-angle-down rotate-icon"></i></h5>
                    </a>
                </div>

                <!-- Card body -->
                <div id="collapseAdvancedSearch" class="collapse py-2" role="tabpanel" aria-labelledby="advancedSearch" data-parent="#accordionEx">
                    <div class="card-body">
                        @include('frontend.estate.form.'.$type.'_'.$estate_type,['fields'=>$fields])
                    </div>
                </div>

            </div>
        @endif
    </div>

    <!-- Accordion wrapper -->
    <div>
        <div class="custom-control custom-switch border-bottom pt-2 pb-3" dir="ltr">
            <input type="checkbox" name="has_photo" class="custom-control-input" id="hasPhoto"
                   onclick="setPhotoFilter(this)" {{$hasPhoto=='true'?'checked':'unchecked'}}>
            <label class="custom-control-label" for="hasPhoto">{{ l('فقط عکس دار') }}</label>
        </div>
    </div>


    @if($templatePage->ads->count() > 0)
        @foreach($templatePage->ads as $ad)
            @if($ad->type == 1)
                <div class="img-ads mt-2">
                    <a href="{{$ad->url ?? 'javascript:void(0)'}}">
                        <img src="{{$ad->image()}}" alt="{{$ad->title}}">
                    </a>
                </div>
            @else
                <div class="border mt-2 text-ads" style="background: #fcfcfc;">
                    <a href="{{$ad->url ?? 'javascript:void(0)'}}">
                        <h5 class="text-info">{{$ad->title}}</h5>
                        <p class="text-body">{{$ad->description}}</p>
                    </a>
                </div>
            @endif
        @endforeach
    @endif

    @include('frontend.layouts.footer_column')
</div>

@section('js')
<script>
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
        var val = $('input[name="q"]').val();

        if(val.replace(/\s/g, "").length == 0){
            if (q!='') {
                $(this).val(q);
            }

            return false;
        }

        if(e.keyCode == 13){
            setUrlParams('q',val);
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

    function setPhotoFilter(cb){
        var val = cb.checked?'true':'false';
        setUrlParams('has_photo',val)
    }

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
                    text: l('مشکل در ثبت اطلاعات!'),
                });
            },
            success: function(response)
            {
                if (response.status == 'true') {
                    $("#modalSaveSearch").modal('hide');
                    toast({
                        type: 'success',
                        text: l('جستجوی شما با موفقیت ذخیره شد.'),
                    });

                }
            }
        });
    }

</script>
@endsection
