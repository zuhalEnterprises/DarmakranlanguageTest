<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$desktopDropdownCode = <<<HTML
                    <div class="dropdown me-2 me-lg-3 d-inline-block">
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

$updatedCount = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();

    // Look for header files
    if (strpos($filePath, 'header') === false) continue;

    $content = file_get_contents($filePath);
    $original = $content;

    // Check if dropdown already present
    if (strpos($content, 'id="languageDropdownBtn"') === false) {
        // Try replacing old dropdown or adding before </header> or navbar-nav
        if (strpos($content, '/lang/en') !== false) {
            $content = preg_replace('/<div class=["\']dropdown[^>]*>.*?<\/div>/s', $desktopDropdownCode, $content, 1);
        } else if (strpos($content, '<div class="nav flex-row') !== false) {
            $content = str_replace('<div class="nav flex-row', $desktopDropdownCode . "\n" . '<div class="nav flex-row', $content);
        } else if (strpos($content, 'navbar-nav') !== false) {
            $content = preg_replace('/(<ul class=["\']navbar-nav[^>]*>)/', '$1' . "\n" . '<li class="nav-item me-2">' . $desktopDropdownCode . '</li>', $content, 1);
        }
    }

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $updatedCount++;
        echo "Injected language dropdown in: " . str_replace(realpath($viewsPath), '', realpath($filePath)) . "\n";
    }
}

echo "Successfully processed header files. Total injected: $updatedCount\n";
