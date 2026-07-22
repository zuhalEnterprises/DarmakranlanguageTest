<?php

$enPath = __DIR__ . '/../resources/lang/en/message.php';
$arPath = __DIR__ . '/../resources/lang/ar/message.php';

$en = include $enPath;
$ar = include $arPath;

$registerTranslations = [
    'در سایت ما با اطمینان ثبت نام کنید.' => [
        'en' => 'Register with confidence on our site.',
        'ar' => 'سجّل في موقعنا بكل ثقة.',
    ],
    'ثبت نام کرده اید؟' => [
        'en' => 'Already registered?',
        'ar' => 'هل لديك حساب بالفعل؟',
    ],
    'ورود به حساب کاربری' => [
        'en' => 'Log In to Your Account',
        'ar' => 'تسجيل الدخول إلى حسابك',
    ],
    'نام و نام خانوادگی' => [
        'en' => 'Full Name',
        'ar' => 'الاسم الكامل',
    ],
    'نام و نام خانوادگی خود را وارد کنید' => [
        'en' => 'Enter your full name',
        'ar' => 'أدخل اسمك الكامل',
    ],
    'نام را وارد کنید.' => [
        'en' => 'Please enter your name.',
        'ar' => 'يرجى إدخال الاسم.',
    ],
    'پست الکترونیکی' => [
        'en' => 'Email Address',
        'ar' => 'البريد الإلكتروني',
    ],
    'ایمیل' => [
        'en' => 'Email',
        'ar' => 'البريد الإلكتروني',
    ],
    'ایمیل معتبر وارد کنید.' => [
        'en' => 'Please enter a valid email address.',
        'ar' => 'يرجى إدخال بريد إلكتروني صحيح.',
    ],
    'رمز عبور' => [
        'en' => 'Password',
        'ar' => 'كلمة المرور',
    ],
    'حداقل ۸ کاراکتر' => [
        'en' => 'Minimum 8 characters',
        'ar' => '8 أحرف على الأقل',
    ],
    'رمز عبور باید حداقل ۸ کاراکتر باشد.' => [
        'en' => 'Password must be at least 8 characters.',
        'ar' => 'يجب أن تكون كلمة المرور 8 أحرف على الأقل.',
    ],
    'تایید رمز عبور' => [
        'en' => 'Confirm Password',
        'ar' => 'تأكيد كلمة المرور',
    ],
    'رمز عبور با تاییدیه هم‌خوانی ندارد.' => [
        'en' => 'Password and confirmation do not match.',
        'ar' => 'كلمة المرور وتأكيدها غير متطابقين.',
    ],
    'ثبت نام' => [
        'en' => 'Register',
        'ar' => 'إنشاء حساب',
    ],
];

foreach ($registerTranslations as $key => $vals) {
    $en[$key] = $vals['en'];
    $ar[$key] = $vals['ar'];

    // Also support dash format
    $dashKey = str_replace(' ', '-', $key);
    $en[$dashKey] = $vals['en'];
    $ar[$dashKey] = $vals['ar'];
}

function saveDict($path, $dict) {
    $content = "<?php\n\nreturn [\n";
    foreach ($dict as $k => $v) {
        $content .= "    " . var_export((string)$k, true) . " => " . var_export((string)$v, true) . ",\n";
    }
    $content .= "];\n";
    file_put_contents($path, $content);
}

saveDict($enPath, $en);
saveDict($arPath, $ar);

echo "Register page translations updated for EN and AR successfully.\n";
