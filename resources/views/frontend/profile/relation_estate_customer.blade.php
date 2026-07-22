@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME')
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
                @include('frontend.layouts.sidebar', ['menu' => '10'])
                <!-- Content-->
                <div class="col-lg-9 col-md-12 mb-5">
                    <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ l('مالکین و مشتریان متناسب') }}</li>
                    </ol>
                </nav>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h1 class="h2 mb-0">
                            {{ l('مالکین و مشتریان متناسب') }}
                        </h1>
                        <div>
                            <span class="btn btn-lg btnAdd btn-primary w-100 mb-2">
                            {{ l('افزودن') }}
                            </span>
                        </div>
                    </div>
                    <div class="card shadow-sm rounded mb-4">
                        <form  id="mySearch">
                        <div class=" card-body border-0  pb-1 me-lg-1">
                            <input type="hidden" name="order" id="order" value="id">
                            <input type="hidden" name="orderby" id="orderby" value="desc">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{ l('کدملک') }}</label>
                                    <input type="text" class="form-control" id="estate_id" name="estate_id" />
                                </div>
                                @if($currentUser->isAdmin() && 0)
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{ l('مشاور فروش') }}</label>
                                    <select class="form-control select2" name="estate_expert_id" id="estate_expert_id" style="width:100%">
                                        <option value="" {{$currentUser->isAdmin()?'selected':''}}>{{l('همه مشاورین')}}</option>
                                        @foreach($users as $item)
                                            <option value="{{$item->id}}">{{$item->fullname()}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{ l('کد مشتری') }}</label>
                                    <input type="text" class="form-control" id="customer_id" name="customer_id" />
                                </div>
                                @if($currentUser->isAdmin())
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{ l('مشاور خرید') }}</label>
                                    <select class="form-control select2" name="customer_expert_id" id="customer_expert_id" style="width:100%">
                                        <option value="" {{$currentUser->isAdmin()?'selected':''}}>{{l('همه مشاورین')}}</option>
                                        @foreach($users as $item)
                                            <option value="{{$item->id}}">{{$item->fullname()}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{ l('مشاهده شده') }}</label>
                                    <select class="form-control form-select" id="seen_estate" name="seen_estate">
                                        <option></option>
                                        <option value="0">{{ l('مشاهده نشده') }}</option>
                                        <option value="1">{{ l('مشاهده شده') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{ l('وضعیت') }}</label>
                                    <select class="form-control form-select" id="status" name="status">
                                        <option></option>
                                        <option value="0">{{ l('جدید') }}</option>
                                        <option value="1">{{ l('رد شده') }}</option>
                                        <option value="2">{{ l('تائید شده') }}</option>
                                        <option value="3">{{ l('ارسال شده') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center my-4 ">
                                <button id="form_search" class="btn btn-primary">
                                    {{ l('جستجو') }}
                                </button>
                            </div>
                        </div>
                        </form>
                        <div class="tab-content1" id="state">
                        </div>
                        <nav class="pt-4 pb-2 border-top" aria-label="Blog pagination" id="pagination">
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header px-4 py-3">
                    <h4 class="modal-title" id="exampleModalLabel">{{ l('افزودن') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding:40px 30px;">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                            <label>{{ l('کدملک') }}</label>
                            <input type="text" class="form-control" id="estate_add" name="estate_add" value=""/>
                        </div>
                        <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                            <label>{{ l('کد مشتری') }}</label>
                            <input type="text" class="form-control" id="customer_add" name="customer_add" />
                        </div>
                        <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                            <label>&nbsp;</label>
                            <button id="form_add" class="form-control btn btn-primary" onclick="addRel()">
                                {{ l('افزودن') }}
                            </button>
                        </div>
                    </div>
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
    $(document).ready(function(){
        $('#mySearch').on('submit', function(e){
            e.preventDefault();
            return false;
        });
    });
    $(".btnAdd").click(function() {
        $("#myModal").modal('show');
    });
    function addRel(id) {
        estate_id = $('#estate_add').val();
        customer_id = $('#customer_add').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
        $.ajax({
            url: '/estate/addRelation',
            type: "POST",
            data: {
                'customer_id': customer_id,
                'estate_id': estate_id
            },
            success: function(data) {
                var res = data.data;
                var operation = res.operation_id;
                $('#estate_add').val('');
                $('#customer_add').val('');
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
        sr += ($('#customer_id').val() != '') ? "customer_id=" + $('#customer_id').val() + "&" : "";
        sr += ($('#estate_id').val() != '') ? "estate_id=" + $('#estate_id').val() + "&" : "";
        sr+=(typeof $('#estate_expert_id').val()!=='undefined' && $('#estate_expert_id').val()>0)?"estate_expert_id="+$("#estate_expert_id").val()+"&":"";
        sr+=(typeof $('#customer_expert_id').val()!=='undefined' && $('#customer_expert_id').val()>0)?"customer_expert_id="+$("#customer_expert_id").val()+"&":"";
        sr+=(typeof $('#seen_estate').val()!=='undefined')?"seen_estate="+$("#seen_estate").val()+"&":"";
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
                url: "/profile/relationEstateCustomerShow?page="+page+"&&"+type,
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
            if(pagin>0){ loadMoreData($(this).attr("pn"),type1); } } ); $(document).ready(function() { CheckSend(); }); function addComment(id , type) { $("#relId").val(id); $("#type").val(type); $("#commentModal").modal('show'); }; function confirm(id) { $.get("/relationEstateCustomerShow/confirm/" + id, function(data, status) { swal({ title:l("ملک پیشنهادی با کد") + id + l("با موفقیت تائید شد"), text: "", type: 'success', allowOutsideClick: true, }); CheckSend(); }); }; function reject(id) { $.get("/relationEstateCustomerShow/reject/" + id, function(data, status) { swal({ title:l("ملک پیشنهادی با کد") + id + l("با موفقیت رد شد"), text: "", type: 'success', allowOutsideClick: true, }); CheckSend(); }); };
</script>
@endsection
