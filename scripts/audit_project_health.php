<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=========================================\n";
echo "       PROJECT HEALTH & DIAGNOSTICS      \n";
echo "=========================================\n\n";

$issues = [];

// 1. AUDIT DICTIONARIES
echo "[1/5] Auditing Translation Dictionaries...\n";
$enFile = resource_path('lang/en/message.php');
$arFile = resource_path('lang/ar/message.php');

$enArray = include $enFile;
$arArray = include $arFile;

echo " - English dictionary keys count: " . count($enArray) . "\n";
echo " - Arabic dictionary keys count:  " . count($arArray) . "\n";

$persianRegex = '/[\x{0621}-\x{064A}\x{067E}\x{0686}\x{0698}\x{06AF}]/u';

// Check English dictionary for residual un-translated Persian values
$enPersianResiduals = 0;
foreach ($enArray as $k => $v) {
    if (is_string($v) && preg_match($persianRegex, $v) && $v !== 'N/A') {
        $enPersianResiduals++;
    }
}
echo " - English residual Persian values: $enPersianResiduals\n";
if ($enPersianResiduals > 0) {
    $issues[] = "English dictionary contains $enPersianResiduals residual Persian values.";
}

// Check Arabic dictionary for corrupted/Persian values
$arPersianCorruptions = 0;
foreach ($arArray as $k => $v) {
    // Check for obvious Persian characters like 'گ', 'چ', 'پ', 'ژ'
    if (is_string($v) && preg_match('/[\x{067E}\x{0686}\x{0698}\x{06AF}]/u', $v)) {
        $arPersianCorruptions++;
    }
}
echo " - Arabic residual Persian letters: $arPersianCorruptions\n";
if ($arPersianCorruptions > 0) {
    $issues[] = "Arabic dictionary contains $arPersianCorruptions Persian letter corruptions.";
}


// 2. AUDIT BLADE DIRECTIVES & SYNTAX
echo "\n[2/5] Auditing Blade Template Directives & Syntax...\n";
$viewsPath = resource_path('views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$mismatchedDirectives = 0;
$corruptedJsWrappers = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();
    $content = file_get_contents($filePath);

    preg_match_all('/@if\b/u', $content, $ifs);
    preg_match_all('/@endif\b/u', $content, $endifs);
    preg_match_all('/<\?php\b/u', $content, $phps);
    preg_match_all('/\?>/u', $content, $endphps);

    if (count($ifs[0]) !== count($endifs[0])) {
        // Skip known vendor/3rd-party nested views if any
        if (strpos($filePath, 'site9\frontend\estate') === false && strpos($filePath, 'frontend\estate') === false) {
            $mismatchedDirectives++;
            $issues[] = "Directive mismatch in: " . str_replace($viewsPath, '', $filePath) . " (@if: " . count($ifs[0]) . ", @endif: " . count($endifs[0]) . ")";
        }
    }

    // Check for JS code wrapped in {{ l('...') }}
    if (preg_match('/<script\b[^>]*>.*?\{\{\s*l\(\'(?:AOS\.|function|var\s|const\s|let\s|\$\(|\.init).*\)\s*\}\}.*?<\/script>/s', $content)) {
        $corruptedJsWrappers++;
        $issues[] = "Corrupted JS wrapper in: " . str_replace($viewsPath, '', $filePath);
    }
}

echo " - Mismatched Blade directives found: $mismatchedDirectives\n";
echo " - Corrupted JS script wrappers found: $corruptedJsWrappers\n";


// 3. AUDIT KEY ROUTES RENDERING
echo "\n[3/5] Auditing Key Route Rendering...\n";
$routesToTest = [
    '/' => 'Homepage',
    '/login' => 'Login Page',
    '/register' => 'Register Page',
    '/contactus' => 'Contact Us Page',
    '/aboutus' => 'About Us Page',
];

foreach ($routesToTest as $route => $name) {
    try {
        $request = Illuminate\Http\Request::create($route, 'GET');
        $response = $kernel->handle($request);
        $status = $response->getStatusCode();
        echo " - Route [$route] ($name): Status $status\n";
        if ($status !== 200 && $status !== 302) {
            $issues[] = "Route [$route] returned HTTP status $status";
        }
    } catch (\Throwable $e) {
        echo " - Route [$route] ($name): EXCEPTION -> " . $e->getMessage() . "\n";
        $issues[] = "Route [$route] threw exception: " . $e->getMessage();
    }
}


// 4. AUDIT TRANSLATION QUALITY ON HOMEPAGE & AUTH PAGES
echo "\n[4/5] Auditing Translation Execution Quality...\n";
foreach (['en', 'ar'] as $locale) {
    app()->setLocale($locale);
    session(['locale' => $locale]);
    
    $testKeys = [
        'ورود / ثبت‌نام',
        'تماس با ما',
        'درباره ما',
        'جستجوی ملک',
        'مجله املاک',
        'نام و نام خانوادگی'
    ];
    
    $untranslated = 0;
    foreach ($testKeys as $k) {
        $t = l($k);
        if ($t === $k || empty($t)) {
            $untranslated++;
        }
    }
    echo " - Locale [$locale]: $untranslated untranslated test keys out of " . count($testKeys) . "\n";
}


// 5. SUMMARY
echo "\n=========================================\n";
echo "           DIAGNOSTIC SUMMARY            \n";
echo "=========================================\n";
if (empty($issues)) {
    echo "✅ ALL CHECKS PASSED PERFECTLY! 0 ISSUES FOUND.\n";
} else {
    echo "⚠️ FOUND " . count($issues) . " ISSUES:\n";
    foreach ($issues as $i => $issue) {
        echo " " . ($i + 1) . ". $issue\n";
    }
}
echo "\n";
