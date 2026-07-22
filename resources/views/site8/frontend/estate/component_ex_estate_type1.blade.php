@foreach($estates as $estate)
<div class="col-lg-6 col-sm-12 mt-3">
    @include(ss('THEME').'.frontend.estate.card' , ['estate' => $estate])
</div>
@endforeach
<script>
function addFavorite(id){
    $.get("/estates/favorite/" + id, function (data, status) {
        if (data.result == 1) {

            $(".itemFavorite_" + id).addClass("text-blue-500").removeClass("text-gray-200");
        } else {
            $(".itemFavorite_" + id).removeClass("text-blue-500").addClass("text-gray-200");
        }
    });
}
</script>
