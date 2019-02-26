<?php

namespace app\assets;

use app\assets\AppAsset;
use yii\web\AssetBundle;

class VehicleStatisticsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/default/pages/bootstrap-datepicker.js',
        'js/default/pages/vehicles/statistics.js',
    ];

    public $depends = [
        'app\assets\AppAsset'

    ];

}