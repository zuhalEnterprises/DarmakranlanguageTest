<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$exactOriginalDropdown = <<<HTML
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle py-0 text-gold" type="button" id="languageDropdownBtn" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="false">
                            <i class="fi-globe me-1"></i> {{ strtoupper(session('locale', app()->getLocale())) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="languageDropdownBtn" style="background-color: #ffffff !important; border: 1px solid #e0e0e0 !important;">
                            <li><a class="dropdown-item py-2 px-3 fw-normal" href="/lang/en" style="color: #212529 !important; background-color: #ffffff !important;">🇬🇧 English</a></li>
                            <li><a class="dropdown-item py-2 px-3 fw-normal" href="/lang/ar" style="color: #212529 !important; background-color: #ffffff !important;">🇦🇪 العربية</a></li>
                            <li><a class="dropdown-item py-2 px-3 fw-normal" href="/lang/fa" style="color: #212529 !important; background-color: #ffffff !important;">🇮🇷 فارسی</a></li>
                        </ul>
                    </div>
HTML;

$updatedFiles = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();

    if (strpos($filePath, 'header') === false) continue;

    $content = file_get_contents($filePath);
    $original = $content;

    // Replace any language dropdown in header files with the exact original button + high-contrast visible text + literal language names
    $content = preg_replace('/<div class=["\']dropdown[^>]*>.*?<\/ul>\s*<\/div>/s', $exactOriginalDropdown, $content);

    // Remove any mobile select elements added earlier
    $content = preg_replace('/<div class=["\']px-3 py-2 my-2 border-bottom d-lg-none["\']>.*?<\/div>/s', '', $content);

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $updatedFiles++;
        echo "Restored exact original dropdown in: " . basename($filePath) . "\n";
    }
}

echo "Successfully updated $updatedFiles header files.\n";
