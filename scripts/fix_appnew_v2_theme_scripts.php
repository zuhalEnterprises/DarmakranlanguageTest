<?php

$viewsPath = realpath(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsPath));

$fixedCount = 0;

$preloaderScript = <<<HTML
    <script>
        (function () {
            window.onload = function () {
                var preloader = document.querySelector('.page-loading');
                if (preloader) {
                    preloader.classList.remove('active');
                    setTimeout(function () {
                        preloader.remove();
                    }, 500);
                }
            };
        })();
    </script>
HTML;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;
    $filePath = $file->getPathname();
    if (strpos($filePath, 'appnew_v2') === false && strpos($filePath, 'app.blade') === false) continue;

    $content = file_get_contents($filePath);
    $original = $content;

    // Ensure main theme JS is loaded unconditionally instead of conditionally on 'en'
    $content = preg_replace('/@if\s*\(\$currentLocale\s*==\s*[\'"]en[\'"]\)\s*<script src="\/vendor\/flatpickr\/dist\/flatpickr\.min\.js"><\/script>\s*<script src="\/vendor\/flatpickr\/dist\/plugins\/rangePlugin\.js"><\/script>\s*<script src="\/js\/theme4\.min\.js"><\/script>\s*@else\s*<script src="\/js\/theme\.min\.js"><\/script>\s*@endif/s', '<script src="/vendor/flatpickr/dist/flatpickr.min.js"></script><script src="/vendor/flatpickr/dist/plugins/rangePlugin.js"></script><script src="/js/theme4.min.js"></script>', $content);
    $content = preg_replace('/@if\s*\(Config::get\([\'"]app\.locale[\'"]\)\s*==\s*[\'"]en[\'"]\)\s*<script src="\/vendor\/flatpickr\/dist\/flatpickr\.min\.js"><\/script>\s*<script src="\/vendor\/flatpickr\/dist\/plugins\/rangePlugin\.js"><\/script>\s*<script src="\/js\/theme4\.min\.js"><\/script>\s*@else\s*<script src="\/js\/theme\.min\.js"><\/script>\s*@endif/s', '<script src="/vendor/flatpickr/dist/flatpickr.min.js"></script><script src="/vendor/flatpickr/dist/plugins/rangePlugin.js"></script><script src="/js/theme4.min.js"></script>', $content);

    // Inject preloader cleanup script before </head> if missing
    if (strpos($content, 'document.querySelector(\'.page-loading\')') === false && strpos($content, '</head>') !== false) {
        $content = str_replace('</head>', $preloaderScript . "\n</head>", $content);
    }

    if ($content !== $original) {
        file_put_contents($filePath, $content);
        $fixedCount++;
        echo "Fixed theme JS & preloader in: " . basename($filePath) . "\n";
    }
}

echo "Successfully updated $fixedCount main layout files.\n";
