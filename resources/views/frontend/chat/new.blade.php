@extends('frontend.layouts.panel',['title'=>'ملکیتو','menu'=>'2'])

    @section('main_content')
    <div class="flex justify-between items-center py-3">
        <h3 class="text-[24px] text-gray-500 font-light">{{ l('ملکیتو') }}</h3>
        <div class="flex justify-center gap-3">
            <a href=""
                class="flex items-center justify-center h-[48px] px-4 sm:px-12 bg-white border border-gray-200 rounded-25 text-gray-500">{{ l('ثبت خریدار') }}</a>
            <a href=""
                class="flex items-center justify-center h-[48px] px-4 sm:px-12 bg-blue-500 rounded-25 text-white">{{ l('سپردن ملک') }}</a>
        </div>
    </div>
    <hr>
    <div class="hidden md:flex items-center justify-between px-5">
        <ul class="flex items-center gap-1" id="tabs-nav">
            <li class="font-light p-3 cursor-pointer text-gray-500 css_active_tab ">
                <a href="#state">
                    {{ l('ملک‌های پیشنهادی') }}
                </a>
            </li>
            <li class="font-light p-3 cursor-pointer text-gray-500">
                <a href="#buyer">{{ l('خریداران پیشنهادی') }}</a>
            </li>
            <li class="font-light p-3 cursor-pointer text-gray-500">
                <a href="#guide" class="flex items-center gap-2">
                    <i class="fa-thin fa-circle-info"></i>
                    <span>{{ l('راهنما') }}</span>
                </a>
            </li>
        </ul>
        <div
            class="border border-gray-200 bg-white rounded-25 h-[37px] px-2 flex justify-between items-center ">
            <input type="text" class="focus:outline-none pr-4">
            <i class="text-gray-200 text-[18px] fa-thin fa-magnifying-glass"></i>
        </div>
    </div>
    <div class="bg-white p-3 border border-gray-200 rounded-25 mt-2 md:mt-0">
        <div
            class="border border-[#FAB86B] bg-[#fab86b0d] py-4 px-6  rounded-25 relative flex flex-col md:flex-row items-center justify-center gap-3 my-2 js_alert">
            <i class="text-[48px] text-[#FAB86B] fa-thin fa-circle-info"></i>
            <p class="text-[15px] font-light text-gray-500 pl-5 leading-loose">{{ l('ملکیتو چیست؟ خریدارانی که به سایت مراجعه می کنند و دنبال ملک می گردند به شما معرفی می شود و شما اگر ملکی داشتید میتونید بهشون معرفی کنید .') }}
                <br>
                {{ l('در صورتی که دکمه l("پذیرش") را بزنید به لیست خریداران شما اضافه خواهد شد.') }}
            </p>
            <a href="" class="absolute top-2 left-5 text-gray-500 text-[24px] js_close_alert">
                <i class="fa-thin fa-xmark"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 tab-content" id="state">
            <div
                class="border border-gray-200 bg-gray-100 rounded-20 p-2 flex flex-col justify-between gap-1">
                <div
                    class="w-full  h-28 relative rounded-2xl overflow-hidden bg-[url('../image/panel/backpic.svg')]">
                    <img src="../assets/image/panel/state-img.jpg" class="w-full h-full object-cover">
                    <div
                        class="absolute pr-5 pb-2 bottom-0 right-0 left-0 flex flex-col gap-1 text-white text-[14px] font-medium">
                        <span>{{ l('250 متری بر عطاران قم') }}</span>
                        <span>{{ l('‌درخواست فروش ملک 2 طبقه') }}</span>
                    </div>
                    <div
                        class="bg-blue-500 text-white text-[14px] font-light absolute top-0 left-0 rounded-br-2xl py-1 px-4">
                        02:22</div>
                </div>
                <div class="px-3">
                    <p class="flex justify-between text-[14px] font-light py-1">
                        <span>{{ l('قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="flex justify-between text-[14px] font-light">
                        <span>{{ l('هر متر') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="px-3 flex items-center ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
            <div
                class="border border-gray-200 bg-gray-100 rounded-20 p-2 flex flex-col justify-between gap-1">
                <div
                    class="w-full  h-28 relative rounded-2xl overflow-hidden bg-[url('../image/panel/backpic.svg')]">
                    <img src="../assets/image/panel/state-img.jpg" class="w-full h-full object-cover">
                    <div
                        class="absolute pr-5 pb-2 bottom-0 right-0 left-0 flex flex-col gap-1 text-white text-[14px] font-medium">
                        <span>{{ l('250 متری بر عطاران قم') }}</span>
                        <span>{{ l('‌درخواست فروش ملک 2 طبقه') }}</span>
                    </div>
                    <div
                        class="bg-blue-500 text-white text-[14px] font-light absolute top-0 left-0 rounded-br-2xl py-1 px-4">
                        02:22</div>
                </div>
                <div class="px-3">
                    <p class="flex justify-between text-[14px] font-light py-1">
                        <span>{{ l('قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="flex justify-between text-[14px] font-light">
                        <span>{{ l('هر متر') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="px-3 flex items-center ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
            <div
                class="border border-gray-200 bg-gray-100 rounded-20 p-2 flex flex-col justify-between gap-1">
                <div
                    class="w-full  h-28 relative rounded-2xl overflow-hidden bg-[url('../image/panel/backpic.svg')]">
                    <img src="../assets/image/panel/state-img.jpg" class="w-full h-full object-cover">
                    <div
                        class="absolute pr-5 pb-2 bottom-0 right-0 left-0 flex flex-col gap-1 text-white text-[14px] font-medium">
                        <span>{{ l('250 متری بر عطاران قم') }}</span>
                        <span>{{ l('‌درخواست فروش ملک 2 طبقه') }}</span>
                    </div>
                    <div
                        class="bg-blue-500 text-white text-[14px] font-light absolute top-0 left-0 rounded-br-2xl py-1 px-4">
                        02:22</div>
                </div>
                <div class="px-3">
                    <p class="flex justify-between text-[14px] font-light py-1">
                        <span>{{ l('قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="flex justify-between text-[14px] font-light">
                        <span>{{ l('هر متر') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="px-3 flex items-center ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
            <div
                class="border border-gray-200 bg-gray-100 rounded-20 p-2 flex flex-col justify-between gap-1">
                <div
                    class="w-full  h-28 relative rounded-2xl overflow-hidden bg-[url('../image/panel/backpic.svg')]">
                    <img src="../assets/image/panel/state-img.jpg" class="w-full h-full object-cover">
                    <div
                        class="absolute pr-5 pb-2 bottom-0 right-0 left-0 flex flex-col gap-1 text-white text-[14px] font-medium">
                        <span>{{ l('250 متری بر عطاران قم') }}</span>
                        <span>{{ l('‌درخواست فروش ملک 2 طبقه') }}</span>
                    </div>
                    <div
                        class="bg-blue-500 text-white text-[14px] font-light absolute top-0 left-0 rounded-br-2xl py-1 px-4">
                        02:22</div>
                </div>
                <div class="px-3">
                    <p class="flex justify-between text-[14px] font-light py-1">
                        <span>{{ l('قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="flex justify-between text-[14px] font-light">
                        <span>{{ l('هر متر') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="px-3 flex items-center ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
            <div
                class="border border-gray-200 bg-gray-100 rounded-20 p-2 flex flex-col justify-between gap-1">
                <div
                    class="w-full  h-28 relative rounded-2xl overflow-hidden bg-[url('../image/panel/backpic.svg')]">
                    <img src="../assets/image/panel/state-img.jpg" class="w-full h-full object-cover">
                    <div
                        class="absolute pr-5 pb-2 bottom-0 right-0 left-0 flex flex-col gap-1 text-white text-[14px] font-medium">
                        <span>{{ l('250 متری بر عطاران قم') }}</span>
                        <span>{{ l('‌درخواست فروش ملک 2 طبقه') }}</span>
                    </div>
                    <div
                        class="bg-blue-500 text-white text-[14px] font-light absolute top-0 left-0 rounded-br-2xl py-1 px-4">
                        02:22</div>
                </div>
                <div class="px-3">
                    <p class="flex justify-between text-[14px] font-light py-1">
                        <span>{{ l('قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="flex justify-between text-[14px] font-light">
                        <span>{{ l('هر متر') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="px-3 flex items-center ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
            <div
                class="border border-gray-200 bg-gray-100 rounded-20 p-2 flex flex-col justify-between gap-1">
                <div
                    class="w-full  h-28 relative rounded-2xl overflow-hidden bg-[url('../image/panel/backpic.svg')]">
                    <img src="../assets/image/panel/state-img.jpg" class="w-full h-full object-cover">
                    <div
                        class="absolute pr-5 pb-2 bottom-0 right-0 left-0 flex flex-col gap-1 text-white text-[14px] font-medium">
                        <span>{{ l('250 متری بر عطاران قم') }}</span>
                        <span>{{ l('‌درخواست فروش ملک 2 طبقه') }}</span>
                    </div>
                    <div
                        class="bg-blue-500 text-white text-[14px] font-light absolute top-0 left-0 rounded-br-2xl py-1 px-4">
                        02:22</div>
                </div>
                <div class="px-3">
                    <p class="flex justify-between text-[14px] font-light py-1">
                        <span>{{ l('قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="flex justify-between text-[14px] font-light">
                        <span>{{ l('هر متر') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="px-3 flex items-center ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
            <div
                class="border border-gray-200 bg-gray-100 rounded-20 p-2 flex flex-col justify-between gap-1">
                <div
                    class="w-full  h-28 relative rounded-2xl overflow-hidden bg-[url('../image/panel/backpic.svg')]">
                    <img src="../assets/image/panel/state-img.jpg" class="w-full h-full object-cover">
                    <div
                        class="absolute pr-5 pb-2 bottom-0 right-0 left-0 flex flex-col gap-1 text-white text-[14px] font-medium">
                        <span>{{ l('250 متری بر عطاران قم') }}</span>
                        <span>{{ l('‌درخواست فروش ملک 2 طبقه') }}</span>
                    </div>
                    <div
                        class="bg-blue-500 text-white text-[14px] font-light absolute top-0 left-0 rounded-br-2xl py-1 px-4">
                        02:22</div>
                </div>
                <div class="px-3">
                    <p class="flex justify-between text-[14px] font-light py-1">
                        <span>{{ l('قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="flex justify-between text-[14px] font-light">
                        <span>{{ l('هر متر') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="px-3 flex items-center ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
            <div
                class="border border-gray-200 bg-gray-100 rounded-20 p-2 flex flex-col justify-between gap-1">
                <div
                    class="w-full  h-28 relative rounded-2xl overflow-hidden bg-[url('../image/panel/backpic.svg')]">
                    <img src="../assets/image/panel/state-img.jpg" class="w-full h-full object-cover">
                    <div
                        class="absolute pr-5 pb-2 bottom-0 right-0 left-0 flex flex-col gap-1 text-white text-[14px] font-medium">
                        <span>{{ l('250 متری بر عطاران قم') }}</span>
                        <span>{{ l('‌درخواست فروش ملک 2 طبقه') }}</span>
                    </div>
                    <div
                        class="bg-blue-500 text-white text-[14px] font-light absolute top-0 left-0 rounded-br-2xl py-1 px-4">
                        02:22</div>
                </div>
                <div class="px-3">
                    <p class="flex justify-between text-[14px] font-light py-1">
                        <span>{{ l('قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="flex justify-between text-[14px] font-light">
                        <span>{{ l('هر متر') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="px-3 flex items-center ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
            <div
                class="border border-gray-200 bg-gray-100 rounded-20 p-2 flex flex-col justify-between gap-1">
                <div
                    class="w-full  h-28 relative rounded-2xl overflow-hidden bg-[url('../image/panel/backpic.svg')]">
                    <img src="../assets/image/panel/state-img.jpg" class="w-full h-full object-cover">
                    <div
                        class="absolute pr-5 pb-2 bottom-0 right-0 left-0 flex flex-col gap-1 text-white text-[14px] font-medium">
                        <span>{{ l('250 متری بر عطاران قم') }}</span>
                        <span>{{ l('‌درخواست فروش ملک 2 طبقه') }}</span>
                    </div>
                    <div
                        class="bg-blue-500 text-white text-[14px] font-light absolute top-0 left-0 rounded-br-2xl py-1 px-4">
                        02:22</div>
                </div>
                <div class="px-3">
                    <p class="flex justify-between text-[14px] font-light py-1">
                        <span>{{ l('قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="flex justify-between text-[14px] font-light">
                        <span>{{ l('هر متر') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="px-3 flex items-center ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
            <div
                class="border border-gray-200 bg-gray-100 rounded-20 p-2 flex flex-col justify-between gap-1">
                <div
                    class="w-full  h-28 relative rounded-2xl overflow-hidden bg-[url('../image/panel/backpic.svg')]">
                    <img src="../assets/image/panel/state-img.jpg" class="w-full h-full object-cover">
                    <div
                        class="absolute pr-5 pb-2 bottom-0 right-0 left-0 flex flex-col gap-1 text-white text-[14px] font-medium">
                        <span>{{ l('250 متری بر عطاران قم') }}</span>
                        <span>{{ l('‌درخواست فروش ملک 2 طبقه') }}</span>
                    </div>
                    <div
                        class="bg-blue-500 text-white text-[14px] font-light absolute top-0 left-0 rounded-br-2xl py-1 px-4">
                        02:22</div>
                </div>
                <div class="px-3">
                    <p class="flex justify-between text-[14px] font-light py-1">
                        <span>{{ l('قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="flex justify-between text-[14px] font-light">
                        <span>{{ l('هر متر') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="px-3 flex items-center ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
            <div
                class="border border-gray-200 bg-gray-100 rounded-20 p-2 flex flex-col justify-between gap-1">
                <div
                    class="w-full  h-28 relative rounded-2xl overflow-hidden bg-[url('../image/panel/backpic.svg')]">
                    <img src="../assets/image/panel/state-img.jpg" class="w-full h-full object-cover">
                    <div
                        class="absolute pr-5 pb-2 bottom-0 right-0 left-0 flex flex-col gap-1 text-white text-[14px] font-medium">
                        <span>{{ l('250 متری بر عطاران قم') }}</span>
                        <span>{{ l('‌درخواست فروش ملک 2 طبقه') }}</span>
                    </div>
                    <div
                        class="bg-blue-500 text-white text-[14px] font-light absolute top-0 left-0 rounded-br-2xl py-1 px-4">
                        02:22</div>
                </div>
                <div class="px-3">
                    <p class="flex justify-between text-[14px] font-light py-1">
                        <span>{{ l('قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="flex justify-between text-[14px] font-light">
                        <span>{{ l('هر متر') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="px-3 flex items-center ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
            <div
                class="border border-gray-200 bg-gray-100 rounded-20 p-2 flex flex-col justify-between gap-1">
                <div
                    class="w-full  h-28 relative rounded-2xl overflow-hidden bg-[url('../image/panel/backpic.svg')]">
                    <img src="../assets/image/panel/state-img.jpg" class="w-full h-full object-cover">
                    <div
                        class="absolute pr-5 pb-2 bottom-0 right-0 left-0 flex flex-col gap-1 text-white text-[14px] font-medium">
                        <span>{{ l('250 متری بر عطاران قم') }}</span>
                        <span>{{ l('‌درخواست فروش ملک 2 طبقه') }}</span>
                    </div>
                    <div
                        class="bg-blue-500 text-white text-[14px] font-light absolute top-0 left-0 rounded-br-2xl py-1 px-4">
                        02:22</div>
                </div>
                <div class="px-3">
                    <p class="flex justify-between text-[14px] font-light py-1">
                        <span>{{ l('قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="flex justify-between text-[14px] font-light">
                        <span>{{ l('هر متر') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="px-3 flex items-center ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="rounded-25 grid grid-cols-1 gap-2 tab-content" id="buyer">
            <div
                class="bg-gray-100 border border-gray-200 rounded-25 py-2 px-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex flex-col gap-1 md:gap-2">
                    <span class="text-[15px] text-white bg-red-200 rounded-25 px-3 w-fit">{{ l('درخواست خریدار آپارتمان') }}</span>
                    <p class="ccs_more">{{ l('در شهرک غرب ، خیابان دادمان، بلوار دریا کوچه 15 پلاک 2-0') }}</p>
                </div>
                <div class="flex flex-col gap-1 md:gap-2">
                    <p class="text-[15px] text-gray-500 flex justify-between">
                        <span class="font-light">{{ l('حداکثر قیمت') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="text-[15px] text-gray-500 flex justify-between font-light">
                        <span>{{ l('حداقل متراژ') }}</span>
                        <span>{{ l('100 متر') }}</span>
                    </p>
                </div>
                <div class="flex items-end ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
            <div
                class="bg-gray-100 border border-gray-200 rounded-25 py-2 px-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex flex-col gap-2">
                    <p class="text-[15px] text-white bg-[#FA896B] rounded-25 px-3 w-fit">{{ l('اجاره صنعتی - تجاری') }}
                    </p>
                    <p class="ccs_more">{{ l('در شهرک غرب ، خیابان دادمان، بلوار دریا کوچه 15 پلاک 2-0') }}</p>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="text-[15px] text-gray-500 flex justify-between">
                        <span class="font-light">{{ l('حداکثر رهن') }}</span>
                        <span class="font-medium">{{ l('2,500,000,000 تومان') }}</span>
                    </p>
                    <p class="text-[15px] text-gray-500 flex justify-between font-light">
                        <span>{{ l('حداکثر اجاره') }}</span>
                        <span>{{ l('2,500,000 تومان') }}</span>
                    </p>
                </div>
                <div class="flex items-end ">
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-gray-500 rounded-25  font-light text-[14px]">{{ l('جزئیات') }}
                    </a>
                    <a href=""
                        class="w-1/2 flex items-center justify-center h-[33px] px-12 text-blue-500 rounded-25 border-gray-200 border bg-white text-[14px]">{{ l('پذیرش') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endsection


@section('js')
<script src="../assets/vendors/jquery/jquery.js"></script>
<script>
    $('#tabs-nav li:first-child').addClass('css_active_tab');
    $('.tab-content').hide();
    $('.tab-content:first').show();

    // Click function
    $('#tabs-nav li').click(function () {
        $('#tabs-nav li').removeClass('css_active_tab');
        $(this).addClass('css_active_tab');
        $('.tab-content').hide();

        var activeTab = $(this).find('a').attr('href');
        $(activeTab).fadeIn();
        return false;
    });
    $('.js_close_alert').click(function (e) {
        e.preventDefault()
        $('.js_alert').addClass('hidden')
    })
</script>
@endsection
