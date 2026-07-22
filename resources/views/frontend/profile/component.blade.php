<div class="fixed left-0 right-0 top-0 bottom-0 bg-gray-500 opacity-80 z-10 hidden" id="js_overlay"></div>
    <section>
        <!-- دکمه انتخاب تکی  -->
        <div>
            <div class="cursor-pointer h-[48px] w-full js_radio_selection">
                <input class="hidden radios" type="radio" name="1" id="${attr_name}">
                <label
                    class="h-full flex items-center justify-center text-base text-gray-500 font-light rounded-25 cursor-pointer js_label-radio css_label-radio js_filter_action"
                    for="${attr_name}">test</label>
            </div>
            <ul>
                <li>
                    <button
                        class="cursor-pointer w-full text-right text-lg text-gray-500 disabled:text-gray-400 js_items js_min js_filter_action">${min_entry}</button>
                </li>

                <li
                    class="mt-2 text-gray-500 rounded-25 text-base font-light w-[78px] h-[78px] hover:bg-white hover:text-blue-500 hover:font-medium hover:border-blue-500 js_Property_Type">
                    <input class="hidden css_checkbox js_filter_checkbox" type="checkbox"
                        id="Property_Type_${attr_name}" label_name="${checkbox_name}">
                    <label
                        class="flex items-center justify-center flex-col cursor-pointer w-full h-full border-[1px] border-gray-400 rounded-25 css_lable"
                        for="Property_Type_${attr_name}">
                        <span class=""><i class="fa-thin ${icon} text-[32px]"></i></span>
                        <p class="js_filter_action">${checkbox_name}</p>
                    </label>
                </li>
                <li class="relative mb-5">
                    <input class="hidden css_city js_filter_btn_${count}" type="checkbox" name="item_${id}" id="item_${id}" element_name="${text}">
                    <label class="before:content-[' '] before:w-[27px] before:h-[27px] before:bg-white before:border-[1px] border-gray-400 before:absolute before:top-[-4px] before:right-0 before:lg:rounded-25 before:rounded-[5px] mr-9 cursor-pointer css_city_label js_filter_action" for="item_${id}">${text}</label>
                </li>
                <li class="flex items-center justify-between h-12 px-3 bg-white border-[1px] border-blue-500 rounded-[15px] lg:rounded-25 ml-4" target='${target_element}'>
                    <span class="text-base text-red-200 pl-2 pt-[6px] cursor-pointer remove_tag" id="tag_${target_element}"><i class="fa-thin fa-xmark"></i></span>
                    <p class="text-base text-gray-500 font-light w-max">${element_name}</p>
                </li>
                <li class="rounded-25 border-[1px] border-gray-400 h-[38px] flex items-center justify-center w-fit px-3 py-3 mx-1 my-1">
                    <span class="pl-2 text-lg lg:text-xl text-gray-400 cursor-pointer js_add_tag"><i class="fa-thin fa-plus"></i></span>
                    <p class="text-base text-gray-500 font-light">${array[i]}</p>
                </li>
                <li class="flex items-center justify-between h-12 px-3 bg-white border-[1px] border-blue-500 rounded-[15px] lg:rounded-25 ml-4">
                    <span class="text-base text-red-200 pl-2 pt-[6px] cursor-pointer remove_tag js_remove_tag"><i class="fa-thin fa-plus"></i></span>
                    <p class="text-base text-gray-500 font-light w-max">${array[i]}</p>
                </li>
            </ul>
        </div>
        <li class="relative mb-5">
            <input class="hidden css_city js_filter_btn_${count}" type="checkbox" name="item_${id}" id="item_${id}" element_name="${text}">
            <label class="before:content-[' '] before:w-[27px] before:h-[27px] before:bg-white before:border-[1px] border-gray-400 before:absolute before:top-[-4px] before:right-0 before:lg:rounded-25 before:rounded-[5px] mr-9 cursor-pointer css_city_label js_filter_action" for="item_${id}">${text}</label>
        </li>
