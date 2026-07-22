<div class="row">    
    @foreach($features as $feature)
    @if($feature->multiple == 1)
    @if(!empty($feature->items))
    <?php 
    $accept=true;  
    if($feature->agent_visible==1) 
    { 
        
        if(!$currentUser->isExpert()) 
            $accept=false; 
    }
    ?>
    @if($accept==true)
        <div class="col-lg-12 my-2">

            <a class="input-title toggle-title collapsed" data-toggle="collapse" href="#{{$feature->title_en}}" role="button" aria-expanded="true" aria-controls="{{$feature->title_en}}">
                @if($feature->icon !="")
                    <img src="{{asset('/frontend/show/svg/'.$feature->icon)}}" width="24px">
                @endif
                {{$feature->title}}
            </a>

            <div class="collapse multi-collapse show" id="{{$feature->title_en}}">
                <div class="card card-body">
                    <div class="row">
                        
                            @foreach($feature->items as $id=>$value)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" id="{{$feature->title_en}}{{$id}}" value="{{$id}}"
                                               type="{{$feature->multiple == 1 ? 'checkbox' : 'radio'}}"
                                               name="{{$feature->title_en}}{{$feature->multiple == 1 ? '[]' : ''}}"
                                               {{$feature->required == 1 && $currentUser->isExpert() ? 'required' : ''}}>
                                        <label class="form-check-label" for="{{$feature->title_en}}{{$id}}">
                                            {{$value}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        
                    </div>
                </div>
            </div>

        </div>
    @endif
    @endif
    @endif
    @endforeach
</div>

<div class="row">
@foreach($features as $feature)
    @if($feature->multiple != 1)
    @if(!empty($feature->items))
    <?php 
    $accept=true;  
    if($feature->agent_visible==1) 
    { 
        if(!$currentUser->isExpert()) 
            $accept=false; 
    }
    ?>
    @if($accept==true)
        <div class="col-md-4 col-sm-6 my-2">

            <label class="input-title" role="button">{{$feature->title}}</label>

            <div class="card card-body border-0 px-0 py-2">
                <select name="{{$feature->title_en}}{{$feature->multiple == 1 ? '[]' : ''}}"
                        {{$feature->required == 1 && $currentUser->isExpert() ? 'required' : ''}}
                        class="form-select select2" style="width:100%">
                    <option value="">{{ l('انتخاب نمایید') }}</option>
                   
                        @foreach($feature->items as $id=>$value)
                            <option value="{{$id}}">{{$value}}</option>
                        @endforeach
                    
                </select>
            </div>

        </div>
        @endif
        @endif
    @endif
@endforeach
</div>
