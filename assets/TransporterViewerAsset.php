<?php

namespace app\assets;

use app\assets\AppAsset;

class TransporterViewerAsset extends AppAsset
{
    public $js = [
        'vendors/base/vendors.bundle.js',
        'demo/default/base/scripts.bundle.js',
        'demo/default/custom/crud/forms/widgets/bootstrap-daterangepicker.js',
        'js/default/pages/timeline_viewer.js',
        'https://www.gstatic.com/charts/loader.js',
        'js/default/pages/timeline_chart.js'
    ];
}