<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$cleanDesktopDropdown = <<<HTML
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-gold fs-sm p-0 d-inline-flex align-items-center gap-1" href="#" role="button" id="langDropdown" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false">
                            <i class="fi-globe"></i> <span>{{ strtoupper(session('locale', app()->getLocale())) }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm fs-sm border-0 my-1" aria-labelledby="langDropdown" style="min-width: 130px;">
                            <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="/lang/en"><span>🇬🇧</span> English</a></li>
                            <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="/lang/ar"><span>🇦🇪</span> {{ l('العربية') }}</a></li>
                            <li><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="/lang/fa"><span>🇮🇷</span> {{ l('فارسی') }}</a></li>
                        </ul>
                    </div>
HTML;

$cleanMobileSelect = <<<HTML
            <div class="px-3 py-2 my-2 border-bottom d-lg-none">
                <div class="d-flex align-items-center gap-2 text-muted fs-sm mb-1">
                    <i class="fi-globe"></i>
                    <span>{{ l('انتخاب زبان') }}</span>
                </div>
                <select class="form-select form-select-sm" onchange="window.location='/lang/' + this.value">
                    <option value="en" {{ session('locale', app()->getLocale()) == 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                    <option value="ar" {{ session('locale', app()->getLocale()) == 'ar' ? 'selected' : '' }}>🇦🇪 {{ l('العربية') }}</option>
                    <option value="fa" {{ session('locale', app()->getLocale()) == 'fa' ? 'selected' : '' }}>🇮🇷 {{ l('فارسی') }}</option>
                </select>
            </div>
HTML;

$updatedFiles = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();

    if (strpos($filePath, 'header') === false) continue;

    $content = file_get_contents($filePath);
    $original = $content;

    // Replace tacky heavy-styled dropdowns with clean theme-native dropdown
    $content = preg_replace('/<div class=["\']dropdown me-2 me-lg-3 d-inline-block["\']>.*?<\/ul>\s*<\/div>/s', $cleanDesktopDropdown, $content);
    $content = preg_replace('/<div class=["\']dropdown me-2 me-lg-3["\']>.*?<\/ul>\s*<\/div>/s', $cleanDesktopDropdown, $content);

    // Replace tacky mobile selects
    $content = preg_replace('/<div class=["\']px-3 py-2 border-bottom d-lg-none my-2["\']>.*?<\/div>/s', $cleanMobileSelect, $content);

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $updatedFiles++;
        echo "Restored clean theme dropdown in: " . basename($filePath) . "\n";
    }
}

echo "Successfully updated $updatedFiles header files with clean, theme-matched language dropdowns.\n";
