<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$fixedCount = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();

    $content = file_get_contents($filePath);
    $original = $content;

    // Fix <script> blocks where JS code was wrapped in {{ l('...') }}
    $content = preg_replace_callback('/<script\b[^>]*>(.*?)<\/script>/s', function($matches) {
        $scriptInner = $matches[1];
        
        // Unwrap {{ l('...') }} if it contains JS keywords or syntax like AOS.init, function, var, const, let, $(, etc.
        $scriptInner = preg_replace_callback('/\{\{\s*l\(\'(.*?)\'\)\s*\}\}/s', function($m) {
            $inner = $m[1];
            // If it looks like JS code (has ;, (), {}, =, function, AOS, var, let, const, Swal, $, document, window)
            if (preg_match('/(AOS\.|function|var\s|let\s|const\s|\$\(|\.init|\.on\(|window\.|document\.|Swal\.)/', $inner)) {
                // Stripping escaping backslashes if any
                $inner = str_replace(['\\\'', '\\"'], ['\'', '"'], $inner);
                return $inner;
            }
            return $m[0];
        }, $scriptInner);

        return '<script' . substr($matches[0], 7, strpos($matches[0], '>') - 7) . '>' . $scriptInner . '</script>';
    }, $content);

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $fixedCount++;
        echo "Fixed JS wrappers in: " . str_replace(realpath($viewsPath), '', realpath($filePath)) . "\n";
    }
}

echo "Successfully fixed JS code in $fixedCount view files.\n";
