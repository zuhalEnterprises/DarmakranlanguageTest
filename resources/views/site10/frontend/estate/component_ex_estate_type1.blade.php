
@if(count($estates)>0)
@foreach($estates as $estate)
<!-- Item-->
<div class="col-12 col-md-6 col-xl-4">
    @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate , 'slider' => false])
</div>
<!-- Item-->
@endforeach
@else
<div class="col-12 col-lg-12">
    <div class="align-items-center  justify-content-md-center border-0 p-md-5 p-4">
        {{ l('کاربر گرامی: متاسفانه نتیجه ای یافت نشد!') }}
    </div>
</div>
@endif
<script>
function addFavorite(id){ $.get("/estates/favorite/" + id, function (data, status) { if (data.result == 1) { /* toast({ type: 'success', text: 'ملک مورد نظر به لیست نشان شده های شما افزوده شد.' });*/ $(".itemFavorite_" + id).addClass("text-blue-500").removeClass("text-gray-200"); //$(".itemFavorite-" + id).addClass("favorited"); } else { /*toast({ type: 'error', text: 'ملک مورد نظر از لیست نشان شده های شما حذف شد.' });*/ $(".itemFavorite_" + id).removeClass("text-blue-500").addClass("text-gray-200"); //$(".itemFavorite-" + id).removeClass("favorited"); } }); }
</script>
