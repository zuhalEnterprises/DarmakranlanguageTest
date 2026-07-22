<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$updatedFiles = 0;

$desktopDropdownCode = <<<HTML
                    <div class="dropdown me-2 me-lg-3">
                        <button class="btn btn-sm dropdown-toggle py-1 px-3 text-gold fw-bold" type="button" id="languageDropdownBtn" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false" style="background-color: rgba(255,255,255,0.15); border: 1px solid #d4af37; color: #d4af37 !important; border-radius: 6px; z-index: 1000;">
                            <i class="fi-globe me-1"></i> {{ strtoupper(session('locale', app()->getLocale())) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="languageDropdownBtn" style="background-color: #ffffff !important; border: 1px solid #d4af37 !important; z-index: 99999 !important; min-width: 150px; margin-top: 5px; opacity: 1 !important; visibility: visible !important;">
                            <li><a class="dropdown-item py-2 px-3 fw-bold" href="/lang/en" style="color: #222222 !important; background-color: #ffffff !important; display: block !important; opacity: 1 !important; visibility: visible !important;"><span class="me-2">🇬🇧</span> English</a></li>
                            <li><a class="dropdown-item py-2 px-3 fw-bold" href="/lang/ar" style="color: #222222 !important; background-color: #ffffff !important; display: block !important; opacity: 1 !important; visibility: visible !important;"><span class="me-2">🇦🇪</span> {{ l('العربية') }}</a></li>
                            <li><a class="dropdown-item py-2 px-3 fw-bold" href="/lang/fa" style="color: #222222 !important; background-color: #ffffff !important; display: block !important; opacity: 1 !important; visibility: visible !important;"><span class="me-2">🇮🇷</span> {{ l('فارسی') }}</a></li>
                        </ul>
                    </div>
HTML;

$mobileSelectCode = <<<HTML
            <div class="px-3 py-2 border-bottom d-lg-none my-2">
                <label class="form-label fs-xs text-muted mb-1"><i class="fi-globe me-1"></i> {{ l('انتخاب زبان') }}</label>
                <select class="form-select form-select-sm" onchange="window.location='/lang/' + this.value" style="background-color: #ffffff !important; color: #222222 !important; border: 1px solid #d4af37 !important; border-radius: 6px; font-weight: bold;">
                    <option value="en" {{ session('locale', app()->getLocale()) == 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                    <option value="ar" {{ session('locale', app()->getLocale()) == 'ar' ? 'selected' : '' }}>🇦🇪 {{ l('العربية') }}</option>
                    <option value="fa" {{ session('locale', app()->getLocale()) == 'fa' ? 'selected' : '' }}>🇮🇷 {{ l('فارسی') }}</option>
                </select>
            </div>
HTML;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();

    if (strpos($filePath, 'header') === false && strpos($filePath, 'app') === false) {
        continue;
    }

    $content = file_get_contents($filePath);
    $original = $content;

    // Replace old language dropdowns in headers
    if (strpos($content, '/lang/en') !== false || strpos($content, 'language-select') !== false || strpos($content, 'dropdown-menu') !== false) {

        // Regex replace existing <div class="dropdown"> ... </div> containing /lang/en
        $content = preg_replace('/<div class=["\']dropdown["\']>\s*<button[^>]*>.*?<\/button>\s*<ul class=["\']dropdown-menu[^>]*>.*?<\/ul>\s*<\/div>/s', $desktopDropdownCode, $content);

        // Replace <select ... id="...language-select...">
        $content = preg_replace('/<select[^>]*id=["\'][^"\']*language-select[^"\']*["\'][^>]*>.*?<\/select>/s', $desktopDropdownCode, $content);

        // Add mobileSelectCode into offcanvas-body if not present
        if (strpos($content, 'offcanvas-body') !== false && strpos($content, 'mobile-language-select') === false) {
            $content = str_replace('<div class="offcanvas-body pt-0">', '<div class="offcanvas-body pt-0">' . "\n" . $mobileSelectCode, $content);
        }
    }

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $updatedFiles++;
        echo "Updated header file: " . basename($filePath) . "\n";
    }
}

echo "Completed updating language dropdowns in $updatedFiles header files.\n";
