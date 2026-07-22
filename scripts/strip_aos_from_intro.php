<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$fixedCount = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();
    if (strpos($filePath, 'intro') === false && strpos($filePath, 'index.blade.php') === false) continue;

    $content = file_get_contents($filePath);
    $original = $content;

    // Strip data-aos-* attributes that hide elements with opacity: 0
    $content = preg_replace('/\s*data-aos(?:-[a-z-]+)?=["\'][^"\']*["\']/i', '', $content);

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $fixedCount++;
        echo "Stripped AOS attributes from: " . str_replace(realpath($viewsPath), '', realpath($filePath)) . "\n";
    }
}

echo "Successfully cleaned AOS attributes in $fixedCount files.\n";
