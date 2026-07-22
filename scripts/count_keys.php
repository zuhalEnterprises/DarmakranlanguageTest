<?php
$en = include __DIR__ . '/../resources/lang/en/message.php';
$ar = include __DIR__ . '/../resources/lang/ar/message.php';

echo "===========================================\n";
echo "FINAL DICTIONARY KEY COUNT REPORT\n";
echo "===========================================\n";
echo "English (EN) Dictionary Keys : " . count($en) . "\n";
echo "Arabic (AR) Dictionary Keys  : " . count($ar) . "\n";
echo "===========================================\n";
