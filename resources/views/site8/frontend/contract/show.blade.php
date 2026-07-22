@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME')
])
<link rel="stylesheet" media="screen" href="/vendor/select2/select2.min.css" />
<link href="/css/Mh1PersianDatePicker.css" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('/frontend/vendor/dropzone/dropzone.min.css')}}" />
@section('main_content')
<style>
    .form-group.row{border-bottom: 1px solid #f5f5f5; padding-bottom: 7px;}
</style>
    <div class="row">

        <div class="col-lg-12">
            @if ($errors->any())
                <div class="alert alert-block alert-danger fade in">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="icon-remove"></i>
                    </button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!empty($model->statusHistory()))
                <?php
                    $css = $icon = '';
                    if($model->statusHistory()->contract_status == 'rejected'){
                        $css = 'alert-danger';
                        $icon = 'ion-ios-close-outline';
                    }elseif($model->statusHistory()->contract_status == 'verified'){
                        $css = 'alert-success';
                        $icon = 'ion-ios-checkmark-outline';
                    }else{
                        $css = 'alert-warning';
                        $icon = 'ion-ios-information-outline';
                    }
                ?>
                <div class="alert alert-block alert-default fade in pad {{$css}}" style="display: flex; align-items: center;">
                    <i class="ion {{$icon}}" style="font-size: 3rem; margin-left: 10px;"></i>
                    <strong style="margin-left: 10px;">{{contractStatuses($model->statusHistory()->contract_status)}} : </strong>
                    <span> {{$model->statusHistory()->description}}</span>
                </div>
            @endif

                <div class="box clearfix">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ l('مشخصات قولنامه') }}</h3>

                        @if($currentUser->isAdmin() || $currentUser->hasAnyRole('admin_super|admin_financial'))
                            <span class="bg-success pull-left" style="padding: 4px 10px; margin-top: -6px;">
                                <span>{{ l('تغییر وضعیت') }}</span>
                                <select class="form-control" name="status" id="status" style="font-size: 12px;display: inline-block; width: auto;">
                                    @foreach(contractStatuses() as $key=>$value)
                                        <option value="{{$key}}" {{$key == $model->status ? 'selected' : ''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-success" id="change-status"
                                        data-toggle="modal" data-target="#my_modal" data-id="{{$model->id}}"
                                        data-code="{{$model->code}}">{{ l('تغییر وضعیت') }}</button>
                            </span>
                        @endif

                    </div>
                    <div class="box-body" style="padding: 15px !important">

                        <div class="form-group row">
                            <label class="col-lg-3 control-label ">{{ l('کد قولنامه') }}</label>
                            <div class="col-md-5 text-aqua text-bold">{{$model->code}}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label ">{{ l('نوع قولنامه') }}</label>
                            <div class="col-md-5 text-maroon text-bold ">{{$model->type == 1 ? l('فروش') : ($model->{{ l('type == 2 ? \'اجاره\' : \'غیره\')}}') }}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label ">{{ l('نوع ملک مورد معامله') }}</label>
                            <div class="col-md-8 text-maroon text-bold ">{{estateTypes($model->estate_type)}}</div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-lg-3 ">{{ l('کد رهگیری') }}</label>
                            <div class="col-lg-9 text-maroon text-bold ">{{$model->tracking_code}}</div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-lg-3 ">{{ l('تاریخ ثبت قولنامه') }}</label>
                            <div class="col-lg-9 text-maroon text-bold ">{{toPersianDate($model->register_at)}}</div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label ">{{ l('شهر') }}</label>
                            <div class="col-lg-9 text-maroon text-bold " id="">{{$model->city->name ?? ''}}</div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label ">{{ l('شعبه') }}</label>
                            <div class="col-lg-9 text-maroon text-bold " id="">
                                <span class="">{{$model->branch->name ?? ''}}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label ">{{ l('مدیر شعبه') }}</label>
                            <div class="col-lg-9 text-maroon text-bold " id=""><span>{{$model->branchManager->name ?? ''}}</span></div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label ">{{ l('مدیر قرارداد') }}</label>
                            <div class="col-lg-9 text-maroon text-bold " id=""><span>{{$model->contractManager->name ?? ''}}</span></div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-lg-3 ">{{ l('جمع کمیسیون دریافتی (تومان)') }}</label>
                            <div class="col-lg-9">
                                <span class="text-bold text-green">{{toPersianNumbers($model->total_commission)}}</span>{{ l('تومان') }}</div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-lg-3">{{ l('توضیحات') }}</label>
                            <div class="col-lg-9 text-muted">{!! $model->description !!}</div>
                        </div>
                    </div>

                </div>

                {{-- estate --}}
                <div class="box clearfix">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ l('مشخصات ملک') }}</h3>
                    </div>
                    <div class=" box-body" >
                        <div class="form-group row">
                            <label class="col-lg-3 control-label ">{{ l('شهر') }}</label>
                            <div class="col-lg-9"><span class="text-bold text-maroon">{{$model->estateCity->name ?? ''}}</span></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label ">{{ l('محله') }}</label>
                            <div class="col-lg-9"><span class="text-bold text-maroon">{{$model->estateDistrict->name ?? ''}}</span></div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-lg-3 ">{{ l('آدرس') }}</label>
                            <div class="col-lg-9"><span class="text-bold text-maroon">{{$model->estate_address}}</span></div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-lg-3 ">{{ l('متراژ') }}</label>
                            <div class="col-lg-9"><span class="text-bold text-maroon">{{$model->estate_area}}</span></div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-lg-3 ">{{ l('طبقه') }}</label>
                            <div class="col-lg-9"><span class="text-bold text-maroon">{{$model->estate_floor}}</span></div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-lg-3 ">{{ l('قیمت کل (تومان)') }}</label>
                            <div class="col-lg-9"><span class="text-bold text-maroon">{{toPersianNumbers($model->total_price)}}</span>{{ l('تومان') }}</div>
                        </div>
                    </div>
                </div>

                {{-- sum commission --}}
                {{--@if(count($userSumCommission) > 0)
                    <div class="box clearfix">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ l('خلاصه درآمد') }}</h3>
                        </div>
                        <div class="box-body" >
                            @foreach($userSumCommission as $item)
                                <div class="col-md-12" style="display: flex;">
                                    <h4 class="control-label ">
                                        {{$item->user->name ?? ''}}
                                        <span class="text-red">{{$item->{{ l('user_id == 1 ? \'( سیستم )\' :\'\'}}') }}</span> :
                                    </h4>
                                    <h4 class="text-green" style="padding-right: 10px;">{{toPersianNumbers($item->{{ l('sum_commission)}} تومان') }}</h4>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif--}}

                {{-- users --}}
                @if(count($model->contractUsers) > 0)
                    <div class="box clearfix">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ l('کارشناسان فروشنده و خریدار:') }}<span class="box-title text-red">{{ l('درآمدهای قولنامه') }}</span></h3>
                        </div>
                        <div class="box-body" >

                            <div class="col-lg-12">
                                <div class="bg-light border my-3 p-4 rounded">
                                    <h4 class="clearfix">
                                    <span class="pull-right">
                                        <i class="fa-coins fal text-yellow"></i>
                                        <span>{{ l('کمیسیون کارشناس فروش:') }}</span>
                                        <span class="text-maroon">{{toPersianNumbers($agentSellerCommission ?? 0)}} تومان </span>
                                        <span class="badge bg-white label shadow-sm text-green">{{toPersianNumbers($sellerCommission ?? 0)}} % </span>
                                    </span>
                                        <span class="pull-left">
                                        <i class="fa-coins fal text-yellow"></i>
                                        <span>{{ l('کمیسیون کارشناس خرید:') }}</span>
                                        <span class="text-maroon">{{toPersianNumbers($agentBuyerCommission ?? 0)}} تومان </span>
                                    </span>
                                    </h4>
                                </div>
                            </div>

                            <table id="contract_users" style="width: 100%;">
                                @foreach($model->contractUsers as $k=>$cu)
                                    <tr class="default-row" id="{{$cu->id}}">
                                        <td style="border: none;">
                                            <div class="bg-success form-group margin pad rounded row">
                                                <div class="col-lg-3" id="city_id">
                                                    <div class="form-group">
                                                        <label class="control-label ">{{ l('نوع کارشناس') }}</label>
                                                        <div class="form-control contract_users">{{$cu->{{ l('type == 1 ? \'کارشناس فروشنده\' : \'کارشناس خریدار\'}}') }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label  ">{{ l('کد کارشناس') }}</label>
                                                        <div class="form-control contract_users"><span class="text-aqua">{{$cu->expert->code ?? ''}}</span> {{$cu->expert->name ?? ''}}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label  ">{{ l('مبلغ کمیسیون اخذ شده (تومان)') }}</label>
                                                        <div class="form-control contract_users">{{toPersianNumbers($cu->expert_commission)}}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label ">{{ l('توضیحات') }}</label>
                                                        <div class="form-control contract_users">{{$cu->description}}</div>
                                                    </div>
                                                </div>

                                                @if(count($model->earnings) > 0)
                                                    @php($earnings = $model->earnings->where('expert_id',$cu->expert_id))
                                                    @if(!empty($earnings))
                                                        <div class="box clearfix col-lg-12">
                                                            <div class="table-responsive no-padding" >
                                                                <table class="table table-advance table-hover" id="">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-center">{{ l('کاربر') }}</th>
                                                                        <th class="text-center">{{ l('نقش') }}</th>
                                                                        <th class="text-center">{{ l('سطح لول معرف') }}</th>
                                                                        <th class="text-center">{{ l('درصد کمیسیون') }}</th>
                                                                        <th class="text-center">{{ l('درآمد') }}</th>
                                                                    </tr>
                                                                    </thead>

                                                                    @foreach($earnings as $item)

                                                                        <?php
                                                                            $systemEarnings = $model->earnings->where('expert_id',$item->expert_id)->whereIn('role_id',[0,1]);
                                                                            $systemCommissionPercent = $systemEarnings->sum('commission_percent');
                                                                            $systemCommissionAmount = $systemEarnings->sum('commission_amount');
                                                                        ?>

                                                                        {{-- نمایش کارشناس و مدیر شعبه دخیل در قولنامه --}}
                                                                        @if(empty($item->user_level))
                                                                            <tr class="" id="{{$item->id}}">
                                                                                <td class="text-center font_12">
                                                                                    @if($item->user)
                                                                                        <span class="font-light">{{$item->user->name ?? ''}}</span><br>
                                                                                        <span class="bg-danger font-light label text-danger text-sm">{{$item->user->code ?? ''}}</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td class="text-center"><span class="badge bg-olive font-light">{{$item->role_id == 1 ? l('سیستم') : ($item->role->title ?? '')}}</span></td>
                                                                                <td class="text-center">{{$item->user_level ?? ''}}</td>
                                                                                <td class="text-center text-red font_14">
                                                                                    @if($item->role_id == 1 && $currentUser->hasAnyRole('admin_branch|expert'))
                                                                                        {{$systemCommissionPercent ?? 0}} %
                                                                                    @else
                                                                                        {{$item->commission_percent ?? 0}} %
                                                                                    @endif
                                                                                </td>
                                                                                <td class="text-center text-green font_12">
                                                                                    <span class=" text-bold">
                                                                                        @if($item->role_id == 1 && $currentUser->hasAnyRole('admin_branch|expert'))
                                                                                            {{toPersianNumbers($systemCommissionAmount ?? 0)}}
                                                                                        @else
                                                                                            {{toPersianNumbers($item->commission_amount ?? 0)}}
                                                                                        @endif
                                                                                    </span> {{ l('تومان') }}
                                                                                </td>
                                                                            </tr>
                                                                        @endif

                                                                        {{-- عدم نمایش لیست افراد معرف، برای نقش l("مدیر شعبه") و l("کارشناس") --}}
                                                                        @if(!empty($item->user_level) && !$currentUser->hasAnyRole('admin_branch|expert'))
                                                                            <tr class="" id="{{$item->id}}">
                                                                                <td class="text-center font_12">
                                                                                    @if($item->user)
                                                                                        <span class="font-light">{{$item->user->name ?? ''}}</span><br>
                                                                                        <span class="bg-danger font-light label text-danger text-sm">{{$item->user->code ?? ''}}</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td class="text-center"><span class="badge bg-olive font-light">{{$item->role_id == 1 ? l('سیستم') : ($item->role->title ?? '')}}</span></td>
                                                                                <td class="text-center">{{$item->user_level ?? ''}}</td>
                                                                                <td class="text-center text-red font_14">{{$item->commission_percent ?? 0}} %</td>
                                                                                <td class="text-center text-green font_12"><span class=" text-bold">{{toPersianNumbers($item->commission_amount)}}</span>{{ l('تومان') }}</td>
                                                                            </tr>
                                                                        @endif

                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>


                                        </td>

                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif

                {{-- seller & buyer --}}
                @if(count($model->contractParties) > 0)
                    <div class="box clearfix">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ l('فروشندگان و خریداران') }}</h3>
                        </div>
                        <div class="box-body" >
                            <table id="contract_parties" style="width: 100%;">
                                @foreach($model->contractParties as $k=>$cp)
                                    <tr class="default-row" id="{{$cp->id}}">
                                        <td style="border: none;">
                                            <div class="bg-success form-group margin pad row">

                                                <div class="col-lg-3" id="city_id">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ l('نوع مشتری') }}</label>
                                                        <div class="form-control contract_parties">{{$cp->{{ l('type == 1 ? \'فروشنده\' : \'خریدار\'}}') }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ l('نام و نام خانوادگی') }}</label>
                                                        <div class="form-control contract_parties">{{$cp->name}}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ l('تلفن') }}</label>
                                                        <div class="form-control contract_parties">{{$cp->phone}}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ l('کد ملی') }}</label>
                                                        <div class="form-control contract_parties">{{$cp->national_code}}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ l('شماره رسید') }}</label>
                                                        <div class="form-control contract_parties">{{$cp->receipt_number}}</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ l('آدرس') }}</label>
                                                        <div class="form-control contract_parties">{{$cp->address}}</div>
                                                    </div>
                                                </div>
                                                <hr/>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif

        </div>

    </div>

