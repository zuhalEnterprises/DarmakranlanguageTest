<?php
$ar = include __DIR__ . '/../resources/lang/ar/message.php';
$en = include __DIR__ . '/../resources/lang/en/message.php';
$missing = [];
foreach ($en as $key => $val) {
    $dashKey = str_replace(' ', '-', $key);
    if (!isset($ar[$key]) && !isset($ar[$dashKey]) && !empty($val)) {
        $missing[] = $key;
    }
}
echo 'Still missing in AR: ' . count($missing) . PHP_EOL;
foreach ($missing as $k) { echo '  ' . $k . PHP_EOL; }
