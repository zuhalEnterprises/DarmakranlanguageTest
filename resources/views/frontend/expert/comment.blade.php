@if(Auth::User() && count($comments)>0)
@foreach ($comments as $comment)

<div class="flex flex-col md:flex-row gap-6 mb-5">
    <div class="flex gap-2">
        <div class="w-[66px] h-[66px] rounded-full overflow-hidden
     border border-gray-400 shrink-0">
            <img  src="{{$comment->user->photo??'/assets/image/profile-expert/profile.png'}}" data-src="{{$comment->user->photo??'/assets/image/profile-expert/profile.png'}}" onerror="this.src='/assets/image/profile-expert/profile.png'"class="w-full h-full" alt="profile">
        </div>
        <div class="flex flex-col md:hidden justify-center gap-3 w-full">
            <h5 class="text-[20px] font-medium text-gray-500">{{$comment->user->{{ l('fullname()?? \'کاربر ناشناس\'}}') }}</h5>
            <div class="flex justify-between  gap-2 text-[16px]">
                <span class="font-light text-blue-500">{{ l('کارشناس') }}</span>
                <div class="flex  w-[140px] justify-end gap-1">
                    @for($i=1;$i<=5;$i++)

                        <i class="material-icons {{$i<=$comment->rate?'selected':''}}">
                        {{$i<=$comment->rate?'star':'star_border'}}
                        </i>
                    @endfor


                </div>
            </div>

        </div>
    </div>
    <div class="w-full">
        <div class="hidden md:flex items-center justify-between w-full">
            <div class="flex gap-2 text-[14px]">
                <span class="text-[14px] font-medium text-gray-500">{{$comment->user->{{ l('fullname()?? \'کاربر ناشناس\'}}') }}</span>
                <span class="font-light text-blue-500">{{ l('کارشناس') }}</span>
            </div>
            <div class="flex  w-[140px] justify-center gap-1">

                @for($i=1;$i<=5;$i++)

                <span class="{{$i<=$comment->rate?'text-orange-500':'text-gray-500'}} text-[16px] md:text-[18px] cursor-pointer js_stars_rating">
                    <i class="fa-solid fa-star"></i>
                </span>


                @endfor


            </div>
        </div>
        <p class="mt-4 pl-4 text-gray-500 text-[18px] font-light js_comment_p">
            {{$comment->body}}
        </p>
        <div class="text-gray-500 text-left text-[12px] font-light">
            {{toPersianDate($comment->created_at,true,false)}}
        </div>
    </div>
</div>

@endforeach
@endif
