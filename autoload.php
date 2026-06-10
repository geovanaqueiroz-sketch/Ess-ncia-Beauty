<?php

spl_autoload_register(function ($class) {

    $paths = [
        __DIR__ . '/app/controller/',
        __DIR__ . '/app/model/',
        __DIR__ . '/app/services/',
        __DIR__ . '/app/middleware/',
        __DIR__ . '/app/router/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
