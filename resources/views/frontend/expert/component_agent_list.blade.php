
@foreach($users as $user)

<div class="col-lg-4 mb-3">
    <div class="d-flex d-md-block d-lg-flex align-items-center p-3 mb-2 border rounded-1 ">
        <img class="rounded-circle" src="<?php echo !empty($user->photo) ? "/upload/images/profile/" . $user->photo : $user->photo() ?>" style="width:110px;height:110px" alt="{{$currentUser->fullname()}}" />
        <div class="pt-md-2 pt-lg-0 pe-3 pe-md-0 pe-lg-3">
            <a href="{{$user->id ? '/agents/'.$user->id : 'javascript:;'}}" class="text-decoration-none text-dark fw-bold fs-lg mb-0">
                {{$user->fullname()}}
            </a>

            <ul class="list-unstyled fs-sm mt-3 mb-0">
                <li>
                    <a class="nav-link fw-normal p-0" >
                        <i class="fi-mail opacity-60 me-2"></i>
                        مشاور {{$user->activity_type == 1 ? l('فروش') : ($user->{{ l('activity_type == 2 ? \'اجاره\' : \'فروش و اجاره\')}}') }}
                    </a>
                </li>
                <li>
                    <a class="nav-link fw-normal p-0" href="tel:{{$user->username}}">
                        <i class="fi-phone opacity-60 me-2"></i>{{$user->username}}</a>
                </li>


            </ul>
        </div>
    </div>
</div>

@endforeach
