<?php

$viewsPath = __DIR__ . '/../resources/views';
$dictPath  = __DIR__ . '/../resources/lang/en/message.php';
$dict = include $dictPath;

$missing = [];
$found   = 0;
$allKeys = [];

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));
foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $content = file_get_contents($file->getPathname());
    preg_match_all("/l\(['\"](.+?)['\"]\)/", $content, $matches);
    foreach ($matches[1] as $key) {
        $dashKey = str_replace(' ', '-', $key);
        if (isset($dict[$key]) || isset($dict[$dashKey])) {
            $found++;
        } else {
            $missing[] = $key;
        }
        $allKeys[] = $key;
    }
}

$missing = array_unique($missing);
sort($missing);

echo "===== TRANSLATION COVERAGE REPORT =====" . PHP_EOL;
echo "Total l() calls found in views: " . count($allKeys)  . PHP_EOL;
echo "Keys WITH English translation:  " . $found            . PHP_EOL;
echo "Keys MISSING translation:       " . count($missing)   . PHP_EOL;
echo PHP_EOL;
if (count($missing) > 0) {
    echo "--- MISSING KEYS (need to be added to message.php) ---" . PHP_EOL;
    foreach ($missing as $m) {
        echo "  '" . $m . "' => '',\n";
    }
} else {
    echo "All translation keys are covered!" . PHP_EOL;
}
