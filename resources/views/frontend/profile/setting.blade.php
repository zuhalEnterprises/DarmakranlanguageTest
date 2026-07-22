@extends(ss('THEME').'.frontend.layouts.intro.appnew_v2', [
    'title' => l('تنظیمات')
])
@section('main_content')
<!-- main -->
<main class="page-wrapper">
    @include(ss('THEME').'.frontend.layouts.header_v2', ['isadmin' => true])
    <!-- Page content-->
    <div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
        <!-- Page content-->
        <div class="row">
            @include('frontend.layouts.sidebar', ['menu' => 'setting'])
            <!-- Content-->
            <div class="col-lg-9 col-md-12 mb-5">
                <!-- Breadcrumb-->
            <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{l('خانه')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> {{l('تنظیمات')}}</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h1 class="h2 mb-0">
                    {{l('تنظیمات')}}
                </h1>
            </div>
            <div class="accordion" id="accordionExample">
                @if(count($models))
                @php
                    $group = '';
                @endphp
                @foreach( $models as $setting)

                @if($setting->group != $group )
                @if($group == '')
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{$setting->group}}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$setting->group}}" aria-expanded="true" aria-controls="collapse{{$setting->group}}">{{$setting->group}}</button>
                    </h2>
                    <div class="accordion-collapse collapse show" aria-labelledby="heading{{$setting->group}}" data-bs-parent="#accordionExample" id="collapse{{$setting->group}}">
                        <div class="accordion-body">
                @else
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{$setting->group}}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$setting->group}}" aria-expanded="true" aria-controls="collapse{{$setting->group}}">{{$setting->group}}</button>
                    </h2>
                    <div class="accordion-collapse collapse" aria-labelledby="heading{{$setting->group}}" data-bs-parent="#accordionExample" id="collapse{{$setting->group}}">
                        <div class="accordion-body">
                @endif
                @endif
                <div class="mb-3">
                    <form class="form-group">
                        <label for="text-input" class="form-label">{{$setting->name}}{{$setting->comment ? '('.$setting->comment.')':''}}  </label>
                        <input class="form-control value{{$setting->id}}" type="text" id="text-input" value="{{$setting->value}}">
                        <button type="button" class="btn btn-primary"  onclick="return saveSetting({{$setting->id}}); return false;">{{l('ویرایش')}}</button>
                    </form>
                </div>



                @php
                $group = $setting->group;
                @endphp

                @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>

@include(ss('THEME').'.frontend.layouts.footer_v2', ['cssClass' => 'intro'])
@endsection
@section('js')
<script src="/frontend/vendor/sweetalert2.all.js"></script>
<script>
    function saveSetting(id)
    {
        var value = $('.value'+id).val();
        var CSRF_TOKEN = '{{ csrf_token() }}';
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $.ajax({
                url: '/profile/setting/update',
                type: "POST",
                data: {
                    'id':id ,
                    'value':value
                },
                success: function(data) {
                    swal({
                        title: "{{l('تنظیمات با موفقیت تغییر کرد')}}",
                        message: "",
                        confirmButtonColor: '#025EC6',
                        confirmButtonText: l('باشه'),
                        type: "success",
                        timer: 2000
                    });

                },
            });
    }
</script>
@endsection
