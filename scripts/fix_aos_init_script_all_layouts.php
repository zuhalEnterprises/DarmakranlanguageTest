<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$cleanAosScript = <<<HTML
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    once: true
                });
            }
        });
    </script>
HTML;

$fixedCount = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();

    $content = file_get_contents($filePath);
    $original = $content;

    // Replace broken single-line commented AOS.init script
    $content = preg_replace('/<script src="https:\/\/unpkg\.com\/aos@[^\"]+"><\/script>\s*<script>\s*AOS\.init\([^<]*\);\s*<\/script>/s', $cleanAosScript, $content);

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $fixedCount++;
        echo "Fixed AOS.init script in: " . str_replace(realpath($viewsPath), '', realpath($filePath)) . "\n";
    }
}

echo "Successfully fixed AOS.init script in $fixedCount files.\n";
