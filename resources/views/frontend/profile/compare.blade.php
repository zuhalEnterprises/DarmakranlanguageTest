@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('مقایسه املاک')
])

@section('main_content')
    <!-- main -->
    <style>
.table-pic {
    height: 45px;
}
@media (min-width:996px) {
    .table-pic {
    height: 75px;
}
}
        </style>
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
        <!-- Page content-->
        <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">

            <!-- Page content-->
            <div class="row">
                @include('frontend.layouts.sidebar', ['menu' => '8'])

                <!-- Content-->
                <div class="col-lg-9 col-md-12 pt-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h1 class="h2 mb-0">{{l('مقایسه املاک')}}</h1>
                        <a class="fw-bold text-decoration-none" href="javascript:void(0)" onclick="removeall()">
                            <i class="fi-trash mt-n1 me-2"></i>{{l('حذف همه')}}
                        </a>
                    </div>
                    <p class="pt-1 mb-4">{{l('در اینجا می توانید املاک مورد نظر خود را مشاهده کرده و به راحتی آنها را مقایسه کنید.')}}</p>
                    <div class="my-3 table-responsive js_content">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col" valign="middle" style="text-align:center">#</th>
                                    <th scope="col" valign="middle" style="text-align:center"class="sortable" onclick="sort('id')">{{l('کد ملک')}}</th>
                                    <th scope="col" valign="middle" style="text-align:center">{{l('نوع ملک')}}</th>
                                    <th scope="col" valign="middle" style="text-align:center">{{l('شهر')}}</th>
                                    <th scope="col" valign="middle" style="text-align:center">{{l('منطقه')}}</th>
                                    <th scope="col" valign="middle" style="text-align:center" class="sortable" onclick="sort('area')">{{l('مساحت کل')}}</th>
                                    <th scope="col" valign="middle" style="text-align:center" class="sortable" onclick="sort('price1')"> {{l('قیمت / رهن')}}</th>
                                    <th scope="col" valign="middle" style="text-align:center" class="sortable" onclick="sort('price2')">{{l('متری / اجاره')}}</th>
                                    <th scope="col" valign="middle" style="text-align:center" class="sortable" onclick="sort('updated_at')"> {{l('تاریخ')}}</th>
                                    <th valign="middle" style="text-align:center" scope="col"> {{l('ابزار')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estates as $estate)
                                <tr>
                                    <th valign="middle" align="center" scope="row" width="100">
                                        <a href="#">
                                            <img class="w-100 object-cover rounded-1 table-pic" src="{{$estate->coverImage()}}"
                                                alt="real estate" >
                                        </a>
                                    </th>
                                    <td valign="middle" align="center">
                                        <a class="text-body text-decoration-none" href="{{ $estate->url() }}">
                                            {{$estate->id}}
                                        </a>
                                    </td>
                                    <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{ $estate->url() }}">{{estateTypes($estate->estate_type)}}</a> </td>
                                    <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{ $estate->url() }}">{{$estate->city->name??""}}</a> </td>
                                    <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{ $estate->url() }}">{{$estate->district->name??""}}</a> </td>
                                    <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{ $estate->url() }}">{{!empty($estate->area)?$estate->{{ l('area." متر":""}}') }}</a></td>
                                    @if ($estate->type == 2)
                                        <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{ $estate->url() }}">{{ toPersianNumbers($estate->{{ l('mortgage) }} ت') }}</td>
                                        <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{ $estate->url() }}">{{ toPersianNumbers($estate->{{ l('rent) }} ت') }}</td>
                                    @else
                                        @if ($estate->price > 0)
                                            <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{ $estate->url() }}">
                                                {{ toPersianNumbers($estate->{{ l('price) }} ت') }}
                                            </a>
                                            </td>
                                                <td valign="middle" align="center">
                                                    <a class="text-body text-decoration-none" href="{{ $estate->url() }}">
                                                {{ toPersianNumbers($estate->{{ l('price_per_meter) }} ت') }}
                                                    </a>
                                            </td>
                                        @else
                                            <td valign="middle" align="center"> <a class="text-body text-decoration-none" href="{{ $estate->url() }}">
                                                {{l('توافقی')}}
                                            </a>
                                            </td>
                                            <td></td>
                                        @endif
                                    @endif
                                    <td valign="middle" align="center"><a class="text-body text-decoration-none" href="{{ $estate->url() }}">{{toPersianDate($estate->showdate)}}</a> </td>
                                    <td valign="middle" align="center">
                                        <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fi-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu my-1" aria-labelledby="contextMenu2">
                                            <li>
                                                <a class="dropdown-item" target="_blank" href="{{ $estate->url() }}">
                                                    <i class="fa-light fa-eye opacity-60 me-2"></i>{{l('مشاهده جزئیات')}}</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" style="cursor:pointer" onclick="if(confirm('{{l('آیا از حذف این ملک مطمئن هستید؟')}}'))destroy({{$estate->id}})" class="flex items-center gap-2 p-2 hover:text-blue-500">
                                                    <i class=" opacity-60 me-2 fa-light fa-trash-can"></i>
                                                    {{l('حذف از لیست مقایسه')}}
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
   @include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<link rel="stylesheet" href="/assets/vendors/swiperjs/css/swiper.css">
<style>
    .overme {
        width: 100px;
        overflow:hidden;
        white-space:nowrap;
        text-overflow: ellipsis;
    }

</style>
<script src="/assets/vendors/swiperjs/js/swiper.js"></script>
<script src="/frontend/vendor/sweetalert2.all.js"></script>
<script>
    const toast = swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 2500
    });
    var swiper = new Swiper(".js_filter_search", {
        slidesPerView: "auto",
        spaceBetween: 16,
        freeMode: true,
    });
    function removeall(){
        $.get("/estates/compare_remove_all", function (data, status)
        {
            toast({
                type: 'success',
                text: '{{l('کلیه املاک از لیست مقایسه های شما حذف شد.')}}'
            });
            $(".js_content").html('');
        });
    }
    function destroy(id){
        $.get("/estates/compare_remove/"+id , function (data, status)
        {
            toast({
                type: 'success',
                text: '{{l('ملک از لیست مقایسه های شما حذف شد.')}}'
            });
            location.reload();
        });
    }
</script>
@endsection