<div class="modal fade" id="my_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <form role="form" method="POST" id="frm-history" action="">
            <input type="hidden" name="type" value="status">
            <input type="hidden" name="status">
            @csrf
            <div class="modal-content" style="width: 650px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">{{ l('تغییر وضعیت قولنامه :') }}
                        <span class="text-aqua">{{$model->code}}</span>
                    </h4>
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

@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection
@section('js')

    <script src="{{asset('admin2/dist/js/regions.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var route = '{{$routeUrl}}';
            var type = '{{$model->type}}';
            var estate_type = '{{$model->estate_type}}';
            var city_id = '{{$model->city_id}}';
            var branch_id = '{{$model->branch_id}}';
            var contract_manager_id = '{{$model->contract_manager_id}}';
            var estate_city_id = '{{$model->estate_city_id}}';
            var estate_district_id = '{{$model->estate_district_id}}';
            $(":radio[name=type][value='" + type + "']").iCheck('check');
            $(":radio[name=estate_type][value='" + estate_type + "']").iCheck('check');
            $('select[name=city_id]').select2().val(city_id).trigger('change');
            $('select[name=branch_id]').select2().val(branch_id).trigger('change');
            $('select[name=contract_manager_id]').select2().val(contract_manager_id).trigger('change');
            $('select[name=estate_city_id]').select2().val(estate_city_id).trigger('change');

            // change status
            $("#change-status").on("click", function () {
                var id = $(this).data('id');
                var status = $('select#status :selected').val();
                $("input[type='hidden'][name='status']").val(status);
                $("#frm-history").attr('action', '/admin/contracts/history/' + id + '/status');
            });
        });
    </script>
@endsection
