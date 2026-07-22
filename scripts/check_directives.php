<?php

$content = file_get_contents(__DIR__ . '/../resources/views/site11/frontend/layouts/header_v2.blade.php');

preg_match_all('/@if\b/u', $content, $ifs);
preg_match_all('/@endif\b/u', $content, $endifs);
preg_match_all('/<\?php\b/u', $content, $phps);
preg_match_all('/\?>/u', $content, $endphps);

echo "@if count: " . count($ifs[0]) . "\n";
echo "@endif count: " . count($endifs[0]) . "\n";
echo "<?php count: " . count($phps[0]) . "\n";
echo "?> count: " . count($endphps[0]) . "\n";
