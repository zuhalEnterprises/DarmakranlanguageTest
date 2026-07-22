<?php

$arPath  = __DIR__ . '/../resources/lang/ar/message.php';
$enPath  = __DIR__ . '/../resources/lang/en/message.php';

$arDict = include $arPath;
$enDict = include $enPath;

$missing = [];
foreach ($enDict as $key => $enVal) {
    if (!isset($arDict[$key]) && !empty($enVal)) {
        $missing[$key] = $enVal;
    }
}

echo "Total EN keys: " . count($enDict) . PHP_EOL;
echo "Total AR keys: " . count($arDict) . PHP_EOL;
echo "Keys in EN but missing in AR: " . count($missing) . PHP_EOL;
echo PHP_EOL;
echo "--- MISSING FROM ARABIC ---" . PHP_EOL;
foreach ($missing as $key => $enVal) {
    echo "  [$key] => $enVal" . PHP_EOL;
}
