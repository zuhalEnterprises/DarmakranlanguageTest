<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$enPath    = realpath(__DIR__ . '/../resources/lang/en/message.php');
$arPath    = realpath(__DIR__ . '/../resources/lang/ar/message.php');

$en = include $enPath;
$ar = include $arPath;

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));
$modifiedCount = 0;
$newKeys = [];

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();
    $content = file_get_contents($filePath);
    $original = $content;

    // 1. Wrap Persian strings inside JS quotes: 'Persian' or "Persian" where l(...) is not already present
    $content = preg_replace_callback('/(?<!l\()(?<!l\(")(?<!l\(\')(?<=\s|=|\(|,|:)(["\'])([^"\']*\b[\x{0600}-\x{06FF}]+\b[^"\']*)\1/u', function($m) use (&$newKeys) {
        $quote = $m[1];
        $text = trim($m[2]);
        if (empty($text) || strpos($text, '{{') !== false || strpos($text, 'l(') !== false) {
            return $m[0];
        }
        $newKeys[$text] = $text;
        return 'l(' . $quote . $text . $quote . ')';
    }, $content);

    // 2. Wrap Persian strings inside ternary/null coalescing Blade expressions: ?? 'فروش' -> ?? l('فروش')
    $content = preg_replace_callback('/(\?\?|\?|:)\s*(["\'])([^"\']*\b[\x{0600}-\x{06FF}]+\b[^"\']*)\2/u', function($m) use (&$newKeys) {
        $operator = $m[1];
        $quote = $m[2];
        $text = trim($m[3]);
        if (empty($text) || strpos($text, 'l(') !== false) {
            return $m[0];
        }
        $newKeys[$text] = $text;
        return $operator . ' l(' . $quote . $text . $quote . ')';
    }, $content);

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $modifiedCount++;
    }
}

echo "JS & Blade Fallback Wrap Completed!\n";
echo "Modified files count: $modifiedCount\n";
echo "Unique new Persian keys extracted: " . count($newKeys) . "\n";

// Synchronize all new keys into dictionaries
$added = 0;
foreach ($newKeys as $k) {
    $dashKey = str_replace(' ', '-', $k);
    if (!isset($en[$k]) && !isset($en[$dashKey])) {
        $en[$k] = $k;
        $ar[$k] = $k;
        $en[$dashKey] = $k;
        $ar[$dashKey] = $k;
        $added++;
    }
}

function saveDictFileJs($path, $data) {
    $out = "<?php\n\nreturn [\n";
    foreach ($data as $k => $v) {
        $out .= "    " . var_export((string)$k, true) . " => " . var_export((string)$v, true) . ",\n";
    }
    $out .= "];\n";
    file_put_contents($path, $out);
}

saveDictFileJs($enPath, $en);
saveDictFileJs($arPath, $ar);

echo "Synchronized $added new keys into English and Arabic dictionaries.\n";
