<?php
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require(__DIR__ . '/../config/helpers.php');

try {
    $dotenv     = new \Symfony\Component\Dotenv\Dotenv();
    $dotenv->load(__DIR__ . '/../.env');
} catch (\Symfony\Component\Dotenv\Exception\PathException $exception) {
}

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
