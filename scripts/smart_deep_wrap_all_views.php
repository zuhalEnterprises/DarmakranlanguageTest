<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$enPath    = realpath(__DIR__ . '/../resources/lang/en/message.php');
$arPath    = realpath(__DIR__ . '/../resources/lang/ar/message.php');

$en = include $enPath;
$ar = include $arPath;

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$modifiedFilesCount = 0;
$wrappedStrings = [];

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();
    $content = file_get_contents($filePath);
    $original = $content;

    // 1. Wrap Persian text inside HTML tag text nodes: > Persian Text <
    // Matches text between > and < containing Persian letters
    $content = preg_replace_callback('/>([^<>{}\r\n]*?[\x{0600}-\x{06FF}]+[^<>{}\r\n]*?)</u', function($m) use (&$wrappedStrings) {
        $text = trim($m[1]);
        if (empty($text) || strpos($text, '{{') !== false || strpos($text, '{!') !== false || strpos($text, '@') !== false) {
            return $m[0];
        }
        $wrappedStrings[$text] = $text;
        return '>{{ l(' . var_export($text, true) . ') }}<';
    }, $content);

    // 2. Wrap Persian text inside attributes (placeholder, title, alt, value, data-*)
    $attrs = ['placeholder', 'title', 'alt', 'data-title', 'data-placeholder', 'data-content', 'aria-label'];
    foreach ($attrs as $attr) {
        $content = preg_replace_callback('/' . $attr . '=(["\'])([^"\']*\b[\x{0600}-\x{06FF}]+\b[^"\']*)\1/u', function($m) use (&$wrappedStrings, $attr) {
            $quote = $m[1];
            $text = trim($m[2]);
            if (empty($text) || strpos($text, '{{') !== false) {
                return $m[0];
            }
            $wrappedStrings[$text] = $text;
            return $attr . '=' . $quote . '{{ l(' . var_export($text, true) . ') }}' . $quote;
        }, $content);
    }

    // 3. Wrap value="Persian Text" on buttons or inputs of type submit/button
    $content = preg_replace_callback('/value=(["\'])([^"\']*\b[\x{0600}-\x{06FF}]+\b[^"\']*)\1/u', function($m) use (&$wrappedStrings) {
        $quote = $m[1];
        $text = trim($m[2]);
        if (empty($text) || strpos($text, '{{') !== false || is_numeric($text)) {
            return $m[0];
        }
        $wrappedStrings[$text] = $text;
        return 'value=' . $quote . '{{ l(' . var_export($text, true) . ') }}' . $quote;
    }, $content);

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $modifiedFilesCount++;
    }
}

echo "Smart Wrap Completed!\n";
echo "Modified files count: $modifiedFilesCount\n";
echo "Newly wrapped Persian strings count: " . count($wrappedStrings) . "\n";

// Add all newly wrapped strings into dictionary files if not present
$addedToDict = 0;
foreach ($wrappedStrings as $str) {
    $dashKey = str_replace(' ', '-', $str);
    if (!isset($en[$str]) && !isset($en[$dashKey])) {
        $en[$str] = $str;
        $ar[$str] = $str;
        $en[$dashKey] = $str;
        $ar[$dashKey] = $str;
        $addedToDict++;
    }
}

function writeDictFile($path, $data) {
    $out = "<?php\n\nreturn [\n";
    foreach ($data as $k => $v) {
        $out .= "    " . var_export((string)$k, true) . " => " . var_export((string)$v, true) . ",\n";
    }
    $out .= "];\n";
    file_put_contents($path, $out);
}

writeDictFile($enPath, $en);
writeDictFile($arPath, $ar);

echo "Added $addedToDict new keys to dictionaries.\n";
