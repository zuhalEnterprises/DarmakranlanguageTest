<?php

/**
 * Generates resources/lang/ar/message.php from en/message.php keys.
 * Run: php scripts/generate_ar_message.php
 */

$basePath = dirname(__DIR__);
$enPath = $basePath . '/resources/lang/en/message.php';
$arPath = $basePath . '/resources/lang/ar/message.php';
$messagesPath = $basePath . '/resources/lang/ar/messages.php';

if (!file_exists($enPath)) {
    fwrite(STDERR, "English message file not found.\n");
    exit(1);
}

$en = include $enPath;
$existing = file_exists($arPath) ? include $arPath : [];
$messages = file_exists($messagesPath) ? include $messagesPath : [];

if (!is_array($en)) {
    fwrite(STDERR, "Invalid English message file.\n");
    exit(1);
}

$arabicMap = [
    'Agent' => 'وكيل',
    'Add Property' => 'إضافة عقار',
    'Properties List' => 'قائمة العقارات',
    'My Leads' => 'عملائي المحتملين',
    'Register Lead' => 'تسجيل عميل',
    'Message' => 'رسالة',
    'Favorites' => 'المفضلة',
    'Exit' => 'خروج',
    'Home' => 'الرئيسية',
    'Buy' => 'شراء',
    'Rent' => 'إيجار',
    'Login' => 'تسجيل الدخول',
    'Register' => 'إنشاء حساب',
    'Dashboard' => 'لوحة التحكم',
    'Delete' => 'حذف',
    'Edit' => 'تعديل',
    'Search' => 'بحث',
    'Filter' => 'تصفية',
    'City' => 'المدينة',
    'Tel' => 'الهاتف',
    'Continue' => 'متابعة',
    'Select' => 'اختيار',
    'Optional' => 'اختياري',
    'Note' => 'ملاحظة',
    'Name' => 'الاسم',
    'Email' => 'البريد الإلكتروني',
    'Mobile' => 'الجوال',
    'Yes' => 'نعم',
    'No' => 'لا',
    'Owner' => 'مالك',
    'Low' => 'منخفض',
    'Average' => 'متوسط',
    'From' => 'من',
    'Until' => 'حتى',
    'In' => 'في',
    'Request' => 'طلب',
    'Areas' => 'المناطق',
    'Apartment' => 'شقة',
    'Villa' => 'فيلا',
    'Shop' => 'محل تجاري',
    'Land' => 'أرض',
    'Detail' => 'التفاصيل',
    'Add my property' => 'إضافة عقاري',
    'Login & Register' => 'تسجيل الدخول وإنشاء حساب',
    'Find Agents' => 'البحث عن الوكلاء',
    'Properties Search' => 'بحث العقارات',
    'Add Agent' => 'تسجيل وكيل',
    'Contact An Agent' => 'الاتصال بالوكيل',
    'Main Admin' => 'المدير الرئيسي',
    'Referrer' => 'مسوق',
    'My Clients' => 'عملائي',
    'Brand List' => 'قائمة العلامات',
    'Brand' => 'علامة تجارية',
    'Create Brand' => 'إنشاء علامة',
    'Edit Brand' => 'تعديل العلامة',
    'Demand Marketing' => 'تسويق الطلب',
    'My Marketing Entries' => 'تسويقاتي',
    'Search Marketing' => 'بحث التسويق',
    'Creation Date' => 'تاريخ الإنشاء',
    'Secondary' => 'ثانوي',
    'Private Gym' => 'صالة رياضية خاصة',
    'Infinity Pool' => 'مسبح لا متناهي',
    'Private Pool' => 'مسبح خاص',
    'Children Pool' => 'مسبح أطفال',
    'Maid Service' => 'خدمة تنظيف',
    'Smart Home System' => 'نظام منزل ذكي',
    'Concierge Service' => 'خدمة الكونسierge',
    'Built-in Wardrobes' => 'خزائن مدمجة',
    'Walk-in Closet' => 'غرفة ملابس',
    'View of Water' => 'إطلالة على الماء',
    'View of Landmark' => 'إطلالة على معلم',
    'Garden' => 'حديقة',
    'Vacant' => 'شاغر',
    'Rented' => 'مؤجر',
    'Under Mortgage' => 'تحت رهن',
    'Motivated Seller' => 'بائع جاد',
    'Property Comments' => 'تعليقات العقارات',
    'Comment List' => 'قائمة التعليقات',
    'Comment Type' => 'نوع التعليق',
    'Under Review' => 'قيد المراجعة',
    'Approve Comment' => 'الموافقة على التعليق',
    'Reject Comment' => 'رفض التعليق',
    'Tag' => 'وسم',
    'Select tag' => 'اختر الوسم',
    'Booking List' => 'قائمة المواعيد',
    'Submit Booking' => 'تسجيل موعد',
    'Booking Request' => 'طلب زيارة',
    'Request a Visit' => 'طلب زيارة',
    'Visit Time' => 'وقت الزيارة',
    'Your Name' => 'اسمك',
    'Send Request' => 'إرسال الطلب',
    'Successfully Submitted' => 'تم التسجيل بنجاح',
    'Thank You for Contacting Us' => 'شكراً لتواصلك معنا',
    'Please Fill Out All Fields' => 'يرجى ملء جميع الحقول',
    'Link Not Found' => 'الرابط غير موجود',
    'Images and Documents' => 'الصور والمستندات',
    'Related Documents' => 'المستندات ذات الصلة',
    'Social Networks' => 'الشبكات الاجتماعية',
    'Submit Consultation Request' => 'إرسال طلب استشارة',
    'You\'re Just One Step Away from Your Ideal Property' => 'أنت على بعد خطوة واحدة من عقارك المثالي',
    'Enter your information and we\'ll contact you shortly' => 'أدخل معلوماتك وسنتواصل معك قريباً',
    'e.g. Ali Rezaei' => 'مثال: علي رضائي',
    'e.g.' => 'مثال',
    'Description' => 'الوصف',
    'Marketer Name' => 'اسم المسوق',
    'We send you daily updates.' => 'نرسل لك تحديثات يومية.',
    'Create base property' => 'إنشاء عقار أساسي',
    'Schedule a Physical Booking' => 'جدولة زيارة حضورية',
    'Booking Date & Time' => 'تاريخ ووقت الزيارة',
    'Select Booking Date & Time' => 'اختر تاريخ ووقت الزيارة',
    'Booked By' => 'حجز بواسطة',
    'Search Booking Requests' => 'بحث طلبات الزيارة',
    'Booking From Date' => 'تاريخ الزيارة من',
    'Booking To Date' => 'تاريخ الزيارة إلى',
    'Please select an advisor' => 'يرجى اختيار مستشار',
    'The advisor has been successfully changed.' => 'تم تغيير المستشار بنجاح.',
    'Error changing advisor. Please try again.' => 'خطأ في تغيير المستشار. يرجى المحاولة مرة أخرى.',
    'Your request has been submitted. Our experts will contact you.' => 'تم تسجيل طلبك. سيتواصل معك خبراؤنا.',
    'The selected comment was successfully deleted.' => 'تم حذف التعليق المحدد بنجاح.',
    'The selected comment was successfully approved.' => 'تمت الموافقة على التعليق المحدد بنجاح.',
    'The selected comment was successfully deactivated.' => 'تم إلغاء تفعيل التعليق المحدد بنجاح.',
    'Marketing Link Copied to Clipboard' => 'تم نسخ رابط التسويق',
    'Error Copying Link' => 'خطأ في نسخ الرابط',
    'There Was a Problem Submitting the Information' => 'حدثت مشكلة في إرسال المعلومات',
    'Price to' => 'السعر حتى',
    'Price since' => 'السعر من',
    'Current Files' => 'الملفات الحالية',
    'My Leads List' => 'قائمة عملائي',
    'Search Marketing Entries' => 'بحث التسويقات',
    'On Notice Period' => 'في فترة الإشعار',
    'VOT (Vacant on Transfer)' => 'شاغر عند النقل',
];

