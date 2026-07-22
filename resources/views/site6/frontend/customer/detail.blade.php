@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('جزئیات تقاضا')
])
@section('main_content')
<!-- <link rel="stylesheet" href="/assets/css/main.css"/> -->
<style>
@media (min-width: 992px)
{

    .collapse{
        visibility: unset;
    }
    }
    .border-t {
        border-top-width: 1px;
    }
    .mobile-w-50 {
        width: 50%;
    }
    @media (min-width: 768px) {
    .mobile-w-50{
        width: 25%;
    }
}
</style>
<script src="/frontend/vendor/sweetalert2.all.js"></script>
<script>
    const toast = swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 2500
    });
</script>
@if ($errors->any())
    <div class="flex justify-between items-center py-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
        @endforeach
    </div>
@endif
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2')
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => '3'])
            <!-- Page content-->
            <div class="col-lg-9 col-md-12 mb-5 account add-property">
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="real-estate-home-v1.html">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{l('جزئیات تقاضا')}} </li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center py-3 d-none">
                    <h3 class="m-0">{{l('مشخصات خریدار')}}</h3>
                    <div class="flex flex-col md:flex-row justify-center gap-3">
                        <a href="/add" class="btn btn-secondary btn-sm">{{l('سپردن ملک')}}</a>
                        <a href="/customers/create" class="btn btn-primary btn-sm">{{l('ثبت خریدار')}}</a>
                    </div>
                </div>
                <div class="rounded-2 bg-white flex gap-2 py-3 px-4 md:py-4 md:px-6 border border-gray-200">
                    <div class="w-full flex flex-col">
                        <!-- جزییات خریدار -->

                        <div class="flex justify-between items-center mb-1">
                            <h3 class="text-[32px] text-gray-500 font-extrabold">
                                @if (!$currentUser->isAdmin() && $model->user_id != $currentUser->id)
                                    @if(isset($model->user))
                                        {{l('مشاور')}}: {{$model->user->fullname()}}
                                    @endif
                                @else
                                    نام:
                                    @if(env('COUNTRY') != 'UAE')
                                        @if($model->gender == 'female')
                                        سرکار خانم
                                        @else
                                        جناب آقای
                                        @endif

                                    @endif
                                    {{$model->name}}
                                @endif
                            </h3>
                        </div>
                        <div class="flex justify-between items-center mb-1 mt-3">
                            <b>{{ l('تاریخ ثبت:') }}</b> {{toPersianDate($model->created_at)}}
                        </div>

                        <div class="flex justify-between items-center mb-1">
                            <div class="d-flex justify-content-between flex-wrap gap-2 py-3 mt-3">
                                <div class="d-flex  align-items-center gap-2 flex-wrap">
                                    <b>{{ l('کدمشتری:') }}</b> {{$model->id}}
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="fw-bold">

                                        {{l('تلفن')}}
                                        @if ($currentUser->isAdmin() || $model->user_id == $currentUser->id)
                                        مشتری
                                        @else
                                        {{l('مشاور')}}

                                        @endif
                                        :
                                    </span>
                                    <span class="text-[17px] md:text-[18px] text-gray-500 font-medium tracking-widest">
                                        @if ($currentUser->isAdmin() || $model->user_id == $currentUser->id)
                                            {{$model->mobile}}
                                            @if(ss('SITE_ID') == 5 || ss('SITE_ID') == 2)
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modelsms" class="text-decoration-none ">
                                                <input class="btn btn-primary" type="button" value="{{ l('ارسال پیامک عدم پاسخ فروشنده') }}" />
                                            </a>
                                            @endif
                                        @else
                                            {{$model->user->username ?? ''}}
                                        @endif
                                    </span>

                                </div>
                                @if ($currentUser->isAdmin())
                                <div class="d-flex  align-items-center gap-2 flex-wrap">
                                    <span class="fw-bold">
                                        {{l('مشاور')}}:
                                    </span>
                                    <span class="text-[17px] md:text-[18px] text-gray-500 font-medium tracking-widest">
                                        @if($model->user != null)
                                        {{$model->user->fullname()}}
                                        @endif
                                    </span>
                                </div>
                                @endif

                                @if($model->user != null)
                                <a href="tel:+98{{substr($model->user->username,1)}}" class="btn btn-success rounded-pill">
                                    <i class="text-[20px] text-[#8DD781]  fa-thin fa-phone"></i>
                                    <span class="text-[20px] text-[#8DD781] font-medium"> {{l('تماس با مشاور')}}</span>
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-2 py-3 px-2 mb-3">

                            <div class="row px-2 border-text-200 ">
                                <!--  -->

                                <div class="col-sm-3 mt-3">
                                    <p class="fw-bold">{{l('تعجیل در خرید')}} : </p>
                                    <p class="font-medium mb-0">
                                        {{$model->purchase_priority == 3 ? l('زیاد') : ($model->{{ l('purchase_priority == 2 ? l(\'متوسط\') : l(\'کم\'))}}') }}
                                    </p>
                                </div>
                                <div class="col-sm-2 mt-3">
                                    <p class="fw-bold">{{l('وضعیت نقدینگی')}} : </p>
                                    <p class="font-medium mb-0">
                                        @if($model->financial_liquidity_type)
                                            {{l(financialLiquidityTypes($model->financial_liquidity_type ?? ''))}}
                                        @endif
                                    </p>
                                </div>

                            </div>
                        </div>


                        <div class="border border-gray-200 rounded-2 py-3 px-2 mb-3 d-flex align-items-center">
                            <div class="w-50 text-gray-500 px-2 border-end border-gray-200 font-light flex flex-col md:flex-row">
                                <span class="fw-bold">{{l('دلیل خرید')}}:</span>
                                <span class="font-medium mb-0">
                                    @if($model->purchase_reason)
                                        {{l(purchaseReasons($model->purchase_reason ?? ''))}}
                                    @endif
                                </span>
                            </div>

                        </div>

                        @if($model->note)
                        <div class="border border-gray-200 rounded-2 py-3 px-2 md:px-5 mb-10 md:mb-3 flex items-center">
                            <div class=" text-gray-500 px-2 border-l border-gray-200 font-light flex flex-col md:flex-row">
                                <span>
                                    {{$model->note}}
                            </div>
                            </div>
                        </div>
                        @endif
                        @if ($model->status == 1 && ($model->user_id == $currentUser->id || $currentUser->isAdmin()))
                        <div class="my-3 d-flex justify-content-end align-items-center gap-4">
                            <a href="/customer/{{$model->id}}/edit_v2" class="btn btn-outline-primary btn-sm">
                                <i class="fs-6 text-gray-500  fa-thin fa-edit"></i>
                                <span class="text-[16px] text-gray-500 font-light"> {{l('ویرایش')}}</span>
                            </a>
                        </div>
                        @endif

                    </div>

                    <div class="w-full flex flex-col mt-2">
                        @if($model->status == 1 && (ss('SITE_ID') == 6) && $currentUser && ($currentUser->isExpert() || $currentUser->isAdmin()))
                        <div class="border border-gray-200 rounded-2 py-3 px-2 mb-3 d-flex align-items-center">
                            <div class="w-100 text-gray-500 px-2 font-light flex flex-col md:flex-row">
                                <div class="mb-4 pb-4 border-bottom" >
                                    <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch justify-content-between">
                                        <a class="btn btn-outline-primary mb-sm-0 mb-3" href="#modal-review" data-bs-toggle="modal">
                                            <i class="fi-edit ms-1"></i>{{ l('ثبت عملکرد') }}</a>
                                        <div class="d-flex align-items-center ms-sm-4">
                                        </div>
                                    </div>
                                </div>
                                <!-- Review-->
                                <div class="opertionlogs">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                </div>


            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="modal-review" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-block position-relative border-0 pb-0 px-sm-5 px-4">
            <h4 class="modal-title mt-4 text-center font-vazir">{{ l('ثبت عملکرد برای تقاضا') }}</h4>
            <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 px-4">
                <div class="mb-3">
                    <label class="form-label" for="type">{{ l('نوع') }}</label>
                    <select class="form-control form-select" id="type" name="type">
                        <option value="11" >{{ l('تماس با مشتری') }}</option>
                        <option value="12" >{{ l('نظر مشاوران') }}</option>
                        <option value="2" >{{ l('سرویس') }}</option>
                        <option value="13" >{{ l('فروش ویژه') }}</option>
                    </select>
                    </div>

                <div class="mb-4">
                <label class="form-label" for="comment">{{ l('توضیحات') }}</label>
                <textarea class="form-control" id="comment" name="comment" rows="5" placeholder="{{ l('توضیحات') }}" required></textarea>
                <div class="invalid-feedback">{{ l('نظر خود را ثبت کنید') }}</div>
                </div>
                <button class="btn btn-primary d-block w-100 mb-4 btnOperation" type="submit">{{ l('ثبت عملکرد') }}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modelsms" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel"
aria-hidden="true" style="z-index: 99999;top:0%;bottom:0% !important;height:auto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ l('تذکر') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
                <h3>{{ l('آیا شما مطمئن هستید؟') }}</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ l('بستن') }}</button>
                <button type="button" class="btn btn-primary smsend">{{ l('بله') }}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modelrelationsms" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true" style="z-index: 99999;top:0%;bottom:0% !important;height:auto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ l('تذکر') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
                <h3>{{ l('آیا شما مطمئن هستید؟') }}</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ l('بستن') }}</button>
                <button type="button" class="btn btn-primary relationsmsend">{{ l('بله') }}</button>
            </div>
        </div>
    </div>
