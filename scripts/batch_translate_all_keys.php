<?php

$enPath = __DIR__ . '/../resources/lang/en/message.php';
$arPath = __DIR__ . '/../resources/lang/ar/message.php';

$en = include $enPath;
$ar = include $arPath;

// 1. Remove malformed keys containing '{{l(' or '{{'
foreach ($en as $k => $v) {
    if (strpos($k, '{{') !== false || strpos($k, '}}') !== false || strpos($k, '@') !== false) {
        unset($en[$k]);
    }
}
foreach ($ar as $k => $v) {
    if (strpos($k, '{{') !== false || strpos($k, '}}') !== false || strpos($k, '@') !== false) {
        unset($ar[$k]);
    }
}

// 2. Comprehensive translation dictionary map for Persian words/phrases
$dictionary = [
    // Real Estate Terms
    'فروش' => ['en' => 'Sale', 'ar' => 'بيع'],
    'اجاره' => ['en' => 'Rent', 'ar' => 'إيجار'],
    'رهن' => ['en' => 'Mortgage / Deposit', 'ar' => 'رهن / تأمين'],
    'خرید' => ['en' => 'Buy', 'ar' => 'شراء'],
    'معاوضه' => ['en' => 'Exchange', 'ar' => 'مقايضة'],
    'پیش فروش' => ['en' => 'Off-Plan', 'ar' => 'قيد الإنشاء'],
    'آپارتمان' => ['en' => 'Apartment', 'ar' => 'شقة'],
    'ویلا' => ['en' => 'Villa', 'ar' => 'فيلا'],
    'زمین' => ['en' => 'Land', 'ar' => 'أرض'],
    'مغازه' => ['en' => 'Shop / Retail', 'ar' => 'محل تجاري'],
    'دفتر کار' => ['en' => 'Office', 'ar' => 'مكتب'],
    'تجاری' => ['en' => 'Commercial', 'ar' => 'تجاري'],
    'اداری' => ['en' => 'Office / Administrative', 'ar' => 'إداري'],
    'مسکونی' => ['en' => 'Residential', 'ar' => 'سكني'],
    'مستغلات' => ['en' => 'Real Estate', 'ar' => 'عقارات'],
    'پروژه' => ['en' => 'Project', 'ar' => 'مشروع'],
    'برج' => ['en' => 'Tower', 'ar' => 'برج'],
    'مجتمع' => ['en' => 'Complex', 'ar' => 'مجمع'],
    'متراژ' => ['en' => 'Area (sq ft / m²)', 'ar' => 'المساحة'],
    'مساحت' => ['en' => 'Area', 'ar' => 'المساحة'],
    'قیمت' => ['en' => 'Price', 'ar' => 'السعر'],
    'تومان' => ['en' => 'AED', 'ar' => 'درهم'],
    'درهم' => ['en' => 'AED', 'ar' => 'درهم'],
    'میلیون' => ['en' => 'Million', 'ar' => 'مليون'],
    'میلیارد' => ['en' => 'Billion', 'ar' => 'مليار'],
    'اتاق' => ['en' => 'Room', 'ar' => 'غرفة'],
    'خواب' => ['en' => 'Bedroom', 'ar' => 'غرفة نوم'],
    'حمام' => ['en' => 'Bathroom', 'ar' => 'حمام'],
    'سرویس بهداشتی' => ['en' => 'Toilet / Restroom', 'ar' => 'دورة مياه'],
    'پارکینگ' => ['en' => 'Parking', 'ar' => 'موقف سيارات'],
    'آسانسور' => ['en' => 'Elevator', 'ar' => 'مصعد'],
    'انبار' => ['en' => 'Storage', 'ar' => 'مستودع'],
    'انباری' => ['en' => 'Storage Room', 'ar' => 'مخزن'],
    'بالکن' => ['en' => 'Balcony', 'ar' => 'شرفة'],
    'استخر' => ['en' => 'Swimming Pool', 'ar' => 'حوض سباحة'],
    'سونا' => ['en' => 'Sauna', 'ar' => 'ساونا'],
    'جکوزی' => ['en' => 'Jacuzzi', 'ar' => 'جاكوزي'],
    'نگهبانی' => ['en' => 'Security', 'ar' => 'حراسة'],
    'سرایدار' => ['en' => 'Caretaker', 'ar' => 'حارس'],
    'مبله' => ['en' => 'Furnished', 'ar' => 'مفروش'],
    'غیر مبله' => ['en' => 'Unfurnished', 'ar' => 'غير مفروش'],
    'نیمه مبله' => ['en' => 'Semi-Furnished', 'ar' => 'نصف مفروش'],
    'طبقه' => ['en' => 'Floor', 'ar' => 'طابق'],
    'سال ساخت' => ['en' => 'Year Built', 'ar' => 'سنة البناء'],
    'عمر بنا' => ['en' => 'Building Age', 'ar' => 'عمر المبنى'],
    'نوساز' => ['en' => 'New Build', 'ar' => 'حديث البناء'],
    'بازسازی شده' => ['en' => 'Renovated', 'ar' => 'مجدد'],
    'سند' => ['en' => 'Title Deed', 'ar' => 'صك الملكية'],
    'موقعیت' => 'Location',
    'منطقه' => ['en' => 'Area / District', 'ar' => 'المنطقة'],
    'شهر' => ['en' => 'City', 'ar' => 'المدينة'],
    'استان' => ['en' => 'Emirate / Province', 'ar' => 'الإمارة'],
    'خیابان' => ['en' => 'Street', 'ar' => 'الشارع'],
    'آدرس' => ['en' => 'Address', 'ar' => 'العنوان'],
    'کد ملک' => ['en' => 'Property ID', 'ar' => 'رمز العقار'],
    'مشاور' => ['en' => 'Agent', 'ar' => 'مستشار'],
    'کارشناس' => ['en' => 'Expert / Consultant', 'ar' => 'خبير'],
    'مالک' => ['en' => 'Owner', 'ar' => 'المالك'],
    'خریدار' => ['en' => 'Buyer', 'ar' => 'المشتري'],
    'فروشنده' => ['en' => 'Seller', 'ar' => 'البائع'],
    'موجر' => ['en' => 'Landlord', 'ar' => 'المؤجر'],
    'مستاجر' => ['en' => 'Tenant', 'ar' => 'المستأجر'],
    'مشتری' => ['en' => 'Client / Customer', 'ar' => 'العميل'],

    // Action Words & UI Terms
    'ثبت' => ['en' => 'Submit', 'ar' => 'إرسال'],
    'ذخیره' => ['en' => 'Save', 'ar' => 'حفظ'],
    'ویرایش' => ['en' => 'Edit', 'ar' => 'تعديل'],
    'حذف' => ['en' => 'Delete', 'ar' => 'حذف'],
    'جستجو' => ['en' => 'Search', 'ar' => 'بحث'],
    'نمایش' => ['en' => 'View / Show', 'ar' => 'عرض'],
    'مشاهده' => ['en' => 'View', 'ar' => 'عرض'],
    'انصراف' => ['en' => 'Cancel', 'ar' => 'إلغاء'],
    'بستن' => ['en' => 'Close', 'ar' => 'إغلاق'],
    'تایید' => ['en' => 'Confirm', 'ar' => 'تأكيد'],
    'رد' => ['en' => 'Reject', 'ar' => 'رفض'],
    'ارسال' => ['en' => 'Send', 'ar' => 'إرسال'],
    'دریافت' => ['en' => 'Receive', 'ar' => 'استلام'],
    'ورود' => ['en' => 'Login', 'ar' => 'تسجيل الدخول'],
    'خروج' => ['en' => 'Logout', 'ar' => 'تسجيل الخروج'],
    'ثبت نام' => ['en' => 'Register', 'ar' => 'إنشاء حساب'],
    'ایجاد' => ['en' => 'Create / Add', 'ar' => 'إنشاء'],
    'جدید' => ['en' => 'New', 'ar' => 'جديد'],
    'بروزرسانی' => ['en' => 'Update', 'ar' => 'تحديث'],
    'تغییر' => ['en' => 'Change', 'ar' => 'تغيير'],
    'آرشیو' => ['en' => 'Archive', 'ar' => 'أرشيف'],
    'فعال' => ['en' => 'Active', 'ar' => 'نشط'],
    'غیرفعال' => ['en' => 'Inactive', 'ar' => 'غير نشط'],
    'وضعیت' => ['en' => 'Status', 'ar' => 'الحالة'],
    'تاریخ' => ['en' => 'Date', 'ar' => 'التاريخ'],
    'زمان' => ['en' => 'Time', 'ar' => 'الوقت'],
    'تلفن' => ['en' => 'Phone', 'ar' => 'الهاتف'],
    'موبایل' => ['en' => 'Mobile', 'ar' => 'الجوال'],
    'ایمیل' => ['en' => 'Email', 'ar' => 'البريد الإلكتروني'],
    'رمز عبور' => ['en' => 'Password', 'ar' => 'كلمة المرور'],
    'نام' => ['en' => 'Name', 'ar' => 'الاسم'],
    'عنوان' => ['en' => 'Title', 'ar' => 'العنوان'],
    'توضیحات' => ['en' => 'Description', 'ar' => 'الوصف'],
    'جزئیات' => ['en' => 'Details', 'ar' => 'التفاصيل'],
    'اطلاعات' => ['en' => 'Information', 'ar' => 'المعلومات'],
    'تصویر' => ['en' => 'Image', 'ar' => 'صورة'],
    'عکس' => ['en' => 'Photo', 'ar' => 'صورة'],
    'فایل' => ['en' => 'File', 'ar' => 'ملف'],
    'ویدیو' => ['en' => 'Video', 'ar' => 'فيديو'],
    'نقشه' => ['en' => 'Map', 'ar' => 'خريطة'],
    'لیست' => ['en' => 'List', 'ar' => 'قائمة'],
    'فهرست' => ['en' => 'Catalog / List', 'ar' => 'قائمة'],
    'جدول' => ['en' => 'Table', 'ar' => 'جدول'],
    'گزارش' => ['en' => 'Report', 'ar' => 'تقرير'],
    'پیام' => ['en' => 'Message', 'ar' => 'رسالة'],
    'اعلامیه' => ['en' => 'Notice', 'ar' => 'إشعار'],
    'هشدار' => ['en' => 'Warning', 'ar' => 'تحذير'],
    'خطا' => ['en' => 'Error', 'ar' => 'خطأ'],
    'موفقیت' => ['en' => 'Success', 'ar' => 'نجاح'],
    'نتیجه' => ['en' => 'Result', 'ar' => 'نتيجة'],
    'موردی یافت نشد' => ['en' => 'No items found', 'ar' => 'لم يتم العثور على نتائج'],
    'در حال بارگذاری' => ['en' => 'Loading...', 'ar' => 'جاري التحميل...'],
];

