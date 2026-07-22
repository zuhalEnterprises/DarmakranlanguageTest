<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$mismatched = [];

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();
    $content = file_get_contents($filePath);

    preg_match_all('/@if\b/u', $content, $ifs);
    preg_match_all('/@endif\b/u', $content, $endifs);
    preg_match_all('/<\?php\b/u', $content, $phps);
    preg_match_all('/\?>/u', $content, $endphps);

    $ifCount = count($ifs[0]);
    $endifCount = count($endifs[0]);
    $phpCount = count($phps[0]);
    $endphpCount = count($endphps[0]);

    if ($ifCount !== $endifCount || $phpCount !== $endphpCount) {
        $mismatched[basename($filePath)] = [
            'file' => str_replace(realpath($viewsPath), '', realpath($filePath)),
            'ifs' => $ifCount,
            'endifs' => $endifCount,
            'phps' => $phpCount,
            'endphps' => $endphpCount
        ];
    }
}

echo "Found " . count($mismatched) . " files with mismatched directives:\n\n";
foreach ($mismatched as $m) {
    echo "File: " . $m['file'] . " -> @if: " . $m['ifs'] . ", @endif: " . $m['endifs'] . ", <?php: " . $m['phps'] . ", ?>: " . $m['endphps'] . "\n";
}
