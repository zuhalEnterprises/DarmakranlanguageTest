<?php

$viewsPath = __DIR__ . '/../resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$report = [];

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();
    $content = file_get_contents($filePath);

    // Strip comments and scripts/styles
    $clean = preg_replace('/\{\{--.*?--\}\}/s', '', $content);
    $clean = preg_replace('/<script.*?>.*?<\/script>/s', '', $clean);
    $clean = preg_replace('/<style.*?>.*?<\/style>/s', '', $clean);

    // Strip all existing l('...') or l("...") or __('...') or __("...")
    $clean = preg_replace('/l\([\'"].*?[\'"]\)/u', '', $clean);
    $clean = preg_replace('/__\([\'"].*?[\'"]\)/u', '', $clean);

    // Find any remaining Persian words in raw HTML text nodes or attributes
    preg_match_all('/[\x{0600}-\x{06FF}]{2,}/u', $clean, $matches);

    if (!empty($matches[0])) {
        // Filter out matches that are inside {{ ... }} or {!! ... !!}
        $rawMatches = [];
        foreach ($matches[0] as $match) {
            // Check if the match is inside raw HTML or attributes
            $rawMatches[] = $match;
        }

        if (count($rawMatches) > 0) {
            $rel = str_replace(realpath($viewsPath), '', realpath($filePath));
            $report[$rel] = array_unique($rawMatches);
        }
    }
}

echo "=== DEEP UNWRAPPED PERSIAN SCAN REPORT ===\n";
echo "Files with potential unwrapped Persian text: " . count($report) . "\n\n";

$count = 0;
foreach ($report as $file => $words) {
    $count++;
    echo "[$count] File: $file (" . count($words) . " raw words)\n";
    $sample = array_slice($words, 0, 8);
    echo "    Sample words: " . implode(', ', $sample) . "\n";
    if ($count >= 50) {
        echo "... and more files.\n";
        break;
    }
}
