<style>
    .lable-gold{
        background-color: #ffdd05;
    }
    .lable-silver{
        background-color: #9d9d9d;
    }
    .lable-bronze{
        background-color: #f1b478;
    }
    .table-p{
        max-height:600px;
        overflow:auto;
    }
    thead tr:nth-child(1) th{
        position: sticky;
        top: 0;
        z-index: 10;
    }

</style>

<div class="border rounded p-3 mb-3 bg-secondary">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-1 w-100 w-lg-auto me-auto">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <p class="m-0">
                    <b> {{l('تعداد نتایج')}}:  </b>
                    {{$totalCount}} {{l('مشتری')}}
                </p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-1">
            <span class="help-table-color border" style="background-color:#a1c0fa"></span>
            <p class="m-0">{{l('الماس')}}</p>
        </div>
        <div class="d-flex align-items-center gap-1">
            <span class="help-table-color border" style="background-color:#ffdd05"></span>
            <p class="m-0">{{l('طلایی')}}</p>
        </div>
        <div class="d-flex align-items-center gap-1">
            <span class="help-table-color border" style="background-color:#9d9d9d"></span>
            <p class="m-0">{{l('نقره ای')}}</p>
        </div>
        <div class="d-flex align-items-center gap-1">
            <span class="help-table-color border" style="background-color:#f1b478"></span>
            <p class="m-0">{{l('برنزی')}}</p>
        </div>
    </div>
</div>

