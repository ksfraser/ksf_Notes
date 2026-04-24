<?php

require_once __DIR__ . '/../../ksf_Calendar/vendor/autoload.php';

$base = __DIR__ . '/../src/Ksfraser/Notes/';

spl_autoload_register(function ($class) use ($base) {
    if (strpos($class, 'Ksfraser\\Notes\\') === 0) {
        $rel = str_replace('Ksfraser\\Notes\\', '', $class);
        $path = $base . str_replace('\\', '/', $rel) . '.php';
        if (file_exists($path)) require $path;
    }
});