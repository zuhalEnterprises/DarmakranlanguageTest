@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', ['title' => l('کارشناسان')])

@section('main_content')


    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <div class="bg-secondary mt-5 pt-5">
            <section class="container pt-3">
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{l('کارشناسان')}}</li>
                    </ol>
                </nav>
                @if(env('COUNTRY') != 'UAE')
                <div class="row">
                    <div class="col-lg-4 pt-1 " >
                        <div class="row mb-3 py-4 border rounded-1 g-1 px-3 bg-white">

                            <div class="col-lg-12 mb-3">
                                <label class="form-label fw-bold" for="ap-title">{{ l('نام کارشناس') }}</label>
                                <input class="form-control" type="text" id="ap-title">
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label class="form-label fw-bold" for="ap-activity">
                                    {{ l('نوع فعالیت') }}
                                </label>
                                <select class="form-select  " id="ap-activity">
                                    <option value="">{{ l('انتخاب کنید') }}</option>
                                    <option value="zanbil">{{ l('خرید و فروش') }}</option>
                                    <option value="shahr">{{ l('رهن و اجاره') }}</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label class="form-label fw-bold" for="ap-estate">
                                    {{ l('نوع ملک') }}
                                </label>
                                <select class="form-select  " id="ap-estate">
                                    <option value="">{{ l('انتخاب کنید') }}</option>
                                    <option value="apartment">{{ l('آپارتمان') }}</option>
                                    <option value="villa">{{ l('منزل ویلایی') }}</option>
                                    <option value="shop">{{ l('مغازه') }}</option>
                                    <option value="earth">{{ l('زمین و باغ') }}</option>
                                    <option value="industrial">{{ l('صنعتی - تجاری') }}</option>
                                </select>
                            </div>
                            <div class="col-lg-12 my-3 d-flex align-items-end justify-content-center">
                                <button class="btn btn-primary w-100">{{ l('جستجو') }}</button>
                            </div>
                            <!-- <div class="text-center mt-2">

                                <button class="btn btn-primary w-50 w-lg-25">{{ l('جستجو') }}</button>
                            </div> -->
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-8">
                        <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch bg-white border rounded-1 py-3 px-4 mb-4">

                            <div class="d-none d-sm-flex align-items-center flex-shrink-0 text-muted"><i class="fi-check-circle me-2"></i><span class="fs-sm mt-n1"><span id="totalCount">184</span>{{ l('نتیجه یافت شد') }}</span>
                            </div>
                                <hr class="d-none d-sm-block w-100 mx-4">
                            <div class="d-flex align-items-center flex-shrink-0">
                                <label class="fs-sm me-2 pe-1 text-nowrap" for="sortby"><i class="fi-arrows-sort text-muted mt-n1 me-2"></i>{{ l('مرتب سازی براساس:') }}</label>
                                <select class="form-select form-select-sm" id="sortby" onchange="checkSend()">
                                    <option value="1">{{ l('جدیدترین') }}</option>
                                    <option value="4">{{ l('گرانترین') }}</option>
                                    <option value="3">{{ l('ارزانترین') }}</option>
                                </select>
                            </div>

                    </div>
                        <div class="row"  id="agent-list-wrapper">

                            @foreach($users as $user)
                            <div class="col-lg-6 mb-3">
                                <div class="d-flex d-md-block d-lg-flex align-items-center p-3 mb-2 border rounded-1 bg-white">
                                    <img class="rounded-circle" src="<?php echo !empty($user->photo) ? "/upload/images/profile/" . $user->photo : $user->photo() ?>"  style="width:110px;height:110px" alt="{{$user->fullname()}}" />
                                    <div class="pt-md-2 pt-lg-0 pe-3 pe-md-0 pe-lg-3">
                                        <a href="{{$user->id ? '/agents/'.$user->id : 'javascript:;'}}" class="text-decoration-none text-dark fw-bold fs-lg mb-0">
                                            {{$user->fullname()}}
                                        </a>

                                        <ul class="list-unstyled fs-sm mt-3 mb-0">
                                            <li>
                                                <a class="nav-link fw-normal p-0" >
                                                    <i class="fi-mail opacity-60 me-2"></i>
                                                    {{l('کارشناس '.($user->activity_type == 1 ? l('فروش') : ($user->{{ l('activity_type == 2 ? \'اجاره\' : \'فروش و اجاره\')))}}') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link fw-normal p-0" href="tel:{{$user->username}}">
                                                    <i class="fi-phone opacity-60 me-2"></i>{{$user->username}}</a>
                                            </li>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>


@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
@section('js')

<script type="text/javascript">
    var page = 1;
    var hasData = true;
    var flag=false;
    var str="";
    $("#search").click(function(){
        str="";
        if($("#name").val().length>0){
            str+="&&name="+$("#name").val();
        }
        //window.history.pushState('', 'New Page Title', (str));
        flag=true;
        loadMoreData(0,str);
    });
    function getmore(page){
        loadMoreData(page,str);
    }
    function loadMoreData(page,str) {
        if(page==0){
            $("#agent-list-wrapper").html("");
        }
        $.ajax({
                url: "?page="+(page+1)+str,
                type: "get",
                beforeSend: function() {
                    $("#spiner").removeClass("d-none");
                }
            })
            .done(function(data) {
                if (data.length == 0) {
                    return;
                }
                $("#spiner").addClass("d-none");
                if (data.count <= 0 || data.count == undefined) {
                    hasData = false;
                    return;
                }
                $(".btnmore1").addClass('d-none').removeClass('d-block');
                if(data.hasPage==true){
                    $("#agent-list-wrapper").append(data.html+"<div class='d-flex justify-content-center py-2 btnmore1' ><input class='btn btn-info' type='button' value='{{ l('دیدن بیشتر') }}' onclick='getmore("+parseInt(parseInt(page)+parseInt(1))+")'/></div>");
                }
                else
                {
                    $("#agent-list-wrapper").append(data.html);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                $("#spiner").addClass("d-none");
                //alert(l('مشکلی در دریافت اطلاعات بوجود آمده است...'));
            });
    }
    $(document).ready(function() {


        $("#search1").click(function() {
            if ($("#collapseExample").hasClass("show")) {
                $("#collapseExample").removeClass("show");
            } else {
                $("#collapseExample").addClass("show");
                $('.select2').select2();

            }

        });

        $("#sorttype").on("change", () => {
            $("#searchform").submit();
        });
        $("#listSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myList li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    $('#save-search').on('click', function() {
        $('input[name=title]').val('');
    });
    $('#submit-save-search').on('click', function() {
        var title = $('input[name=title]').val();
        if (title.replace(/\s/g, "").length == 0) {
            $('#title').focus();
            return false;
        }
        var url = window.location.href;
        submitSaveSearch(title, url)
    });
    // send save-search request

    $(".filter-sort-item").click(function() {
        $("#sort").val($(this).attr("data-value"));
        $(".btn-search").click();
        $(".filter-sort-item").removeClass("filter-sort-active");
        $(this).addClass("filter-sort-active");
        //$(".filter-sort-active").removeClass("filter-sort-active");
        // $(e.target).parent().addClass("filter-sort-active");
    });
    function updateNextSelect(obj, val) {
        $(obj).find('option').each(function() {
            if (parseInt($(this).val()) < parseInt(val)) {
                $(this).attr('disabled', 'disabled');
            } else {
                $(this).removeAttr('disabled');
            }
        });
        $('.js_select2').select2({
            tags: true
        });
    }
    function updatePrevSelect(obj, val) {
        $(obj).find('option').each(function() {
            if (parseInt($(this).val()) > parseInt(val)) {
                $(this).attr('disabled', 'disabled');
            } else {
                $(this).removeAttr('disabled');
            }
        });
        $('.js_select2').select2({
            tags: true
        });
    }
</script>
@endsection
