<?php

$enPath = __DIR__ . '/../resources/lang/en/message.php';
$arPath = __DIR__ . '/../resources/lang/ar/message.php';

$en = include $enPath;
$ar = include $arPath;

echo "=== TRANSLATION QUALITY AUDIT ===\n\n";

$enUntranslated = 0;
$arUntranslated = 0;

$enPersianValues = [];
$arPersianValues = [];

foreach ($en as $key => $val) {
    if (preg_match('/[\x{0600}-\x{06FF}]/u', $val)) {
        $enPersianValues[$key] = $val;
    }
}

foreach ($ar as $key => $val) {
    // In Arabic, valid Arabic characters are in \x{0600}-\x{06FF}.
    // But specific Persian characters like (پ, چ, ژ, گ) or Persian syntax might indicate untranslated Persian.
    if (preg_match('/[پچژگ]/u', $val)) {
        $arPersianValues[$key] = $val;
    }
}

echo "Total EN keys: " . count($en) . "\n";
echo "EN keys still containing Persian letters: " . count($enPersianValues) . "\n\n";

echo "Total AR keys: " . count($ar) . "\n";
echo "AR keys containing Persian-specific letters (پ, چ, ژ, گ): " . count($arPersianValues) . "\n\n";

if (count($enPersianValues) > 0) {
    echo "Sample EN untranslated keys:\n";
    $sample = array_slice($enPersianValues, 0, 10, true);
    foreach ($sample as $k => $v) {
        echo "  '$k' => '$v'\n";
    }
}
