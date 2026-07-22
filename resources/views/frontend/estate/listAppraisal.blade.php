@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('کارشناسی قیمت ملک')
])
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
        <!-- Page content-->
        <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
            <!-- Page content-->
            <div class="row">
                @include('frontend.layouts.sidebar', ['menu' => 'appraisal'])
                <!-- Content-->
                <div class="col-lg-9 col-md-12 mb-5">
                    <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ l('کارشناسی قیمت ملک') }}</li>
                    </ol>
                </nav>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h1 class="h2 mb-0">
                            {{ l('کارشناسی قیمت ملک') }}
                        </h1>
                    </div>

                    <div class="tab-content1" id="appraisal">
                    </div>
                    <nav class="pt-4 pb-2 border-top" aria-label="Blog pagination" id="pagination">
                    </nav>
                </div>
            </div>
        </div>
    </main>

@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection

@section('js')
<link rel="stylesheet" href="/assets/vendors/swiperjs/css/swiper.css">
<script src="/assets/vendors/swiperjs/js/swiper.js"></script>
<script src="/frontend/vendor/sweetalert2.all.js"></script>
<script src="/frontend/js/paging.js"></script>
<script>
    const toast = swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 2500
    });
    function CheckSend()
    {
        var sr = "";
        loadMoreData(1,sr)
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
                url: "/profile/appraisalShow?page="+page+"&&"+type,
                type: "get",
                beforeSend: function() {
                    $('.page-loading').addClass('active');
                }
            })
            .done(function(data) {
                $('.page-loading').removeClass('active');
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
            if(pagin>0){ loadMoreData($(this).attr("pn"),type1); } } ); $(document).ready(function() { CheckSend(); }); function destroy(id){ $.get("/profile/appraisal/remove/"+id , function (data, status) { toast({ type: 'success', text: 'با موفقیت حذف شد' }); CheckSend(); }); }
</script>
@endsection
