<?php

use yii\helpers\StringHelper;

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        switch (strtolower($value)) {
            case 'true':
                return true;
            case 'false':
                return false;
            case 'empty':
                return '';
            case 'null':
                return null;
        }
        if (strlen($value) > 1 && StringHelper::startsWith($value, '"') && StringHelper::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }
        return $value;
    }
}

?>