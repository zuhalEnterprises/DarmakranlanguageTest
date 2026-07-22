@extends(ss('THEME') . '.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME'),
])

<link rel="stylesheet" media="screen" href="/vendor/select2/select2.min.css" />
<link href="/css/Mh1PersianDatePicker.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('/frontend/vendor/dropzone/dropzone.min.css') }}" />
@section('main_content')
    <style>
        .search {
            background: #E7E7E7;
            width: 100%;
            height: 40px;
            cursor: pointer
        }

        #search {
            background: #E7E7E7;
            width: 100%;
            border-top: 3px solid #D2D6DE
        }

        .not {
            display: none
        }

        .dropzone.dz-started .dz-message {
            border: 1px solid gray;
            display: block !important;
            display: inline-table;
            width: 120px !important;
            height: 125px !important;
            float: right;
        }

        .dropzone {
            min-height: 150px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            background: white;
            padding: 20px 20px;
        }

        .dropzone .dz-message {
            text-align: center;
            margin: .5em 0;
        }

        .dz-preview {
            float: right;
        }
    </style>
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME') . '.frontend.layouts.header_v2', ['isadmin' => true])
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
                            <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> {{ l('ایجاد قولنامه') }}</li>
                        </ol>
                    </nav>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h1 class="h2 mb-0">
                            {{ l('ایجاد قولنامه') }}
                        </h1>
                    </div>

                    <div class="rounded shadow-sm mb-4">
                        <div class=" border-0  pb-1 me-lg-1">
                            @if($errors->any())
                            <h4 style="color: red">{{$errors->first()}}</h4>
                            @endif
                            <form role="form" id="add" method="POST" action="{{!empty($model)?"/profile/ContractEdit/".$model->id:"/profile/ContractAdd"}}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <input type="hidden" name="user_id" value="{{ $currentUser->id }}">
                                @if(!empty($model))
                                <input type="hidden" name="id" value="{{ $model->id }}">
                                @endif
                                <section class="box" style="line-height: 250%">

                                    <div class="box-body" style="padding: 15px !important">

                                        <div class=" row ">
                                            <div class="col-12 ">
                                                <label class="form-label fw-bold required m-0">{{ l('نوع قولنامه') }}</label>
                                                <div class="">
                                                    <label class="radio-inline">
                                                        <input name="type" class="type" type="radio"


                                                        {{ !empty($model) ? ($model->type == 1 ? 'checked' : '') : 'checked' }}
                                                            value="1" required> {{ l('فروش') }}
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input name="type" class="type" type="radio"
                                                            {{ !empty($model) ? ($model->type == 2 ? 'checked' : '') : 'checked' }}
                                                            value="2"> {{ l('اجاره') }}
                                                    </label>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 ">
                                                <label class="form-label fw-bold required m-0">{{ l('نوع ملک مورد معامله') }}</label>
                                                <div class="">
                                                    @foreach (estateTypes() as $key => $value)
                                                        <label class="radio-inline">
                                                            <input name="estate_type"
                                                                {{ !empty($model) ? ($model->estate_type == $key ? 'checked' : '') : '' }}
                                                                class="estate_type" type="radio"
                                                                value="{{ $key }}" required>
                                                            {{ $value }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row g-3 mt-3">
                                            <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                <label class="form-label fw-bold required">{{ l('کد قولنامه') }}</label>
                                                <input type="text" class="form-control" name="contractid" id="contractid"
                                                    value="{{ !empty($model) ? $model->contractid : '' }}" required>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                <label class="form-label fw-bold required">{{ l('تاریخ قولنامه') }}</label>
                                                <input type="text" name="register_date" id="register_date"
                                                    value="{{ !empty($model) ?toPersianDateYdm($model->register_date) : '' }}"
                                                    onclick="Mh1PersianDatePicker.Show(this,'1402/05/01')"
                                                    class="form-control text-muted pull-right" required>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                <label class="form-label fw-bold required">{{ l('تاریخ محضر') }}</label>
                                                <input type="text" name="registryofficedate" id="registryofficedate"
                                                    value="{{ !empty($model) ? toPersianDateYdm($model->registryofficedate) : '' }}"
                                                    onclick="Mh1PersianDatePicker.Show(this,'1402/05/01')"
                                                    class="form-control text-muted pull-right" required>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                <label class="form-label fw-bold required">{{ l('تاریخ تحویل') }}</label>
                                                <input type="text" name="deliverydate" id="deliverydate"
                                                    onclick="Mh1PersianDatePicker.Show(this,'1402/05/01')"
                                                    value="{{ !empty($model) ? toPersianDateYdm($model->deliverydate) : '' }}"
                                                    class="form-control text-muted pull-right" required>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                <label class="form-label fw-bold required">{{ l('کد رهگیری') }}</label>
                                                <input type="text" class="form-control" name="tracking_code"
                                                    id="tracking_code"
                                                    value="{{ !empty($model) ? $model->tracking_code : '' }}" required>
                                            </div>
                                        </div>


                                        <div class="row my-3">
                                            <div class="col-12 ">
                                                <label class="form-label fw-bold required">{{ l('جمع کمیسیون دریافتی (تومان)') }}</label>
                                                <input  class="form-control   number js_number js_Splitnumber1" type="text"   onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));" name="total_commission"
                                                    id="total_commission"
                                                    value="{{ !empty($model) ? $model->total_commission : '' }}">
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col-12 ">
                                                <label class="form-label fw-bold">{{ l('توضیحات') }}</label>
                                                <textarea class="form-control" name="description">{{ !empty($model) ? $model->description : '' }}</textarea>
                                            </div>
                                        </div>

                                        {{-- estate --}}
                                        <div class="mt-2">
                                            <div class="box-header with-border">
                                                <h3 class="box-title text-aqua">{{ l('مشخصات فروشنده') }}</h3>
                                            </div>

                                            <div class=" row g-3 mt-2">
                                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                    <label class="form-label fw-bold required">{{ l('کدملک') }}</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ !empty($model) ? $model->estate_id : '' }}"
                                                        name="estate_id" id="estate_id" required>
                                                </div>

                                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                    <label class="form-label fw-bold required">{{ l('نام مالک') }}</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ !empty($model) ? $model->estate_name : '' }}"
                                                        name="estate_name" id="estate_name" required>
                                                </div>


                                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                    <label class="form-label fw-bold required">{{ l('کدملی مالک') }}</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ !empty($model) ? $model->estate_nationalId : '' }}"
                                                        name="estate_nationalId" id="estate_nationalId" required>
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                    <label class="form-label fw-bold required">{{ l('شماره شناسنامه مالک') }}</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ !empty($model) ? $model->estate_idCard : '' }}"
                                                        name="estate_idCard" id="estate_idCard" required>
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                    <label class="form-label fw-bold required">{{ l('نام پدر مالک') }}</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{!empty($model) ? $model->estate_fatherName : '' }}"
                                                        name="estate_fatherName" id="estate_fatherName" required>
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                    <label class="form-label fw-bold required">{{ l('تلفن مالک') }}</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ !empty($model) ? $model->estate_phone : '' }}"
                                                        name="estate_phone" id="estate_phone" required>
                                                </div>
                                            </div>

                                            <div class="row my-3">
                                                <div class="col-12 ">
                                                    <label class="form-label fw-bold required">{{ l('آدرس') }}</label>
                                                    <textarea class="form-control" name="estate_address"
                                                        id="estate_address" required>{{ !empty($model) ? $model->estate_address : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class=" row my-3">
                                                <div class="col-12 ">
                                                    <label class="form-label fw-bold required">{{ l('قیمت کل (تومان)') }}</label>
                                                    <input  class="form-control  number js_number js_Splitnumber1" type="text"   onkeypress="OnlyNumber(event,false)" onkeyup="SplitNumber($(this));" name="total_price"
                                                        id="total_price"
                                                        value="{{ !empty($model) ? $model->total_price : '' }}" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="my-2">
                                            <div class="box-header with-border">
                                                <h3 class="box-title text-aqua">{{ l('مشخصات خریدار') }}</h3>
                                            </div>

                                            <div class=" row my-3 g-3">
                                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                    <label class="form-label fw-bold required">{{ l('کد مشتری') }}</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ !empty($model) ? $model->customer_id : '' }}"
                                                        name="customer_id" id="customer_id" required>
                                                </div>

                                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                    <label class="form-label fw-bold required">{{ l('نام مشتری') }}</label>
                                                    <input type="text" class="form-control number"
                                                        name="customer_name"
                                                        value="{{ !empty($model) ? $model->customer_name : '' }}"
                                                        id="customer_name" required>
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                    <label class="form-label fw-bold required">{{ l('کدملی مشتری') }}</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ !empty($model) ? $model->customer_nationalId : '' }}"
                                                        name="customer_nationalId" id="customer_nationalId" required>
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                    <label class="form-label fw-bold required">{{ l('شماره شناسنامه مشتری') }}</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{ !empty($model) ? $model->customer_idCard : '' }}"
                                                        name="customer_idCard" id="customer_idCard" required>
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                    <label class="form-label fw-bold required">{{ l('نام پدر مشتری') }}</label>
                                                    <input type="text" class="form-control number"
                                                        value="{{!empty($model) ? $model->customer_fatherName : '' }}"
                                                        name="customer_fatherName" id="customer_fatherName" required>
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                    <label class="form-label fw-bold required">{{ l('تلفن مشتری') }}</label>
                                                    <input type="text" class="form-control number"
                                                        name="customer_phone"
                                                        value="{{ !empty($model) ? $model->customer_phone : '' }}"
                                                        id="customer_phone" required>
                                                </div>
                                            </div>


                                        </div>


                                        {{-- users --}}

                                        <input type="hidden" id="js_csrf_token" value="{{ csrf_token() }}">
                                        <input type="hidden" id="js_estates_storeMedia"
                                            value="{{ route('contract.storeMedia') }}">

                                        <div class="box attachment-block clearfix mt-4">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">{{ l('مشاوران فروشنده و خریدار') }}
                                                    <button type="button" class="btn btn-info btn-social btn-xs"
                                                        onclick="addRow('contract_users')" style="margin-bottom: 5px;">
                                                        <i class="fa fa-plus-circle"></i>{{ l('افزودن') }}</button>
                                                </h3>
                                            </div>
                                            <div class="box-body">
                                                <table id="contract_users" style="width: 100%">

                                                    <tr class="default-row buy" style="display: none">
                                                        <td style="border: none;padding-bottom:10px">
                                                            <div class="box-footer  margin pad rounded row shadow-sm"
                                                                style="padding-bottom:20px ">
                                                                <div class="col-lg-3 col-sm-12">
                                                                    <label class="control-label ">{{ l('نوع مشاور') }}</label>

                                                                    <select name="contract_users[]" id=""
                                                                        class="form-control contract_users" required>
                                                                        <option value="1" selected>{{ l('مشاور فروشنده') }}
                                                                        </option>
                                                                        <option value="2">{{ l('مشاور خریدار') }}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-4 col-sm-12">
                                                                    <label class="control-label ">{{ l('کد مشاور') }}</label>

                                                                    <select name="contract_users1[]" id="expert_id"
                                                                        class="form-control contract_users agent" required>
                                                                        @foreach ($users as $user)
                                                                            <option value="{{ $user->id }}">
                                                                                {{ $user->code }} | {{ $user->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-12">
                                                                    <label class="control-label  required">{{ l('درصد کمیسیون') }}</label>
                                                                    <input name="contract_users2[]" type="text"
                                                                        class="form-control number contract_users2"
                                                                        value="" required>
                                                                </div>
                                                                <div class="col-lg-2 col-sm-12">
                                                                    <input type="button" class="btn btn-danger mt-4 del1"    value="{{ l('حذف') }}"/>
                                                                 </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                    <tr class="default-row sell" style="display: none">
                                                        <td style="border: none;padding-bottom:10px">
                                                            <!-- <a class="btn btn-danger btn-xs pull-left" onclick="deleteRow('contract_users',this);" style="margin-bottom: -30px; margin-left: -2px;">
                                                            <i class="fa fa-remove" style="font-size: 1.5rem;"></i>
                                                        </a> -->
                                                            <div class="box-footer  margin pad rounded row shadow-sm  "
                                                                style="padding-bottom:20px ">
                                                                <div class="col-lg-3 col-sm-12">
                                                                    <label class="control-label ">{{ l('نوع مشاور') }}</label>


                                                                    <select name="contract_users[]" id=""
                                                                        class="form-control contract_users" required>
                                                                        <option value="1">{{ l('مشاور فروشنده') }}</option>
                                                                        <option value="2" selected>{{ l('مشاور خریدار') }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-4 col-sm-12">
                                                                    <label class="control-label ">{{ l('کد مشاور') }}</label>

                                                                    <select name="contract_users1[]" id="expert_id"
                                                                        class="form-control contract_users agent" required>
                                                                        @foreach ($users as $user)
                                                                            <option value="{{ $user->id }}">
                                                                                {{ $user->code }} | {{ $user->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-12">
                                                                    <label class="control-label  ">{{ l('درصد کمیسیون') }}</label>
                                                                    <input name="contract_users2[]" type="text"
                                                                        class="form-control number contract_users2" required
                                                                        value="">
                                                                </div>
                                                                <div class="col-lg-2 col-sm-12">
                                                                    <input type="button" class="btn btn-danger mt-4 del1"  value="{{ l('حذف') }}"/>
                                                                 </div>

                                                            </div>

                                                        </td>
                                                    </tr>
                                                    @if(!empty($model))
                                                    @foreach ($model->contractUsers as $contractUsers )
                                                    <tr class="default-row buy" id="row_{{$contractUsers->id}}" >
                                                        <input type="hidden" name="contractUsersold[]" value="{{$contractUsers->id}}"/>
                                                        <td style="border: none;padding-bottom:10px">
                                                            <div class="box-footer  margin pad rounded row shadow-sm"
                                                                style="padding-bottom:20px ">
                                                                <div class="col-lg-3 col-sm-12">
                                                                    <label class="control-label ">{{ l('نوع کارشناس') }}</label>

                                                                    <select name="contract_users_old[]" id=""
                                                                        class="form-control contract_users" required>
                                                                        <option value="1" {{$contractUsers->type==1?'selected':''}} selected>{{ l('کارشناس فروشنده') }}
                                                                        </option>
                                                                        <option value="2" {{$contractUsers->type==2?'selected':''}} >{{ l('کارشناس خریدار') }}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-4 col-sm-12">
                                                                    <label class="control-label ">{{ l('کد کارشناس') }}</label>

                                                                    <select name="contract_users1_old[]" id="expert_id"
                                                                        class="form-control contract_users agent" required>
                                                                        @foreach ($users as $user)
                                                                            <option value="{{ $user->id }}" {{$contractUsers->expert_id==$user->id?'selected':''}}>
                                                                                {{ $user->code }} | {{ $user->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-12">
                                                                    <label class="control-label  required">{{ l('درصد کمیسیون') }}</label>
                                                                    <input name="contract_users2_old[]" type="text"
                                                                        class="form-control number contract_users2"
                                                                        value="{{$contractUsers->expert_commission}}" required>
                                                                </div>
                                                                <div class="col-lg-2 col-sm-12">
                                                                   <input type="button" class="btn btn-danger mt-4" onclick="delcontractuser({{$contractUsers->id}})" value="{{ l('حذف') }}"/>
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </table>
                                            </div>
                                        </div>

                                        <div id="images" class=" card mb-3">
                                            <div class="border-bottom card-header">
                                                <strong class="mb-0">{{ l('بارگزاری اسناد') }}</strong>
                                            </div>
                                            <div class="">
                                                @if(!empty($model))
                                                @foreach ($model->contractDocument as $item)

                                                        <div id="media-{{$item->id}}" data-id="{{$item->id}}" class="card p-1 rounded dz-preview"  style="flex-basis: 19%;">
                                                            <div class="mb-0 est-container">

                                                                    <img src="/upload/images/contract/{{ $item->url() }}" class="w-100 est-img" style="height:250px;margin-bottom:10px">

                                                            </div>
                                                            <button type="button" data-toggle="tooltip" title="{{l('حذف')}}" data-id="{{$item->id}}"
                                                                    id="itemID-{{$item->id}}" data-name="{{$item->name}}"
                                                                    data-route="images" class="btn btn-danger remove-img rounded-0">
                                                                <i class="d-inline fa fa-trash me-2"></i>{{l('حذف')}}
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div id="img-upload"
                                                class="dropzone uploader text-center dz-clickable rounded mb-2"
                                                data-bs-toggle="dropzone" style="width: 100%;z-index:0">

                                                <div class="dz-message" data-dz-message=""
                                                    style="width:120px;height:120px;border:1px solid;border-radius:25%;padding-top:35px">
                                                    <i class="text-[50px] text-gray-500 fa-thin fa-camera"
                                                        style="font-size:25px"></i>
                                                    <div class="uploader-text">
                                                        <span
                                                            class="text-[16px] text-gray-500 font-light">{{ l('تصاویر') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                    <div class="panel-footer clearfix">

                                        <button  class="btn btn-success pull-right save"  onclick="return savecheck()">
                                            <i class="fa fa-save"></i> {{ l('ذخیره') }}
                                        </button>
                                        <button type="button" onclick="window.history.back();"
                                            class="btn btn-danger pull-left">
                                            <i class="fa fa-close"></i> {{ l('انصراف') }}
                                        </button>
                                    </div>
                                </section>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>



    <div class="modal fade" id="estatecheck" style="background:white" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"> {{ l('املاک مشابه') }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="estatecheck1">
                </div>
            </div>
        </div>
    </div>
    @include(ss('THEME') . '.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
    <script src="{{ asset('/frontend/vendor/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin2/plugins/fileuploads/js/dropify.min.js') }}"></script>
    <script src="/js/Mh1PersianDatePicker.js"></script>
    <script src="{{ asset('admin2/dist/js/regions.js') }}"></script>
    <script src="{{asset('frontend/vendor/sweetalert2.all.js')}}"></script>
    <script type="text/javascript">

    function delcontractuser(id)
        {
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
                    $.get("/profile/contractUserDestroy/" + id, function(data, status) {
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
    $("#contract_users").on('click',".del1",function()
    {
        if($(this).parent().parent().parent().attr('id')=='dundefined')
            $(this).parent().parent().parent().parent().remove();
        else
        $(this).parent().parent().parent().parent().css("display","none");

    });
$(".remove-img").on("click", function () {
    var estateId = '{{!empty($model)?$model->id:''}}';
    var id = $(this).data('id');
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
                $.ajax({
                    url: '/contract/media/' + id,
                    type: 'DELETE',
                    data: {_token: '{{csrf_token()}}',contract_id:estateId},
                    dataType: 'json'
                })
                    .done(function (response) {
                        swal({
                            title: "",
                            text: "{{l('گزینه مورد نظر با موفقیت حذف شد')}}.",
                            type: 'success',
                            allowOutsideClick: false,
                        }).then((result)=>{
                            $('#images #media-'+id).remove();
                    });
                    })
                    .fail(function () {
                        swal("{{l('خطا')}}!", "{{l('حذف با مشکل مواجه شد')}}!", 'error');
                    });
            });
        },
        allowOutsideClick: ()=>!swal.isLoading()
    });
});


        var uploadedDocumentMap = {}
        var myDropzone = new Dropzone('#img-upload', {
            uploadMultiple: false,
            acceptedFiles: ".jpeg,.jpg,.png", // "image/*"
            parallelUploads: 1,
            maxFiles: 100,
            maxFilesize: 5,
            maxThumbnailFilesize: 5,
            addRemoveLinks: true,
            dictRemoveFile: "{{ l('حذف') }}",
            dictCancelUpload: "{{ l('لغو آپلود') }}",
            url: $('#js_estates_storeMedia').val(),
            headers: {
                'X-CSRF-TOKEN': $('#js_csrf_token').val()
            },
            type: 'POST',
            success: function(file, response) {
                file.imgID = response.name;
                $(".dz-preview:last-child").attr('data-id', file.imgID);
                $('form#add').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function(file) {
                remove1(file.name);
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form#add').find('input[name="document1[]"][value="' + name + '"]').remove()
            },
            init: function() {
                console.log('init');
                this.on("maxfilesexceeded", function(file) {
                    this.removeFile(file);
                    alert("{{ l('حداکثر تعداد تصاویر 10 عدد میباشد') }}!");
                });
                this.on("error", function(file, message) {
                    if (message.indexOf('too big') > 0) {
                        alert("{{ l('حجم عکس بیش از 5 مگابایت می باشد') }}.");
                        this.removeFile(file);
                    }
                    if (message == "Invalid JSON response from server.") {
                        this.removeFile(file);
                        alert("{{ l('حجم عکس بیش از 10 مگابایت می باشد') }}.");
                    }
                });
                this.on("thumbnail", function(file) {});
                // default image
                this.on("addedfile", function(file) {
                    file.previewElement.addEventListener("click", function() {
                        $('#img-upload').find('.dz-preview').removeClass('img-cover');
                        $(this).addClass('img-cover');
                    });
                });
                if (typeof drop !== 'undefined') {
                    for (var c = 0; c < drop.length; c++) {
                        //alert();
                        var mockFile = {
                            name: drop[c][0],
                            size: 200000
                        };
                        this.emit("addedfile", mockFile);
                        this.emit("thumbnail", mockFile, "/upload/images/estate/" + drop[c][2]);
                        this.emit("complete", mockFile);
                    }
                }
            },
        });

        function buy(id) {
            $.get('/estateget/' + id, function(data, status) {
                seller = data.html['expert_id'];
                $(".buy").show();
                $(".buy").find('.agent').val(data.html['expert_id']);
                $("#d" + data.html['expert_id']).find(".contract_users").val(1);
                $("#estate_name").val(data.html['user']['name'] + " " + data.html['user']['last_name']);
                $("#estate_phone").val(data.html['user']['username']);
                var stre = "";
                if (data.html['street'] != null) {
                    stre = data.html['street']['name'];
                }
                $("#estate_address").val(data.html['city']['name'] + "-" + data.html['district']['name'] + "-" +
                    stre + "-" + data.html['address'] + l("-پلاک") + data.html['unit_no']);
                $("#total_price").val(data.html['price']);
            });
        }

        function sell(id) {
            $.get('/customerget/' + $(this).val(), function(data, status) {
                seller = data.html['expert_id'];
                $(".sell").show();
                $(".sell").find('.agent').val(data.html['user_id']);
                if (seller > 0) {
                    $("#d" + seller).find('.agent').val(seller);
                }
                $("#d" + data.html['user_id']).find(".contract_users").val(2);
                $("#customer_name").val(data.html['name']);
                $("#customer_phone").val(data.html['mobile']);
            });
        }
        $(document).ready(function() {
            var seller = 0;
            var buyer = 0;
            $("#estate_id").keypress(function(e) {
                var key = e.which;
                if (key == 13) {
                    $("#estate_name").val("");
                    $("#estate_phone").val("");
                    $("#estate_address").val("");
                    $("#total_price").val("");
                    if ($(this).val() != 0) {
                        $.get('/estateget/' + $(this).val(), function (data, status) {
                            //addRow("contract_users",data.html['expert_id']);
                            //$("#d"+data.html['expert_id']).find('.agent').val(data.html['expert_id']);
                            seller=data.html['expert_id'];

                            $(".buy").show();
                            $(".buy").find('.agent').val(data.html['expert_id']);

                            $("#d"+data.html['expert_id']).find(".contract_users").val(1);
                            $("#estate_name").val(data.html['user']['name']+" "+data.html['user']['last_name']);
                            $("#estate_phone").val(data.html['user']['username']);
                            var stre="";
                            if(data.html['street']!=null){
                                stre=data.html['street']['name'];
                            }
                            $("#estate_address").val(data.html['city']['name']+"-"+data.html['district']['name']+"-"+ stre+"-"+data.html['address']+"-پلاک"+data.html['unit_no']);
                            $("#total_price").val(data.html['price']);
                        });
                    }
                    return false;
                }
            });
            $("#customer_id").keypress(function(e) {
                var key = e.which;
                if (key == 13) {
                    $("#customer_name").val("");
                    $("#customer_phone").val("");
                    if ($(this).val() != 0) {
                        $.get('/customerget/' + $(this).val(), function (data, status) {
                            //addRow("contract_users",data.html['user_id']);
                            $(".sell").show();
                            $(".sell").find('.agent').val(data.html['user_id']);
                            if(seller>0){

                                $("#d"+seller).find('.agent').val(seller);
                            }
                            $("#d"+data.html['user_id']).find(".contract_users").val(2);
                            $("#customer_name").val(data.html['name']);
                            $("#customer_phone").val(data.html['mobile']);

                        });

                    }
                    return false;
                }
            });


        });
        function savecheck(){
                var isValid = true;
                $('input,textarea,select').filter('[required]:visible').each(function() {
                if ( $(this).val() === '' )
                    isValid = false;
                });
                if(isValid==true)
                    $("#add").submit();

        }
        function remove1(id1) {
            var estateId = '{{ !empty($contract) ? $contract->id : '' }}';
            var id = id1;
            $.ajax({
                    url: '/contract/media/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        estate_id: estateId
                    },
                    dataType: 'json'
                })
                .done(function(response) {
                    $('#images #media-' + id).remove();

                })
                .fail(function() {
                    swal("{{ l('خطا') }}!", "{{ l('حذف با مشکل مواجه شد') }}!", 'error');
                });
        }

        function experts_request(branch_id, user_id) {
            $.get("/api/branches/" + branch_id + "/experts?user_id=" + user_id, function(data, status) {
                if (data.status) {
                    removeSelectOptionsByClass('agent');

                    $('select.agent').each(function(index, elm) {
                        $.each(data.result, function(i, item) {
                            $(elm).append($('<option>', {
                                value: i,
                                text: item
                            }));
                        });
                    });


                }
            });
        }

        var partiesRowCount = 1,
            usersRowCount = 2;

        function addRow(tableID, id) {

            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);

            var colCount = table.rows[0].cells.length;
            //alert(colCount);
            var index = tableID === 'contract_users' ? usersRowCount++ : partiesRowCount++;
            for (var i = 0; i < colCount; i++) {
                var newcell = row.insertCell(i);
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                //alert(rowCount);
                //alert(table.rows[rowCount].innerHTML);
                newcell.setAttribute('id', "d" + id);
                //newcell.setAttribute('style', table.rows[0].cells[i].getAttribute('style'));

            }

        }

        function getId(element) {
            rowNumber = element.parentNode.parentNode.rowIndex;
            cellNumber = element.parentNode.cellIndex;
            return rowNumber;
        }

        function deleteRow(tableID, rowNum) {
            var target_row = getId(rowNum);
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            if (rowCount > 1) {
                table.deleteRow(target_row);
            }
        }

        function SplitNumber(obj){
    var Getnumber= toEnglishNumber(obj.val()).replace(/,/g,'');
    obj.val(Getnumber.split("").reverse().join("").replace(/(.{3}\B)/g, "$1,").split("").reverse().join(""));

}
window.SplitNumber=SplitNumber;
function OnlyNumber(event,HasBullet){
if(HasBullet){
    var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,<>+\/?-]/;
}
else{
    var blockSpecialRegex = /[a-zA-Zآ-ی~`!@#$%*'"^&()_={}[\]:;,.<>+\\/?-]/; } var key = String.fromCharCode(!event.charCode ? event.which : event.charCode); if (blockSpecialRegex.test(key)) { event.preventDefault(); } } function toEnglishNumber(strNum) { var pn = ["۰", l("۱"), l("۲"), l("۳"), l("۴"), l("۵"), l("۶"), l("۷"), l("۸"), l("۹")]; // Persian var an = ["٠", l("١"), l("٢"), l("٣"), l("٤"), l("٥"), l("٦"), l("٧"), l("٨"), l("٩")]; // Arabic var en = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]; var cache = strNum; for (var i = 0; i < 10; i++) {
        cache = cache.replace(new RegExp(pn[i], 'g'), en[i]); // Persian digits
        cache = cache.replace(new RegExp(an[i], 'g'), en[i]); // Arabic digits
    }
    return cache;
}
    </script>
@endsection
