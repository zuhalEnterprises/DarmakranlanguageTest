@foreach($estates as $estate)

<!-- Item-->
<div class="col-12 col-md-6 col-lg-3 pb-sm-2">
    <article class="position-relative">
        <div class="position-relative mb-3">
            @if(\Auth::user())

                <button class="itemFavorite_{{$estate->id}} text-[20px]  {{count($estate->favorites)>0?'text-blue-500':'text-gray-200'}} btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="right" onclick="addFavorite({{$estate->id}}) " data-id="{{$estate->id}}">
                    <i class="fi-heart"></i>
                </button>

             @endif

            <img class="rounded-3" src="{{$estate->coverImage()}}" alt="اجاره اقامتگاه {{ estateTypes($estate->estate_type) }} در {{($estate->city->name ?? '')}}" style="height: 250px;
    object-fit: cover;width:100%">
        </div>
        <h3 class="mb-2 fs-lg">
            <a class="nav-link stretched-link" href="/room/{{ $estate->id }}">
                 اجاره اقامتگاه {{ estateTypes($estate->estate_type) }} در {{($estate->city->name ?? '')}}
            </a>
        </h3>
        <ul class="list-inline mb-0 fs-sm">
            <li class="list-inline-item pe-1">
                {{ !empty($fieldList['room_count'][$estate->room_count]) && $fieldList['room_count'][$estate->room_count] != l('سوئیت') ? $fieldList['room_count'][$estate->room_count] .' '. l('خوابه') : l('سوئیت') }} . {{$estate->area}} متر . تا {{$estate->{{ l('max_person}} مهمان') }}
            </li>
            <!--li class="list-inline-item pe-1"><i class="fi-star-filled mt-n1 me-1 fs-base text-warning align-middle"></i><b>5.0</b>
                <span class="text-muted">{{ l('&nbsp;(48نظر)') }}</span>
            </li-->
            <li class="list-inline-item pe-1">
                @if($estate->{{ l('rent != 0) هر شب از') }}
                <b>{{toPersianNumbers($estate->{{ l('rent)}} تومان') }}</b>
                @else
                <b>{{ l('توافقی') }}</b>
                @endif
            </li>

        </ul>
    </article>
</div>


@endforeach
<script>
    function addFavorite(id) { $.get("/estates/favorite/" + id, function(data, status) { if (data.result == 1) { /* toast({ type: 'success', text: 'ملک مورد نظر به لیست نشان شده های شما افزوده شد.' });*/ $(".itemFavorite_" + id).addClass("text-blue-500").removeClass("text-gray-200"); //$(".itemFavorite-" + id).addClass("favorited"); } else { /*toast({ type: 'error', text: 'ملک مورد نظر از لیست نشان شده های شما حذف شد.' });*/ $(".itemFavorite_" + id).removeClass("text-blue-500").addClass("text-gray-200"); //$(".itemFavorite-" + id).removeClass("favorited"); } }); }
</script>
