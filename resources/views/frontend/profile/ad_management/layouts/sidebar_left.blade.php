<div class="col-lg-2 hidden-xs side-ads">
    @php($ads = $templatePage->ads->where('show_place',4) ?? [])
    @foreach($ads as $ad)
        @if($ad->type == 1)
            <div class="img-ads mb-2">
                <a href="{{$ad->url ?? 'javascript:void(0)'}}">
                    <img class="radius-5" src="{{$ad->image()}}" alt="{{$ad->title}}">
                </a>
            </div>
        @else
            <div class="border mb-2 text-ads" style="background: #fcfcfc;">
                <a href="{{$ad->url ?? 'javascript:void(0)'}}">
                    <h5 class="text-info">{{$ad->title}}</h5>
                    <p class="text-body text-small">{{$ad->description}}</p>
                </a>
            </div>
        @endif
    @endforeach
</div>
