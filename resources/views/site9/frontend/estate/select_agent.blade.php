@section('title', l('ثبت رایگان آگهی ملک-انتخاب کارشناس'))

@extends('frontend.layouts.app')
@section('head')
@endsection
@section('main_content')

    @include('frontend.layouts.header')

    <div class="container">

        <h1 class="sabt">{{ l('انتخاب کارشناس') }}</h1>

        <div class="col page-desc py-2 text-justify">
            <?php echo $templatePage->description;?>
        </div>

        <div class="rounded z-depth-0 bg-light mt-2 bg-white mt-3 py-2 col">
            <form action="/estates/{{$token}}/assign_agent" method="post">
                @csrf
            {{--<div class="row" style="justify-content: center;">
                <div class="col-xl-4 col-md-4 adress-area my-2 px-2 kama-agent-tile " id="adress1">
                    <div class="adress-card rounded-sm pt-2 px-3 border primary-agent">
                        <div class="form-check">
                            <input checked class="form-check-input" id="materialChecked" name="materialExampleRadios" type="radio"> <label class="form-check-label" for="materialChecked">{{ l('انتخاب این کارشناس') }}</label>
                        </div>
                        <hr class=" mt-2 mb-2">
                        <div>
                            <div class="img-area"><img alt="" class="rounded-circle" src="img/avatar1.jpg"></div>
                            <div class="customer-info p-2">
                                <h3>{{ l('رضا محمدی') }}</h3>
                                <h4>{{ l('کارشناس ارشد') }}</h4>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row adress-footer">
                            <div class="col-lg-6"><a href="#">{{ l('مشاهده پروفایل') }}</a></div>
                            <div class="col-lg-6"><a href="#"><i class="fa fa-phone"></i> 09126503636</a></div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>--}}
            <div class="row col">

                @foreach($agents as $agent)
                    <div class="col-xl-4 col-md-4 col-sm-12 adress-area my-2 px-2 kama-agent-tile" id="adress2">
                        <div class="adress-card rounded-sm pt-2 px-3 border">
                            <div class="form-check">
                                <input class="form-check-input" id="agent-{{$agent->id}}" name="agent_id" type="radio" value="{{$agent->id}}" required>
                                <label class="form-check-label" for="agent-{{$agent->id}}">{{ l('انتخاب کارشناس') }}</label>
                            </div>
                            <hr class=" mt-2 mb-2">
                            <div>
                                <div class="img-area"><img alt="" class="rounded-circle" src="{{$agent ? $agent->photo() : noImage()}}"></div>
                                <div class="customer-info p-2">
                                    <h3>{{$agent->name ?? ''}}</h3>
                                    <p>کارشناس متخصص
                                        {{--{{$agent->getRoleTitle() ?? ''}}--}}
                                        <span class="font-weight-bolder">
                                            {{$agent->activity_type == 1 ? l('فروش') : ($agent->activity_type == 2 ? l('اجاره') : l('فروش و اجاره'))}}
                                            {{estateTypes($agent->activity_estate_type ?? 1)}}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row adress-footer">
                                <div class="col-lg-6"><a href="/agents_v2/{{$agent->code ?? '0'}}" target="_blank">{{ l('مشاهده پروفایل') }}</a></div>
                                <div class="col-lg-6"><a href="tel:+98{{substr($agent->username,1)}}"><i class="fa fa-phone"></i> {{$agent->username}}</a></div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                @endforeach

            </div>


            <div class="my-2">
                {{--<a class="btn btn-link border-primary ml-0 btn-sabt waves-effect waves-light" href="#">{{ l('بازگشت') }}</a>--}}
                <button class="btn btn-success border-primary ml-0 btn-sabt waves-effect waves-light" id="select-agent" type="submit">{{ l('تایید نهایی') }}</button>
            </div>

            </form>
        </div>
    </div>

@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () { $('#select-agent').on('click',function () { var selectedAgent = document.querySelector('input[name="agent_id"]:checked'); if(selectedAgent===null){ return swal({ type : 'warning', text: l("برای تکمیل ثبت ملک انتخاب یکی از کارشناسان الزامیست!"), confirmButtonColor: '#3085d6', confirmButtonText: 'تایید' }); } //var agentId = selectedAgent.value; //alert(agentId) }) });
    </script>
@endsection
