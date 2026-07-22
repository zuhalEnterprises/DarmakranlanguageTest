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

    'accepted' => 'يجب قبول :attribute.',
    'active_url' => 'الرابط :attribute غير صالح.',
    'after' => 'يجب أن يكون :attribute تاريخًا بعد :date.',
    'alpha' => 'يجب أن يحتوي :attribute على أحرف فقط.',
    'alpha_dash' => 'يجب أن يحتوي :attribute على أحرف وأرقام وشرطات.',
    'alpha_num' => 'يجب أن يحتوي :attribute على أحرف وأرقام فقط.',
    'array' => 'يجب أن يكون :attribute مصفوفة.',
    'before' => 'يجب أن يكون :attribute تاريخًا قبل :date.',
    'between' => [
        'numeric' => 'يجب أن يكون :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم :attribute بين :min و :max كيلو بايت.',
        'string' => 'يجب أن يكون طول :attribute بين :min و :max حرفًا.',
        'array' => 'يجب أن يحتوي :attribute على بين :min و :max عنصرًا.',
    ],
    'boolean' => 'يجب أن يكون حقل :attribute صحيحًا أو خاطئًا.',
    'confirmed' => 'التأكيد لـ :attribute لا يتطابق.',
    'date' => ':attribute ليس تاريخًا صحيحًا.',
    'date_format' => 'لا يتطابق :attribute مع الشكل :format.',
    'different' => 'يجب أن يكون :attribute و :other مختلفين.',
    'digits' => 'يجب أن يحتوي :attribute على :digits رقمًا.',
    'digits_between' => 'يجب أن يحتوي :attribute على بين :min و :max رقمًا.',
    'dimensions' => 'تحتوي :attribute على أبعاد صورة غير صالحة.',
    'distinct' => 'يحتوي حقل :attribute على قيمة مكررة.',
    'email' => 'يجب أن يكون :attribute بريدًا إلكترونيًا صالحًا.',
    'exists' => ':attribute المحدد غير صالح.',
    'file' => 'يجب أن يكون :attribute ملفًا.',
    'filled' => 'حقل :attribute مطلوب.',
    'image' => 'يجب أن يكون :attribute صورة.',
    'in' => ':attribute المحدد غير صالح.',
    'in_array' => 'حقل :attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'ip' => 'يجب أن يكون :attribute عنوان IP صالحًا.',
    'json' => 'يجب أن يكون :attribute سلسلة JSON صالحة.',
    'max' => [
        'numeric' => 'لا يجوز أن يكون :attribute أكبر من :max.',
        'file' => 'لا يجوز أن يكون حجم :attribute أكبر من :max كيلو بايت.',
        'string' => 'لا يجوز أن يكون طول :attribute أكبر من :max حرفًا.',
        'array' => 'لا يجوز أن يحتوي :attribute على أكثر من :max عنصرًا.',
    ],
    'mimes' => 'يجب أن يكون :attribute ملفًا من النوع: :values.',
    'mimetypes' => 'يجب أن يكون :attribute ملفًا من النوع: :values.',
    'min' => [
        'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
        'file' => 'يجب أن يكون حجم :attribute على الأقل :min كيلو بايت.',
        'string' => 'يجب أن يكون طول :attribute على الأقل :min حرفًا.',
        'array' => 'يجب أن يحتوي :attribute على الأقل :min عنصرًا.',
    ],
    'not_in' => ':attribute المحدد غير صالح.',
    'numeric' => 'يجب أن يكون :attribute رقمًا.',
    'present' => 'يجب أن يكون حقل :attribute موجودًا.',
    'regex' => 'الشكل الخاص بـ :attribute غير صالح.',
    'required' => 'حقل :attribute مطلوب.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other قيمته :value.',
    'required_unless' => 'حقل :attribute مطلوب إلا إذا كان :other ضمن :values.',
    'required_with' => 'حقل :attribute مطلوب عندما يكون :values موجودًا.',
    'required_with_all' => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
    'required_without' => 'حقل :attribute مطلوب عندما لا يكون :values موجودًا.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا تكون أي من :values موجودة.',
    'same' => 'يجب أن يتطابق :attribute مع :other.',
    'size' => [
        'numeric' => 'يجب أن يكون :attribute مساويًا لـ :size.',
        'file' => 'يجب أن يكون حجم :attribute :size كيلو بايت.',
        'string' => 'يجب أن يكون طول :attribute :size حرفًا.',
        'array' => 'يجب أن يحتوي :attribute على :size عنصرًا.',
    ],
    'string' => 'يجب أن يكون حقل :attribute سلسلة نصية.',
    'timezone' => 'يجب أن يكون حقل :attribute منطقة زمنية صالحة.',
    'unique' => 'تم استخدام :attribute من قبل.',
    'uploaded' => 'فشل تحميل :attribute.',
    'url' => 'الشكل الخاص بـ :attribute غير صالح.',
    'at_least_one' => 'يجب أن يكون على الأقل :attribute موجودًا في النظام.',

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
        'national_code' => 'الرمز الوطني',
        'experience' => 'الخبرة',
        'acquaintance_type' => 'طريقة التعرف',
        'slug' => 'الرابط',
        'name' => 'الاسم',
        'username' => 'اسم المستخدم',
        'email' => 'البريد الإلكتروني',
        'first_name' => 'الاسم الأول',
        'last_name' => 'اسم العائلة',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'city' => 'المدينة',
        'country' => 'البلد',
        'address' => 'العنوان',
        'phone' => 'الهاتف',
        'mobile' => 'الهاتف المحمول',
        'card_number' => 'رقم البطاقة',
        'father_name' => 'اسم الأب',
        'reagent_code' => 'رمز المرجعية',
        'code' => 'الرمز',
        'age' => 'العمر',
        'sex' => 'الجنس',
        'gender' => 'الجنس',
        'day' => 'اليوم',
        'month' => 'الشهر',
        'year' => 'السنة',
        'hour' => 'الساعة',
        'minute' => 'الدقيقة',
        'second' => 'الثانية',
        'title' => 'العنوان',
        'text' => 'النص',
        'content' => 'المحتوى',
        'description' => 'الوصف',
        'excerpt' => 'الملخص',
        'date' => 'التاريخ',
        'time' => 'الوقت',
        'available' => 'متاح',
        'size' => 'الحجم',
        'terms' => 'الشروط',
        'back_name' => 'اسم لوحة التحكم',
        'front_name' => 'اسم الموقع',
        'date_from' => 'تاريخ البداية',
        'date_to' => 'تاريخ النهاية',
        'owner_mobile' => 'رقم هاتف المالك',
        'owner_name' => 'اسم المالك',
        'photo' => 'صورة الملف الشخصي',
        'image_cover' => 'صورة غلاف الصفحة',
        'image_avatar' => 'صورة الملف الشخصي',
        'latitude' => 'الموقع على الخريطة (خط العرض)',
        'longitude' => 'الموقع على الخريطة (خط الطول)',
        'reagent_id' => 'معرف المرجعية',
        'video_url' => 'رابط الفيديو',
        'office_area' => 'مساحة المكتب',
        'guild_code' => 'رمز الهوية الصناعية',
        'ownership_type' => 'حالة ملكية المكتب',
        'rent_expiration_date' => 'تاريخ انتهاء عقد الإيجار',
        'active_in_holidays' => 'حالة النشاط في أيام العطل',
        'working_hours' => 'ساعات العمل',
        'contract_coordinator_count' => 'عدد منسقي العقود',
        'contract_room_count' => 'عدد غرف العقود',
        'contract_coordinators' => 'منسقي العقود',
        'contract_writing_level' => 'مستوى التعرف على كتابة العقود',
        'business_license_receipt_date' => 'أول تاريخ الحصول على ترخيص العمل',
        'business_license_expiration_date' => 'تاريخ انتهاء ترخيص العمل الحالي',
        'estate_type' => 'نوع العقار',
        'residence_type' => 'حالة السكن',
        'purchase_reason' => 'سبب الشراء',
        'purchase_priority' => 'مستوى الإلحاح في الشراء/الإيجار',
        'financial_liquidity_type' => 'حالة السيولة المالية',
        'alias' => 'الاسم المستعار'
    ],

];