$wordReplacements = [
    'Add' => 'إضافة', 'Property' => 'عقار', 'Properties' => 'العقارات',
    'Lead' => 'عميل', 'Leads' => 'العملاء', 'Register' => 'تسجيل',
    'My' => 'لي', 'List' => 'قائمة', 'Search' => 'بحث',
    'Edit' => 'تعديل', 'Delete' => 'حذف', 'Create' => 'إنشاء',
    'Select' => 'اختيار', 'Enter' => 'أدخل', 'Please' => 'يرجى',
    'Minimum' => 'الحد الأدنى', 'Maximum' => 'الحد الأقصى',
    'Amount' => 'المبلغ', 'Price' => 'السعر', 'Size' => 'المساحة',
    'Agent' => 'وكيل', 'Agents' => 'الوكلاء', 'Customer' => 'عميل',
    'Client' => 'عميل', 'Dashboard' => 'لوحة التحكم',
    'Information' => 'معلومات', 'Details' => 'التفاصيل',
    'Phone' => 'الهاتف', 'Mobile' => 'الجوال', 'Password' => 'كلمة المرور',
    'Login' => 'تسجيل الدخول', 'Logout' => 'تسجيل الخروج',
    'Home' => 'الرئيسية', 'City' => 'المدينة', 'Area' => 'المنطقة',
    'Type' => 'النوع', 'Status' => 'الحالة', 'Date' => 'التاريخ',
    'Time' => 'الوقت', 'Name' => 'الاسم', 'Email' => 'البريد الإلكتروني',
    'Note' => 'ملاحظة', 'Notes' => 'ملاحظات', 'Image' => 'صورة',
    'Images' => 'الصور', 'File' => 'ملف', 'Files' => 'الملفات',
    'Submit' => 'إرسال', 'Send' => 'إرسال', 'Save' => 'حفظ',
    'Cancel' => 'إلغاء', 'Close' => 'إغلاق', 'Back' => 'عودة',
    'Next' => 'التالي', 'Previous' => 'السابق', 'Continue' => 'متابعة',
    'Success' => 'نجاح', 'Error' => 'خطأ', 'Warning' => 'تحذير',
    'Yes' => 'نعم', 'No' => 'لا', 'All' => 'الكل', 'New' => 'جديد',
    'Free' => 'مجاني', 'Optional' => 'اختياري', 'Required' => 'مطلوب',
    'Buy' => 'شراء', 'Rent' => 'إيجار', 'Sale' => 'بيع',
    'Owner' => 'مالك', 'Tenant' => 'مستأجر', 'Contract' => 'عقد',
    'Project' => 'مشروع', 'Brand' => 'علامة', 'Manufacturer' => 'مطور',
    'Comment' => 'تعليق', 'Comments' => 'التعليقات', 'Review' => 'مراجعة',
    'Booking' => 'حجز', 'Visit' => 'زيارة', 'Request' => 'طلب',
    'Marketing' => 'تسويق', 'Demand' => 'طلب', 'Consultation' => 'استشارة',
    'Floor' => 'طابق', 'Room' => 'غرفة', 'Rooms' => 'الغرف',
    'Building' => 'مبنى', 'Apartment' => 'شقة', 'Villa' => 'فيلا',
    'Land' => 'أرض', 'Shop' => 'محل', 'Office' => 'مكتب',
    'Parking' => 'موقف', 'Pool' => 'مسبح', 'Garden' => 'حديقة',
    'View' => 'إطلالة', 'Price' => 'السعر', 'Deposit' => 'وديعة',
    'Mortgage' => 'رهن', 'Cash' => 'نقد', 'Payment' => 'دفع',
    'Filter' => 'تصفية', 'Sort' => 'ترتيب', 'Show' => 'عرض',
    'Hide' => 'إخفاء', 'More' => 'المزيد', 'Less' => 'أقل',
    'Total' => 'الإجمالي', 'Count' => 'العدد', 'Number' => 'الرقم',
    'Code' => 'الرمز', 'Tag' => 'وسم', 'Link' => 'رابط',
    'Copy' => 'نسخ', 'Share' => 'مشاركة', 'Compare' => 'مقارنة',
    'Favorite' => 'مفضلة', 'Favorites' => 'المفضلة',
    'Admin' => 'مدير', 'User' => 'مستخدم', 'Expert' => 'خبير',
    'Advisor' => 'مستشار', 'Manager' => 'مدير', 'Referrer' => 'مسوق',
    'Profile' => 'الملف الشخصي', 'Settings' => 'الإعدادات',
    'Notification' => 'إشعار', 'Notifications' => 'الإشعارات',
    'Document' => 'مستند', 'Documents' => 'المستندات',
    'Social' => 'اجتماعي', 'Network' => 'شبكة', 'Networks' => 'الشبكات',
    'Description' => 'الوصف', 'Title' => 'العنوان', 'Content' => 'المحتوى',
    'Category' => 'الفئة', 'Categories' => 'الفئات',
    'Active' => 'نشط', 'Inactive' => 'غير نشط', 'Pending' => 'قيد الانتظار',
    'Approved' => 'موافق عليه', 'Rejected' => 'مرفوض',
    'Successfully' => 'بنجاح', 'Failed' => 'فشل',
    'Contact' => 'اتصال', 'Message' => 'رسالة', 'Chat' => 'محادثة',
    'Report' => 'تقرير', 'Export' => 'تصدير', 'Import' => 'استيراد',
    'Upload' => 'رفع', 'Download' => 'تحميل', 'Print' => 'طباعة',
    'Map' => 'خريطة', 'Location' => 'الموقع', 'Address' => 'العنوان',
    'District' => 'الحي', 'Province' => 'المحافظة', 'Country' => 'البلد',
    'sqft' => 'قدم مربع', 'AED' => 'درهم', 'Up' => 'فأكثر',
    'of' => 'من', 'the' => '', 'a' => '', 'an' => '', 'to' => 'إلى',
    'for' => 'لـ', 'and' => 'و', 'or' => 'أو', 'with' => 'مع',
    'from' => 'من', 'in' => 'في', 'on' => 'على', 'at' => 'في',
    'by' => 'بواسطة', 'is' => '', 'are' => '', 'was' => '', 'were' => '',
    'has' => '', 'have' => '', 'been' => '', 'will' => '', 'be' => '',
    'your' => 'خاصتك', 'You' => 'أنت', 'you' => 'أنت', 'We' => 'نحن',
    'we' => 'نحن', 'our' => 'نحن', 'Our' => 'نحن', 'The' => '',
    'the' => '', 'this' => 'هذا', 'This' => 'هذا', 'that' => 'ذلك',
    'not' => 'لا', 'Not' => 'لا', 'all' => 'جميع', 'All' => 'جميع',
];

