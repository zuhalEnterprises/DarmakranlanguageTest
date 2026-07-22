<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$fixedFiles = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();
    if (strpos($filePath, 'header') === false) continue;

    $content = file_get_contents($filePath);
    $original = $content;

    // Remove double </div> </div> </header> patterns where only one </div> is needed before </header>
    $content = preg_replace('/(<\/div>\s*)<\/div>\s*<\/header>/s', '$1</header>', $content);

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $fixedFiles++;
        echo "Fixed closing tags in: " . basename($filePath) . "\n";
    }
}

echo "Cleaned closing tags in $fixedFiles header files.\n";
