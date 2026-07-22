@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME')
])

<style>
table{color:black!important}

@media (min-width: 1000px){
.modal-dialog {
  max-width: 800px!important;
  margin: 1.75rem auto;
}
}
</style>
<link rel="stylesheet" href="/assets/css/sweetalert.css" />
<script src="/assets/js/sweetalert.min.js"></script>
@section('main_content')
<form method="POST" action="/profile/partiesAdd" id="form1">
    @csrf
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
                    <li class="breadcrumb-item"><a href="/profile/contract">{{l('قولنامه ها')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> {{l('نمایش پرداختی های قولنامه')}}</li>
                </ol>
            </nav>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="h2 mb-0">
                        {{l('نمایش پرداختی های قولنامه')}}
                    </h1>
                  <div>
                    <input type="button" class="btn btn-danger" value="{{ l('پرداخت جدید') }}" onclick="showparties()"/>
                  </div>
                </div>


                <div class="card shadow-sm mt-2">
                    <div class=" card-body border-0  pb-1 me-lg-1">
<div class="my-3 table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th scope="col">{{ l('ردیف') }}</th>
                <th scope="col">{{ l('نام کاربر') }}</th>
                <th scope="col">{{ l('طرف قرارداد') }}</th>
                <th scope="col">{{ l('مبلغ کمیسیون اخذ شده') }}</th>
                <th scope="col">{{ l('شماره رسید') }}</th>
                <th scope="col">{{ l('سند رسید') }}</th>
                <th scope="col">{{ l('توضیحات') }}</th>
                <th></th>

            </tr>
        </thead>
        <tbody>
            <?php
                $ii=1;
            ?>
            @foreach($ContractParties as $Contract)
            <tr id="row_<?php echo $Contract->id; ?>">
                <td align="center">
                    <?php echo $ii++; ?>
                </td>
                <td align="center">
                    {{$Contract->name}}
                </td>
                <td align="center">
                    {{$Contract->{{ l('type==1? l("فروشنده"):l("خریدار")}}') }}
                </td>
                <td align="center">
                    {{$Contract->commission}}
                </td>
                <td align="center">
                    {{$Contract->receipt_number}}
                </td>
                <td align="center">
                    {{$Contract->receipt_doc}}
                </td>
                <td align="center">
                    {{$Contract->description}}
                </td>
                <td class="text-center">
                    <span class="p-1" onclick="showparties({{$Contract->id}})" style="cursor: pointer;">
                    <i class="fa fa-pen text-green"></i>
                    </span>
                    <span class="p-1"  onclick="destroy({{$Contract->id}})" style="cursor: pointer;">
                    <i class="fa fa-close text-danger"></i>
                    </span>
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
</div>
</main>
<div class="modal fade" id="estatecheck"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel"> {{l('پرداخت جدید')}} </h5>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="createparties">


        </div>
      </div>
    </div>
  </div>
  <input type="hidden" id="js_csrf_token" value="{{ csrf_token() }}">
</form>
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection

@section('js')
<script src="{{asset('frontend/vendor/sweetalert2.all.js')}}"></script>
<script>
    $('.trigger-swal').on('click', function () {
        swal("آیا از حذف قولنامه مطمئن هستید؟ ", {
  dangerMode: true,
  buttons: true,
});

})

    function showparties(id){
        $.ajax({
            type: 'POST',
            url: '/profile/createparties',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            data: {
                _method:'post',
                contract_id:{{$id}},
                id:id
            },
            error: function (xhr, status, error) {
            },
            success: function (response) {
                if(id>0)
                $("#form1").attr('action','/profile/partiesEdit')
                $('#estatecheck').modal('toggle')
                $("#createparties").html(response.html);

            }
        });
    }

    function destroy(id){
        swal({
        text: " {{l('آیا از حذف گزینه مورد نظر اطمینان دارید')}} ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: "{{l('لغو')}}",
        confirmButtonText: "{{l('بله')}}",
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.get("/profile/partiesDestroy/"+id, function(data, status) {
                    swal({
                            title: "",
                            text: "{{l('گزینه مورد نظر با موفقیت حذف شد')}}.",
                            type: 'success',
                        }).then((result)=>{
                            $('#row_'+id).remove();
                    });
                })
            })
        },
        allowOutsideClick: ()=>!swal.isLoading()
    });
    }
 const toast = swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 2500
    });



    $(".close").click(function(){
        $("#form1").attr('action','/profile/partiesAdd')
    $('#estatecheck').modal('toggle')
})
</script>
@endsection
