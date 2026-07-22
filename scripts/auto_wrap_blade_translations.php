<?php

$targetDirs = [
    __DIR__ . '/../resources/views/frontend',
    __DIR__ . '/../resources/views/site10/frontend',
    __DIR__ . '/../resources/views/site3/frontend',
];

$modifiedCount = 0;

foreach ($targetDirs as $dir) {
    if (!is_dir($dir)) continue;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    foreach ($iterator as $file) {
        if ($file->getExtension() !== 'php') continue;
        $filePath = $file->getPathname();
        $content = file_get_contents($filePath);
        $originalContent = $content;

        // Regex to replace Persian text inside HTML tags: >Persian Text<
        // Excluding tags with existing blade syntax {{...}}
        $content = preg_replace_callback('/>([^<>{}\n\r]*[\x{0600}-\x{06FF}]+[^<>{}\n\r]*)</u', function($matches) {
            $text = trim($matches[1]);
            if (empty($text) || strpos($text, '{{') !== false || strpos($text, '@') !== false) {
                return $matches[0];
            }
            return '>{{ l(' . var_export($text, true) . ') }}<';
        }, $content);

        // Regex to replace Persian text inside placeholder attributes: placeholder="Persian Text"
        $content = preg_replace_callback('/placeholder=(["\'])([^"\']*\b[\x{0600}-\x{06FF}]+\b[^"\']*)\1/u', function($matches) {
            $quote = $matches[1];
            $text = trim($matches[2]);
            if (empty($text) || strpos($text, '{{') !== false) {
                return $matches[0];
            }
            return 'placeholder=' . $quote . '{{ l(' . var_export($text, true) . ') }}' . $quote;
        }, $content);

        if ($content !== $originalContent) {
            file_put_contents($filePath, $content);
            $modifiedCount++;
            echo "Wrapped hardcoded Persian in: " . basename($filePath) . "\n";
        }
    }
}

echo "\nTotal view files updated with l() wrappers: $modifiedCount\n";
