@foreach($users as $user)
<div class="w-full flex items-stretch justify-start rounded-2xl border-[1px] border-gray-200 p-3">
    <div class="flex w-[170px] h-[170px] shrink-0">
        <a class="intro-expert-img w-full h-full rounded-full overflow-hidden" href="{{$user->id ? '/agents_v2/'.$user->id : 'javascript:;'}}">
            <img class="w-full h-full object-cover" src="<?php echo !empty($user->photo) ? "/upload/images/profile/" . $user->photo : $user->photo() ?>" alt="">
        </a>
    </div>
    <div class="flex flex-col justify-between w-full mr-4">
        <div class="flex">

            <div class="text-[20px] ml-6 cursor-pointer text-blue-500">
                @if(Auth::check())
                <span class="itemFavorite_{{$user->id}} text-[20px]  {{$user->isFavorite == 1?'text-blue-500':'text-gray-200'}}  cursor-pointer hover:text-blue-500" onclick="addFavorite({{$user->id}}) " data-id="{{$user->id}}">
                    <i class=" fa-solid fa-bookmark"></i>
                </span>
                @else
                <a class="btn-bookmark favorite" id="modalActivate2" href="/login">
                    <i class="fa-thin fa-bookmark"></i>
                </a>
                @endif
            </div>

            <div class="flex flex-wrap items-center justify-between border-b-[1px] border-gray-200 pb-4 mr-4 w-full">
                <a href="{{$user->id ? '/agents_v2/'.$user->id : 'javascript:;'}}">
                    <h3 class="text-gray-500 text-lg font-extrabold w-full mb-3">{{$user->fullname()}}</h3>
                </a>
                {{--<p class="text-gray-500 text-base font-light">{{ l('قم-خیابان جمهوری,خیابان عطاران,نبش کوچه 8') }}</p>--}}
                {{--<p class="text-gray-500 text-base font-light"><span class="font-medium">25</span>{{ l('قول نامه موفق') }}</p>--}}
            </div>
        </div>
        <div class="flex items-start justify-start space-x-16 pt-4 pb-4 mr-14">
            <div class="ml-16">
                <ul class="space-y-3">
                    <li>
                        <p class="text-[15px] text-gray-500 font-light"><span>{{ l('تخصص مشاور:') }}</span> <span class="font-medium">{{$user->activity_type == 1 ? l('فروش') : ($user->{{ l('activity_type == 2 ? \'اجاره\' : \'فروش و اجاره\')}}') }}</span></p>
                    </li>
                    <li>
                        <p class="text-[15px] text-gray-500 font-light"><span>{{ l('تلفن:') }}</span> <span class="font-medium">{{$user->username}}</span></p>
                    </li>
                </ul>
            </div>
            <div>
                <ul class="space-y-3">
                    <li>
                        <p class="text-[15px] text-gray-500 font-light"><span>{{ l('سابقه فعالیت:') }}</span> <span class="font-medium">{{$user->experience ? $user->{{ l('experience.\' سال\': \'\'}}') }}</span></p>
                    </li>
                </ul>
            </div>
            <div>
                <ul class="space-y-3">
                    <!-- <li><p class="text-[15px] text-gray-500 font-light"><span>{{ l('ملک قولنامه شده:') }}</span> <span class="font-medium">180</span></p></li>-->
                    <li>
                        <p class="text-[15px] text-gray-500 font-light"><span>{{ l('جدید ترین فعالیت:') }}</span> <span class="font-medium">{{!empty($user->last_activity)?toPersianDate($user->last_activity):''}}</span></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="rounded-full  flex justify-between items-center px-3 w-[170px] mr-auto">


            <div class="flex items-center justify-end max-w-[150px] w-full">
             <!--
                <p class="max-w-[150px] w-full">

                    <a class="block bg-white h-11 rounded-full border-[1px] border-gray-400 text-base text-gray-500 font-medium text-center" href="{{'tel:+98'.substr($user->username,1)}}"><i class="fa-light fa-phone text-2xl text-gray-400 relative top-1"></i>{{ l('تماس') }}</a>

                </p>
                -->
            </div>
        </div>
    </div>
</div>



@endforeach
<script>
    function addFavorite(id){
        $.get("/agents/favorite/" + id, function (data, status) {
            if (data.result == 1) {
                $(".itemFavorite_" + id).addClass("text-blue-500").removeClass("text-gray-200");
            } else {

                $(".itemFavorite_" + id).removeClass("text-blue-500").addClass("text-gray-200");

            }
        });
    }
    </script>
