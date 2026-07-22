<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$keys = [
    'دارمکران',
    'سرمایه‌گذاری امروز، آرامش فردا',
    'فروش',
    'اجاره',
    'ثبت ملک',
    'ثبت تقاضا',
    'املاک فروشی',
    'مشاهده همه',
    'همین حالا تماس بگیرید',
    'املاک فروش فوری',
    'چرا دارمکران برای شما انتخاب خوبی است؟',
    'مالک هستید؟',
    'املاک اکازیون',
];

foreach (['fa', 'ar', 'en'] as $lang) {
    app()->setLocale($lang);
    session(['locale' => $lang]);
    echo "=== LOCALE: $lang ===\n";
    foreach ($keys as $key) {
        $trans = l($key);
        echo "[$key] => \"$trans\"\n";
    }
    echo "\n";
}
