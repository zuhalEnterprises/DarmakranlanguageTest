@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2',['title'=>'شعبات'])
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <section class="container mt-5 mb-lg-5 mb-4 pt-5 pb-lg-5">
            <!-- Breadcrumb-->
            <nav class="mb-3 pt-md-5" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> {{l('بنگاه های املاک')}}</li>
                </ol>
            </nav>
           
            <div class="my-4">
                <div class="row"  id="agent-list-wrapper">
                    <div class="col-lg-4 mb-3">
                        <div class="d-flex d-md-block d-lg-flex align-items-center p-3 mb-2 border rounded-1 ">
                            <img class="rounded-circle" src="https://kolbeh.ir/upload/images/profile/img_kJ75TxMv44CqHQ2m.jpg"  style="width:110px;height:110px" alt="{{ l('املاک بنفش') }}" />
                            <div class="pt-md-2 pt-lg-0 pe-3 pe-md-0 pe-lg-3">
                                <a href="#" class="text-decoration-none text-dark fw-bold fs-lg mb-0">
                                    {{ l('املاک بنفش') }}
                                </a>
                                <ul class="list-unstyled fs-sm mt-3 mb-0">
                                    <li>
                                        <a class="nav-link fw-normal p-0" >
                                            <i class="fi-map-pin opacity-60 me-2"></i>
                                            {{ l('آدرس: قم، زنبیل آباد، خ 20 متری امام حسین') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link fw-normal p-0" href="tel:09335512584">
                                            <i class="fi-phone opacity-60 me-2"></i>09335512584</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <!----start main-page----->
        <div class="content-box">
            <div class="bg-light border-bottom expert-form" style="min-height:240px">
                <form method="post" action="/branches/search" style="margin-bottom: -50px;">
                    @csrf
                    <div class="border-0 container p-4">
                        <div class="mb-2 mt-lg-5 mt-md-5 row">
                            <div class="col-lg-4 col-md-4">
                                <div class="mb-3">
                                    <label class="active mdb-main-label">{{ l('نام شعبه') }}</label>
                                    <input type="text" name="branch_name" id="branch_name" value="{{$branchName ?? ''}}" class="form-control-lg form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label class="mdb-main-label">{{ l('محله های فعالیت') }}</label>
                                    <select name="districts[]" id="districts" class="select2 form-control" style="width: 100%" multiple searchable=l("اینجا جستجو کنید") style="min-height:auto !important;">
                                        @foreach($districts as $district)
                                        <option value="{{$district->id}}">{{$district->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 text-right align-self-center">
                                <button type="submit" class="btn btn-warning py-2 px-4">
                                    <i class="fa-search far p-1"></i> {{ l('جستجو') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="expert-tiles mt80">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="breadcrumb">
                                <li><a href="/">{{ l('خانه') }}</a></li>
                                <li>{{ l('جستجوی شعبه') }}</li>
                            </ul>
                        </div>
                        {{-- agents list --}}
                        <div class="col-lg-8">
                            @foreach($branches as $branch)
                            <div class="mx-2">
                                <div class="mb-3 p-3 rounded row agent-list-card">
                                    <div class="col-lg-3">
                                        <div class="cover-wrapper bg-light rounded-3">
                                            <img src="{{$branch->coverImage(1)}}" class="mw-100 rounded-3 w-100" alt="{{$branch->name}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-9 information " style="line-height: 1.75rem;">

                                        <a href="{{$branch->code ? '/branch/'.$branch->code : 'javascript:;'}}" class="more-btn">
                                            <h5 class="main_title pb-3">{{$branch->name}}</h5>
                                        </a>
                                        <div class="">

                                            <span class="sub-title">{{ l('مدیر شعبه:') }}</span>
                                            <span class="text-orange">{{$branch->user->name ?? ''}} {{$branch->user->last_name ?? ''}}</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <span class="sub-title">{{ l('نوع بنگاه:') }}</span>
                                                <span class="text-muted">{{$branch->{{ l('type == 1 ? \'مغازه\' : \'اداری\'}}') }}</span><br>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="sub-title">{{ l('تعداد اتاق قرارداد:') }}</span>
                                                <span class="text-muted">{{$branch->contract_room_count ? toPersianNumbers($branch->{{ l('contract_room_count) : \'ندارد\'}}') }}</span><br>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="sub-title">{{ l('رنج فعالیت:') }}</span>
                                                <span class="text-muted">{{toPersianNumbers($branch->activityRangeMin).($branch->activityRangeMax > $branch->activityRangeMin ? ' - '.toPersianNumbers($branch->{{ l('activityRangeMax).\' تومان\' : \'\')}}') }}</span><br>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="sub-title">{{ l('امتیاز مردمی:') }}</span>
                                                <span class="text-muted">{{ l('نامشخص') }}</span><br>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="sub-title">{{ l('سهم کمیسیون:') }}</span>
                                                <span class="text-muted">{{$branch->comision+15}}</span><br>
                                            </div>
                                        </div>
                                        <div class="">
                                            <span class="sub-title">{{ l('امکان عقد قرارداد در روزهای تعطیل دارد؟') }}</span>
                                            <span class="text-muted">{{$branch->active_in_holidays == 1 ? l('بله') : ($branch->{{ l('active_in_holidays == 2 ? \'خیر\' : \'با هماهنگی قبلی\')}}') }}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- ads column --}}
                        <div class="col-lg-4">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
    @include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection

@section('js')

<script src="{{asset('/admin2/dist/js/regions.js')}}"></script>
<script src="{{asset('/admin2/plugins/select2/4.0.3/js/select2.min.js')}}"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();

        $("#listSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myList li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        var branchType = '{{$branchType}}';
        var activityRange = <?php echo json_encode($activityRange); ?>;
        var selectedDistricts = <?php echo json_encode($selectedDistricts); ?>;
        $('#branch_type').val(branchType).trigger('change');
        $('#activity_range_min').val(activityRange[0]).trigger('change');
        $('#activity_range_max').val(activityRange[1]).trigger('change');
        $('#districts').val(selectedDistricts).trigger('change');
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
    function submitSaveSearch(title, url) {
        $.ajax({
            type: 'POST',
            url: '/agents/save-search',
            data: {
                _token: '{{csrf_token()}}',
                title: title,
                url: url
            },
            error: function(response) {
                toast({
                    type: 'error',
                    text: l('مشکل در ثبت اطلاعات!'),
                });
            },
            success: function(response) {
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
