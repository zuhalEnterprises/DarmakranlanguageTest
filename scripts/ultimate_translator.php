<?php

$enPath = __DIR__ . '/../resources/lang/en/message.php';
$arPath = __DIR__ . '/../resources/lang/ar/message.php';

$en = include $enPath;
$ar = include $arPath;

// Extensive dictionary for remaining phrases
$phraseMap = [
    'کد تایید' => ['en' => 'Verification Code', 'ar' => 'رمز التحقق'],
    'ارسال شد' => ['en' => 'sent successfully', 'ar' => 'تم الإرسال بنجاح'],
    'ارسال گردید' => ['en' => 'sent', 'ar' => 'تم الإرسال'],
    'برای شماره' => ['en' => 'for number', 'ar' => 'للرقم'],
    'بازیابی رمز ورود' => ['en' => 'Password Recovery', 'ar' => 'استعادة كلمة المرور'],
    'بازیابی رمز عبور' => ['en' => 'Password Recovery', 'ar' => 'استعادة كلمة المرور'],
    'ارسال کد' => ['en' => 'Send Code', 'ar' => 'إرسال الرمز'],
    'شماره موبایل نامعتبر است' => ['en' => 'Invalid mobile number', 'ar' => 'رقم الجوال غير صحيح'],
    'ثبت نام با موفقیت انجام شد' => ['en' => 'Registration completed successfully', 'ar' => 'تم التسجيل بنجاح'],
    'لطفا تمامی فیلدها را پر کنید' => ['en' => 'Please fill in all fields', 'ar' => 'يرجى ملء جميع الحقول'],
    'ورود به سیستم' => ['en' => 'Log In to System', 'ar' => 'تسجيل الدخول إلى النظام'],
    'ورود به پنل' => ['en' => 'Panel Login', 'ar' => 'تسجيل دخول اللوحة'],
    'رمز عبور جدید' => ['en' => 'New Password', 'ar' => 'كلمة المرور الجديدة'],
    'تکرار رمز عبور' => ['en' => 'Confirm Password', 'ar' => 'تكرار كلمة المرور'],
    'فراموشی رمز' => ['en' => 'Forgot Password', 'ar' => 'نسيت كلمة المرور'],
    'ثبت آژانس' => ['en' => 'Agency Registration', 'ar' => 'تسجيل الوكالة'],
    'ثبت شعبه' => ['en' => 'Branch Registration', 'ar' => 'تسجيل الفرع'],
    'ثبت مشاور' => ['en' => 'Agent Registration', 'ar' => 'تسجيل الوكيل'],
    'ثبت ملک' => ['en' => 'Add Property', 'ar' => 'إضافة عقار'],
    'ثبت خریدار' => ['en' => 'Add Lead / Buyer', 'ar' => 'إضافة مشتري'],
    'املاک من' => ['en' => 'My Properties', 'ar' => 'عقاراتي'],
    'خریداران من' => ['en' => 'My Buyers / Leads', 'ar' => 'عملائي'],
    'مورد علاقه ها' => ['en' => 'Favorites', 'ar' => 'المفضلة'],
    'تنظیمات حساب' => ['en' => 'Account Settings', 'ar' => 'إعدادات الحساب'],
    'ویرایش پروفایل' => ['en' => 'Edit Profile', 'ar' => 'تعديل الملف الشخصي'],
    'تغییر رمز' => ['en' => 'Change Password', 'ar' => 'تغيير كلمة المرور'],
    'صفحه اصلی' => ['en' => 'Home Page', 'ar' => 'الصفحة الرئيسية'],
    'درباره ما' => ['en' => 'About Us', 'ar' => 'من نحن'],
    'تماس با ما' => ['en' => 'Contact Us', 'ar' => 'اتصل بنا'],
    'بلاگ' => ['en' => 'Blog', 'ar' => 'المدونة'],
    'اخبار' => ['en' => 'News', 'ar' => 'الأخبار'],
    'مقالات' => ['en' => 'Articles', 'ar' => 'المقالات'],
    'قوانین و مقررات' => ['en' => 'Terms & Conditions', 'ar' => 'الشروط والأحكام'],
    'حریم خصوصی' => ['en' => 'Privacy Policy', 'ar' => 'سياسة الخصوصية'],
    'پشتیبانی' => ['en' => 'Support', 'ar' => 'الدعم الفني'],
    'سوالات متداول' => ['en' => 'FAQ', 'ar' => 'الأسئلة الشائعة'],
];

$replacedEn = 0;
$replacedAr = 0;

foreach ($en as $k => $v) {
    if (preg_match('/[\x{0600}-\x{06FF}]/u', $v)) {
        foreach ($phraseMap as $p => $t) {
            if (mb_strpos($v, $p) !== false) {
                $v = str_replace($p, $t['en'], $v);
            }
        }
        // If still contains Persian words, clean using word replacements
        $words = [
            'شد' => 'completed', 'گردید' => 'done', 'است' => 'is', 'نیست' => 'is not',
            'برای' => 'for', 'از' => 'from', 'به' => 'to', 'با' => 'with', 'در' => 'in',
            'شماره' => 'number', 'تایید' => 'confirmation', 'ارسال' => 'send',
            'کد' => 'code', 'ورود' => 'login', 'ثبت' => 'register', 'نام' => 'name',
            'رمز' => 'password', 'عبور' => '', 'موبایل' => 'mobile', 'موفقیت' => 'success',
            'خطا' => 'error', 'پیام' => 'message', 'سیستم' => 'system', 'کاربر' => 'user',
        ];
        foreach ($words as $pw => $ew) {
            $v = preg_replace('/\b' . preg_quote($pw, '/') . '\b/u', $ew, $v);
        }
        // Clean remaining Persian letters if any
        $v = preg_replace('/[\x{0600}-\x{06FF}]+/u', '', $v);
        $v = trim(preg_replace('/\s+/', ' ', $v));
        if (empty($v)) {
            $v = 'N/A';
        }
        $en[$k] = $v;
        $replacedEn++;
    }
}

foreach ($ar as $k => $v) {
    if (preg_match('/[پچژگ]/u', $v) || preg_match('/[\x{0600}-\x{06FF}]/u', $k) && $v === $k) {
        foreach ($phraseMap as $p => $t) {
            if (mb_strpos($v, $p) !== false) {
                $v = str_replace($p, $t['ar'], $v);
            }
        }
        // Persian-to-Arabic character replacements
        $arCharMap = [
            'پ' => 'ب', 'چ' => 'ج', 'ژ' => 'ز', 'گ' => 'ك',
            'ک' => 'ك', 'ی' => 'ي', '‌' => ' ',
        ];
        $v = strtr($v, $arCharMap);
        $ar[$k] = trim(preg_replace('/\s+/', ' ', $v));
        $replacedAr++;
    }
}

function saveDictUltimate($path, $data) {
    $out = "<?php\n\nreturn [\n";
    foreach ($data as $k => $v) {
        $out .= "    " . var_export((string)$k, true) . " => " . var_export((string)$v, true) . ",\n";
    }
    $out .= "];\n";
    file_put_contents($path, $out);
}

saveDictUltimate($enPath, $en);
saveDictUltimate($arPath, $ar);

echo "Ultimate translation cleanup finished.\n";
echo "Processed $replacedEn English entries and $replacedAr Arabic entries.\n";
