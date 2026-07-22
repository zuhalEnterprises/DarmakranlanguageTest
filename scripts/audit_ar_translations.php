<?php

$arPath = __DIR__ . '/../resources/lang/ar/message.php';
$ar = include $arPath;

// List of fixes for known broken/mixed Arabic translations
$fixes = [
    'با-ما-در-ارتباط-باشید!' => 'تواصل معنا!',
    'با-ما-در-ارتباط-باشید' => 'تواصل معنا',
    'تماس-از-9-الی-21' => 'الاتصال من 9 صباحاً حتى 9 مساءً',
    'آدرس-صفحات-ما-:' => 'روابط صفحاتنا على مواقع التواصل :',
    'آدرس-صفحات-ما' => 'عناوين صفحاتنا',
    'ما-را-دنبال-کنید' => 'تابعنا على مواقع التواصل',
    'ما-را-دنبال-کنید:' => 'تابعنا :',
    'دنبال-کنید' => 'تابعنا',
    'تلفن-:' => 'الهاتف :',
    'رقم-اتصال-:' => 'رقم الاتصال :',
    'آدرس-:' => 'العنوان :',
    'ایمیل-:' => 'البريد الإلكتروني :',
];

// Let's also scan all entries in $ar to find any values containing Persian characters/words
$persianWords = ['با', 'در', 'ارتباط', 'باشید', 'کنید', 'از', 'الی', 'را', 'صفحات', 'ما', 'شما', 'برای', 'این', 'است', 'هستند', 'می‌باشد', 'شد', 'گردید'];

$suspicious = [];
foreach ($ar as $key => $val) {
    foreach ($persianWords as $pw) {
        if (preg_match("/\b" . preg_quote($pw, '/') . "\b/u", $val)) {
            $suspicious[$key] = $val;
            break;
        }
    }
}

echo "Found " . count($suspicious) . " suspicious Arabic values containing Persian words.\n\n";

foreach ($suspicious as $k => $v) {
    echo "KEY: '$k'\n  OLD VAL: '$v'\n";
}
