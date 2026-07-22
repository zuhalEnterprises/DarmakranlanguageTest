@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', ['title' => ss('SITE_NAME')])
@section('head')
@endsection
@section('main_content')
@include(ss('THEME').'.frontend.layouts.header_v2')
<div class="container mt-5 mb-md-4 py-5">
    <!-- Breadcrumb-->
    <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ l('درباره ما') }}</li>
        </ol>
    </nav>

    <h1 class="h2 mb-4 font-vazir">{{ l('درباره ما') }}</h1>
    <div class="row mx-0">
        <div class="col-12 px-0 p-1 text-justify" style="min-height: 300px;line-height:250%;font-size:20px">
         {{ss('SITE_NAME')}} با هدف خرید و فروش آنلاین ملک در سال ۱۳۹۵ بصورت استان محور در سراسر کشور شروع به کار کرده است.
<br/>
تیم {{ss('SITE_NAME')}} در صدد بنگاهداری ملک نمی باشد و صرفا خدمات املاک به کارشناسان و مشتریان عرضه می کند.
        </div>
    </div>
</div>
    @section('js')

@endsection
@include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
@endsection