function translateEnToAr(string $english, array $map, array $wordReplacements): string
{
    if (isset($map[$english]) && $map[$english] !== '') {
        return $map[$english];
    }

    $result = $english;
    uksort($wordReplacements, fn ($a, $b) => strlen($b) <=> strlen($a));
    foreach ($wordReplacements as $en => $ar) {
        if ($ar !== '') {
            $result = preg_replace('/\b' . preg_quote($en, '/') . '\b/u', $ar, $result);
        }
    }

    $result = preg_replace('/\s+/', ' ', trim($result));
    return $result !== '' ? $result : $english;
}

function persianToArabicFallback(string $persian, array $faArMap): string
{
    $keyword = str_replace(' ', '-', $persian);
    if (isset($faArMap[$keyword])) {
        return $faArMap[$keyword];
    }

    $result = $persian;
    uksort($faArMap, fn ($a, $b) => mb_strlen($b) <=> mb_strlen($a));
    foreach ($faArMap as $fa => $ar) {
        $faText = str_replace('-', ' ', $fa);
        if ($ar !== '' && mb_strpos($result, $faText) !== false) {
            $result = str_replace($faText, $ar, $result);
        }
    }

    return trim($result) !== '' ? trim($result) : $persian;
}

$output = is_array($existing) ? $existing : [];
if (is_array($messages)) {
    $output = array_merge($output, $messages);
}

