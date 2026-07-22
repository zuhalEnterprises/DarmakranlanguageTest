@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME')
])

<style>
    .table-p{
    max-height:600px;
    overflow:auto;
    }

    thead tr:nth-child(1) th{
        position: sticky;
        top: 0;
        z-index: 10;
    }

table{color:black!important}

@media (min-width: 1000px){
.modal-dialog {
  max-width: 800px!important;
  margin: 1.75rem auto;
}
}
</style>
@section('main_content')

<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => '2'])
            <!-- Content-->
            <div class="col-lg-9 col-md-12 mb-5">
                <!-- Breadcrumb-->
            <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> {{l('نمایش قولنامه')}}</li>
                </ol>
            </nav>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="h2 mb-0">
                        {{l('نمایش قولنامه')}}
                    </h1>
                    <a class="btn btn-primary btn-sm ms-2 order-lg-3 d-none d-lg-block" href="/profile/contract/add"><i class="fi-plus me-2"></i>{{ l('ثبت قولنامه جدید') }}</a>

                </div>
                <div class="card shadow-sm rounded mb-4">
                    <div class=" card-body border-0  pb-1 me-lg-1 table-p">

                        <table id="example" style="width: 100%" class="table table-bordered table-striped table-hover" dir="rtl">
                        <thead class="table-primary">
                                <tr>
                                    {{-- <th class="text-center" style="width: 50px;">{{ l('ردیف') }}</th>--}}
                                    <th class="text-center fixed-width-sm">{{ l('شناسه') }}
                                        <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'id']))}}"><i class="icon-caret-down"></i></a>
                                        <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'-id']))}}"><i class="icon-caret-up"></i></a>
                                    </th>

                                    <th class="text-center">{{ l('کد قولنامه') }}</th>
                                    <th class="text-center">{{ l('تاریخ ثبت قولنامه') }}
                                        <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'register_at']))}}"><i class="icon-caret-down"></i></a>
                                        <a href="{{url()->current().'?'.http_build_query(array_merge(request()->all(),['sort' =>'-register_at']))}}"><i class="icon-caret-up"></i></a>
                                    </th>
                                    <th class="text-center">{{ l('نوع قولنامه') }}</th>
                                    <th class="text-center">{{ l('نوع ملک') }}</th>
                                    <th class="text-center">{{ l('جمع کمیسیون(تومان)') }}</th>

                                    <th class="text-center"></th>
                                </tr>

                        </thead>
                        <tbody>
                                @foreach( $model as $item)
                                <tr>
                                    {{-- <td class="text-center"><input type="checkbox" class="checkboxes" name="ids[]" value="{{$item->id}}" /></td>--}}
                                    {{-- <td class="text-center">{{toPersianNumbers($loop->iteration)}}</td>--}}
                                    <td tabindex="0" class="text-center">{{$item->id}}</td>

                                    <td class="text-center"><span class="bg-gray label text-sm">{{$item->contractid}}</span></td>
                                    <td>{{toPersianDateYdm($item->register_at)}}</td>
                                    <td>{{$item->type == 1 ? l('فروش') : ($item->{{ l('type == 2 ? \'اجاره\' : \'غیره\')}}') }}</td>
                                    <td>{{mapEstateCategoryName($item->estate_type)}}</td>
                                    <td class="text-center">{{toPersianNumbers($item->total_commission)}}</td>

                                    <td class="text-center">

                                        @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super'))
                                        <a href="/profile/contract/{{$item->id}}/edit" class="icon edit text-decoration-none">
                                            <i class="fa fa-edit "></i>
                                        </a>
                                        @endif
                                        @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super'))
                                        <span data-toggle="tooltip" title="{{ l('نمایش پرداختی های قولنامه') }}">
                                            <a href="/profile/contractearn/{{$item->id}}" class="text-decoration-none">
                                                <i class="fa {{$item->archived == 1 ? 'fa-folder' : 'fa-folder-open'}}"></i>
                                            </a>
                                        </span>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="my_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <form role="form" method="POST" id="frm-history" action="">
            <input type="hidden" name="type" value="archive">
            @csrf
            <div class="modal-content" style="width: 650px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel"></h4>
                </div>
                <div class="modal-body" id="modal-body">
                    <div class="form-group ">
                        <label for="modal-description" class="required">{{ l('توضیحات') }}</label>
                        <textarea class="form-control" name="description" id="modal-description" required></textarea>
                        <p class="text-red" id="description-error" style="display: none">{{ l('فیلد توضیحات الزامیست!') }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-right">
                        <i class="fa fa-save"></i> {{ l('ذخیره') }}
                    </button>
                    <button class="btn btn-danger pull-left" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i> {{ l('انصراف') }}
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<div class="modal fade" id="modal-history" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 750px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel"></h4>
            </div>
            <div class="modal-body" id="modal-body" style="background-color: #ecf0f5;">
                <p class="text-center" id="loading">{{ l('در حال دریافت اطلاعات ...') }}</p>
                <ul class="timeline">
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="estatecheck" style="background:white" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel"> {{l('پرداخت کمیسیون')}} </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="estatecheck1">
        </div>
      </div>
    </div>
  </div>

@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection

@section('js')
<script type="text/javascript">
    var route = 'contracts';
    var CSRF_TOKEN = '{{csrf_token()}}';
    function ContractEarn(id)
    {
        $.ajax({
            type: 'POST',
            url: '/profile/contractearn',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            data: {
                _method:'post',
                contract_id:id,
            },
            error: function (xhr, status, error) {
            },
            success: function (response) {
                if(response.count>0){ $('#estatecheck').modal('toggle') $("#estatecheck1").html(response.html); } } }); } $(document).ready(function() { $(".close").click(function(){ $('#estatecheck').modal('toggle') }) // show search $(".search-admin").on("click", function() { $(".form-search").toggleClass("hide-search"); }) // show detail $("a.detail").on("click", function() { var id = $(this).data('id'); location.href = "/profile/" + route + "/" + id; }); // edit $("a.edit").on("click", function() { var id = $(this).data('id'); location.href = "/admin/" + route + "/" + id + "/edit"; }); // archive item $("a.archive").on("click", function() { var id = $(this).data('id'); var archiveStatus = $(this).data('archive'); archiveStatus == 1 ? $('.modal-title').text('خروج از بایگانی') : $('.modal-title').text('بایگانی قولنامه') $("#frm-history").attr('action', '/admin/contracts/history/' + id + '/archive'); }); $('#modal-history').on('submit', function(e) { if ($('#modal-description').val().trim().length == 0) { $('#modal-description').focus(); $('#description-error').show(); return false; } return true; e.preventDefault(); }); $("#modal-history").on('show.bs.modal', function(e) { $('ul.timeline').empty(); var id = $(e.relatedTarget).data('id'); var code = $(e.relatedTarget).data('code'); var htmlContent = '<div>{{ l('کد قولنامه: \' + \'') }}<span class="text-aqua">' + code + '</span>&emsp;';
            $('#modal-history h4.modal-title').html(htmlContent);
            $('#loading').fadeIn(500);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $.ajax({
                url: '/admin/contracts/history/' + id,
                type: "GET",
                success: function(data) {
                    var res = data.data.result;
                    console.log(res);
                    var itemList = '';
                    if (res != null) {
                        //$.each(res, function (i) {
                        $.each(res, function(key, value) {
                            console.log(value);
                            itemList += '<li>' +
                                '<i class="bg-orange fa fa-user"></i>' +
                                '<div class="timeline-item">' +
                                '<span class="time"><i class="fa fa-clock-o"></i> ' +
                                '<span id="history-datetime">' + value.date + '</span>' +
                                '</span>' +
                                '<h3 class="timeline-header">' +
                                '<a href="#" id="history-user" class="iranYekanLight text-black">' + value.user + '</a> : ' +
                                '<span id="history-action" class="text-green">' + value.action + '</span>' +
                                '</h3>' +
                                '<div class="timeline-body" id="history-description">' + value.description + '</div>' +
                                '</div>' +
                                '</li>';
                        });
                        //});

                    }
                    $('ul.timeline').append(itemList)
                    $('#loading').hide();
                },
            });
        });

        // remove item




        $("a.remove").on("click", function() {
            var id = $(this).data('id');
            var name = $(this).data('name');

                        $.ajax({
                                url: '/admin/' + route + '/' + id,
                                type: 'POST',
                                data: {
                                    _token: CSRF_TOKEN,
                                    _method: 'DELETE'
                                },
                                dataType: 'json'
                            })
                            .done(function(response) {
                                swal({
                                    text: l('گزینه مورد نظر با موفقیت حذف شد.'),
                                    type: 'success',
                                    allowOutsideClick: false,
                                }).then((result) => { location.reload(); }); }) .fail(function() { swal('خطا!', 'حذف با مشکل مواجه شد!', 'error'); }); }); });
</script>
@endsection