</div>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script src="{{asset('frontend/vendor/sweetalert2.all.js')}}"></script>
<script src="/frontend/js/paging.js"></script>
<script>
    $(".btnAdd").click(function() {
        $("#myModal").modal('show');
    });
    function addRel(id) {
        estate_id = $('#estate_add').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
        $.ajax({
            url: '/estate/addRelation',
            type: "POST",
            data: {
                'customer_id': {{$model->id}},
                'estate_id': estate_id
            },
            success: function(data) {
                var res = data.data;
                var operation = res.operation_id;
                $('#estate_add').val('');
                $('#myModal').modal('toggle');
                CheckSend();
                swal({
                    title: l("ارتباط با موفقیت ثبت شد"),
                    message: "",
                    confirmButtonColor: '#025EC6',
                    confirmButtonText: l('باشه'),
                    type: "success",
                    timer: 2000
                });
            },
        });
    };
    function CheckSend()
    {
        var sr = "";
        sr += "customer_id={{$model->id}}&";
        sr += ($('#estate_id').val() != '') ? "estate_id=" + $('#estate_id').val() + "&" : "";
        sr+=(typeof $('#status').val()!=='undefined')?"status="+$("#status").val()+"&":"";
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
                url: "/profile/relationEstateCustomerShow?show=2&type="+{{$model->request_type}}+"&page="+page+"&&"+type,
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
    function addComment(id , type)
    {
        $("#relId").val(id);
        $("#type").val(type);
        $("#commentModal").modal('show');
    };
    var CSRF_TOKEN = '{{csrf_token()}}';

    function confirm(id) {
        $("#status"+id).html("تائید شده");
        $.ajax({
            url: '/profile/relationEstateCustomer/confirm',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            dataType: 'json'
        })
        .done(function(response) {
            swal({
                title:l("تایید شد"),
                type: 'success',
                timer: 2000,
                allowOutsideClick: false
            }).then((result) => {
                //CheckSend();
            });

        })
        .fail(function() {
            swal('خطا!', l('متاسفانه عملیات با شکست مواجه گردید'), 'error');
        });
    };
    function reject(id) {
        $("#status"+id).html("رد شده");
        $.ajax({
            url: '/profile/relationEstateCustomer/reject',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            dataType: 'json'
        })
        .done(function(response) {
            swal({
                title:l("رد شد"),
                type: 'success',
                timer: 2000,
                allowOutsideClick: false
            }).then((result) => {
                //CheckSend();
            });

        })
        .fail(function() {
            swal('خطا!', l('متاسفانه عملیات با شکست مواجه گردید'), 'error');
        });
    };
    function priority(val , id)
    {
        $("#priority"+id).html(val);
        $.ajax({
            url: '/profile/relationEstateCustomer/priority',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                id: id,
                val: val
            },
            dataType: 'json'
        })
        .done(function(response) {
            swal({
                title:l("اولویت تغییر کرد"),
                type: 'success',
                timer: 2000,
                allowOutsideClick: false
            }).then((result) => {
                //CheckSend();
            });

        })
        .fail(function() {
            swal('خطا!', l('متاسفانه عملیات با شکست مواجه گردید'), 'error');
        });
    };

    $(".relationsmsend").click(function() {
        var customer_id = {{ $model->id }};
        var CSRF_TOKEN = '{{ csrf_token() }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
        $.ajax({
            url: '/sendRelationEstate/{{ $model->id }}',
            type: "GET",
            success: function(data) {
                $('#modelrelationsms').modal('toggle');
                swal({
                    title: "{{l('پیامک با موفقیت ارسال گردید')}}",
                    message: "",
                    confirmButtonColor: '#025EC6',
                    confirmButtonText: l('باشه'),
                    type: "success",
                    timer: 2000
                });
            },
        });
    });
    $(".smsend").click(function() {
        var customer_id = {{ $model->id }};
        var CSRF_TOKEN = '{{ csrf_token() }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
        $.ajax({
            url: '/customer/absence',
            type: "POST",
            data: {
                'customer_id':customer_id ,

            },
            success: function(data) {
                $('#modelsms').modal('toggle');
                swal({
                    title: "{{l('پیامک با موفقیت ارسال گردید')}}",
                    message: "",
                    confirmButtonColor: '#025EC6',
                    confirmButtonText: l('باشه'),
                    type: "success",
                    timer: 2000
                });

            },
        });
    });
    $(document).ready(function() {
        $(".btnOperation").click(function() {
            comment = $('#comment').val();
            type = $('#type').val();
            customer_id = {{ $model->id }};
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
                    'customer_id': customer_id,
                    'comment': comment,
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
                    getOperations({{ $model->id }});
                },
            });
        });
        $(".close").click(function() {
            $("#myModal").modal('hide');
        });
    })
    function getOperations(customer_id)
    {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});
        $.ajax({
            url: '/operationsCustomer/' + customer_id,
            type: "GET",
            success: function(data) {
                //console.log(data.html);
                $(".opertionlogs").html(data.html);
            }
        });
    }
    @if($currentUser && ($currentUser->isExpert() || $currentUser->isAdmin()))
    getOperations({{ $model->id }});
    @endif
</script>
@endsection
