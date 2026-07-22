
<div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button collapsed font_10" type="button"
            data-bs-toggle="collapse" data-bs-target="#collapseOne"
            aria-expanded="false" aria-controls="collapseOne">
            {{ l('خصوصیات') }}
        </button>
    </h2>
    <div id="collapseOne" class="groupshow1 accordion-collapse collapse"
        data-mcs-theme="dark" aria-labelledby="headingOne"
        data-bs-parent="#apartment-rent" style="overflow:auto">
        @foreach($features as $feature)
        @if($feature->group==1)
        @if(!empty($feature->items))

    <div class="row  mx-0 group{{$feature->group}}">
        <div class="{{$feature->title_en}} featurs col-lg-12 my-2 px-3">
                <label id="lbl{{$feature->title_en}}" class="input-title toggle-title" aria-controls="{{$feature->title_en}}">
                @if($feature->title==l('نوع توالت')){{'نوع سرویس بهداشتی'}}
                @else
                {{$feature->title}}
                @endif
    </label>
            <div class="" id="{{$feature->title_en}}">
                <div class="">
                    <div class="row mx-0">
                    @if($feature->multiple != 1)
                        <select id="{{$feature->title_en}}{{$feature->multiple == 1 ? '[]' : ''}}" name="{{$feature->title_en}}{{$feature->multiple == 1 ? '[]' : ''}}"
                            {{$feature->required == 1 && \Auth::check() && $currentUser->isExpert() ? 'required' : ''}}
                            class="form-select select2 feathers" style="width:100%">
                            <option value="">{{ l('انتخاب نمایید') }}</option>
                    @endif


                            @foreach($feature->items as $id=>$value)
                            @if($feature->multiple != 1)
                            <option value="{{$id}}">{{$value}}</option>
                            @endif
                            @if($feature->multiple == 1)
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 px-0">
                                    <div class="form-check">
                                        <input class="form-check-input feathers" id="{{$feature->title_en}}{{$id}}" value="{{$id}}"
                                               type="{{$feature->multiple == 1 ? 'checkbox' : 'radio'}}"
                                               name="{{$feature->title_en}}{{$feature->multiple == 1 ? '[]' : ''}}"
                                               {{$feature->required == 1 && \Auth::check() && $currentUser->isExpert() ? 'required' : ''}}>
                                        <label class="form-check-label" for="{{$feature->title_en}}{{$id}}">
                                            {{$value}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                            @endforeach


                        @if($feature->multiple != 1)
                            </select>
                        @endif

                    </div>
                </div>
            </div>

        </div>
        </div>
        @endif
@endif
        @endforeach



</div>
</div>

<!-- امکانات -->
<div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed font_10" type="button"
            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
            aria-expanded="false" aria-controls="collapseTwo">
            {{ l('امکانات') }}
        </button>
    </h2>

        <div id="collapseTwo" class="groupshow2 accordion-collapse collapse"
        data-mcs-theme="dark" aria-labelledby="headingTwo"
        data-bs-parent="#apartment-rent" style="overflow:auto">
        @foreach($features as $feature)
        @if($feature->group==2)
        @if(!empty($feature->items))
    <div class="row  mx-0 group{{$feature->group}}">
    <div class=" col-lg-12 my-2 px-3">

            <div class="collapse multi-collapse show" id="{{$feature->title_en}}">
                    <div class="row mx-0">
                    @if($feature->multiple != 1)
                    <select name="{{$feature->title_en}}{{$feature->multiple == 1 ? '[]' : ''}}"
                            {{$feature->required == 1 && \Auth::check() && $currentUser->isExpert() ? 'required' : ''}}
                            class="form-select select2 feathers" style="width:100%">
                            <option value="">{{ l('انتخاب نمایید') }}</option>
                         @endif


                            @foreach($feature->items as $id=>$value)
                            @if($feature->multiple != 1)
                            <option value="{{$id}}">{{$value}}</option>
                            @endif
                            @if($feature->multiple == 1)
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 px-3">
                                    <div class="form-check">
                                        <input class="form-check-input js_feature {{$feature->title_en}}" id="{{$feature->title_en}}{{$id}}" value="{{$id}}"
                                               type="{{$feature->multiple == 1 ? 'checkbox' : 'radio'}}"
                                               name="{{$feature->title_en}}{{$feature->multiple == 1 ? '[]' : ''}}"
                                               {{$feature->required == 1 && $currentUser->isExpert() ? 'required' : ''}}>
                                              <label class="form-check-label" id="js_lbl{{$feature->title_en}}{{$id}}" for="{{$feature->title_en}}{{$id}}">
                                            {{$value}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                            @endforeach


                        @if($feature->multiple != 1)
                            </select>
                        @endif


                </div>
            </div>

        </div>
        </div>
        @endif
@endif
        @endforeach

</div>


    </div>

    <!-- شرایط -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed font_10" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                aria-expanded="false" aria-controls="collapseThree">
                {{ l('شرایط') }}
            </button>
        </h2>

        <div id="collapseThree" class="groupshow3 accordion-collapse collapse"
            data-mcs-theme="dark" aria-labelledby="headingThree"
            data-bs-parent="#apartment-rent" style="overflow:auto">
            @foreach($features as $feature)
            @if($feature->group==3)
            @if(!empty($feature->items))
    <div class="row mx-0 group{{$feature->group}}">
    <div class=" col-lg-12 my-2 px-3">

            <div class="collapse multi-collapse show" id="{{$feature->title_en}}">
                <div class="">
                    <div class="row mx-0">
                    @if($feature->multiple != 1)
                    <select  name="{{$feature->title_en}}{{$feature->multiple == 1 ? '[]' : ''}}"
                            {{$feature->required == 1 && \Auth::check() && $currentUser->isExpert() ? 'required' : ''}}
                            class="form-select select2 feathers" style="width:100%">
                            <option value="">{{ l('انتخاب نمایید') }}</option>
                    @endif


                            @foreach($feature->items as $id=>$value)
                            @if($feature->multiple != 1)
                            <option value="{{$id}}">{{$value}}</option>
                            @endif
                            @if($feature->multiple == 1)
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 px-3">
                                    <div class="form-check">
                                        <input class="form-check-input js_condition"  id="{{$feature->title_en}}{{$id}}" value="{{$id}}"
                                               type="{{$feature->multiple == 1 ? 'checkbox' : 'radio'}}"
                                               name="{{$feature->title_en}}{{$feature->multiple == 1 ? '[]' : ''}}"
                                               {{$feature->required == 1 && \Auth::check()  && $currentUser->isExpert() ? 'required' : ''}}>
                                                <label class="form-check-label" id="js_lbl{{$feature->title_en}}{{$id}}" for="{{$feature->title_en}}{{$id}}">
                                            {{$value}}
                                        </label>
                                    </div>
                                </div>
                            @endif
                            @endforeach


                        @if($feature->multiple != 1)
                            </select>
                        @endif

                    </div>
                </div>
            </div>

        </div>
        </div>
        @endif
@endif
        @endforeach

</div>
</div>

<div></div>






