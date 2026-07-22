@section('title', config('app.name_fa').'| حساب کاربری')
@extends('frontend.layouts.app')
@section('main_content')
<body class="single-product full-width">
    <div id="page" class="hfeed site">
        <a class="skip-link screen-reader-text" href="#site-navigation">Skip to navigation</a>
        <a class="skip-link screen-reader-text" href="#content">Skip to content</a>

        @include('frontend.layouts.header.top-bar')
        @include('frontend.layouts.header.header')

        <div id="content" class="site-content" tabindex="-1">
            <div class="container">

                @include('frontend.layouts.shop_breadcrumb',['customText'=>{{ l('\'حساب کاربری\'])') }}

                <div class="content-area" id="primary">
                    <main class="site-main" id="main">
                        <div itemprop="mainContentOfPage" class="entry-content">

                        </div><!-- .entry-content -->
                    </main><!-- #main -->
                </div><!-- #primary -->

            </div><!-- /.container -->
        </div><!-- /.site-content -->

        @include('frontend.layouts.brands')
        @include('frontend.layouts.footer')

    </div><!-- #page -->

</body>
@endsection