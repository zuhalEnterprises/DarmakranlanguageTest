@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('عملکرد املاک')
])
@section('head')
<link rel="stylesheet" media="screen" href="/vendor/select2/select2.min.css" />
@endsection
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
        <!-- Page content-->
        <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
            <!-- Page content-->
            <div class="row">
                @include('frontend.layouts.sidebar', ['menu' => '9'])
                <!-- Content-->
                <div class="col-lg-9 col-md-12 mb-5">
                    <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{l('عملکرد املاک')}}</li>
                    </ol>
                </nav>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h1 class="h2 mb-0">
                            {{l('عملکرد املاک')}}
                        </h1>
                        @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                        <div>
                            <span class="btn btn-lg btnAdd btn-primary w-100 mb-2">
                                {{l('افزودن')}}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="card shadow-sm rounded mb-4">
                        <form  id="mySearch">
                        <div class=" card-body border-0  pb-1 me-lg-1">
                            <input type="hidden" name="order" id="order" value="id">
                            <input type="hidden" name="orderby" id="orderby" value="desc">
                            <div class="row">
                                @if($currentUser->isAdmin())
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                    <label class="form-label fw-bold" for="user_id">{{l('مشاور')}}</label>
                                    <select class="form-control select2" name="user_id" id="user_id" style="width:100%">
                                        <option value="" {{$currentUser->isAdmin()?'selected':''}}>{{l('همه مشاورین')}}</option>
                                        @if(ss('SITE_ID') == 3 || ss('SITE_ID') == 8)
                                        @foreach($branches as $branch)
                                            <option value="{{(-1) * $branch->id}}">مشاورین شعبه {{$branch->name}}</option>
                                        @endforeach
                                        @endif
                                        @foreach($users as $item)
                                            <option value="{{$item->id}}" {{ (app('request')->input('user_id') == $item->id)?"selected":"" }}>{{$item->fullname()}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                    <label class="form-label fw-bold" for="customer_id">{{l('کد مشتری')}}</label>
                                    <input type="text" class="form-control" id="customer_id" name="customer_id" />
                                </div>
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                    <label class="form-label fw-bold" for="estate_id">{{l('کدملک')}}</label>
                                    <input type="text" class="form-control" id="estate_id" name="estate_id" />
                                </div>
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                    <label class="form-label fw-bold" for="type">{{l('نوع')}} </label>
                                    <select class="form-control form-select" id="type" name="type">
                                        <option></option>
                                        @if(ss('SITE_ID') == 3)
                                        <option value="1" {{ (app('request')->input('type') == 1)?"selected":"" }}>{{l('کارشناسی')}}</option>
                                        @endif
                                        <option value="2" {{ (app('request')->input('type') == 2)?"selected":"" }}>{{l('بازدید')}}</option>
                                        <option value="3" {{ (app('request')->input('type') == 3)?"selected":"" }}>{{l('آگهی')}}</option>
                                        @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5)
                                        <option value="5" {{ (app('request')->input('type') == 5)?"selected":"" }}>{{l('نردبان')}}</option>
                                        @endif
                                        <option value="4" {{ (app('request')->input('type') == 4)?"selected":"" }}>{{l('توضیحات')}}</option>

                                    </select>
                                </div>
                                @if (env('COUNTRY') == 'UAE')
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                    <label class="form-label fw-bold"> {{l('تاریخ از')}}</label>
                                    <input name="datefrom" id="datefrom" class="form-control date-picker rounded pe-5" type="text" placeholder="{{l('تاریخ از')}}" value="{{ app('request')->input('datefrom') }}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                                </div>
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                    <label class="form-label fw-bold"> {{l('تاریخ تا')}}</label>
                                    <input name="dateto" id="dateto" class="form-control date-picker rounded pe-5" type="text" placeholder="{{l('تاریخ تا')}}" value="{{ app('request')->input('dateto') }}" data-datepicker-options='{"altInput": true, "altFormat": "F j, Y", "dateFormat": "Y-m-d"}'>
                                </div>
                                @else
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                    <label class="form-label fw-bold"> {{l('تاریخ از')}}</label>
                                    <input type="text" name="datefrom" id="datefrom" class="form-control" readonly value="{{ app('request')->input('datefrom') }}" style="cursor: pointer" />
                                </div>
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                    <label class="form-label fw-bold"> {{l('تاریخ تا')}}</label>
                                    <input type="text" name="dateto" id="dateto" class="form-control" readonly value="{{ app('request')->input('dateto') }}" style="cursor: pointer" />
                                </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-center my-4 ">
                                <button id="form_search" class="btn btn-primary">
                                    {{l('جستجو')}}
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="tab-content1" id="state">
                    </div>
                    <nav class="pt-4 pb-2 border-top" aria-label="Blog pagination" id="pagination">
                    </nav>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header px-4 py-3">
                    <h4 class="modal-title" id="exampleModalLabel">{{l('افزودن')}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding:40px 30px;">
                    <div class="mb-3">
                        <label class="form-label" for="type">{{l('کد ملک')}} </label>
                        <input class="form-control" id="add_estate_id" name="add_estate_id"></input>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="type">{{l('نوع')}} </label>
                        <select class="form-control form-select" id="add_type" name="add_type">
                            <option value="1" >{{l('کارشناسی')}}</option>
                            <option value="4" >{{l('توضیحات')}}</option>
                            <option value="3" >{{l('آگهی')}}</option>
                            <option value="5" >{{l('نردبان')}}</option>
                        </select>
                    </div>
                    <div class="mb-3 " id="expert_id">
                        <label class="form-label" for="expert_id">{{l('مشاور')}} </label>
                        <select class="form-control form-select" id="add_expert_id" name="add_expert_id">
                        @foreach($users as $item)
                            <option value="{{$item->id}}">{{$item->fullname()}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="comment">{{l('توضیحات')}} </label>
                        <textarea class="form-control" id="comment" name="comment" rows="5" placeholder="{{l('توضیحات')}}" required></textarea>
                        <div class="invalid-feedback">{{l('نظر خود را ثبت کنید')}}</div>
                    </div>
                    <button class="btn btn-primary d-block w-100 mb-4 btnOperation" type="submit">{{l('ثبت عملکرد')}}</button>
                </div>
            </div>
        </div>
    </div>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<link rel="stylesheet" href="/assets/vendors/swiperjs/css/swiper.css">
<script src="/assets/vendors/swiperjs/js/swiper.js"></script>
<script src="/frontend/vendor/sweetalert2.all.js"></script>
<script src="/frontend/js/paging.js"></script>
<link rel="stylesheet" href="/admin2/dist/css/persian-datepicker-0.4.5.min.css" />
<!-- custom css -->
<link href="/admin/css/date_picker/kamadatepicker.css" rel="stylesheet">
<script src="/admin/js/date_picker/kamadatepicker.js"></script>
<script>
    $(document).ready(function(){
        $('#mySearch').on('submit', function(e){
            e.preventDefault();
            return false;
        });
    });
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
    kamaDatepicker('datefrom', customOptions);
    kamaDatepicker('dateto', customOptions);
    const toast = swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 2500
    });

    $(".btnAdd").click(function() {
        $("#myModal").modal('show');
    });
    var CSRF_TOKEN = '{{ csrf_token() }}';
    $(document).ready(function() {
        $(".btnOperation").click(function() {
            estate_id = $('#add_estate_id').val();;
            expert_id = $('#add_expert_id').val();;
            comment = $('#comment').val();
            type = $('#add_type').val();
            if (comment.length == 0) {
                $('#comment').focus();
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $.ajax({
                url: '/estate/addOperation',
                type: "POST",
                data: {
                    'type': type,
                    'comment': comment,
                    'estate_id': estate_id,
                    'expert_id': expert_id
                },
                success: function(data) {
                    var res = data.data;
                    var operation = res.operation_id;
                    $('#comment').val('');
                    $('#modal-review').modal('toggle');
                    swal({
                        title: "{{l('عملکرد با موفقیت ثبت شد')}}",
                        message: "",
                        confirmButtonColor: '#025EC6',
                        confirmButtonText: l('باشه'),
                        type: "success",
                        timer: 2000
                    });
                    CheckSend();
                },
            });
        });
    });
    $(".close").click(function() {
        $("#myModal").modal('hide');
    });
    function CheckSend()
    {
        var sr = "";
        sr += ($('#customer_id').val() != '') ? "customer_id=" + $('#customer_id').val() + "&" : "";
        sr += ($('#estate_id').val() != '') ? "estate_id=" + $('#estate_id').val() + "&" : "";
        sr+=(typeof $('#user_id').val()!=='undefined')?"user_id="+$("#user_id").val()+"&":"";
        sr+=(typeof $('#type').val()!=='undefined' && $('#type').val()>0)?"type="+$("#type").val()+"&":"";
        sr+=(typeof $('#datefrom').val()!=='undefined' )?"datefrom="+$("#datefrom").val()+"&":"";
        sr+=(typeof $('#dateto').val()!=='undefined' )?"dateto="+$("#dateto").val()+"&":"";
        sr+= "order="+$("#order").val()+"&";
        sr+= "orderby="+$("#orderby").val()+"&";
        loadMoreData(1,sr)
    }
    function sort(type)
    {
        if($("#orderby").val() == "desc"){
            $("#orderby").val("asc");
        }
        else
        {
            $("#orderby").val("desc");
        }
        $("#order").val(type);
        CheckSend();
    }
    $("#form_search").click(function() {
        CheckSend();
    });
    var pagin = 1;
    var str="";
    function loadMoreData(page,type) {
        type1=type;
        if(page==1){
            $(".tab-content1").html("");
        }
        $.ajax({
                url: "/profile/operationEstateShow?page="+page+"&&"+type,
                type: "get",
                beforeSend: function() {
                    $('.page-loading').addClass('active');
                }
            })
            .done(function(data) {
                $('.page-loading').removeClass('active');
                if (data.length == 0) {
                    return;
                }
                $(".tab-content1").html(data.html);
                var result = Paging(pagin ,20,data.totalCount, "myClass", "myDisableClass");
                $("#pagination").html(result);
                $('.page-loading').removeClass('active');
            })
        }
        $("#pagination").on("click", "a", function () {
            pagin=$(this).attr("pn");
            if(pagin>0){
            loadMoreData($(this).attr("pn"),type1);
            }
        }
    );
    $(document).ready(function() {
        CheckSend();
    });
    function destroy(id){
        $.get("/profile/operationEstate/destroy/"+id , function (data, status)
        {
            toast({
                type: 'success',
                text: '{{l('با موفقیت حذف شد')}}'
            });
            CheckSend();
        });
    }
</script>
@endsection
