<?php

$viewsPath = __DIR__ . '/../resources/views';
$enPath    = __DIR__ . '/../resources/lang/en/message.php';
$arPath    = __DIR__ . '/../resources/lang/ar/message.php';

$en = include $enPath;
$ar = include $arPath;

$missing = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $content = file_get_contents($file->getPathname());
    preg_match_all("/l\(['\"](.+?)['\"]\)/u", $content, $matches);
    foreach ($matches[1] as $key) {
        $dashKey = str_replace(' ', '-', $key);
        if (!isset($en[$key]) && !isset($en[$dashKey])) {
            // Check if key is actual Persian text or readable phrase
            if (preg_match('/[\x{0600}-\x{06FF}]/u', $key) && strlen($key) > 1 && strpos($key, '$') === false) {
                $missing[$key] = $key;
            }
        }
    }
}

echo "Found " . count($missing) . " unique Persian translation keys missing from dictionaries.\n";

// Map of common Persian real estate terms to English & Arabic
$translations = [
    'در سایت ما با اطمینان ثبت نام کنید.' => ['en' => 'Register with confidence on our site.', 'ar' => 'سجّل في موقعنا بكل ثقة.'],
    'ثبت نام کرده اید؟' => ['en' => 'Already registered?', 'ar' => 'هل لديك حساب بالفعل؟'],
    'ورود به حساب کاربری' => ['en' => 'Log In to Your Account', 'ar' => 'تسجيل الدخول إلى حسابك'],
    'نام و نام خانوادگی خود را وارد کنید' => ['en' => 'Enter your full name', 'ar' => 'أدخل اسمك الكامل'],
    'نام را وارد کنید.' => ['en' => 'Please enter your name.', 'ar' => 'يرجى إدخال الاسم.'],
    'پست الکترونیکی' => ['en' => 'Email Address', 'ar' => 'البريد الإلكتروني'],
    'ایمیل معتبر وارد کنید.' => ['en' => 'Please enter a valid email address.', 'ar' => 'يرجى إدخال بريد إلكتروني صحيح.'],
    'حداقل ۸ کاراکتر' => ['en' => 'Minimum 8 characters', 'ar' => '8 أحرف على الأقل'],
    'رمز عبور باید حداقل ۸ کاراکتر باشد.' => ['en' => 'Password must be at least 8 characters.', 'ar' => 'يجب أن تكون كلمة المرور 8 أحرف على الأقل.'],
    'تایید رمز عبور' => ['en' => 'Confirm Password', 'ar' => 'تأكيد كلمة المرور'],
    'رمز عبور با تاییدیه هم‌خوانی ندارد.' => ['en' => 'Password and confirmation do not match.', 'ar' => 'كلمة المرور وتأكيدها غير متطابقين.'],
    'لطفا شماره موبایل خود را وارد کنید' => ['en' => 'Please enter your mobile number', 'ar' => 'يرجى إدخال رقم هاتفك المحمول'],
    'رمز عبور شماره' => ['en' => 'Password for number', 'ar' => 'كلمة المرور للرقم'],
    'را وارد کنید' => ['en' => 'enter', 'ar' => 'أدخل'],
    'ارسال مجدد کد تایید' => ['en' => 'Resend verification code', 'ar' => 'إعادة إرسال رمز التحقق'],
    'ثانیه زمان باقی مانده است.' => ['en' => 'seconds remaining.', 'ar' => 'ثانية متبقية.'],
    'ورود با رمز یک‌بار مصرف' => ['en' => 'Login with OTP', 'ar' => 'تسجيل الدخول برمز المرة الواحدة'],
    'بازیابی رمز عبور' => ['en' => 'Password Recovery', 'ar' => 'استعادة كلمة المرور'],
];

$addedCount = 0;
foreach ($missing as $k) {
    if (isset($en[$k])) continue;

    $enText = isset($translations[$k]['en']) ? $translations[$k]['en'] : $k;
    $arText = isset($translations[$k]['ar']) ? $translations[$k]['ar'] : $k;

    $en[$k] = $enText;
    $ar[$k] = $arText;

    $dashKey = str_replace(' ', '-', $k);
    $en[$dashKey] = $enText;
    $ar[$dashKey] = $arText;

    $addedCount++;
}

function saveDictFile($path, $dict) {
    $content = "<?php\n\nreturn [\n";
    foreach ($dict as $k => $v) {
        $content .= "    " . var_export((string)$k, true) . " => " . var_export((string)$v, true) . ",\n";
    }
    $content .= "];\n";
    file_put_contents($path, $content);
}

saveDictFile($enPath, $en);
saveDictFile($arPath, $ar);

echo "Successfully synchronized $addedCount missing keys into English and Arabic dictionaries.\n";
