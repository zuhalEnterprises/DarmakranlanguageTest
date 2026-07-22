@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2',
[
'title'=>'تماس با '.ss('SITE_NAME')
])
@section('main_content')
    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <!-- Page content-->
        <!-- Breadcrumb-->
        <div class="container mt-5 mb-md-4 pt-5">
            <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ l('خانه') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$post->title}}</li>
                </ol>
            </nav>
        </div>
        <!-- Hero-->
        <section class="container mb-5 pb-2 pb-md-4 pb-lg-5">
            {!! $post->body !!}
        </section>
        <section class="container mb-5 pb-2 pb-md-4 pb-lg-5">

        </section>
    </main>
    @include(ss('THEME').'.frontend.layouts.footer_v2',['cssClass'=>'intro'])
    @endsection
