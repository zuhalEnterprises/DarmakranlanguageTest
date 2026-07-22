@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('جزئیات تقاضا')
])
@section('main_content')
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
<!-- main -->
<main class="page-wrapper">
    @include(ss('THEME') . '.frontend.layouts.header_v2')
    <div class="container mt-1 pt-1 p-0">

    </div>
    <section class="container mt-5 mb-lg-5 mb-4 pt-5 pb-lg-5">
        <!-- Breadcrumb-->
        <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="real-estate-home-v1.html">{{l('خانه')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> {{l('جزئیات تقاضا')}} </li>
            </ol>
        </nav>

        <div>
            <div>
                <!-- جزییات خریدار -->
                <div class="px-2 row">
                    @if (!$currentUser->isAdmin() && $model->user_id != $currentUser->id)
                    @if(isset($model->user))
                    <div class="col-6 col-sm-3 mb-3">
                        <p class=" mb-2">
                            {{l('مشاور')}}:
                        </p>
                        <p class="fw-bold mb-0">
                            {{$model->user->fullname()}}
                        </p>
                    </div>

                    @endif
                    @else
                    <div class="col-12 col-sm-12  col-lg-6">
                        <h3 class="text-[32px] text-gray-500 font-extrabold">
                        @if($model->gender == 'female')
                        {{l('سرکار خانم')}}
                        @else
                        {{l('جناب آقای')}}
                        @endif
                        {{$model->name}}
                        </h3>
                    </div>
                    @endif

                    <div class="col-6 col-sm-3 mb-3">
                        <p class=" mb-2">
                            {{l('تاریخ ثبت')}}:
                        </p>
                        <p class="fw-bold mb-0">
                            {{toPersianDate($model->created_at)}}
                        </p>
                    </div>
                    @if (env('COUNTRY') == 'UAE')
                    <div class="col-6 col-sm-3 mb-3">
                        <p class=" mb-2">
                            {{l('ثبت کننده')}}:
                        </p>
                        <p class="fw-bold mb-0">
                            {{$model->creator->fullname()}}
                        </p>
                    </div>
                    @endif
                    <div class="col-6 col-sm-3 mb-3">
                        <a href="/suggest/{{$model->guid}}" target="_blank">
                            {{l('صفحه ارسالی برای مشتری')}}
                        </a>
                    </div>

                </div>

                <div class=" rounded-2 py-3 mb-3">
                    <div class="px-2 row">
                        <div class="col-6 col-sm-3 mb-3">
                            <p class=" mb-2"> {{l('کدمشتری')}}: </p>
                            <p class="fw-bold mb-0">
                                <span class="font-medium">{{$model->id}}</span>
                            </p>
                        </div>
                        @if ($currentUser->isAdmin() || $model->user_id == $currentUser->id)
                        <div class="col-12 col-sm-12  col-lg-9">
                            <p class=" mb-2">
                                {{l('تلفن مشتری')}}:
                            </p>
                            <p class="fw-bold mb-0">
                                <span class="font-medium">
                                    @if ($currentUser->isAdmin() || $model->user_id == $currentUser->id)
                                    <a href="javascript:void(0)" class="me-3 text-dark d-none d-lg-inline mb-2 mb-lg-0" onclick="addOperation(11)">
                                        {{$model->mobile}}
                                    </a>

                                    <a href="javascript:void(0)" onclick="addOperation(11)" class="btn btn-info rounded">
                                        <i class="text-[20px] text-[#8DD781]  fa-thin fa-phone"></i>
                                        <span class="text-[20px] text-[#8DD781] font-medium"> {{l('تماس')}} </span>
                                    </a>
                                    @if(ss('SITE_ID') == 4 &&  $model->mobile2 != '')
                                    <a href="javascript:void(0)" onclick="addOperation(17)" class="btn rounded text-white" style="background-color: #0eba44;">
                                        <i class="text-[20px] text-[#8DD781]  fi-whatsapp fs-base"></i>
                                        <span class="text-[20px] text-[#8DD781] font-medium"> {{l('واتساپ')}} </span>
                                    </a>
                                    @endif
                                    @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2 )
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modelsms" class="text-decoration-none ">
                                        <input class="btn btn-primary" type="button" value="{{l('ارسال پیامک عدم پاسخ فروشنده')}}" />
                                    </a>
                                    @endif
                                    @endif
                                </span>
                            </p>
                        </div>
                        @endif

                        @if ($currentUser->isAdmin())
                        @if($model->user != null)
                        <div class="col-6 col-sm-3 mb-3">
                            <p class=" mb-2"> {{l('مشاور')}}: </p>
                            <p class="fw-bold mb-0">
                                <span class="font-medium">
                                    {{$model->user->fullname()}}
                                </span>
                            </p>
                        </div>
                        @endif
                        @endif

                        @if ($currentUser->isAdmin() || $model->user_id != $currentUser->id)
                        @if($model->user != null)
                        <div class="col-12 col-sm-12  col-lg-9">
                            <p class=" mb-2">
                                {{l('تلفن مشاور')}}:
                            </p>
                            <p class="fw-bold mb-0">
                                <span class="font-medium">
                                    {{$model->user->username ?? ''}}
                                </span>
                            </p>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
                <div class=" rounded-2 py-3 mb-3">
                    <div class="px-2 row">
                        @if($model->build_date)
                        <div class="col-6 col-sm-3 mb-3">
                            <p class=" mb-2"> {{l('سال ساخت')}}: </p>
                            <p class="fw-bold mb-0">
                                <span class="font-medium">{{$model->build_date}}</span>
                            </p>
                        </div>
                        @endif
                        <div class="col-6 col-sm-3 mb-3">
                            <p class=" mb-2"> {{l('حداقل مساحت')}}: </p>
                            <p class="fw-bold mb-0">
                                <span class="font-medium">{{toPersianNumbers($model->area_min)}}</span> {{l('متر')}}
                            </p>
                        </div>
                        <div class="col-6 col-sm-3 mb-3">
                            <p class=" mb-2"> {{l('حداکثر مساحت')}}: </p>
                            <p class="fw-bold mb-0">
                                <span class="fw-bold font-medium">{{toPersianNumbers($model->area_max)}}</span> {{l('متر')}}
                            </p>
                        </div>
                        @if($model->request_type == 1)
                        <div class="col-6 col-sm-3 mb-3">
                            <p class=" mb-2">{{l('حداقل مبلغ')}}: </p>
                            <p class="fw-bold mb-0">
                                <span class="font-medium">{{toPersianNumbers($model->price_min)}}</span>
                                {{l('تومان')}}
                            </p>
                        </div>
                        <div class="col-6 col-sm-3 mb-3">
                            <p class=" mb-2">{{l('حداکثر مبلغ')}}: </p>
                            <p class="fw-bold mb-0">
                                <span class="font-medium">{{toPersianNumbers($model->price_max)}}</span>
                                {{l('تومان')}}
                            </p>
                        </div>
                        @endif
                        @if($model->request_type == 2)
                        @if($model->mortgage_min > 0)
                        <div class="col-6 col-sm-3 mb-3">
                            <p class=" mb-2">{{l('حداقل مبلغ ودیعه')}}: </p>
                            <p class="fw-bold mb-0">
                                <span class="font-medium">{{toPersianNumbers($model->mortgage_min)}}</span>
                                {{l('تومان')}}
                            </p>
                        </div>
                        @endif
                        @if($model->mortgage_max > 0)
                        <div class="col-6 col-sm-3 mb-3">
                            <p class=" mb-2">{{l('حداکثر مبلغ ودیعه')}}: </p>
                            <p class="fw-bold mb-0">
                                <span class="font-medium">{{toPersianNumbers($model->mortgage_max)}}</span>
                                {{l('تومان')}}
                            </p>
                        </div>
                        @endif
                        @if($model->rent_min > 0)
                        <div class="col-6 col-sm-3 mb-3">
                            <p class="mb-2">{{l('حداقل مبلغ اجاره')}}: </p>
                            <p class="fw-bold mb-0">
                                <span class="font-medium">{{toPersianNumbers($model->rent_min)}}</span>
                                {{l('تومان')}}
                            </p>
                        </div>
                        @endif
                        @if($model->rent_max > 0)
                        <div class="col-6 col-sm-3 mb-3">
                            <p class="mb-2">{{l('حداکثر مبلغ اجاره')}}: </p>
                            <p class="fw-bold  mb-0">
                                <span class="font-medium">{{toPersianNumbers($model->rent_max)}}</span>
                                {{l('تومان')}}
                            </p>
                        </div>
                        @endif
                        @endif
                    </div>
                    <div class="row px-2 border-text-200 ">
                        <div class="col-6 col-sm-3 mt-3">
                            <p class="mb-2">{{l('نوع ملک')}}:</p>
                            <p class="fw-bold font-medium mb-0">
                                {{$model->estate_type > 0 ? estateTypes($model->estate_type) : ''}}
                            </p>
                        </div>
                        <div class="col-6 col-sm-3 mt-3 d-none">
                            <p class="mb-2">{{l('تعجیل در خرید')}}: </p>
                            <p class="fw-bold font-medium mb-0">
                                {{$model->purchase_priority == 3 ? l('زیاد') : ($model->{{ l('purchase_priority == 2 ? l(\'متوسط\') : l(\'کم\'))}}') }}
                            </p>
                        </div>
                        <div class="col-6 col-sm-3 mt-3">
                            <p class="mb-2">{{l('وضعیت نقدینگی')}}: </p>
                            <p class="fw-bold font-medium mb-0">
                                @if($model->financial_liquidity_type)
                                    {{l(financialLiquidityTypes($model->financial_liquidity_type ?? ''))}}
                                @endif
                            </p>
                        </div>
                        <div class="col-6 col-sm-3 mt-3">
                            <p class="mb-2">{{l('نوع درخواست')}}: </p>
                            <p class="fw-bold font-medium mb-0">
                                @if($model->request_type == 1)
                                    {{l('خرید')}}
                                @endif
                                @if($model->request_type == 2)
                                    {{l('رهن و اجاره')}}
                                @endif
                            </p>
                        </div>
                        <div class="col-6 col-sm-3 mt-3">
                            <p class="mb-2">{{l('قابلیت معاوضه')}}: </p>
                            <p class="fw-bold font-medium mb-0">
                                @if($model->compensation  == 1)
                                    {{l('بله')}}
                                @endif
                                @if($model->compensation  == 0)
                                    {{l('خیر')}}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="rounded-2 py-3 px-2 mb-3 d-flex align-items-center">
                    <p class=" flex flex-col md:flex-row gap-1 text-gray-500 font-light mb-3 md:mb-3">
                        <span class=" ">{{l('محله های درخواستی')}}:</span>
                        <span class="fw-bold font-medium ">
                            @foreach($model->districts as $district)
                            <span class="fw-bold badge bg-faded-info m-1 ">{{$district->name}}</span>
                            @endforeach
                        </span>
                    </p>
                </div>
                <div class="rounded-2 py-3 px-2 mb-3 d-flex align-items-center">
                    <div class="w-50 text-gray-500 border-end border-gray-200 font-light flex flex-col md:flex-row">
                        <span class="">{{l('دلیل خرید')}}:</span>
                        <span class="fw-bold font-medium mb-0">
                            @if($model->purchase_reason)
                                {{l(purchaseReasons($model->purchase_reason ?? ''))}}
                            @endif
                        </span>
                    </div>
                </div>
                <div class=" rounded-2 py-3 mb-4">
                    <div class="px-2 row">
                        @if($model->grade > 0)
                        <div class="col-6 col-sm-3 mb-4">
                            <p class=" mb-2">{{l('نوع مشتری')}}:</p>
                            <p class="fw-bold mb-0">
                                {{CustomerGrade((int)$model->grade)}}
                            </p>
                        </div>
                        @endif

                        @if($model->max_room_count)
                        <div class="col-6 col-sm-3 mb-4">
                            <p class=" mb-2">{{l('حداقل تعداد خواب')}}:</p>
                            <p class="fw-bold mb-0">
                                {{$model->max_room_count}}
                            </p>
                        </div>
                        @endif
                        @if($model->max_unit_in_floor)
                        <div class="col-6 col-sm-3 mb-4">
                            <p class=" mb-2">
                                {{l('حداکثر تعداد واحد در طبقه')}}:
                            </p>
                            <p class="fw-bold mb-0">
                                {{$model->max_unit_in_floor}}
                            </p>
                        </div>
                        @endif
                        @if($model->max_building_age)
                        <div class="col-6 col-sm-3 mb-4">
                            <p class=" mb-2">
                                {{l('حداکثر عمر بنا')}}:
                            </p>
                            <p class="fw-bold mb-0">
                            <?php
                                switch($model->max_building_age){
                                    case '1':
                                        echo l('حداکثر 1 سال');
                                        break;
                                    case '2':
                                        echo l('حداکثر 2 سال');
                                        break;
                                        case '3':
                                        echo l('حداکثر 5 سال');
                                        break;
                                        case '4':
                                        echo l('حداکثر 10 سال');
                                        break;
                                        case '5':
                                        echo l('حداکثر 20 سال');
                                        break;
                                        case '6':
                                        echo l('حداکثر 30 سال');
                                        break;
                                        case '7':
                                        echo l('بیش از 30 سال');
                                        break;
                                }
                            ?>
                            </p>
                        </div>
                        @endif
                        @if($model->usage_type)
                        <div class="col-6 col-sm-3 mb-4">
                            <p class=" mb-2"> {{l('نوع کاربری')}}: </p>
                            <p class="fw-bold mb-0">
                                {{l(getFeatureValue($featureValues, $model->usage_type))}}
                            </span>
                        </div>
                        @endif
                        @if($model->min_built_area)
                        <div class="col-6 col-sm-3 mb-4">
                            <p class=" mb-2">
                                    {{l('حداقل زیر بنا')}}:
                            </p>
                            <p class="fw-bold mb-0">
                                {{$model->min_built_area}}
                            </p>
                        </div>
                        @endif
                        @if($model->acquaintance_type>0)
                        <div class="col-6 col-sm-3 mb-4">
                            <p class=" mb-2">
                                    Lead Source:
                            </p>
                            <p class="fw-bold mb-0">
                                {{$model->get_acquaintance_type != null ? $model->get_acquaintance_type->name : ""}}
                            </p>
                        </div>
                        @endif
                        @if($model->acquaintance != '')
                        <div class="col-6 col-sm-3 mb-4">
                            <p class=" mb-2">
                                    Lead Source Comment:
                            </p>
                            <p class="fw-bold mb-0">
                                {{$model->acquaintance}}
                            </p>
                        </div>
                        @endif
                        <div class="col-12 col-sm-12 mt-3">
                            <p class="fw-bold mb-0">
                            <?php
                            if(!empty($model->facilities)){
                                foreach(json_decode($model->facilities,true) as $value){
                                    if($value==35)
                                        echo l('پارکینگ')."، ";
                                    if($value==36)
                                        echo l('انباری')."، ";
                                    if($value==37)
                                        echo l('آسانسور')."، ";
                                }
                            }
                            if(!empty($model->conditions)){
                                foreach(json_decode($model->conditions,true) as $value){
                                    if($value==15)
                                        echo l('پیش فروش').", ";
                                    if($value==304)
                                        echo l('کلید نخورده').", ";
                                    if($value==348)
                                        echo l('فول امکانات');
                                }
                            }
                            ?>
                            </p>
                        </div>
                    </div>
                </div>
                @if($model->note)
                <div class="">
                    <div class=" text-gray-500 px-2 border-l border-gray-200 font-light flex flex-col md:flex-row">
                        <span>
                            {{l('توضیحات')}}:
                        </span>
                        <span class="fw-bold font-medium mb-0">
                            {{$model->note}}
                        </span>

                    </div>
                </div>
                @endif

            </div>
            <div class="px-2 d-flex gap-2 justify-content-end">
                @if ($model->status == 1 && ($model->user_id == $currentUser->id || $currentUser->isAdmin()))
                <div class="order-lg-last">
                    <a href="/customer/{{$model->id}}/edit_v2" class="btn btn-outline-primary btn-sm">
                        <i class="fs-6 text-gray-500  fa-thin fa-edit"></i>
                        {{l('ویرایش')}}
                    </a>
                </div>
                @endif
                @if (env('COUNTRY') == 'UAE')
                @if($model->user_id != null && ($currentUser->isAdmin() || ($currentUser->isExpert() &&  $model->user_id == $currentUser->id) ))
                <div class="order-lg-last">
                    <a class="btn btn-outline-primary btn-sm" style="cursor:pointer" onclick="if(confirm('{{l('آیا از حذف کارشناس این تقاضا مطمئن هستید؟')}}'))removeagentclick({{$model->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                        <i class="fs-6 opacity-60 me-2 fa-light fa-trash-can"></i>
                        {{l('حذف کارشناس')}}
                    </a>
                </div>
                @endif
                @if(!$currentUser->isAdmin() && $currentUser->isExpert() &&  $model->user_id == null)
                <div class="order-lg-last">
                    <a class="btn btn-outline-primary btn-sm" style="cursor:pointer" onclick="if(confirm('{{l('آیا از انتقال کارشناس این تقاضا مطمئن هستید؟')}}'))assigntomeclick({{$model->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                        <i class="fs-6 opacity-60 me-2 fa-light"></i>
                        {{l('انتقال به من')}}
                    </a>
                </div>
                @endif
                @endif
            </div>
            @if(ss('SITE_ID') != 4 )
            <div class="w-full flex flex-col mt-2">
                @if(!empty($countLike) && count($countLike)>0)
                <div class="border border-gray-200 rounded-2 py-3 px-2 mb-3 d-flex align-items-center">
                    <div class="w-100 text-gray-500 px-2 font-light flex flex-col md:flex-row">
                        <span class="fw-bold">{{l('مشتری های شبیه این شماره همراه')}}</span>
                        <span class="font-medium mb-0">
                            <div class="my-3 table-responsive" >
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col" align="center">{{l('کد مشتری')}}</th>
                                            <th scope="col" align="center">{{l('نام مشاور')}}</th>
                                            <th scope="col" align="center">{{l('نام مشتری')}}</th>
                                            <th scope="col" align="center">{{l('شماره موبایل مشتری')}}</th>
                                            <th scope="col" align="center">{{l('نوع درخواست')}}</th>
                                            <th scope="col" align="center">{{l('نوع ملک')}}</th>
                                            <th scope="col" align="center">{{l('تاریخ ثبت')}}</th>
                                            <th scope="col" align="center">{{l('وضعیت مشتری')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($countLike as $estate)
                                        <tr>
                                            <td align="center">
                                                <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                                                    {{$estate->id}}
                                                </a>
                                            </td>
                                            <td align="center">
                                                <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                                                    {{$estate->user ? $estate->user->fullname() : ""}}
                                                </a>
                                            </td>
                                            <td align="center">
                                                <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                                                    {{$estate->name}}
                                                </a>
                                            </td>
                                            <td align="center">
                                                <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                                                    {{$estate->mobile}}
                                                </a>
                                            </td>
                                            <td align="center">
                                                <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                                                    @if ($estate->request_type == 2)
                                                    {{l('رهن واجاره')}}
                                                    @else
                                                    {{l('خرید و فروش')}}
                                                    @endif
                                                </a>
                                            </td>
                                            <td align="center">
                                                <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                                                    {{$estate->estate_type>0 ? estateTypes($estate->estate_type) : ''}}
                                                </a>
                                            </td>
                                            <td align="center">
                                                <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                                                    {{ toPersianDate($estate->created_at) }}
                                                </a>
                                            </td>
                                            <td align="center">
                                                <a href="/customer/{{$estate->id}}" target="_blank" class="text-decoration-none">
                                                    {{ l(CustomerStatus($estate->status)) }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </span>
                    </div>
                </div>
                @endif
            </div>
            @endif
            <div class="w-full flex flex-col mt-3">
                @if($model->status == 1 && (ss('SITE_ID') == 8 || ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2 || ss('SITE_ID') == 4) && $currentUser && ($currentUser->isExpert() || $currentUser->isAdmin()))
                <div class="border border-gray-200 rounded-2 py-3 px-2 mb-3 d-flex align-items-center">
                    <div class="w-100 text-gray-500 px-2 font-light flex flex-col md:flex-row">
                        <div class="mb-4 pb-4 border-bottom" >
                            <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch justify-content-between">
                                <a class="btn btn-outline-primary mb-sm-0 mb-3" href="#modal-review" data-bs-toggle="modal">
                                    <i class="fi-edit ms-1"></i>{{l('ثبت عملکرد')}}
                                </a>
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
            @if($model->status == 1 && (ss('SITE_ID') == 8 || ss('SITE_ID') == 3 || ss('SITE_ID') == 5 || ss('SITE_ID') == 2 || ss('SITE_ID') == 4) && $currentUser && ($currentUser->isExpert() || $currentUser->isAdmin()))
            <div class="row">
                <div class="divRelation col-lg-12 mt-5">
                    <!-- Breadcrumb-->
                    <div class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center justify-content-between mb-3 gap-3">
                        <span class="fw-bold">
                            {{l('املاک مناسب برای این مشتری')}}
                        </span>
                        @if($model->resenddate > date('Y-m-d'))
                        <span style="color:red">[ {{l('توقف ارسال')}} ]</span>
                        @endif
                        @if ($model->status == 1 && $model->lastdateSms != date('Y-m-d') && ($currentUser->isAdmin() || $model->user_id == $currentUser->id))
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modelrelationsms" class="text-decoration-none ">
                            <input class="btn btn-primary" type="button" value="{{l('ارسال پیامک املاک متناسب')}}" />
                        </a>
                        @endif
                    </div>
                    <div class="card shadow-sm mb-4">
                        <div class=" card-body border-0  pb-1 me-lg-1">
                            <input type="hidden" name="order" id="order" value="id">
                            <input type="hidden" name="orderby" id="orderby" value="desc">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{l('کدملک')}}</label>
                                    <input type="text" class="form-control" id="estate_id" name="estate_id" />
                                </div>
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{l('وضعیت')}} </label>
                                    <select class="form-control form-select" id="status" name="status">
                                        <option></option>
                                        <option value="0">{{l('جدید')}}</option>
                                        <option value="1">{{l('رد شده')}}</option>
                                        <option value="2">{{l('تائید شده')}}</option>
                                        <option value="3">{{l('ارسال شده')}}</option>
                                    </select>
                                </div>
                                @if(ss('SITE_ID') == 8 || ss('SITE_ID') == 5 || ss('SITE_ID') == 3 || ss('SITE_ID') == 4 )
                                <div class="col-md-6 col-lg-4 col-sm-12 mt-2">
                                    <label>{{l('اولویت')}} </label>
                                    <select class="form-control form-select" id="priority" name="priority">
                                        @if(ss('SITE_ID') != 5)
                                        <option value=""></option>
                                        @endif
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-center my-4 ">
                                <button id="form_search" class="btn btn-primary">
                                    {{l('جستجو')}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content1" id="state">
                    </div>
                    <nav class="pt-4 pb-2 border-top" aria-label="Blog pagination" id="pagination">
                    </nav>
                </div>
            </div>
            @endif
        </div>
    </section>
</main>
<div class="modal fade" id="modal-review" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-block position-relative border-0 pb-0 px-sm-5 px-2">
                <h4 class="modal-title mt-4 text-center font-vazir">{{l('ثبت عملکرد برای تقاضا')}}</h4>
                <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 px-2">
                <div class="mb-3">
                    <label class="form-label" for="type">{{l('نوع')}} </label>
                    <select class="form-control form-select" id="type" name="type">
                        <option value="11" >{{l('تماس با مشتری')}}</option>
                        <option value="12" >{{l('نظر مشاوران')}}</option>
                        <option value="2" >{{l('سرویس')}}</option>
                        @if(ss('SITE_ID') == 3)
                        <option value="13" >{{l('فروش ویژه')}}</option>
                        @endif
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
<div class="modal fade" id="modelsms" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true" style="z-index: 99999;top:0%;bottom:0% !important;height:auto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{l('تذکر')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
                <h3>{{l('آیا شما مطمئن هستید؟')}}</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{l('بستن')}}</button>
                <button type="button" class="btn btn-primary smsend">{{l('بله')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modelrelationsms" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true" style="z-index: 99999;top:0%;bottom:0% !important;height:auto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{l('تذکر')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
                <h3>{{l('آیا شما مطمئن هستید؟')}}</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{l('بستن')}}</button>
                <button type="button" class="btn btn-primary relationsmsend">{{l('بله')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-removereview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-block position-relative border-0 pb-0 px-sm-5 px-4">
            <h4 class="modal-title mt-4 text-center font-vazir">{{l('دلیل حذف کارشناس')}}</h4>
            <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form  id="js_singup-expert2" role="form"  method="POST">
            <div class="modal-body px-sm-5 px-4">

                <div class="mb-4">
                    <label class="form-label" for="comment">
                        {{l('توضیحات')}}
                        <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control" id="editcomment2" name="editcomment2" rows="5" placeholder="{{l('توضیحات')}}" required></textarea>
                    <div class="invalid-feedback">{{l('نظر خود را ثبت کنید')}}</div>
                </div>
                <button class="btn btn-primary d-block w-100 mb-4 btnEditOperation2" type="submit">{{l('ثبت عملکرد')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>
@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script src="{{asset('frontend/vendor/sweetalert2.all.js')}}"></script>
<script src="/frontend/js/paging.js"></script>
<script>
    function removeagentclick(customerId)
    {
        $('#modal-removereview').modal('toggle');
        /*

        */
    }
    $(document).ready(function() {
        $('#js_singup-expert2').validate({
            errorPlacement: function (error, element) {
                var type = $(element).attr('cus-valid')
                if (type == 'true') {
                    error.insertAfter(element.parent().parent());
                } else {
                    error.insertAfter(element)
                }
            },
        });
        $(".btnEditOperation2").click(function()
        {
            if($('#editcomment2').val() == '')
            {
                return ;
            }

            $('#modal-removereview').modal('toggle');
            var customerId = {{$model->id}};
            var comment = $('#editcomment2').val();
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
                    //CheckSend();
                    location.reload();
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
                    //CheckSend();
                    location.reload();
                });
            })
            .fail(function(response) {
                if(response.status == 422){
                    swal('{{l('خطا')}}!', 'You have become an agent on a property over time', 'error');
                }
            });
    }
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
                    title: "{{l('ارتباط با موفقیت ثبت شد')}}",
                    message: "",
                    confirmButtonColor: '#025EC6',
                    confirmButtonText: '{{l('باشه')}}',
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
        sr+=(typeof $('#priority').val()!=='undefined')?"priority="+$("#priority").val()+"&":"";
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
                /*if (data.totalCount == 0)
                {
                    $('.divRelation').hide();
                }
                else
                {
                    $('.divRelation').show();
                }*/
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

    function confirmm(id) {
        $("#status"+id).html("{{l('تائید شده')}}");
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
                title:"{{l('تایید شد')}}",
                type: 'success',
                timer: 2000,
                allowOutsideClick: false
            }).then((result) => {
                //CheckSend();
            });

        })
        .fail(function() {
            swal('{{l('خطا!')}}', '{{l('متاسفانه عملیات با شکست مواجه گردید')}}', 'error');
        });
    };
    function reject(id) {
        $("#status"+id).html("{{l('رد شده')}}");
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
                title:"{{l('رد شد')}}",
                type: 'success',
                timer: 2000,
                allowOutsideClick: false
            }).then((result) => {
                //CheckSend();
            });

        })
        .fail(function() {
            swal('{{l('خطا!')}}', '{{l('متاسفانه عملیات با شکست مواجه گردید')}}', 'error');
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
                title:"{{l('اولویت تغییر کرد')}}",
                type: 'success',
                timer: 2000,
                allowOutsideClick: false
            }).then((result) => {
                //CheckSend();
            });

        })
        .fail(function() {
            swal('{{l('خطا!')}}', '{{l('متاسفانه عملیات با شکست مواجه گردید')}}', 'error');
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
                    confirmButtonText: '{{l('باشه')}}',
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
                    confirmButtonText: '{{l('باشه')}}',
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
                        confirmButtonText: '{{l('باشه')}}',
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
    function addOperation(type)
    {
        customer_id = {{ $model->id }};
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
                'comment': '',
            },
            success: function(data) {
                var res = data.data;
                var operation = res.operation_id;
            },
        });
        getOperations({{ $model->id }});
        if(type == 11)
        {
            window.open('tel:{{ $model->mobile }}');
        }
        if(type == 17)
        {
            window.open("https://wa.me/{{$model->mobile2}}");
        }
    }
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


