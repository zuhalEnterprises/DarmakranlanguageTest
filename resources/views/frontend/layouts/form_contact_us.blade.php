<div id="contact-form" class="mt-5">

    @if (\Session::has('success'))
    <div class="alert alert-success ml-3 mr-3">
        <p>{{\Session::get('success')}}</p>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger ml-3 mr-3">
        <ul>
            @foreach ($errors->all() as $error)
            <ol>{{ $error }}</ol>
            @endforeach
        </ul>
    </div>
    @endif

    <form class="form-horizontal clearfix border p-4 rounded" action="/contact" method="post">
        @csrf

        <div class="col-12 form-group mt-3">
            <div class="row">
                <label class="col-4" for="nameForm">{{ l('نام') }}
                    <span class="required" style="color: red;"> * </span>
                </label>
                <div class="col-8">
                    <input type="text" id="nameForm" name="name" class="form-control" required oninvalid="this.setCustomValidity('{{ l('لطفا نام خود را وارد نمایید!') }}')" oninput="setCustomValidity('')">
                </div>
            </div>
        </div>

        <div class="col-12 form-group">
            <div class="row">
                <label class="col-4" for="nameForm">{{ l('شماره موبایل') }}
                    <span class="required" style="color: red;"> * </span>
                </label>
                <div class="col-8">
                    <input type="tel" name="mobile" pattern="[0-9]{11}" maxlength="11" class="form-control" required oninvalid="this.setCustomValidity('{{ l('شماره موبایل الزامیست!') }}')" oninput="setCustomValidity('')">
                </div>
            </div>
        </div>
        <div class="col-12 form-group">
            <div class="row">
                <label class="col-4" for="nameForm">{{ l('ایمیل') }}</label>
                <div class="col-8">
                    <input type="email" name="email" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-12 form-group">
            <textarea style="height:150px" id="message" name="message" cols="45" rows="100" aria-required="true" placeholder="{{ l('متن پیام') }}" class="form-control" required oninvalid="this.setCustomValidity('{{ l('لطفا متن پیام را وارد نمایید!') }}')" oninput="setCustomValidity('')"></textarea>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
            <button type="submit" class="btn btn-success px-5 py-2">{{ l('ارسال پیام') }}</button>
        </div>
    </form>
    <div class="cls"></div>
</div>