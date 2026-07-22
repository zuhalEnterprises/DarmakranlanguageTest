<?php

$viewsPath = __DIR__ . '/../resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$hardcodedFiles = [];

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();
    $content = file_get_contents($filePath);

    // Remove blade comment blocks {{-- ... --}} and blade print tags {{ ... }} and {!! ... !!}
    $cleanContent = preg_replace('/\{\{--.*?--\}\}/s', '', $content);
    $cleanContent = preg_replace('/\{\!\!.*?\!\!\}/s', '', $cleanContent);
    $cleanContent = preg_replace('/\{\{.*?\}\}/s', '', $cleanContent);
    $cleanContent = preg_replace('/<script.*?>.*?<\/script>/s', '', $cleanContent);
    $cleanContent = preg_replace('/<style.*?>.*?<\/style>/s', '', $cleanContent);

    // Match Persian characters outside blade expressions
    preg_match_all('/[\x{0600}-\x{06FF}]+/u', $cleanContent, $matches);
    if (!empty($matches[0])) {
        // Filter out short numbers or common single words if needed
        $persianWords = array_filter($matches[0], function($w) {
            return mb_strlen($w) > 2;
        });
        if (count($persianWords) > 0) {
            $relativePath = str_replace(realpath($viewsPath), '', realpath($filePath));
            $hardcodedFiles[$relativePath] = count($persianWords);
        }
    }
}

echo "Found " . count($hardcodedFiles) . " views with hardcoded Persian text outside {{ l(...) }}:\n\n";
arsort($hardcodedFiles);
foreach ($hardcodedFiles as $f => $count) {
    echo "  - $f ($count Persian words)\n";
}
