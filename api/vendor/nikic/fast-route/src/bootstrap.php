<?php

namespace Fast;

require __DIR__ . '/functions.php';

spl_autoload_register(function($class) {
    if (strpos($class, 'Fast\\') === 0) {
        $name = substr($class, strlen('Fast'));
        require __DIR__ . strtr($name, '\\', DIRECTORY_SEPARATOR) . '.php';
    }
});