<div class="row">
@php
$labelcolor = array(0 => '' , 1 => 'lable-bronze' , 2 => 'lable-silver' , 3 => 'lable-gold' , 4 => 'lable-diamond');
@endphp
@foreach($model as $item)
<div class="col-md-12 col-lg-12 col-sm-12 mb-5">
    <div class="card shadow-lg pb-1 me-lg-1">
        <div class="card-header  bg-secondary">
            <div class="row">
                <a href="/customer/{{$item->id}}" class="col-6 col-lg-2 col-sm-6 mt-2 mt-lg-3 text-decoration-none text-dark">

                    <span>
                    {{l('کدمشتری')}}:
                    </span>
                    <h6 class="card-title">
                        <span class="{{$labelcolor[(int)$item->label]}}  " style="padding:2px;color:#000">&nbsp;{{$item->id}}&nbsp; </span>
                    </h6>
                </a>
                <div class="col-2 col-lg-1 order-lg-last mt-2 mt-lg-3 ms-auto">
                    @if($currentUser->isExpert() || $currentUser->isAdmin())

                    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fi-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                        <li>
                            <a class="dropdown-item" target="_blank" href="/customer/{{$item->id}}">
                                <i class="fa-light fa-eye opacity-60 me-2"></i>{{l('مشاهده جزئیات')}}
                            </a>
                        </li>
                        @if($item->user_id == $currentuserid || $currentUser->isAdmin() )
                        @if($item->status == 1)
                        <li>
                            <a class="dropdown-item"  target="_blank" href="/customer/{{$item->id}}/edit_v2" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                {{l('ویرایش')}}
                            </a>
                        </li>
                        @if(env('COUNTRY') != 'UAE')
                        <li>
                            <a class="dropdown-item"  target="_blank" style="cursor:pointer" onclick="if(confirm('{{l('آیا از بروزکردن این تقاضا مطمئن هستید؟')}}'))ladder({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-edit"></i>
                                {{l('بروزرسانی')}}
                            </a>
                        </li>
                        @endif
                        @endif
                        @if($currentUser->isAdmin())
                        <li>
                            @if($item->status == 1)
                            <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm('{{l('آیا از آرشیو کردن این تقاضا مطمئن هستید؟')}}'))deleteclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                {{l('انتقال به آرشیو')}}
                            </a>
                            @else
                            <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm('{{l('آیا از جاری کردن این تقاضا مطمئن هستید؟')}}'))undeleteclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                {{l('انتقال به جاری')}}
                            </a>
                            @endif
                        </li>
                        @endif
                        @if($currentUser->isAdmin() && 0)
                        <li>
                            <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm(l('آیا از حذف این تقاضا مطمئن هستید؟')))deleteclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                {{l('حذف تقاضا')}}
                            </a>
                        </li>
                        @endif
                        @endif
                        @if($item->user_id != null && ($currentUser->isAdmin() || ($currentUser->isExpert() &&  $item->user_id == $currentuserid) ))
                        <li>
                            <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm('{{l('آیا از حذف کارشناس این تقاضا مطمئن هستید؟')}}'))removeagentclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                {{l('حذف کارشناس')}}
                            </a>
                        </li>
                        @endif
                        @if(!$currentUser->isAdmin() && $currentUser->isExpert() &&  $item->user_id == null)
                        <li>
                            <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm('{{l('آیا از انتقال کارشناس این تقاضا مطمئن هستید؟')}}'))assigntomeclick({{$item->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                {{l('انتقال به من')}}
                            </a>
                        </li>
                        @endif
                    </ul>
                    @endif
                </div>
                <a href="/customer/{{$item->id}}" class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3 text-decoration-none text-dark">
                    <span class="">{{l('ایجاد کننده')}}:</span>
                    <h6 class="card-title">
                        {{$item->creator && $item->creator->fullname() ? $item->creator->fullname() : '------------'}}
                    </h6>
                </a>
                <a href="/customer/{{$item->id}}" class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3 text-decoration-none text-dark">
                    <span class="">{{l('نام مشاور')}}:</span>
                    <h6 class="card-title">
                        {{$item->user && $item->user->fullname() ? $item->user->fullname() : '------------'}}
                    </h6>
                </a>

                @if($currentUser->isAdmin() || $currentUser->id == $item->user_id )
                <a href="/customer/{{$item->id}}" class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3 text-decoration-none text-dark">
                    <span class="">{{l('نام خریدار')}}:</span>
                    <h6 class="card-title">
                        {{$item->name}}
                    </h6>
                </a>
                @endif
                @if($currentUser->isAdmin() || $currentUser->id == $item->user_id )
                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3 text-decoration-none text-dark">
                    <span class="">{{l('تلفن خریدار')}}:</span>
                    <h6 style="cursor:pointer"  onclick="addOperation({{$item->id}} , '{{$item->mobile}}')" class="card-title">
                         {{$item->mobile}}
                    </h6>
                </div>
                @endif
                @if($item->grade > 0)
                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                    <span class="">{{l('نوع مشتری')}}:</span>
                    <h6 class="">
                        {{CustomerGrade($item->grade)}}
                    </h6>
                </div>
                @endif
                @if($item->language != null)
                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                    <span class="">{{l('زبان')}}:</span>
                    <h6 class="">
                        {{$item->language->name}}
                    </h6>
                </div>
                @endif
                @if($item->country != null)
                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                    <span class="">{{l('کشور')}}:</span>
                    <h6 class="">
                        {{$item->country->name}}
                    </h6>
                </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                    <span class="">{{l('نوع معامله')}}:</span>
                    <h6 class="">
                        {{$item->{{ l('request_type == 1 ? l(\'خرید\') : l(\'اجاره\')}}') }}
                    </h6>
                </div>
                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                    <span class="">{{l('نوع ملک')}}:</span>
                    <h6 class="">
                        {{estateTypes($item->estate_type)}}
                    </h6>
                </div>

                @if($item->request_type == 1)
                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                    <span class="">{{l('قیمت از (تومان)')}}:</span>
                    <h6 class="">
                        {{toPersianNumbers($item->price_min)}}
                    </h6>
                </div>
                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                    <span class="">{{l('قیمت تا (تومان)')}}:</span>
                    <h6 class="">
                        {{toPersianNumbers($item->price_max)}}
                    </h6>
                </div>
                @else

                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                    <span class="">{{l('اجاره از (تومان)')}}:</span>
                    <h6 class="">
                        {{toPersianNumbers($item->rent_min)}}
                    </h6>
                </div>
                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                    <span class="">{{l('اجاره تا (تومان)')}}:</span>
                    <h6 class="">
                        {{toPersianNumbers($item->rent_max)}}
                    </h6>
                </div>

                @endif
                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                    <span class="">{{l('مساحت از')}}:</span>
                    <h6 class="">
                        {{$item->area_min}}
                    </h6>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 mt-2 mt-lg-3">
                    <span class="">{{l('محلات')}}:</span>
                    <span class="fw-bold font-medium ">
                        @foreach($item->districts as $district)
                        <span class="fw-bold badge bg-faded-info m-1 ">{{$district->name}}</span>
                        @endforeach
                    </span>

                </div>

            </div>

        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                    <span class="">{{l('آخرین تماس')}}:</span>
                    <h6 class="">
                        @php
                        $last_operation = last_operation(11 , $item->id);

                        if($last_operation != null)
                        {
                            echo $last_operation->created_at;
                        }
                        else
                        {
                            echo '----------';
                        }
                        @endphp
                    </h6>
                </div>
                <div class="col-6 col-md-6 col-lg-2 col-sm-6 mt-3">
                    <span class="">{{l('آخرین واتساپ')}}:</span>
                    <h6 class="">
                        @php
                        $last_operation = last_operation(17 , $item->id);
                        if($last_operation != null)
                        {
                            echo $last_operation->created_at;
                        }
                        else
                        {
                            echo '----------';
                        }
                        @endphp
                    </h6>
                </div>
                <div class="col-6 col-md-6 col-lg-8 col-sm-12 mt-3">
                    <span class="">{{l('آخرین نظر')}}:</span>

                    <h6 class="">
                        @php

                        $last_operation = last_operation(12 , $item->id);
                        if($last_operation != null)
                        {
                            echo $last_operation->comment;
                        }
                        else
                        {
                            echo '----------';
                        }
                        @endphp
                    </h6>
                </div>
            </div>
        </div>
    </div>

</div>
@endforeach
</div>
<div class="modal fade" id="modal-editreview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-block position-relative border-0 pb-0 px-sm-5 px-4">
            <h4 class="modal-title mt-4 text-center font-vazir">{{l('دلیل حذف کارشناس')}}</h4>
            <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form  id="js_singup-expert" role="form"  method="POST">
            <div class="modal-body px-sm-5 px-4">
                <input type="hidden" name="customerId" id="customerId">
                <div class="mb-4">
                    <label class="form-label" for="comment">
                        {{l('توضیحات')}}
                        <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control" id="editcomment" name="editcomment" rows="5" placeholder="{{l('توضیحات')}}" required></textarea>
                    <div class="invalid-feedback">{{l('نظر خود را ثبت کنید')}}</div>
                </div>
                <button class="btn btn-primary d-block w-100 mb-4 btnEditOperation" type="submit">{{l('ثبت عملکرد')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    var CSRF_TOKEN = '{{csrf_token()}}';
    var userID = '{{$currentUser->id ?? 0}}';
    function deleteclick(customerId) {
        $.ajax({
                url: '/notecustomer/delete',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    customerid: customerId
                },
                dataType: 'json'
            })
            .done(function(response) {
                swal({
                    text: '{{l('گزینه مورد نظر با موفقیت حذف شد.')}}',
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => {
                    CheckSend();
                    //location.reload();
                });
            })
            .fail(function() {
                swal('خطا!', '{{l('حذف با مشکل مواجه شد!')}}', 'error');
            });
    }
    function removeagentclick(customerId)
    {
        $('#customerId').val(customerId);
        $('#modal-editreview').modal('toggle');
        /*

        */
    }
    $(document).ready(function() {
        $('#js_singup-expert').validate({
            errorPlacement: function (error, element) {
                var type = $(element).attr('cus-valid')
                if (type == 'true') {
                    error.insertAfter(element.parent().parent());
                } else {
                    error.insertAfter(element)
                }
            },
        });
        $(".btnEditOperation").click(function()
        {
            if($('#editcomment').val() == '')
            {
                return ;
            }

            $('#modal-editreview').modal('toggle');
            var customerId = $('#customerId').val();
            var comment = $('#editcomment').val();
            $.ajax({
                url: '/customer/removeagent',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    customerid: customerId,
                    comment: comment
                },
                dataType: 'json'
            })
            .done(function(response) {
                swal({
                    text: '',
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => {
                    CheckSend();
                    //location.reload();
                });
            })
            .fail(function() {
                swal('خطا!', '{{l('حذف با مشکل مواجه شد!')}}', 'error');
            });
            return false;
        });
    })
    function assigntomeclick(customerId) {
        $.ajax({
                url: '/customer/assignToMe',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    customerid: customerId
                },
                dataType: 'json'
            })
            .done(function(response) {
                swal({
                    text: '',
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => {
                    CheckSend();
                    //location.reload();
                });
            })
            .fail(function(response) {
                if(response.status == 422){
                    swal('{{l('خطا')}}!', 'You have become an agent on a property over time', 'error');
                }
            });
    }

    function ladder(customerId) {
        $.ajax({
                url: '/customer/ladder',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    customerid: customerId
                },
                dataType: 'json'
            })
            .done(function(response) {
                swal({
                    text: '',
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => {
                   // CheckSend();
                });
            })
            .fail(function() {
                swal('{{l('خطا!')}}', '{{l('حذف با مشکل مواجه شد!')}}', 'error');
            });
    }
    function undeleteclick(customerId) {
        $.ajax({
                url: '/notecustomer/undelete',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    customerid: customerId
                },
                dataType: 'json'
            })
            .done(function(response) {
                swal({
                    text: '{{l('تقاضا با موفقیت جاری گردید')}}',
                    type: 'success',
                    allowOutsideClick: false
                }).then((result) => {
                    CheckSend();
                    //location.reload();
                });
            })
            .fail(function() {
                swal('{{l('خطا!')}}', '{{l('مشلکلی بوجود آمده است!')}}', 'error');
            });
    }
    function addOperation(id , mobile)
    {
        customer_id = id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
        $.ajax({
            url: '/estate/addOperation',
            type: "POST",
            data: {
                'type': 11,
                'customer_id': customer_id,
                'comment': '',
            },
            success: function(data) {
                var res = data.data;
                var operation = res.operation_id;
            },
        });
        window.open('tel:mobile');
    }
</script>
<style>
    .sortable{
        /* color:blue !important; */
        cursor: pointer
    }
    .table > :not(caption) > * > * {
        padding: 0.5rem;
    }
</style>

