@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => ss('SITE_NAME')
])

@section('main_content')

    <!-- main -->
    <main class="page-wrapper">
        @include(ss('THEME').'.frontend.layouts.header_v2')
        <style>
            .image_v {
                background-image: url(/img/real-estate/{{$selectedCity}}.jpg);
                background-position: center;
                background-size: cover;
            }
        </style>

    </main>
<style>
    .shadow-sm {
        box-shadow: 0 0.125rem 0.125rem -0.125rem #bbbbbb, 0 0.25rem 0.75rem #bbbbbb !important;
      }
</style>

    @include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
