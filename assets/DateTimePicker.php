<?php

namespace app\assets;

use app\assets\AppAsset;
use yii\web\AssetBundle;

class DateTimePicker extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/default/pages/jquery.datetimepicker.full.min.js',
        'js/plugins/datetimepicker.js'
    ];
    public $css = [
      'css/plugins/jquery.datetimepicker.min.css'
    ];
    public $depends = [
        'app\assets\AppAsset'
    ];

}