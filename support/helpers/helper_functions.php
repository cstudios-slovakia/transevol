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

if (! function_exists('cost_format')) {
    function cost_format ($cost, bool $displayCurrency = true)
    {
        if ( ! $cost){
            $cost = 0;
        }

        $formatted  = \app\support\StaticCostsCalculators\CostFormatter::format($cost);

        if ($displayCurrency){
            return $formatted . '€';
        }

        return $formatted;
    }
}