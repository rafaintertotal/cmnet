<?php
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/src');

spl_autoload_register(
    function ($class) {
        include str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        return true;
    },
    true,
    true
);
