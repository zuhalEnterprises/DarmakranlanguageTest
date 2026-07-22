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

    // Replace multi-line or inline text nodes between HTML tags that contain Persian characters
    // Matches > TEXT < where TEXT has Persian characters and NO {{ ... }} or Blade directives
    $content = preg_replace_callback('/>([^<>]*?[\x{0600}-\x{06FF}]+[^<>]*?)</us', function($m) use (&$newKeys) {
        $inner = $m[1];
        // If it already contains blade syntax {{ ... }} or blade comments or directives @..., skip or parse sub-parts
        if (strpos($inner, '{{') !== false || strpos($inner, '{!') !== false || strpos($inner, '@') !== false) {
            return $m[0];
        }
        $text = trim($inner);
        if (empty($text) || mb_strlen($text) < 2) {
            return $m[0];
        }
        // Normalize whitespace for key
        $cleanKey = preg_replace('/\s+/', ' ', $text);
        $newKeys[$cleanKey] = $cleanKey;

        // Maintain original leading/trailing whitespace around the wrapped key
        preg_match('/^(\s*)/', $inner, $lead);
        preg_match('/(\s*)$/', $inner, $trail);

        return '>' . $lead[1] . '{{ l(' . var_export($cleanKey, true) . ') }}' . $trail[1] . '<';
    }, $content);

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $modifiedCount++;
    }
}

echo "Ultra Wrap Completed!\n";
echo "Modified files count: $modifiedCount\n";
echo "Unique new Persian keys extracted: " . count($newKeys) . "\n";

// Add extracted keys to dictionaries
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

function saveDictFileUltra($path, $data) {
    $out = "<?php\n\nreturn [\n";
    foreach ($data as $k => $v) {
        $out .= "    " . var_export((string)$k, true) . " => " . var_export((string)$v, true) . ",\n";
    }
    $out .= "];\n";
    file_put_contents($path, $out);
}

saveDictFileUltra($enPath, $en);
saveDictFileUltra($arPath, $ar);

echo "Synchronized $added new keys into English and Arabic dictionaries.\n";
