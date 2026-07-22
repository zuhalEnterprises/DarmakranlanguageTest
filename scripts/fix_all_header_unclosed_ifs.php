<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$fixedFiles = 0;

$profileBlock = <<<HTML
        <div class="dropdown d-none d-lg-block order-lg-3 my-n2 me-4">
            <a class="d-block py-2" ref="" style="width:40px">
                <img class="rounded-circle w-100" src="{{!empty(\$currentUser)?\$currentUser->photo():''}}" alt="{{!empty(\$currentUser) ? \$currentUser->fullname():''}}" style="height: 40px">
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <div class="d-flex align-items-start border-bottom px-3 py-1 mb-2"><img class="rounded-circle" src="{{!empty(\$currentUser)?\$currentUser->photo():''}}" width="48" alt="{{!empty(\$currentUser) ? \$currentUser->fullname():''}}">
                    <div class="pe-2 text-right d-none d-lg-block">
                        <h6 class="fs-base mb-0"> {{!empty(\$currentUser) ? (\$currentUser->isExpert()?\$currentUser->fullname():\$currentUser->username):''}}</h6>
                    </div>
                </div>
                <a class="dropdown-item" href="/profile/info_v2"><i class="fi-user opacity-60 me-2"></i>{{l('ویرایش مشخصات')}}</a>
                <a class="dropdown-item" href="/favorite"><i class="fi-heart opacity-60 me-2"></i>{{l('موردعلاقه')}}</a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="/logout"> {{l('خروج')}}</a>
            </div>
        </div>
        @endif
HTML;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();
    if (strpos($filePath, 'header') === false) continue;

    $content = file_get_contents($filePath);
    
    preg_match_all('/@if\b/u', $content, $ifs);
    preg_match_all('/@endif\b/u', $content, $endifs);

    if (count($ifs[0]) > count($endifs[0])) {
        // Fix broken @else <div class="dropdown"> blocks that erased profile dropdown and @endif
        $content = preg_replace('/@else\s*<div class=["\']dropdown["\']>.*?<\/li>\s*@if\(empty\(\$currentUser\)\).*?<\/a>\s*<\/li>\s*@else\s*<li class=["\']nav-item dropdown d-lg-none["\']>.*?<div class=["\']offcanvas/s', "@else\n$profileBlock\n<div class=\"offcanvas", $content);
        
        file_put_contents($filePath, $content);
        $fixedFiles++;
        echo "Fixed unclosed @if in: " . basename($filePath) . "\n";
    }
}

echo "Fixed unclosed @if in $fixedFiles header files.\n";