// Helper function to translate Persian text to EN / AR
function translatePersianPhrase($text, $lang, $dictionary) {
    // If exact match in dictionary
    if (isset($dictionary[$text][$lang])) {
        return $dictionary[$text][$lang];
    }

    // Try word-by-word replacement or key phrase translation
    $translated = $text;
    foreach ($dictionary as $pWord => $tPair) {
        if (isset($tPair[$lang])) {
            $translated = str_replace($pWord, $tPair[$lang], $translated);
        }
    }

    // If string still contains Persian characters, apply fallback English/Arabic cleanup
    if (preg_match('/[\x{0600}-\x{06FF}]/u', $translated)) {
        if ($lang === 'en') {
            // Convert common Persian numbers to English
            $persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            $latinDigits   = ['0','1','2','3','4','5','6','7','8','9'];
            $translated = str_replace($persianDigits, $latinDigits, $translated);

            // Clean common Persian residual words
            $cleanMap = [
                'تومان' => 'AED', 'درهم' => 'AED', 'متر' => 'm²', 'مربع' => 'sq',
                'خواب' => 'bed', 'اتاق' => 'room', 'طبقه' => 'floor', 'سال' => 'years',
                'قیمت' => 'Price', 'مساحت' => 'Area', 'ثبت' => 'Submit', 'ویرایش' => 'Edit',
                'حذف' => 'Delete', 'جستجو' => 'Search', 'تایید' => 'Confirm', 'جدید' => 'New',
                'ملک' => 'Property', 'املاک' => 'Properties', 'شهر' => 'City', 'منطقه' => 'District',
            ];
            foreach ($cleanMap as $p => $e) {
                $translated = str_replace($p, $e, $translated);
            }
        }
    }

    return $translated;
}

$enTranslatedCount = 0;
$arTranslatedCount = 0;

foreach ($en as $k => $v) {
    // If value still has Persian characters, translate it!
    if (preg_match('/[\x{0600}-\x{06FF}]/u', $v)) {
        $en[$k] = translatePersianPhrase($k, 'en', $dictionary);
        $enTranslatedCount++;
    }
}

foreach ($ar as $k => $v) {
    // If value has Persian-specific letters (پ, چ, ژ, گ) or equals key, translate it!
    if (preg_match('/[پچژگ]/u', $v) || $v === $k) {
        $ar[$k] = translatePersianPhrase($k, 'ar', $dictionary);
        $arTranslatedCount++;
    }
}

function saveFinalDict($path, $data) {
    $out = "<?php\n\nreturn [\n";
    foreach ($data as $k => $v) {
        $out .= "    " . var_export((string)$k, true) . " => " . var_export((string)$v, true) . ",\n";
    }
    $out .= "];\n";
    file_put_contents($path, $out);
}

saveFinalDict($enPath, $en);
saveFinalDict($arPath, $ar);

echo "Batch translation completed!\n";
echo "English keys translated from Persian: $enTranslatedCount\n";
echo "Arabic keys translated from Persian: $arTranslatedCount\n";
