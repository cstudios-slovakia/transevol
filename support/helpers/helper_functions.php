<?php

require __DIR__ . '/../../vendor/illuminate/support/helpers.php';

if (! function_exists('dd')) {
    function dd ()
    {
        array_map(function($x) {
            dump($x);
        }, func_get_args());
        die;
    }
}