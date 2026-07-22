<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute باید پذیرفته شده باشد.',
    'active_url' => 'آدرس :attribute معتبر نیست',
    'after' => ':attribute باید تاریخی بعد از :date باشد.',
    'alpha' => ':attribute باید شامل حروف الفبا باشد.',
    'alpha_dash' => ':attribute باید شامل حروف الفبا و عدد و خظ تیره(-) باشد.',
    'alpha_num' => ':attribute باید شامل حروف الفبا و عدد باشد.',
    'array' => ':attribute باید شامل آرایه باشد.',
    'before' => ':attribute باید تاریخی قبل از :date باشد.',
    'between' => [
        'numeric' => ':attribute باید بین :min و :max باشد.',
        'file' => ':attribute باید بین :min و :max کیلوبایت باشد.',
        'string' => ':attribute باید بین :min و :max کاراکتر باشد.',
        'array' => ':attribute باید بین :min و :max آیتم باشد.',
    ],
    'boolean' => 'فیلد :attribute فقط میتواند صحیح و یا غلط باشد',
    'confirmed' => ':attribute با تاییدیه مطابقت ندارد.',
    'date' => ':attribute یک تاریخ معتبر نیست.',
    'date_format' => ':attribute با الگوی :format مطاقبت ندارد.',
    'different' => ':attribute و :other باید متفاوت باشند.',
    'digits' => ':attribute باید :digits رقم باشد.',
    'digits_between' => ':attribute باید بین :min و :max رقم باشد.',
    'dimensions' => ':attribute دارای ابعاد تصویر نامعتبر می‌باشد.',
    'distinct' => 'فیلد :attribute دارای یک مقدار تکراری می‌باشد.',
    'email' => 'فرمت :attribute معتبر نیست.',
    'exists' => ':attribute انتخاب شده، معتبر نیست.',
    'file' => ':attribute باید یک فایل باشد',
    'filled' => 'فیلد :attribute الزامی است',
    'image' => ':attribute باید تصویر باشد.',
    'in' => ':attribute انتخاب شده، معتبر نیست.',
    'in_array' => 'فیلد :attribute در :other وجود ندارد.',
    'integer' => ':attribute باید نوع داده ای عددی (integer) باشد.',
    'ip' => ':attribute باید IP آدرس معتبر باشد.',
    'json' => 'فیلد :attribute باید یک رشته از نوع JSON باشد.',
    'max' => [
        'numeric' => ':attribute نباید بزرگتر از :max باشد.',
        'file' => ':attribute نباید بزرگتر از :max کیلوبایت باشد.',
        'string' => ':attribute نباید بیشتر از :max کاراکتر باشد.',
        'array' => ':attribute نباید بیشتر از :max آیتم باشد.',
    ],
    'mimes' => ':attribute باید یکی از فرمت های :values باشد.',
    'mimetypes' => ':attribute باید یکی از فرمت های :values باشد.',
    'min' => [
        'numeric' => ':attribute نباید کوچکتر از :min باشد.',
        'file' => ':attribute نباید کوچکتر از :min کیلوبایت باشد.',
        'string' => ':attribute نباید کمتر از :min کاراکتر باشد.',
        'array' => ':attribute نباید کمتر از :min آیتم باشد.',
    ],
    'not_in' => ':attribute انتخاب شده، معتبر نیست.',
    'numeric' => ':attribute باید شامل عدد باشد.',
    'present' => 'فیلد :attribute باید در پارامترهای ارسالی وجود داشته باشد.',
    'regex' => ':attribute یک فرمت معتبر نیست',
    'required' => 'فیلد :attribute الزامی است',
    'required_if' => 'فیلد :attribute هنگامی که :other برابر با :value است، الزامیست.',
    'required_unless' => 'فیلد :attribute ضروری است، مگر آنکه :other در :values وجود داشته باشد.',
    'required_with' => ':attribute الزامی است زمانی که :values موجود است.',
    'required_with_all' => ':attribute الزامی است زمانی که :values موجود است.',
    'required_without' => ':attribute الزامی است زمانی که :values موجود نیست.',
    'required_without_all' => ':attribute الزامی است زمانی که :values موجود نیست.',
    'same' => ':attribute و :other باید مانند هم باشند.',
    'size' => [
        'numeric' => ':attribute باید برابر با :size باشد.',
        'file' => ':attribute باید برابر با :size کیلوبایت باشد.',
        'string' => ':attribute باید برابر با :size کاراکتر باشد.',
        'array' => ':attribute باسد شامل :size آیتم باشد.',
    ],
    'string' => 'فیلد :attribute باید یک String باشد.',
    'timezone' => 'فیلد :attribute باید یک منطقه صحیح باشد.',
    'unique' => ':attribute قبلا انتخاب شده است.',
    'uploaded' => 'فایل :attribute با موفقیت آپلود نشد.',
    'url' => 'فرمت آدرس :attribute اشتباه است.',
    'at_least_one' => 'حداقل یک  :attribute باید در سیستم موجود باشد.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'national_code' => 'کد ملی',
        'experience' => 'سابقه کاری',
        'acquaintance_type' => 'نحوه آشنایی',
        'slug' => 'صفحه',
        'name' => 'نام',
        'username' => 'نام کاربری',
        'email' => 'پست الکترونیکی',
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'password' => 'رمز عبور',
        'password_confirmation' => 'تاییدیه ی رمز عبور',
        'city' => 'شهر',
        'country' => 'کشور',
        'address' => 'نشانی',
        'phone' => 'تلفن',
        'mobile' => 'تلفن همراه',
        'card_number' => 'شماره کارت',
        'father_name' => 'نام پدر',
        'reagent_code' => 'کد معرف',
        'code' => 'کد',
        'age' => 'سن',
        'sex' => 'جنسیت',
        'gender' => 'جنسیت',
        'day' => 'روز',
        'month' => 'ماه',
        'year' => 'سال',
        'hour' => 'ساعت',
        'minute' => 'دقیقه',
        'second' => 'ثانیه',
        'title' => 'عنوان',
        'text' => 'متن',
        'content' => 'محتوا',
        'description' => 'توضیحات',
        'excerpt' => 'خلاصه',
        'date' => 'تاریخ',
        'time' => 'زمان',
        'available' => 'در دسترس',
        'size' => 'اندازه',
        'terms' => 'شرایط',
        'back_name' => 'نام داشبورد',
        'front_name' => 'نام سایت',
        'date_from' => 'تاریخ شروع',
        'date_to' => 'تاریخ پایان',
        'owner_mobile' => 'شماره همراه',
        'owner_name' => 'نام مالک',
        'photo' => 'تصویر پروفایل',
        'image_cover' => 'تصویر کاور صفحه',
        'image_avatar' => 'تصویر پروفایل',
        'latitude' => 'موقعیت روی نقشه (عرض جغرافیایی)',
        'longitude' => 'موقعیت روی نقشه (طول جغرافیایی)',
        'reagent_id' => 'شناسه معرف',
        'video_url' => 'لینک ویدئو',
        'office_area'=>'متراژ دفتر',
        'guild_code'=>'کد شناسه صنفی',
        'ownership_type'=>'وضعیت مالکیت دفتر',
        'rent_expiration_date'=>'تاریخ انقضای قرارداد اجاره',
        'active_in_holidays'=>'وضعیت فعالیت در روزهای تعطیل',
        'working_hours'=>'ساعات کاری',
        'contract_coordinator_count'=>'تعداد مدیر قرارداد',
        'contract_room_count'=>'تعداد اتاق قرارداد',
        'contract_coordinators'=>'مدیران قرارداد',
        'contract_writing_level'=>'میزان آشنایی با قرارداد نویسی',
        'business_license_receipt_date'=>'اولین تاریخ دریافت پروانه کسب',
        'business_license_expiration_date'=>'تاریخ انقضای پروانه کسب فعلی',
        'estate_type'=>'نوع ملک',
        'residence_type'=>'وضعیت سکونت',
        'purchase_reason'=>'دلیل خرید',
        'purchase_priority'=>'میزان تعجیل در خرید/اجاره',
        'financial_liquidity_type'=>'وضعیت نقدینگی',
        'alias'=>'کد معرف'
    ],

];
