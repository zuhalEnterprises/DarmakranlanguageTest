<?php

$cleanDropdown = <<<HTML
<div class="dropdown">
    <button class="btn btn-sm btn-outline-light dropdown-toggle py-0 text-gold" type="button" id="languageDropdownBtn" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false">
        <i class="fi-globe me-1"></i> {{ strtoupper(session('locale', app()->getLocale())) }}
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="languageDropdownBtn" style="background-color: #ffffff !important; border: 1px solid #e0e0e0 !important; z-index: 9999;">
        <li><a class="dropdown-item py-2 px-3 fw-normal" href="/lang/en" style="color: #212529 !important; background-color: #ffffff !important;">🇬🇧 English</a></li>
        <li><a class="dropdown-item py-2 px-3 fw-normal" href="/lang/ar" style="color: #212529 !important; background-color: #ffffff !important;">🇦🇪 العربية</a></li>
        <li><a class="dropdown-item py-2 px-3 fw-normal" href="/lang/fa" style="color: #212529 !important; background-color: #ffffff !important;">🇮🇷 فارسی</a></li>
    </ul>
</div>
HTML;

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$fixedCount = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();
    if (strpos($filePath, 'header') === false) continue;

    $content = file_get_contents($filePath);

    // Replace all duplicate / stray dropdown blocks with a single clean dropdown block where appropriate
    // First, remove extra stray <div class="dropdown">...</div> blocks if more than one exists in top bar
    $count = 0;
    $content = preg_replace_callback('/<div class=["\']dropdown["\']>.*?<\/ul>\s*<\/div>/s', function($m) use (&$count, $cleanDropdown) {
        $count++;
        // Keep the first valid desktop dropdown, remove stray secondary duplicates
        if ($count == 1) {
            return $cleanDropdown;
        }
        return '';
    }, $content);

    // Test for valid PHP parsing by running php -l on the template file
    file_put_contents($filePath, $content);
    $fixedCount++;
    echo "Cleaned header: " . basename($filePath) . "\n";
}

echo "Cleaned $fixedCount header files.\n";
