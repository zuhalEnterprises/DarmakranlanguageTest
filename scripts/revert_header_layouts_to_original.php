<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$revertedCount = 0;

$cleanLanguageSwitcher = <<<HTML
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle py-0 text-gold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fi-globe me-1"></i> {{ strtoupper(session('locale', app()->getLocale())) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="/lang/en">🇬🇧 English</a></li>
                            <li><a class="dropdown-item" href="/lang/ar">🇦🇪 العربية</a></li>
                            <li><a class="dropdown-item" href="/lang/fa">🇮🇷 فارسی</a></li>
                        </ul>
                    </div>
HTML;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();
    if (strpos($filePath, 'header') === false) continue;

    $content = file_get_contents($filePath);
    $original = $content;

    // Standardize the language switcher to the clean simple dropdown
    $content = preg_replace('/<div class=["\']dropdown[^>]*>.*?<\/ul>\s*<\/div>/s', $cleanLanguageSwitcher, $content);

    // Remove any leftover mobile select components or inline style overrides
    $content = preg_replace('/<div class=["\']px-3 py-2 my-2 border-bottom d-lg-none["\']>.*?<\/div>/s', '', $content);

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $revertedCount++;
        echo "Reverted header: " . basename($filePath) . "\n";
    }
}

echo "Reverted $revertedCount header layout files.\n";