$faArDirect = [
    'ورود' => 'تسجيل الدخول', 'ثبت-نام' => 'إنشاء حساب', 'خروج' => 'تسجيل الخروج',
    'خانه' => 'الرئيسية', 'داشبورد' => 'لوحة التحكم', 'ثبت-ملک' => 'إضافة عقار',
    'ثبت-ملک-من' => 'إضافة عقاري', 'جستجو' => 'بحث', 'جستجوی-ملک' => 'بحث العقارات',
    'ﺟﺴﺘﺠﻮی-ملک' => 'بحث العقارات', 'ویرایش' => 'تعديل', 'حذف' => 'حذف',
    'مشاهده' => 'عرض', 'شهر' => 'المدينة', 'محله' => 'الحي', 'تلفن' => 'الهاتف',
    'کارشناس' => 'وكيل', 'مشاور' => 'مستشار', 'مشتری' => 'عميل', 'خریدار' => 'مشتري',
    'فروش' => 'بيع', 'اجاره' => 'إيجار', 'خرید' => 'شراء', 'املاک' => 'العقارات',
    'موردعلاقه-ها' => 'المفضلة', 'موردعلاقه' => 'المفضلة', 'پیام' => 'رسالة',
    'ورود-به-حساب-کاربری' => 'تسجيل الدخول', 'ورود-و-ثبت-نام' => 'تسجيل الدخول وإنشاء حساب',
    'ثبت-رایگان-ملک' => 'إضافة عقار مجاناً', 'ثبت-رایگان-آگهی' => 'نشر إعلان مجاني',
    'مجله-املاک' => 'مجلة العقارات', 'کارشناسان' => 'الوكلاء', 'درباره-ما' => 'من نحن',
    'تماس-با-ما' => 'اتصل بنا', 'لینک-های-مرتبط' => 'روابط ذات صلة',
    'مقالات-مرتبط' => 'مقالات ذات صلة', 'فایل-های-فروش-ملک-جدید' => 'ملفات عقارات جديدة للبيع',
    'مشاهده-همه' => 'عرض الكل', 'مقالات-بیشتر' => 'المزيد من المقالات',
    'املاک-فروشی' => 'عقارات للبيع', 'املاک-فروش-فوری' => 'عقارات للبيع العاجل',
    'املاک-اکازیون' => 'عقارات فرصة', 'ثبت-تقاضا' => 'تسجيل طلب',
    'سرمایه‌گذاری-امروز،-آرامش-فردا' => 'استثمر اليوم، راحة غداً',
    'دارمکران' => 'دارمکران',
    'مشاوره-رایگان-خرید-و-اجاره-ملک' => 'استشارة مجانية لشراء وإيجار العقارات',
    'همین-حالا-تماس-بگیرید' => 'اتصل الآن',
    'چرا-دارمکران-برای-شما-انتخاب-خوبی-است؟' => 'لماذا دارمکران خيار جيد لك؟',
    'مالک-هستید؟' => 'هل أنت مالك؟',
    'ثبت-رایگان-آگهی' => 'نشر إعلان مجاني',
    'مجله-املاک-امارات' => 'مجلة عقارات الإمارات',
    'کارشناسان-دارمکران' => 'وكلاء دارمکران',
    'سلام!-به-سایت-دارمکران-خوش-آمدید.' => 'مرحباً! أهلاً بك في موقع دارمکران.',
    'هنوز-ثبت-نام-نکرده-اید؟' => 'لم تسجل بعد؟',
    'پست-الکترونیکی' => 'البريد الإلكتروني',
    'رمز-عبور' => 'كلمة المرور',
    'رمز-عبور-را-فراموش-کرده-اید؟' => 'نسيت كلمة المرور؟',
    'رمز-عبور-را-وارد-نمایید' => 'أدخل كلمة المرور',
    'تمام-حقوق-این-سایت-متعلق-به' => 'جميع حقوق هذا الموقع محفوظة لـ',
    'است' => '',
    'تولید-توسط' => 'إنتاج بواسطة',
    'درباره-ما' => 'من نحن',
    'مدیر-اصلی' => 'المدير الرئيسي', 'بازاریاب' => 'مسوق', 'کاربر-عادی' => 'مستخدم عادي',
    'داشبورد-من' => 'لوحتي', 'لیست-املاک' => 'قائمة العقارات',
    'لیست-مشتریان' => 'قائمة العملاء', 'بازاریابی-تقاضا' => 'تسويق الطلب',
    'ویرایش-مشخصات' => 'تعديل البيانات', 'ثبت-خریدار' => 'تسجيل عميل',
    'مدیریت-املاک' => 'إدارة العقارات', 'عملکرد-املاک' => 'أداء العقارات',
    'لیست-سازندگان' => 'قائمة المطورين', 'لیست-پروژه-ها' => 'قائمة المشاريع',
    'مدیریت-مشتریان' => 'إدارة العملاء', 'ثبت-مشتری' => 'تسجيل عميل',
    'مشاور-فروش' => 'مستشار مبيعات', 'مشاور-اجاره' => 'مستشار إيجار',
    'مشاور-فروش-و-اجاره' => 'مستشار مبيعات وإيجار',
    'گروه-مشاورین-املاک-دارمکران-با-سال‌ها-تجربه-ارزشمند-در-حوزه-خرید،-فروش-و-سرمایه‌گذاری-ملکی-در-دبی،-مفتخر-است-همراه-و-مشاور-مطمئن-شما-در-این-مسیر-باشد.-تیمی-از-کارشناسان-باتجربه-و-آگاه-به-بازار-املاک-امارات،-آماده‌اند-تا-با-ارائه-راهکارهای-تخصصی،-شما-را-در-حفظ-و-افزایش-سرمایه‌تان-یاری-رسانند.' =>
        'مجموعة مستشاري عقارات دارمكران، بخبرتها الثمينة في مجال شراء وبيع واستثمار العقارات في دبي، فخورة بأن تكون رفيقك ومستشارك الموثوق. فريق من الخبراء المتمرسين في سوق العقارات الإماراتي جاهز لمساعدتك في حفظ وزيادة استثمارك.',
    'هر-کجای-کشور-امارات-که-ملکی-برای-فروش-دارید-می-تونید-با-چند-کلیک-ساده-ملکتان-را-به-صورت-رایگان-در-دارمکران-آگهی-و-در-سریع-ترین-زمان-ممکن-معامله-کنید' =>
        'أينما كان لديك عقار للبيع في الإمارات، يمكنك بنقرات بسيطة نشر إعلانك مجاناً على دارمكران وإتمام الصفقة في أسرع وقت.',
    'املاک-دارمکران-یک-بنگاه-معاملات-ملکی-در-دبی-است-که-به‌طور-تخصصی-خدمات-خرید،-فروش-و-اجاره-ملک-را-به-سرمایه‌گذاران-ایرانی-ارائه-می‌دهد.-با-آشنایی-کامل-با-بازار-املاک-امارات،-املاک-دارمکران-مسیر-مطمئنی-برای-سرمایه‌گذاری،-خرید-خانه-و-دریافت-اقامت-في-دبي-فراهم-می‌کند.' =>
        'دارمكران للعقارات هي وكالة عقارية في دبي تقدم خدمات شراء وبيع وإيجار العقارات للمستثمرين. بفضل معرفتها الكاملة بسوق العقارات الإماراتي، توفر دارمكران مساراً آمناً للاستثمار وشراء المنازل والإقامة في دبي.',
];

foreach ($en as $key => $englishValue) {
    if (isset($output[$key]) && $output[$key] !== '' && $output[$key] !== $key) {
        continue;
    }

    $persian = str_replace('-', ' ', $key);
    $arabic = $faArDirect[$key] ?? null;

    if ($arabic === null && is_string($englishValue) && $englishValue !== '' && $englishValue !== $persian) {
        $arabic = translateEnToAr($englishValue, $arabicMap, $wordReplacements);
    }

    if ($arabic === null || $arabic === $englishValue) {
        $arabic = persianToArabicFallback($persian, $faArDirect);
    }

    if ($arabic === $persian && is_string($englishValue) && $englishValue !== '') {
        $arabic = translateEnToAr($englishValue, $arabicMap, $wordReplacements);
    }

    $output[$key] = $arabic;
}

ksort($output);

$content = "<?php\n\nreturn [\n";
foreach ($output as $k => $v) {
    $content .= "    '" . str_replace(["\\", "'"], ["\\\\", "\\'"], $k) . "' => '" . str_replace(["\\", "'"], ["\\\\", "\\'"], $v) . "',\n";
}
$content .= "];\n";

file_put_contents($arPath, $content);
echo "Generated " . count($output) . " Arabic translations to {$arPath}\n";
