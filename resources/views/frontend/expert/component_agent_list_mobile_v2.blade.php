@foreach($users as $user)
<div class="rounded-2xl border-[1px] border-gray-200 p-3 relative my-3">
    <div class="flex items-start justify-start">
        <div>
            <div class="m-auto"> <a class="w-[100px] h-[100px] rounded-full overflow-hidden intro-expert-img block" href="{{$user->id ? '/agents_v2/'.$user->id : 'javascript:;'}}"><img class="w-full h-full object-contain" src="<?php echo !empty($user->photo) ? "/upload/images/profile/" . $user->photo : "/assets/image/logo/desktop-logo.svg" ?>"  alt=""></a></div>
            <div class="mt-3">
                {{--<div dir="ltr" class="inline-block css_star-rating">
                    <input class="hidden" id="star-5" type="radio" name="rating" value="star-5" />
                    <label class="text-gray-400 text-lg cursor-pointer" for="star-5" title="{{ l('5 ستاره') }}">
                      <i class="active fa fa-star" aria-hidden="true"></i>
                    </label>
                    <input class="hidden" id="star-4" type="radio" name="rating" value="star-4" />
                    <label class="text-gray-400 text-lg cursor-pointer" for="star-4" title="{{ l('4 ستاره') }}">
                      <i class="active fa fa-star" aria-hidden="true"></i>
                    </label>
                    <input class="hidden" id="star-3" type="radio" name="rating" value="star-3" />
                    <label class="text-gray-400 text-lg cursor-pointer" for="star-3" title="{{ l('3 ستاره') }}">
                      <i class="active fa fa-star" aria-hidden="true"></i>
                    </label>
                    <input class="hidden" id="star-2" type="radio" name="rating" value="star-2" />
                    <label class="text-gray-400 text-lg cursor-pointer" for="star-2" title="{{ l('2 ستاره') }}">
                      <i class="active fa fa-star" aria-hidden="true"></i>
                    </label>
                    <input class="hidden" id="star-1" type="radio" name="rating" value="star-1" />
                    <label class="text-gray-400 text-lg cursor-pointer" for="star-1" title="{{ l('1 ستاره') }}">
                      <i class="active fa fa-star" aria-hidden="true"></i>
                    </label>
                </div>--}}
            </div>
        </div>
        <div class="mr-4 space-y-3">
            <a href="{{$user->id ? '/agents_v2/'.$user->id : 'javascript:;'}}"><h2 class="text-lg text-gray-500 font-extrabold">{{$user->fullname()}}</h2></a>
            <p class="text-sm text-gray-500 font-light"><span>{{ l('تخصص کارشناس:') }}</span> <span class="font-medium">{{$user->activity_type == 1 ? l('فروش') : ($user->{{ l('activity_type == 2 ? \'اجاره\' : \'فروش و اجاره\')}}') }}</span></p>
            <!--<p class="text-sm text-gray-500 font-light"><span>{{ l('ملک ثبت شده:') }}</span> <span class="font-medium">200</span></p>
            <p class="text-sm text-gray-500 font-light"><span>{{ l('ملک قولنامه شده:') }}</span> <span class="font-medium">180</span></p>
            <p class="text-sm text-gray-500 font-light"><span>{{ l('رنج قیمت:') }}</span> <span class="font-medium">{{ l('7/879 میلیارد تومان') }}</span></p>-->
            <p class="text-sm text-gray-500 font-light"><span>{{ l('جدید ترین فعالیت:') }}</span> <span class="font-medium">{{!empty($user->last_activity)?toPersianDate($user->last_activity):''}}</span></p>
        </div>
        <div class="text-xl cursor-pointer text-blue-500 absolute left-3"></div>
    </div>
    <div class="flex items-center justify-between mt-4">
        <!--p class="ml-3 max-w-[150px] w-full"><a class="block h-11 rounded-2xl border-[1px] border-gray-200 text-base text-gray-500 font-medium text-center" href="{{'whatsapp://send?phone=+98'.substr($user->username,1)}}"><i class="fa-brands fa-whatsapp text-2xl text-green-500 relative top-1"></i>{{ l('واتس آپ') }}</a></p-->
        <p class="max-w-[150px] w-full"><a class="block bg-white h-11 rounded-2xl border-[1px] border-gray-400 text-base text-gray-500 font-medium text-center" href="{{'tel:+98'.substr($user->username,1)}}"><i class="fa-light fa-phone text-2xl text-gray-400 relative top-1"></i>{{ l('تماس') }}</a></p>
    </div>
</div>
@endforeach
