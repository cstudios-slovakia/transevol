<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendors/base/vendors.bundle.css',
        'demo/default/base/style.bundle.css',
        'demo/default/media/img/logo/favicon.ico',

    ];
    public $js = [
        'vendors/base/vendors.bundle.js',
        'demo/default/base/scripts.bundle.js',

    ];
    public $depends = [
        'yii\web\YiiAsset'
//        'yii\web\JqueryAsset' => [
//            'js'=>[]
//        ],
//        'yii\bootstrap\BootstrapAsset',
    ];
}
